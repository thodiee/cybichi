<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perjanjian Kerja Sama {{ $agreement->agreement_number }} - CYBICHI</title>
    <style>
        @page {
            margin: 22mm 20mm 20mm 20mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.55;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .brand-title {
            font-size: 18pt;
            font-weight: bold;
            color: #1e40af;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 8pt;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .company-meta {
            font-size: 8pt;
            color: #475569;
            line-height: 1.3;
        }
        .doc-title {
            text-align: center;
            margin: 15px 0 20px 0;
        }
        .doc-title h2 {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title h3 {
            font-size: 10pt;
            font-weight: bold;
            color: #2563eb;
            margin: 3px 0 0 0;
            font-family: monospace;
        }
        .section-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 14px;
            margin-bottom: 6px;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        .parties-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .parties-table td {
            vertical-align: top;
            padding: 4px 6px;
            font-size: 9pt;
        }
        .pasal-title {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            color: #1e40af;
            margin-top: 12px;
            margin-bottom: 4px;
        }
        .pasal-subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 9.5pt;
            color: #334155;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .scope-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 10px 14px;
            margin: 8px 0;
            font-size: 9pt;
            line-height: 1.5;
        }
        .signatures-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .sig-col {
            width: 38%;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
        }
        .sig-qr {
            width: 24%;
            text-align: center;
            vertical-align: middle;
        }
        .sig-line {
            margin-top: 60px;
            border-top: 1px solid #334155;
            font-weight: bold;
            font-size: 9pt;
            color: #0f172a;
            padding-top: 4px;
        }
        .qr-img {
            width: 90px;
            height: 90px;
        }
    </style>
</head>
<body>

    <!-- Header Letterhead -->
    <table class="header-table">
        <tr>
            <td style="width: 60%; vertical-align: middle;">
                <div class="brand-title">{{ \App\Models\SiteSetting::get('brand_name', 'CYBICHI') }}</div>
                <div class="brand-subtitle">{{ \App\Models\SiteSetting::get('brand_tagline', 'SECURE TECHNOLOGY, EMPOWERING FUTURES') }}</div>
                <div class="company-meta" style="margin-top: 4px;">
                    <strong>{{ \App\Models\SiteSetting::get('legal_entity_name', 'PT Siber Cybichi Solusindo') }}</strong> | NPWP: {{ \App\Models\SiteSetting::get('tax_id', '01.234.567.8-012.000') }}<br>
                    {{ str_replace("\n", ", ", \App\Models\SiteSetting::get('office_address', 'Cyber 2 Tower Lt. 18, Jakarta Selatan 12950')) }}
                </div>
            </td>
            <td style="width: 40%; vertical-align: top; text-align: right;">
                <div style="font-size: 8.5pt; color: #64748b;">
                    Official Corporate Legal Document<br>
                    <strong>ID Dokumen:</strong> <span style="font-family: monospace; color: #2563eb;">{{ substr($agreement->uuid, 0, 13) }}...</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="doc-title">
        <h2>SURAT PERJANJIAN KERJA SAMA (MoU) &amp; SURAT PERINTAH KERJA (SPK)</h2>
        <h3>NOMOR: {{ $agreement->agreement_number }}</h3>
        <div style="font-size: 8.5pt; color: #64748b; margin-top: 2px;">
            Tentang: {{ $agreement->project_name }}
        </div>
    </div>

    <p style="text-align: justify; margin-bottom: 10px; font-size: 9.5pt;">
        Pada hari ini, tanggal <strong>{{ $agreement->agreement_date->translatedFormat('d F Y') }}</strong>, bertempat di Jakarta, telah dibuat dan disepakati perjanjian kerja sama rekayasa perangkat lunak dan layanan teknologi informasi oleh dan antara para pihak sebagai berikut:
    </p>

    <!-- Parties Table -->
    <table class="parties-table">
        <tr>
            <td style="width: 50%; border-right: 1px solid #e2e8f0; padding-right: 12px;">
                <strong style="color: #1e40af;">I. PIHAK PERTAMA (PENYEDIA JASA):</strong><br>
                <strong>Nama Badan Usaha :</strong> {{ \App\Models\SiteSetting::get('legal_entity_name', 'PT Siber Cybichi Solusindo') }}<br>
                <strong>Alamat Kantor    :</strong> {{ str_replace("\n", ", ", \App\Models\SiteSetting::get('office_address', 'Cyber 2 Tower Lt. 18, Jakarta Selatan')) }}<br>
                <strong>Diwakili Oleh    :</strong> Manajemen &amp; Founder CYBICHI<br>
                <strong>Jabatan          :</strong> Direktur Utama<br>
                <em>Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK PERTAMA</strong>.</em>
            </td>
            <td style="width: 50%; padding-left: 12px;">
                <strong style="color: #1e40af;">II. PIHAK KEDUA (PENGGUNA JASA):</strong><br>
                <strong>Nama Klien       :</strong> {{ $agreement->client->contact_name }}<br>
                <strong>Jabatan          :</strong> {{ $agreement->client->job_title ?? 'Pimpinan / Penanggung Jawab Proyek' }}<br>
                <strong>Perusahaan       :</strong> {{ $agreement->client->company_name ?? '-' }}<br>
                <strong>No. Identitas/NPWP:</strong> {{ $agreement->client->identity_number ?? '-' }}<br>
                <strong>Alamat Domisili  :</strong> {{ $agreement->client->address ?? '-' }}<br>
                <em>Selanjutnya dalam perjanjian ini disebut sebagai <strong>PIHAK KEDUA</strong>.</em>
            </td>
        </tr>
    </table>

    <p style="text-align: justify; margin-top: 6px; margin-bottom: 8px; font-size: 9pt;">
        Kedua belah pihak secara sadar dan sepakat untuk mengikatkan diri dalam Perjanjian Kerja Sama Pemasangan dan Implementasi Sistem Teknologi Informasi dengan ketentuan pasal-pasal berikut:
    </p>

    <!-- Pasal 1 -->
    <div class="pasal-title">PASAL 1</div>
    <div class="pasal-subtitle">RUANG LINGKUP PEKERJAAN &amp; SPESIFIKASI SISTEM</div>
    <div style="font-size: 9pt; text-align: justify;">
        PIHAK PERTAMA berkewajiban merancang, mengonfigurasi, dan memasang sistem perangkat lunak untuk kebutuhan operasional PIHAK KEDUA dengan rincian lingkup pekerjaan sebagai berikut:
    </div>
    <div class="scope-box">
        {!! nl2br(e($agreement->scope_of_work)) !!}
    </div>

    <!-- Pasal 2 -->
    <div class="pasal-title">PASAL 2</div>
    <div class="pasal-subtitle">JANGKA WAKTU PENGERJAAN &amp; SERAH TERIMA (BAST)</div>
    <div style="font-size: 9pt; text-align: justify;">
        1. Pelaksanaan pekerjaan dimulai efektif terhitung sejak tanggal <strong>{{ $agreement->start_date->translatedFormat('d F Y') }}</strong> dengan estimasi penyelesaian pada tanggal <strong>{{ $agreement->estimated_completion_date ? $agreement->estimated_completion_date->translatedFormat('d F Y') : '-' }}</strong>.<br>
        2. Setelah seluruh sistem berfungsi sesuai spesifikasi, kedua belah pihak wajib menandatangani Berita Acara Serah Terima (BAST) sebagai bukti selesainya tahapan implementasi.
    </div>

    <!-- Pasal 3 -->
    <div class="pasal-title">PASAL 3</div>
    <div class="pasal-subtitle">NILAI KONTRAK &amp; TATA CARA PEMBAYARAN</div>
    <div style="font-size: 9pt; text-align: justify;">
        1. Total nilai kontrak untuk pelaksanaan seluruh pekerjaan ini adalah sebesar <strong>{{ $agreement->formatted_contract_value }}</strong>.<br>
        2. Ketentuan pembayaran disepakati secara bertahap (termin) sebagai berikut:<br>
        <div style="background-color: #f1f5f9; padding: 6px 10px; margin: 4px 0; border-radius: 4px; font-family: monospace;">
            {!! nl2br(e($agreement->payment_terms_summary)) !!}
        </div>
        3. Pembayaran dilakukan melalui transfer bank resmi ke rekening PT CYBICHI TEKNOLOGI NUSANTARA sebagaimana tercantum pada Invoice resmi.
    </div>

    <!-- Pasal 4 -->
    <div class="pasal-title">PASAL 4</div>
    <div class="pasal-subtitle">GARANSI SISTEM, SLA, &amp; KERAHASIAAN INFORMASI (NDA)</div>
    <div style="font-size: 9pt; text-align: justify;">
        1. <strong>Garansi Pemeliharaan:</strong> PIHAK PERTAMA memberikan jaminan garansi perbaikan bug dan stabilitas performa sistem selama <strong>{{ $agreement->warranty_period_months }} bulan</strong> terhitung sejak penandatanganan BAST.<br>
        2. <strong>Kerahasiaan Data (NDA):</strong> Kedua belah pihak wajib menjaga kerahasiaan seluruh data bisnis, kredensial server, dan informasi transaksi yang diperoleh selama pelaksanaan kerja sama ini.<br>
        3. <strong>Lisensi Penggunaan:</strong> PIHAK KEDUA diberikan hak pakai lisensi komersial penuh atas aplikasi yang dipasang untuk operasional internal perusahaannya.
    </div>

    <!-- Signatures -->
    <table class="signatures-table">
        <tr>
            <td class="sig-col">
                <strong>PIHAK PERTAMA</strong><br>
                PT CYBICHI TEKNOLOGI NUSANTARA<br>
                <div class="sig-line">
                    FOUNDER / MANAGEMENT CYBICHI
                </div>
                <div style="font-size: 7.5pt; color: #15803d; font-weight: bold; margin-top: 2px;">
                    [TERVALIDASI TANDA TANGAN DIGITAL]
                </div>
            </td>
            <td class="sig-qr">
                <img src="{{ $qrDataUri }}" class="qr-img" alt="QR Verifikasi Dokumen"><br>
                <div style="font-size: 7pt; color: #64748b; margin-top: 3px;">
                    <strong>VERIFIKASI KEASLIAN</strong><br>
                    Dokumen Sah Terdaftar di CYBICHI
                </div>
            </td>
            <td class="sig-col">
                <strong>PIHAK KEDUA</strong><br>
                {{ $agreement->client->company_name ?? $agreement->client->contact_name }}<br>
                <div class="sig-line">
                    {{ $agreement->client->contact_name }}
                </div>
                <div style="font-size: 7.5pt; color: #64748b; margin-top: 2px;">
                    {{ $agreement->client->job_title ?? 'Pimpinan / Penanggung Jawab' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
