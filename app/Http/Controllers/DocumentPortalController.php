<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Invoice;
use App\Services\PdfService;
use Illuminate\Http\Request;

class DocumentPortalController extends Controller
{
    public function view(string $uuid)
    {
        $invoice = Invoice::with(['client', 'product', 'items', 'agreements'])
            ->where('uuid', $uuid)
            ->first();

        $agreement = null;

        if ($invoice) {
            $agreement = $invoice->agreements->first();
        } else {
            $agreement = Agreement::with(['client', 'product', 'invoice.items'])
                ->where('uuid', $uuid)
                ->firstOrFail();
            $invoice = $agreement->invoice;
        }

        return view('pages.documents.view', compact('invoice', 'agreement', 'uuid'));
    }

    public function downloadInvoice(string $uuid)
    {
        $invoice = Invoice::with(['client', 'product', 'items'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        $pdf = PdfService::generateInvoicePdf($invoice);

        $safeNum = str_replace(['/', '\\'], '-', $invoice->invoice_number);
        return $pdf->download("INVOICE-{$safeNum}.pdf");
    }

    public function downloadAgreement(string $uuid)
    {
        $agreement = Agreement::with(['client', 'product'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        $pdf = PdfService::generateAgreementPdf($agreement);

        $safeNum = str_replace(['/', '\\'], '-', $agreement->agreement_number);
        return $pdf->download("MOU-SPK-{$safeNum}.pdf");
    }

    public function verify(string $hash)
    {
        $invoice = Invoice::with(['client', 'product'])
            ->where('verification_hash', $hash)
            ->first();

        $agreement = null;

        if (!$invoice) {
            $agreement = Agreement::with(['client', 'product'])
                ->where('verification_hash', $hash)
                ->first();
        }

        $isValid = ($invoice !== null || $agreement !== null);

        return view('pages.documents.verify', compact('isValid', 'invoice', 'agreement', 'hash'));
    }
}
