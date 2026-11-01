<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:100',
            'whatsapp_number' => 'required|string|max:25',
            'company_name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:150',
            'interested_category' => 'nullable|string|max:100',
            'referenced_product_id' => 'nullable|exists:products,id',
            'project_brief' => 'required|string|max:2000',
        ]);

        $code = 'INQ-' . date('Ym') . '-' . strtoupper(Str::random(4));

        $inquiry = Inquiry::create([
            'inquiry_code' => $code,
            'client_name' => $validated['client_name'],
            'company_name' => $validated['company_name'] ?? null,
            'whatsapp_number' => $validated['whatsapp_number'],
            'email' => $validated['email'] ?? null,
            'interested_category' => $validated['interested_category'] ?? null,
            'referenced_product_id' => $validated['referenced_product_id'] ?? null,
            'project_brief' => $validated['project_brief'],
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        $adminWa = SiteSetting::get('contact_whatsapp', '6281299887766');
        $cleanWa = preg_replace('/[^0-9]/', '', $adminWa);

        $product = $inquiry->referenced_product_id ? Product::find($inquiry->referenced_product_id) : null;
        $productText = $product ? " (Produk Acuan: {$product->title} / {$product->product_code})" : "";

        $waText = "Halo Tim CYBICHI, saya telah mengajukan konsultasi kebutuhan IT melalui website:\n"
            . "------------------------------------------------\n"
            . "Kode Permintaan : {$code}\n"
            . "Nama Pengirim   : {$inquiry->client_name}\n"
            . ($inquiry->company_name ? "Perusahaan/Instansi: {$inquiry->company_name}\n" : "")
            . "No. WhatsApp    : {$inquiry->whatsapp_number}\n"
            . "Kebutuhan       : " . ($inquiry->interested_category ?? 'Solusi IT Terpadu') . "{$productText}\n"
            . "Rincian Singkat : {$inquiry->project_brief}\n"
            . "------------------------------------------------\n"
            . "Mohon dapat dihubungi untuk pembahasan teknis dan penawaran biaya. Terima kasih.";

        $waUrl = "https://wa.me/{$cleanWa}?text=" . rawurlencode($waText);

        return redirect()->away($waUrl);
    }
}
