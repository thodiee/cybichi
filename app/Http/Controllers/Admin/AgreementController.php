<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SecurityAuditLog;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgreementController extends Controller
{
    public function index(Request $request)
    {
        $query = Agreement::with(['client', 'product', 'invoice']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('template_type')) {
            $query->where('template_type', $request->input('template_type'));
        }

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('agreement_number', 'like', "%{$s}%")
                    ->orWhere('project_name', 'like', "%{$s}%")
                    ->orWhereHas('client', function ($cq) use ($s) {
                        $cq->where('contact_name', 'like', "%{$s}%")
                            ->orWhere('company_name', 'like', "%{$s}%");
                    });
            });
        }

        $agreements = $query->latest('agreement_date')->paginate(10)->withQueryString();
        return view('admin.agreements.index', compact('agreements'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('contact_name')->get();
        $products = Product::where('is_active', true)->orderBy('title')->get();
        $invoices = Invoice::with('client')->latest()->get();

        $selectedClientId = $request->query('client_id');
        $selectedProductId = $request->query('product_id');
        $selectedInvoiceId = $request->query('invoice_id');

        $year = date('Y');
        $month = date('m');
        $count = Agreement::whereYear('created_at', $year)->whereMonth('created_at', $month)->count() + 1;
        $nextNumber = "MOU/CYB/{$year}/{$month}/" . str_pad($count, 4, '0', STR_PAD_LEFT);

        return view('admin.agreements.create', compact(
            'clients',
            'products',
            'invoices',
            'nextNumber',
            'selectedClientId',
            'selectedProductId',
            'selectedInvoiceId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agreement_number' => 'required|string|max:50|unique:agreements,agreement_number',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'nullable|exists:products,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'template_type' => 'required|in:software_installation,custom_development,internet_network_contract,it_maintenance',
            'project_name' => 'required|string|max:200',
            'agreement_date' => 'required|date',
            'start_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date|after_or_equal:start_date',
            'warranty_period_months' => 'required|integer|min:0',
            'contract_value' => 'required|numeric|min:0',
            'payment_terms_summary' => 'required|string',
            'scope_of_work' => 'required|string',
            'agreement_clauses_html' => 'nullable|string',
            'status' => 'required|in:draft,issued,signed_active,completed,terminated',
        ]);

        $uuid = (string) Str::uuid();
        $hash = hash('sha256', $uuid . '-' . microtime(true) . '-' . Str::random(16));

        $agreement = Agreement::create([
            'uuid' => $uuid,
            'agreement_number' => $validated['agreement_number'],
            'client_id' => $validated['client_id'],
            'product_id' => $validated['product_id'] ?? null,
            'invoice_id' => $validated['invoice_id'] ?? null,
            'template_type' => $validated['template_type'],
            'project_name' => $validated['project_name'],
            'agreement_date' => $validated['agreement_date'],
            'start_date' => $validated['start_date'],
            'estimated_completion_date' => $validated['estimated_completion_date'] ?? null,
            'warranty_period_months' => $validated['warranty_period_months'],
            'contract_value' => $validated['contract_value'],
            'payment_terms_summary' => $validated['payment_terms_summary'],
            'scope_of_work' => $validated['scope_of_work'],
            'agreement_clauses_html' => $validated['agreement_clauses_html'] ?: '<p>Perjanjian ini berlaku mengikat kedua belah pihak sejak tanggal ditandatangani.</p>',
            'status' => $validated['status'],
            'verification_hash' => $hash,
            'created_by' => Auth::id() ?? 1,
        ]);

        SecurityAuditLog::record('mou_issued', $agreement, null, [
            'number' => $agreement->agreement_number,
            'client_id' => $agreement->client_id,
            'contract_value' => $agreement->contract_value,
        ]);

        return redirect()->route('admin.agreements.show', $agreement)
            ->with('success', "Dokumen Perjanjian Kerja Sama '{$agreement->agreement_number}' berhasil diterbitkan!");
    }

    public function show(Agreement $agreement)
    {
        $agreement->load(['client', 'product', 'invoice', 'creator']);
        return view('admin.agreements.show', compact('agreement'));
    }

    public function edit(Agreement $agreement)
    {
        $agreement->load(['client', 'product', 'invoice']);
        $clients = Client::orderBy('contact_name')->get();
        $products = Product::where('is_active', true)->orderBy('title')->get();
        $invoices = Invoice::with('client')->latest()->get();

        return view('admin.agreements.edit', compact('agreement', 'clients', 'products', 'invoices'));
    }

    public function update(Request $request, Agreement $agreement)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'nullable|exists:products,id',
            'invoice_id' => 'nullable|exists:invoices,id',
            'template_type' => 'required|in:software_installation,custom_development,internet_network_contract,it_maintenance',
            'project_name' => 'required|string|max:200',
            'agreement_date' => 'required|date',
            'start_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date|after_or_equal:start_date',
            'warranty_period_months' => 'required|integer|min:0',
            'contract_value' => 'required|numeric|min:0',
            'payment_terms_summary' => 'required|string',
            'scope_of_work' => 'required|string',
            'agreement_clauses_html' => 'nullable|string',
            'status' => 'required|in:draft,issued,signed_active,completed,terminated',
        ]);

        $old = $agreement->only(['project_name', 'contract_value', 'status']);

        $agreement->update([
            'client_id' => $validated['client_id'],
            'product_id' => $validated['product_id'] ?? null,
            'invoice_id' => $validated['invoice_id'] ?? null,
            'template_type' => $validated['template_type'],
            'project_name' => $validated['project_name'],
            'agreement_date' => $validated['agreement_date'],
            'start_date' => $validated['start_date'],
            'estimated_completion_date' => $validated['estimated_completion_date'] ?? null,
            'warranty_period_months' => $validated['warranty_period_months'],
            'contract_value' => $validated['contract_value'],
            'payment_terms_summary' => $validated['payment_terms_summary'],
            'scope_of_work' => $validated['scope_of_work'],
            'agreement_clauses_html' => $validated['agreement_clauses_html'] ?: $agreement->agreement_clauses_html,
            'status' => $validated['status'],
        ]);

        SecurityAuditLog::record('mou_updated', $agreement, $old, $agreement->only(['project_name', 'contract_value', 'status']));

        return redirect()->route('admin.agreements.show', $agreement)
            ->with('success', "Dokumen Perjanjian '{$agreement->agreement_number}' berhasil diperbarui!");
    }

    public function downloadPdf(Agreement $agreement)
    {
        $pdf = PdfService::generateAgreementPdf($agreement);
        $safeNum = str_replace(['/', '\\'], '-', $agreement->agreement_number);
        return $pdf->download("MOU-SPK-{$safeNum}.pdf");
    }
}
