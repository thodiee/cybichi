<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $healthCat = ServiceCategory::where('slug', 'healthcare-it-systems')->first();
        $webCat = ServiceCategory::where('slug', 'web-app-development')->first();
        $netCat = ServiceCategory::where('slug', 'internet-network-isp')->first();

        $products = [
            [
                'category_id' => $webCat->id,
                'product_code' => 'PRD-WEB-001',
                'title' => 'Metani — Smart Agriculture & Commodity Marketplace',
                'slug' => 'metani-smart-agriculture',
                'client_or_industry' => 'Agribisnis, Koperasi Tani & Ekspor Komoditas',
                'base_price' => 18500000.00,
                'short_summary' => 'Platform digitalisasi rantai pasok agribisnis terpadu dengan integrasi telemetri cuaca, katalog komoditas, dan escrow pembayaran.',
                'full_description' => 'Metani adalah solusi enterprise berbasis web untuk kelompok tani, koperasi, dan agregator komoditas pertanian. Dilengkapi manajemen mitra tani, pencatatan hasil panen presisi, verifikasi kualitas komoditas, integrasi pembayaran termin aman, serta dashboard analitik tren harga pasar secara real-time.',
                'key_features' => [
                    'Katalog Komoditas Pertanian Digital dengan Klasifikasi Mutu Standar Nasional',
                    'Manajemen Database Mitra Petani, Luas Lahan & Histori Hasil Panen',
                    'Sistem Pembayaran Rekening Bersama (Escrow) Otomatis & Penjadwalan Termin',
                    'Dashboard Analitik Fluktuasi Harga Pasar & Estimasi Nilai Panen',
                    'Integrasi Sensor Telemetri IoT Cuaca & Kelembapan Tanah Pertanian',
                    'Pencetakan Surat Jalan & Dokumen Pengiriman BAST Otomatis'
                ],
                'tech_stack' => ['Laravel 13', 'MySQL 8.0', 'Tailwind CSS', 'Vite', 'Alpine.js', 'REST API IoT'],
                'thumbnail_path' => '/assets/images/products/metani-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'http://localhost:8000',
                'demo_usage_guide' => 'Masuk sebagai Super Admin untuk melihat modul manajemen stok komoditas dan verifikasi transaksi, atau masuk sebagai Petani Mitra untuk simulasi pendaftaran hasil panen.',
                'demo_credentials' => [
                    [
                        'role' => 'Super Admin',
                        'username' => 'admin@metani.id',
                        'password' => 'metani2026',
                    ],
                    [
                        'role' => 'Petani Mitra',
                        'username' => 'petani@metani.id',
                        'password' => 'petani2026',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Basis data demo di-reset otomatis setiap hari pukul 00:00 WIB ke kondisi awal.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_id' => $webCat->id,
                'product_code' => 'PRD-WEB-002',
                'title' => 'Ngafe — Intelligent Coffee Shop POS & Multi-Outlet Inventory',
                'slug' => 'ngafe-coffee-shop-pos',
                'client_or_industry' => 'Food & Beverage, Kafe Chain & Resto Modern',
                'base_price' => 14500000.00,
                'short_summary' => 'Sistem kasir cerdas layar sentuh dengan pemotongan stok bahan baku otomatis per gram dan sinkronisasi multi-outlet.',
                'full_description' => 'Ngafe dirancang khusus memenuhi ritme cepat industri F&B modern. Mendukung kasir layar sentuh offline-tolerant, manajemen resep menu dengan pengurangan gramatur biji kopi dan susu secara akurat, integrasi QRIS dinamis, hingga rekapitulasi tutup kas harian tanpa selisih.',
                'key_features' => [
                    'Point of Sale (POS) Layar Sentuh Cepat dengan Antarmuka Responsif',
                    'Manajemen Resep Minuman & Pemotongan Bahan Baku Otomatis per Resep',
                    'Dukungan Multi-Outlet, Multi-Gudang & Hak Akses Kasir/Manager Terpisah',
                    'Integrasi QRIS Statis/Dinamis & Pengiriman Struk Digital via WhatsApp',
                    'Laporan Penjualan Harian, Profit Margin per Menu & Laporan Kasir Kas Masuk/Keluar',
                    'Kompatibel dengan Printer Thermal Bluetooth, USB, dan LAN Network'
                ],
                'tech_stack' => ['Laravel 13', 'Alpine.js', 'MySQL 8.0', 'Thermal Printer ESC/POS', 'Tailwind CSS'],
                'thumbnail_path' => '/assets/images/products/ngafe-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://ngafe.cybichi.com',
                'demo_usage_guide' => 'Gunakan akun Manager untuk mengatur master resep dan harga menu, atau gunakan akun Kasir untuk mencoba simulasi pemesanan meja dan pembayaran cepat.',
                'demo_credentials' => [
                    [
                        'role' => 'Store Manager',
                        'username' => 'manager@ngafe.id',
                        'password' => 'ngafe123',
                    ],
                    [
                        'role' => 'Kasir Outlet',
                        'username' => 'kasir@ngafe.id',
                        'password' => 'kasir123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_id' => $healthCat->id ?? $webCat->id,
                'product_code' => 'PRD-MED-001',
                'title' => 'AntreanRS — Hospital Smart Queue & Medical Check-In Hub',
                'slug' => 'antreanrs-hospital-smart-queue',
                'client_or_industry' => 'Rumah Sakit, Klinik Utama & Pusat Layanan Medis',
                'base_price' => 24000000.00,
                'short_summary' => 'Sistem antrean medis terintegrasi panggilan suara otomatis, kios touchscreen mandiri, dan integrasi poli spesialis.',
                'full_description' => 'AntreanRS menertibkan alur pengunjung fasilitas kesehatan. Menghubungkan loket pendaftaran, display ruang tunggu televisi, panggilan suara multibahasa sintesis, serta ruang periksa dokter dengan estimasi waktu tunggu yang akurat.',
                'key_features' => [
                    'Kios Cetak Tiket Mandiri dengan Pemindaian Barcode Kartu Pasien / BPJS',
                    'Panggilan Suara Text-to-Speech Otomatis Menyebut Nomor Antrean & Nama Poli',
                    'Display Layar TV Ruang Tunggu dengan Video Edukasi & Informasi Dokter Jaga',
                    'Dashboard Meja Dokter untuk Memanggil, Melewati, atau Merujuk Pasien Antrean',
                    'Statistik Waktu Pelayanan Rata-Rata per Dokter & Laporan Kepuasan Pasien',
                    'Arsitektur WebSocket Real-Time Tanpa Perlu Refresh Halaman'
                ],
                'tech_stack' => ['Laravel 13', 'WebSocket Sync', 'MySQL 8.0', 'Web Speech API', 'Tailwind CSS'],
                'thumbnail_path' => '/assets/images/products/antreanrs-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://antreanrs.cybichi.com',
                'demo_usage_guide' => 'Buka peran Loket untuk mencetak nomor antrean baru, dan buka peran Dokter untuk melihat daftar panggilan antrean poliklinik.',
                'demo_credentials' => [
                    [
                        'role' => 'Petugas Loket',
                        'username' => 'loket@antreanrs.id',
                        'password' => 'antrean123',
                    ],
                    [
                        'role' => 'Dokter Poli',
                        'username' => 'dokter@antreanrs.id',
                        'password' => 'dokter123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'category_id' => $webCat->id,
                'product_code' => 'PRD-WEB-004',
                'title' => 'Bilasin — Smart Laundry & Dry Clean Operational System',
                'slug' => 'bilasin-smart-laundry-system',
                'client_or_industry' => 'Usaha Laundry Kiloan/Satuan & Dry Clean Chain',
                'base_price' => 12500000.00,
                'short_summary' => 'Aplikasi operasional laundry lengkap pelacakan status cuci, notifikasi WhatsApp otomatis, dan manajemen kasir.',
                'full_description' => 'Bilasin menyederhanakan seluruh alur kerja laundry dari timbangan masuk hingga pengambilan pakaian. Pelanggan secara otomatis mendapatkan WhatsApp saat pakaian selesai disetrika dan siap diambil, meminimalisir penumpukan cucian.',
                'key_features' => [
                    'Pencatatan Order Kiloan & Satuan Cepat dengan Cetak Nota Mini Thermal',
                    'Pelacakan Tahapan Cuci (Diterima, Dicuci, Pengeringan, Setrika, Siap Ambil)',
                    'Pengiriman Notifikasi WhatsApp Otomatis ke Pelanggan saat Cucian Selesai',
                    'Manajemen Paket Member Langganan, Deposit Saldo & Diskon Promosi',
                    'Laporan Utilisasi Mesin Cuci & Analisis Omset Mingguan/Bulanan',
                    'Sistem Multi-User untuk Kasir, Tim Cuci, dan Pemilik Usaha'
                ],
                'tech_stack' => ['Laravel 13', 'Tailwind CSS', 'MySQL 8.0', 'WhatsApp Gateway API', 'Alpine.js'],
                'thumbnail_path' => '/assets/images/products/bilasin-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://bilasin.cybichi.com',
                'demo_usage_guide' => 'Login sebagai Kasir untuk membuat nota order cucian baru, atau sebagai Owner untuk melihat rekapitulasi omset dan stok deterjen.',
                'demo_credentials' => [
                    [
                        'role' => 'Owner Bisnis',
                        'username' => 'owner@bilasin.id',
                        'password' => 'bilasin123',
                    ],
                    [
                        'role' => 'Kasir / Staf Cuci',
                        'username' => 'kasir@bilasin.id',
                        'password' => 'bilasin123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'category_id' => $webCat->id,
                'product_code' => 'PRD-WEB-005',
                'title' => 'Fastion — Modern Fashion Retail POS & Omnichannel Inventory',
                'slug' => 'fastion-fashion-retail-pos',
                'client_or_industry' => 'Butik, Toko Pakaian & Distributor Fashion Retail',
                'base_price' => 16000000.00,
                'short_summary' => 'Sistem kasir dan manajemen persediaan toko pakaian dengan variasi matriks ukuran/warna dan cetak label barcode.',
                'full_description' => 'Fastion mengatasi kompleksitas inventaris fashion ritel yang memiliki ratusan varian ukuran, warna, dan jenis kain. Menghubungkan kasir penjualan toko dengan sistem stok gudang secara akurat.',
                'key_features' => [
                    'Manajemen Produk Matriks Dua Dimensi (Varian Warna & Ukuran S, M, L, XL, XXL)',
                    'Generator & Pencetak Label Barcode / QR Code Mandiri ke Printer Label',
                    'Kasir Penjualan Berkecepatan Tinggi dengan Dukungan Barcode Scanner',
                    'Mutasi Antar Gudang & Cabang Toko Disertai Dokumen Surat Jalan Resmi',
                    'Laporan Barang Fast Moving vs Slow Moving untuk Optimasi Modal Usaha',
                    'Integrasi Program Loyalitas Poin Pelanggan & Diskon Member'
                ],
                'tech_stack' => ['Laravel 13', 'MySQL 8.0', 'Tailwind CSS', 'Barcode Engine', 'Alpine.js'],
                'thumbnail_path' => '/assets/images/products/fastion-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://fastion.cybichi.com',
                'demo_usage_guide' => 'Masuk sebagai Manager Toko untuk melihat katalog varian produk dan membuat diskon event, atau login sebagai Kasir Butik untuk transaksi.',
                'demo_credentials' => [
                    [
                        'role' => 'Manager Toko',
                        'username' => 'manager@fastion.id',
                        'password' => 'fastion123',
                    ],
                    [
                        'role' => 'Kasir Butik',
                        'username' => 'kasir@fastion.id',
                        'password' => 'fastion123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'category_id' => $webCat->id,
                'product_code' => 'PRD-WEB-006',
                'title' => 'Perpus Online — Enterprise Digital Library & E-Catalog System',
                'slug' => 'perpus-online-digital-library',
                'client_or_industry' => 'Universitas, Sekolah, Instansi Pemerintahan & Lembaga Riset',
                'base_price' => 13500000.00,
                'short_summary' => 'Sistem otomasi perpustakaan berstandar OPAC dengan sirkulasi barcode, denda otomatis, dan portal e-book.',
                'full_description' => 'Perpus Online mendigitalkan seluruh siklus perpustakaan modern. Memudahkan pencarian koleksi buku fisik maupun digital oleh civitas akademika serta mengotomatisasi penagihan keterlambatan peminjaman.',
                'key_features' => [
                    'Katalog Publik Online (OPAC) Berkecepatan Tinggi dengan Pencarian Full-Text',
                    'Modul Sirkulasi Peminjaman & Pengembalian Kilat Berbasis Barcode Buku',
                    'Kalkulasi Denda Keterlambatan Otomatis Dihitung Berdasarkan Hari Kerja',
                    'Portal Pembaca Dokumen PDF & Jurnal Terproteksi Tanpa Fitur Copy Ilegal',
                    'Cetak Kartu Anggota Perpustakaan Ber-Barcode & Berfoto Resmi',
                    'Laporan Statistik Minat Baca, Buku Terpopuler & Inventaris Aset Koleksi'
                ],
                'tech_stack' => ['Laravel 13', 'MySQL 8.0', 'Tailwind CSS', 'PDF Viewer Engine', 'Alpine.js'],
                'thumbnail_path' => '/assets/images/products/perpus-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://perpus.cybichi.com',
                'demo_usage_guide' => 'Masuk sebagai Pustakawan untuk mengelola sirkulasi dan katalog buku, atau jelajahi portal OPAC publik untuk simulasi peminjaman.',
                'demo_credentials' => [
                    [
                        'role' => 'Kepala Perpustakaan',
                        'username' => 'pustakawan@perpus.id',
                        'password' => 'perpus123',
                    ],
                    [
                        'role' => 'Anggota Riset',
                        'username' => 'anggota@perpus.id',
                        'password' => 'perpus123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'category_id' => $netCat->id,
                'product_code' => 'PRD-NET-001',
                'title' => 'ISP Corporate Network & MikroTik Hotspot Controller',
                'slug' => 'isp-network-mikrotik-hotspot',
                'client_or_industry' => 'Kantor Korporat, Hotel, Co-Working Space & Kawasan Komersial',
                'base_price' => 8500000.00,
                'short_summary' => 'Dashboard integrasi MikroTik RouterOS v7 untuk manajemen bandwidth antrean, voucher hotspot, dan failover multi-WAN.',
                'full_description' => 'Solusi manajemen jaringan terpadu CYBICHI untuk mengontrol lalu lintas data internet korporat. Membagi bandwidth secara adil, memblokir situs berbahaya, dan menyediakan portal login Wi-Fi bermerek.',
                'key_features' => [
                    'Integrasi MikroTik RouterOS v7 API untuk Manajemen Bandwidth Otomatis',
                    'Generator Voucher Wi-Fi Hotspot Terintegrasi Cetak Desain Kustom',
                    'Konfigurasi Multi-WAN Failover & Load Balancing Koneksi Cadangan',
                    'Pemisahan Jalur VLAN Tamu (Guest Network) dan Jalur Internal Kantor',
                    'Dashboard Monitoring Uptime Link Fiber Optic & Grafik Bandwidth Real-Time',
                    'Fitur Pembatasan Akses Konten Berbahaya & Prioritas Aplikasi Bisnis (Zoom/Meet)'
                ],
                'tech_stack' => ['RouterOS v7', 'MikroTik API PHP', 'Radius Server', 'Tailwind CSS', 'Laravel 13'],
                'thumbnail_path' => '/assets/images/products/network-thumb.svg',
                'has_live_demo' => true,
                'demo_url' => 'https://netflow.cybichi.com',
                'demo_usage_guide' => 'Masuk sebagai Network Engineer untuk melihat status routerboard, traffic graph live, dan generator voucher hotspot.',
                'demo_credentials' => [
                    [
                        'role' => 'Network Engineer',
                        'username' => 'noc@cybichi.com',
                        'password' => 'nocmikrotik123',
                    ],
                ],
                'show_credentials_publicly' => true,
                'demo_reset_notice' => 'Server demo di-reset otomatis setiap hari pukul 00:00 WIB.',
                'demo_health_status' => 'online',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
