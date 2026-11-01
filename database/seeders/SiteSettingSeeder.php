<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General & Identity
            ['brand_name', 'CYBICHI', 'general', 'text'],
            ['brand_tagline', 'SECURE TECHNOLOGY, EMPOWERING FUTURES', 'general', 'text'],
            ['legal_entity_name', 'PT CYBICHI TEKNOLOGI NUSANTARA', 'billing_legal', 'text'],
            ['tax_id', '01.234.567.8-901.000', 'billing_legal', 'text'],
            ['office_address', 'CYBICHI Tech Tower Lt. 12, Jl. Jend. Sudirman Kav. 45, Jakarta Selatan 12190', 'contact', 'textarea'],
            ['contact_email', 'halo@cybichi.com', 'contact', 'text'],
            ['contact_whatsapp', '6281299887766', 'contact', 'text'],
            ['business_hours', 'Senin - Jumat: 08.30 - 17.30 WIB', 'contact', 'text'],

            // Hero Section
            ['hero_badge', 'Enterprise IT & Healthcare Solutions 2026', 'hero', 'text'],
            ['hero_headline', 'Transforming Healthcare & Business with Secure IT Solutions', 'hero', 'textarea'],
            ['hero_subheadline', 'Mitra teknologi strategis untuk rekayasa perangkat lunak enterprise, sistem informasi rumah sakit & klinik, konektivitas jaringan berkecepatan tinggi, serta tata kelola keamanan informasi berstandar internasional.', 'hero', 'textarea'],
            ['hero_cta_demo_text', 'Eksplorasi Live Demo', 'hero', 'text'],
            ['hero_cta_wa_text', 'Konsultasi Proyek Gratis', 'hero', 'text'],

            // Trust Stats
            ['stats_projects_completed', '120+', 'general', 'text'],
            ['stats_active_clients', '85+', 'general', 'text'],
            ['stats_uptime_guarantee', '99.98%', 'general', 'text'],
            ['stats_years_experience', '8+ Tahun', 'general', 'text'],

            // Bank Accounts for Invoices
            ['bank_accounts', json_encode([
                [
                    'bank' => 'BCA',
                    'account_number' => '8800-1234-5678',
                    'holder_name' => 'PT CYBICHI TEKNOLOGI NUSANTARA',
                    'branch' => 'KCU Sudirman Jakarta'
                ],
                [
                    'bank' => 'Mandiri',
                    'account_number' => '137-00-9876543-2',
                    'holder_name' => 'PT CYBICHI TEKNOLOGI NUSANTARA',
                    'branch' => 'KC Bursa Efek Indonesia'
                ],
                [
                    'bank' => 'BRI',
                    'account_number' => '0341-01-000987-30-5',
                    'holder_name' => 'PT CYBICHI TEKNOLOGI NUSANTARA',
                    'branch' => 'KC Veteran Jakarta'
                ]
            ]), 'billing_legal', 'json'],

            ['invoice_warranty_terms', 'Garansi pemeliharaan sistem & perbaikan bug kritis berlaku selama 90 hari kalender sejak tanggal serah terima (BAST). Layanan purnajual mencakup pemantauan performa server dan bantuan teknis via WhatsApp Dedicated SLA.', 'billing_legal', 'textarea'],

            // SEO & Social
            ['meta_title', 'CYBICHI — Transforming Healthcare & Business with Secure IT Solutions', 'seo', 'text'],
            ['meta_description', 'CYBICHI menghadirkan solusi teknologi terpercaya: Healthcare IT, Hospital Smart Queue, Enterprise Web/ERP, Dedicated ISP Network, dan Generator E-Invoice & MoU Resmi.', 'seo', 'textarea'],
            ['meta_keywords', 'healthcare it, sistem informasi rumah sakit, software house jakarta, pembuatan web korporat, sistem pos kasir, erp gudang, jasa mikrotik isp, invoice online, cybichi', 'seo', 'text'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $s[0]],
                [
                    'setting_value' => $s[1],
                    'setting_group' => $s[2],
                    'setting_type' => $s[3],
                    'updated_at' => now(),
                ]
            );
        }
    }
}
