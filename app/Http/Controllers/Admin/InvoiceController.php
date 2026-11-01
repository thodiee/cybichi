<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\SecurityAuditLog;
use App\Models\SiteSetting;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['client', 'product', 'creator']);

        if ($request->filled('status')) {
            $query->where('payment_status', $request->input('status'));
        }

        if ($request->filled('billing_type')) {
            $query->where('billing_type', $request->input('billing_type'));
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('invoice_number', 'like', "%{$s}%")
                    ->orWhere('project_title', 'like', "%{$s}%")
                    ->orWhereHas('client', function ($cq) use ($s) {
                        $cq->where('contact_name', 'like', "%{$s}%")
                            ->orWhere('company_name', 'like', "%{$s}%");
                    });
            });
        }

        $invoices = $query->latest('issue_date')->paginate(10)->withQueryString();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('contact_name')->get();
        $products = Product::where('is_active', true)->orderBy('title')->get();

        $selectedClientId = $request->query('client_id');
        $selectedProductId = $request->query('product_id');

        // Next automatic invoice number
        $year = date('Y');
        $month = date('m');
        $count = Invoice::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        $nextNumber = "INV/CYB/{$year}/{$month}/" . str_pad($count, 4, '0', STR_PAD_LEFT);

        $bankAccounts = SiteSetting::get('bank_accounts', []);
        $bankInfo = '';
        if (is_array($bankAccounts)) {
            foreach ($bankAccounts as $b) {
                $bankInfo .= "{$b['bank']}: {$b['account_number']} a/n {$b['holder_name']} ({$b['branch']})\n";
            }
        }

        return view('admin.invoices.create', compact('clients', 'products', 'nextNumber', 'bankInfo', 'selectedClientId', 'selectedProductId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'nullable|exists:products,id',
            'project_title' => 'required|string|max:200',
            'billing_type' => 'required|in:one_time,down_payment,milestone_termin,final_settlement,recurring',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'balance_due' => 'required|numeric|min:0',
            'payment_status' => 'required|in:draft,unpaid,partial_dp,paid,overdue,cancelled',
            'payment_method_info' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:200',
            'items.*.item_description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_name' => 'nullable|string|max:30',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
        ]);

        $uuid = (string) Str::uuid();
        $hash = hash('sha256', $uuid . '-' . microtime(true) . '-' . Str::random(16));

        $invoice = Invoice::create([
            'uuid' => $uuid,
            'invoice_number' => $validated['invoice_number'],
            'client_id' => $validated['client_id'],
            'product_id' => $validated['product_id'] ?? null,
            'project_title' => $validated['project_title'],
            'billing_type' => $validated['billing_type'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'subtotal' => $validated['subtotal'],
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'tax_percentage' => $validated['tax_percentage'] ?? 0,
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'grand_total' => $validated['grand_total'],
            'amount_paid' => $validated['amount_paid'] ?? 0,
            'balance_due' => $validated['balance_due'],
            'payment_status' => $validated['payment_status'],
            'paid_at' => ($validated['payment_status'] === 'paid' || $validated['payment_status'] === 'partial_dp') ? now() : null,
            'payment_method_info' => $validated['payment_method_info'],
            'admin_notes' => $validated['admin_notes'],
            'verification_hash' => $hash,
            'created_by' => Auth::id() ?? 1,
        ]);

        foreach ($validated['items'] as $index => $itemData) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $itemData['item_name'],
                'item_description' => $itemData['item_description'] ?? null,
                'quantity' => $itemData['quantity'],
                'unit_name' => $itemData['unit_name'] ?: 'Paket',
                'unit_price' => $itemData['unit_price'],
                'total_price' => $itemData['total_price'],
                'sort_order' => $index + 1,
            ]);
        }

        SecurityAuditLog::record('invoice_created', $invoice, null, [
            'number' => $invoice->invoice_number,
            'client_id' => $invoice->client_id,
            'grand_total' => $invoice->grand_total,
        ]);

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', "Invoice '{$invoice->invoice_number}' berhasil diterbitkan!");
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'product', 'items', 'creator', 'agreements']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(['client', 'product', 'items']);
        $clients = Client::orderBy('contact_name')->get();
        $products = Product::where('is_active', true)->orderBy('title')->get();

        return view('admin.invoices.edit', compact('invoice', 'clients', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'nullable|exists:products,id',
            'project_title' => 'required|string|max:200',
            'billing_type' => 'required|in:one_time,down_payment,milestone_termin,final_settlement,recurring',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'balance_due' => 'required|numeric|min:0',
            'payment_status' => 'required|in:draft,unpaid,partial_dp,paid,overdue,cancelled',
            'payment_method_info' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:200',
            'items.*.item_description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_name' => 'nullable|string|max:30',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
        ]);

        $old = $invoice->only(['grand_total', 'payment_status', 'amount_paid', 'balance_due']);

        $invoice->update([
            'client_id' => $validated['client_id'],
            'product_id' => $validated['product_id'] ?? null,
            'project_title' => $validated['project_title'],
            'billing_type' => $validated['billing_type'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'subtotal' => $validated['subtotal'],
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'tax_percentage' => $validated['tax_percentage'] ?? 0,
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'grand_total' => $validated['grand_total'],
            'amount_paid' => $validated['amount_paid'] ?? 0,
            'balance_due' => $validated['balance_due'],
            'payment_status' => $validated['payment_status'],
            'paid_at' => ($validated['payment_status'] === 'paid' && !$invoice->paid_at) ? now() : $invoice->paid_at,
            'payment_method_info' => $validated['payment_method_info'],
            'admin_notes' => $validated['admin_notes'],
        ]);

        // Recreate items
        $invoice->items()->delete();
        foreach ($validated['items'] as $index => $itemData) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $itemData['item_name'],
                'item_description' => $itemData['item_description'] ?? null,
                'quantity' => $itemData['quantity'],
                'unit_name' => $itemData['unit_name'] ?: 'Paket',
                'unit_price' => $itemData['unit_price'],
                'total_price' => $itemData['total_price'],
                'sort_order' => $index + 1,
            ]);
        }

        SecurityAuditLog::record('invoice_updated', $invoice, $old, $invoice->only(['grand_total', 'payment_status', 'amount_paid', 'balance_due']));

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('success', "Invoice '{$invoice->invoice_number}' berhasil diperbarui!");
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,partial_dp,paid,cancelled',
        ]);

        $oldStatus = $invoice->payment_status;
        $newStatus = $request->input('payment_status');

        $updates = ['payment_status' => $newStatus];
        if ($newStatus === 'paid') {
            $updates['amount_paid'] = $invoice->grand_total;
            $updates['balance_due'] = 0;
            $updates['paid_at'] = now();
        }

        $invoice->update($updates);

        SecurityAuditLog::record('invoice_status_changed', $invoice, ['status' => $oldStatus], ['status' => $newStatus]);

        return back()->with('success', "Status Invoice berhasil diubah menjadi: " . strtoupper($newStatus));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $pdf = PdfService::generateInvoicePdf($invoice);
        $safeNum = str_replace(['/', '\\'], '-', $invoice->invoice_number);
        return $pdf->download("INVOICE-{$safeNum}.pdf");
    }
}
