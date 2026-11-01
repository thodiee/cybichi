<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'client_code' => 'CLN-2026-001',
                'contact_name' => 'Budi Santoso, S.T.',
                'job_title' => 'Direktur Utama',
                'company_name' => 'PT Nusantara Agro Mandiri',
                'whatsapp_number' => '081234567890',
                'email' => 'budi.santoso@agro-mandiri.co.id',
                'identity_number' => '3171051203850002',
                'address' => 'Gedung Agro Plaza Lt. 5, Jl. Rasuna Said Blok X-2 No. 1, Jakarta Selatan',
                'notes' => 'Klien enterprise untuk proyek implementasi Metani Smart Agriculture di 3 sentra perkebunan Jawa Timur.',
            ],
            [
                'client_code' => 'CLN-2026-002',
                'contact_name' => 'Amanda Putri Rahayu',
                'job_title' => 'Owner & Founder',
                'company_name' => 'CV Harapan Kopi Indonesia',
                'whatsapp_number' => '081987654321',
                'email' => 'amanda@harapankopi.com',
                'identity_number' => '3273014508920004',
                'address' => 'Jl. Riau No. 88, Citarum, Bandung, Jawa Barat',
                'notes' => 'Pemasangan sistem POS Ngafe untuk 4 gerai kafe di Bandung dan Jakarta Selatan.',
            ],
            [
                'client_code' => 'CLN-2026-003',
                'contact_name' => 'dr. Hendra Wijaya, Sp.A',
                'job_title' => 'Kepala Divisi Teknologi Informasi',
                'company_name' => 'RSIA Sehat Sentosa',
                'whatsapp_number' => '081377889900',
                'email' => 'hendra.wijaya@rsiasehatsentosa.com',
                'identity_number' => '3174092401780001',
                'address' => 'Jl. Boulevard Raya Blok QF-1, Kelapa Gading, Jakarta Utara',
                'notes' => 'Pemasangan sistem antrean cerdas AntreanRS untuk 8 poli spesialis dan 4 loket pendaftaran rawat jalan.',
            ],
        ];

        foreach ($clients as $c) {
            Client::updateOrCreate(['client_code' => $c['client_code']], $c);
        }
    }
}
