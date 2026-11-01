<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServicePackage;
use Illuminate\Database\Seeder;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $netCat = ServiceCategory::where('slug', 'internet-network-isp')->first();
        $managedCat = ServiceCategory::where('slug', 'managed-it-support')->first();

        $packages = [
            [
                'category_id' => $netCat->id,
                'package_name' => 'Corporate Dedicated 50 Mbps',
                'badge_text' => 'Bisnis Berkembang',
                'price_amount' => 2500000.00,
                'billing_period' => '/ bulan',
                'specifications' => [
                    'Kecepatan Simetris 50 Mbps Upload : 50 Mbps Download (1:1)',
                    'Jaminan Service Level Agreement (SLA) 99.8%',
                    '1 Alamat IP Public Statis Termasuk',
                    'Routerboard Gigabit & Optical Network Terminal (ONT)',
                    'Dukungan Teknis Siaga 24/7 Response Time < 30 Menit'
                ],
                'cta_whatsapp_template' => 'Halo Tim CYBICHI, saya tertarik berlangganan paket *Corporate Dedicated 50 Mbps* (Rp 2.500.000/bln). Mohon info pengecekan jangkauan lokasi dan jadwal instalasi.',
                'is_highlighted' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $netCat->id,
                'package_name' => 'Corporate Dedicated 100 Mbps',
                'badge_text' => 'Paling Populer',
                'price_amount' => 4500000.00,
                'billing_period' => '/ bulan',
                'specifications' => [
                    'Kecepatan Simetris 100 Mbps Upload : 100 Mbps Download (1:1)',
                    'Jaminan Service Level Agreement (SLA) 99.9%',
                    '2 Alamat IP Public Statis Termasuk',
                    'Dual-Core Enterprise Router & Switch Gigabit Managed',
                    'Prioritas Utama Jalur Data Video Conference (Zoom/Meet/Teams)',
                    'Monitoring Jaringan Proaktif via Dashboard Network Operations Center'
                ],
                'cta_whatsapp_template' => 'Halo Tim CYBICHI, saya tertarik berlangganan paket *Corporate Dedicated 100 Mbps* (Rp 4.500.000/bln). Mohon info survey lokasi kantor kami dan draft penawaran resminya.',
                'is_highlighted' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_id' => $netCat->id,
                'package_name' => 'Corporate Dedicated 250 Mbps Enterprise',
                'badge_text' => 'Perusahaan Skala Besar',
                'price_amount' => 9500000.00,
                'billing_period' => '/ bulan',
                'specifications' => [
                    'Kecepatan Simetris 250 Mbps Upload : 250 Mbps Download (1:1)',
                    'Jaminan SLA Tertinggi 99.95% dengan Garansi Restitusi',
                    'Subnet 4 Alamat IP Public Statis',
                    'Jalur Redundan Dual-Fiber Optic (Ring Topology Failover)',
                    'Dedicated Account Manager & Tim On-Site Siaga'
                ],
                'cta_whatsapp_template' => 'Halo Tim CYBICHI, kami memerlukan koneksi *Corporate Dedicated 250 Mbps Enterprise* untuk kantor pusat kami. Mohon dihubungi untuk pembahasan teknis lanjutan.',
                'is_highlighted' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_id' => $managedCat->id,
                'package_name' => 'Managed IT & Maintenance Standard',
                'badge_text' => 'Pemeliharaan Rutin',
                'price_amount' => 3500000.00,
                'billing_period' => '/ bulan',
                'specifications' => [
                    'Pemeliharaan Preventif Software & Server Bulanan',
                    'Audit Keamanan Cyber & Pemasangan Patch Reguler',
                    'Backup Terjadwal Basis Data ke Cloud Terisolasi',
                    'Kunjungan On-Site Darurat 2x per Bulan + Bantuan Remote Tanpa Batas',
                    'Laporan Kinerja Sistem & Rekomendasi Hardware Bulanan'
                ],
                'cta_whatsapp_template' => 'Halo Tim CYBICHI, saya tertarik untuk kontrak *Managed IT & Maintenance Standard* (Rp 3.500.000/bln). Mohon penjelasan alur kerja sama dan SLA penanganannya.',
                'is_highlighted' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($packages as $pkg) {
            ServicePackage::updateOrCreate(['package_name' => $pkg['package_name']], $pkg);
        }
    }
}
