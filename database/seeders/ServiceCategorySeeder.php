<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Healthcare IT & Medical Systems',
                'slug' => 'healthcare-it-systems',
                'short_description' => 'Sistem antrean rumah sakit cerdas, SIMRS, integrasi kartu BPJS, dan display poliklinik terpadu.',
                'full_description' => 'Solusi teknologi informasi khusus rumah sakit, klinik spesialis, dan faskes untuk mengoptimalkan alur pelayanan pasien serta efisiensi manajemen medis.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Web Application & Enterprise ERP',
                'slug' => 'web-app-development',
                'short_description' => 'Sistem informasi berbasis web, ERP, POS, E-Commerce, dan Portal Korporat berskala enterprise.',
                'full_description' => 'Kami merancang dan membangun sistem informasi web arsitektur modern berkecepatan tinggi, aman dari celah siber, serta mudah dioperasikan oleh staf perusahaan.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile & Desktop App',
                'slug' => 'mobile-desktop-app',
                'short_description' => 'Aplikasi native Android/iOS dan software desktop kasir/loket sinkronisasi real-time.',
                'full_description' => 'Pengembangan aplikasi mobile berbasis Flutter/React Native dan desktop application terintegrasi langsung dengan database pusat.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Internet Service & Network (ISP/Corporate)',
                'slug' => 'internet-network-isp',
                'short_description' => 'Akses internet dedicated, instalasi Fiber Optik, konfigurasi MikroTik, VLAN & hotspot manajemen.',
                'full_description' => 'Penyediaan dan optimalisasi infrastruktur jaringan internet kantor, hotel, dan kawasan komersial dengan jaminan SLA uptime 99.8%.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Cloud, Server & DevOps',
                'slug' => 'cloud-server-devops',
                'short_description' => 'Setup VPS enterprise, dedicated server, hardening keamanan, SSL manajemen & backup terpusat.',
                'full_description' => 'Layanan arsitektur komputasi awan andal dengan pemulihan bencana otomatis dan isolasi data perbankan/finansial.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'IT Hardware & Smart Security',
                'slug' => 'hardware-smart-security',
                'short_description' => 'Pengadaan server fisik, integrasi IP Camera CCTV, access door RFID & smart office.',
                'full_description' => 'Penyediaan perangkat keras komputasi dan instalasi sistem keamanan pintar gedung kantor terpusat.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Managed IT Support & Maintenance',
                'slug' => 'managed-it-support',
                'short_description' => 'Kontrak pemeliharaan rutin software, hardware, dan dukungan tim IT outsource profesional.',
                'full_description' => 'Layanan tim teknis berdedikasi untuk menjamin kelancaran operasional IT harian bisnis Anda tanpa repot merekrut tim internal.',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            ServiceCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
