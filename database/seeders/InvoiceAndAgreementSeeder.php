<?php

namespace Database\Seeders;

use App\Models\Agreement;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvoiceAndAgreementSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'superadmin')->first();
        $client1 = Client::where('client_code', 'CLN-2026-001')->first();
        $client2 = Client::where('client_code', 'CLN-2026-002')->first();
        $prodMetani = Product::where('product_code', 'PRD-WEB-001')->first();
        $prodNgafe = Product::where('product_code', 'PRD-WEB-002')->first();

        $bankAccounts = SiteSetting::get('bank_accounts', []);
        $bankInfo = '';
        if (is_array($bankAccounts)) {
            foreach ($bankAccounts as $b) {
                $bankInfo .= "{$b['bank']}: {$b['account_number']} a/n {$b['holder_name']} ({$b['branch']})\n";
            }
        }

        // 1. Invoice Metani
        $inv1 = Invoice::updateOrCreate(
            ['invoice_number' => 'INV/CYB/2026/10/0042'],
            [
                'uuid' => (string) Str::uuid(),
                'client_id' => $client1->id,
                'product_id' => $prodMetani->id,
                'project_title' => 'Implementasi Sistem Web Metani Smart Agriculture & Telemetri Panen',
                'billing_type' => 'down_payment',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'subtotal' => 18500000.00,
                'discount_amount' => 0.00,
                'tax_percentage' => 0.00,
                'tax_amount' => 0.00,
                'grand_total' => 18500000.00,
                'amount_paid' => 9250000.00,
                'balance_due' => 9250000.00,
                'payment_status' => 'partial_dp',
                'paid_at' => now()->subDay(),
                'payment_method_info' => $bankInfo,
                'admin_notes' => 'Pembayaran Uang Muka (DP 50%) telah terverifikasi. Sisa pelunasan 50% dibayarkan selambat-lambatnya 7 hari kalender pasca Berita Acara Serah Terima (BAST).',
                'created_by' => $admin->id,
            ]
        );

        $inv1->items()->delete();
        InvoiceItem::create([
            'invoice_id' => $inv1->id,
            'item_name' => 'Lisensi & Instalasi Sistem Web Metani Smart Agriculture',
            'item_description' => 'Paket lisensi komersial seumur hidup termasuk modul katalog komoditas, manajemen mitra tani, dan escrow transaksi.',
            'quantity' => 1,
            'unit_name' => 'Paket',
            'unit_price' => 15000000.00,
            'total_price' => 15000000.00,
            'sort_order' => 1,
        ]);
        InvoiceItem::create([
            'invoice_id' => $inv1->id,
            'item_name' => 'Kustomisasi Modul Telemetri IoT & Dashboard Ekspor',
            'item_description' => 'Integrasi API sensor cuaca pertanian, penyesuaian formulir grading mutu panen, dan konfigurasi server cloud.',
            'quantity' => 1,
            'unit_name' => 'Paket',
            'unit_price' => 3500000.00,
            'total_price' => 3500000.00,
            'sort_order' => 2,
        ]);

        // Agreement Metani
        Agreement::updateOrCreate(
            ['agreement_number' => 'MOU/CYB/2026/10/0019'],
            [
                'uuid' => (string) Str::uuid(),
                'client_id' => $client1->id,
                'product_id' => $prodMetani->id,
                'invoice_id' => $inv1->id,
                'template_type' => 'software_installation',
                'project_name' => 'Pemasangan dan Implementasi Sistem Metani Smart Agriculture',
                'agreement_date' => now()->toDateString(),
                'start_date' => now()->toDateString(),
                'estimated_completion_date' => now()->addDays(21)->toDateString(),
                'warranty_period_months' => 3,
                'contract_value' => 18500000.00,
                'payment_terms_summary' => "Tahap 1: Uang Muka (DP) 50% senilai Rp 9.250.000 saat penandatanganan perjanjian.\nTahap 2: Pelunasan 50% senilai Rp 9.250.000 paling lambat 7 hari kerja setelah penandatanganan Berita Acara Serah Terima (BAST).",
                'scope_of_work' => implode("\n", [
                    '1. Instalasi dan konfigurasi basis data sistem Metani pada infrastruktur VPS Klien.',
                    '2. Penyesuaian skema klasifikasi mutu komoditas dan formulir data petani mitra.',
                    '3. Pengujian performa keamanan (Security Hardening & Penetration Testing).',
                    '4. Sesi pelatihan (Training & Onboarding) staf operasional dan administrator.',
                    '5. Masa pendampingan peluncuran (Go-Live Support) dan garansi perbaikan bug selama 90 hari.'
                ]),
                'agreement_clauses_html' => '<p>Perjanjian ini berlaku mengikat kedua belah pihak sejak tanggal ditandatangani. Segala hak kekayaan intelektual atas source code dasar tetap berada di bawah naungan CYBICHI, dengan hak pakai lisensi komersial eksklusif diberikan kepada Pihak Kedua.</p>',
                'status' => 'issued',
                'created_by' => $admin->id,
            ]
        );

        // 2. Invoice Ngafe POS
        $inv2 = Invoice::updateOrCreate(
            ['invoice_number' => 'INV/CYB/2026/10/0043'],
            [
                'uuid' => (string) Str::uuid(),
                'client_id' => $client2->id,
                'product_id' => $prodNgafe->id,
                'project_title' => 'Pemasangan Paket Point of Sale Ngafe Multi-Outlet & Resep Inventaris',
                'billing_type' => 'down_payment',
                'issue_date' => now()->toDateString(),
                'due_date' => now()->addDays(5)->toDateString(),
                'subtotal' => 14500000.00,
                'discount_amount' => 0.00,
                'tax_percentage' => 0.00,
                'tax_amount' => 0.00,
                'grand_total' => 14500000.00,
                'amount_paid' => 0.00,
                'balance_due' => 7250000.00, // DP 50%
                'payment_status' => 'unpaid',
                'payment_method_info' => $bankInfo,
                'admin_notes' => 'Tagihan Uang Muka (DP 50%) untuk memulai konfigurasi POS Ngafe dan setup menu 4 outlet.',
                'created_by' => $admin->id,
            ]
        );

        $inv2->items()->delete();
        InvoiceItem::create([
            'invoice_id' => $inv2->id,
            'item_name' => 'Lisensi Software POS Ngafe Cloud Multi-Outlet (4 Outlet)',
            'item_description' => 'Sistem kasir layar sentuh, modul dapur display, manajemen hak akses manager, dan rekonsiliasi kas.',
            'quantity' => 1,
            'unit_name' => 'Lisensi',
            'unit_price' => 11500000.00,
            'total_price' => 11500000.00,
            'sort_order' => 1,
        ]);
        InvoiceItem::create([
            'invoice_id' => $inv2->id,
            'item_name' => 'Setup & Kalibrasi Resep Pemotongan Bahan Baku Gramatur',
            'item_description' => 'Input 150 item menu & komposisi resep biji kopi/susu, training kasir, dan pengujian printer thermal.',
            'quantity' => 1,
            'unit_name' => 'Paket',
            'unit_price' => 3000000.00,
            'total_price' => 3000000.00,
            'sort_order' => 2,
        ]);

        Agreement::updateOrCreate(
            ['agreement_number' => 'MOU/CYB/2026/10/0020'],
            [
                'uuid' => (string) Str::uuid(),
                'client_id' => $client2->id,
                'product_id' => $prodNgafe->id,
                'invoice_id' => $inv2->id,
                'template_type' => 'software_installation',
                'project_name' => 'Pemasangan Paket Point of Sale Ngafe Multi-Outlet & Resep Inventaris',
                'agreement_date' => now()->toDateString(),
                'start_date' => now()->toDateString(),
                'estimated_completion_date' => now()->addDays(14)->toDateString(),
                'warranty_period_months' => 3,
                'contract_value' => 14500000.00,
                'payment_terms_summary' => "Tahap 1: DP 50% senilai Rp 7.250.000 sebelum instalasi menu.\nTahap 2: Pelunasan 50% senilai Rp 7.250.000 pasca uji coba transaksi di 4 gerai kafe.",
                'scope_of_work' => implode("\n", [
                    '1. Konfigurasi server cloud POS Ngafe untuk 4 outlet cabang.',
                    '2. Setup master data bahan baku dan formula resep minuman.',
                    '3. Uji coba cetak struk kasir Bluetooth / USB dan QRIS dinamis.',
                    '4. Pelatihan staf kasir dan store manager.',
                    '5. Garansi purnajual pemeliharaan sistem selama 3 bulan.'
                ]),
                'agreement_clauses_html' => '<p>CYBICHI menjamin ketersediaan sistem POS Ngafe dengan pemulihan cepat dan bantuan teknis selama jam operasional kafe.</p>',
                'status' => 'issued',
                'created_by' => $admin->id,
            ]
        );
    }
}
