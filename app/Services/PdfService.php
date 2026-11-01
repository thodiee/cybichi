<?php

namespace App\Services;

use App\Models\Agreement;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public static function generateInvoicePdf(Invoice $invoice)
    {
        $qrDataUri = QrCodeService::generateDataUri($invoice->verification_url);

        return Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'qrDataUri' => $qrDataUri,
        ])->setPaper('a4', 'portrait');
    }

    public static function generateAgreementPdf(Agreement $agreement)
    {
        $qrDataUri = QrCodeService::generateDataUri($agreement->verification_url);

        return Pdf::loadView('pdf.agreement', [
            'agreement' => $agreement,
            'qrDataUri' => $qrDataUri,
        ])->setPaper('a4', 'portrait');
    }
}
