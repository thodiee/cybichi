<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }} - CYBICHI</title>
    <style>
        @page {
            margin: 25mm 20mm 20mm 20mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .brand-title {
            font-size: 20pt;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 8pt;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .company-meta {
            font-size: 8.5pt;
            color: #475569;
            line-height: 1.35;
        }
        .invoice-title {
            font-size: 18pt;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-partial {
            background-color: #fef3c7;
            color: #b45309;
        }
        .badge-unpaid {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-col {
            width: 50%;
            vertical-align: top;
            font-size: 9.5pt;
        }
        .info-label {
            font-size: 8pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .info-value {
            color: #0f172a;
            font-weight: 500;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f8fafc;
            color: #334155;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 12px;
            border-top: 1px solid #cbd5e1;
            border-bottom: 2px solid #94a3b8;
            text-align: left;
        }
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5pt;
            vertical-align: top;
        }
        .items-table .text-right {
            text-align: right;
        }
        .items-table .text-center {
            text-align: center;
        }
        .calc-table {
            width: 100%;
            margin-top: 10px;
        }
        .calc-table td {
            padding: 4px 8px;
            font-size: 9.5pt;
        }
        .grand-total-row td {
            border-top: 2px solid #2563eb;
            border-bottom: 2px solid #2563eb;
            font-size: 11pt;
            font-weight: bold;
            color: #1e40af;
            padding: 8px 8px;
        }
        .balance-due-row td {
            background-color: #eff6ff;
            font-weight: bold;
            color: #1d4ed8;
            font-size: 11pt;
            padding: 8px 8px;
        }
        .footer-table {
            width: 100%;
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .bank-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            font-size: 8.5pt;
        }
        .qr-box {
            text-align: center;
            vertical-align: top;
        }
        .qr-img {
            width: 95px;
            height: 95px;
        }
        .stamp-box {
            text-align: center;
            vertical-align: top;
            width: 220px;
        }
        .sign-line {
            margin-top: 55px;
            border-top: 1px solid #475569;
            font-weight: bold;
            font-size: 9pt;
            color: #0f172a;
        }
    </style>
</head>
<body>

    <!-- Header Letterhead -->
    <table class="header-table">
        <tr>
            <td style="width: 55%; vertical-align: middle;">
                <div class="brand-title">{{ \App\Models\SiteSetting::get('brand_name', 'CYBICHI') }}</div>
                <div class="brand-subtitle">{{ \App\Models\SiteSetting::get('brand_tagline', 'SECURE TECHNOLOGY, EMPOWERING FUTURES') }}</div>
                <div class="company-meta" style="margin-top: 6px;">
                    <strong>{{ \App\Models\SiteSetting::get('legal_entity_name', 'PT Siber Cybichi Solusindo') }}</strong><br>
                    NPWP: {{ \App\Models\SiteSetting::get('tax_id', '01.234.567.8-012.000') }}<br>
                    {!! nl2br(e(\App\Models\SiteSetting::get('office_address', "Cyber 2 Tower Lt. 18, Jl. H.R. Rasuna Said\nJakarta Selatan 12950, Indonesia"))) !!}<br>
                    Email: {{ \App\Models\SiteSetting::get('contact_email', 'corporate@cybichi.com') }} | WA: {{ \App\Models\SiteSetting::get('contact_whatsapp', '081234567890') }}
                </div>
            </td>
            <td style="width: 45%; vertical-align: top; text-align: right;">
                <div class="invoice-title">INVOICE</div>
                <div style="font-size: 11pt; font-family: monospace; font-weight: bold; color: #2563eb; margin-top: 3px;">
                    {{ $invoice->invoice_number }}
                </div>
                <div style="margin-top: 8px;">
                    @if($invoice->payment_status === 'paid')
                        <span class="badge badge-paid">PAID / LUNAS</span>
                    @elseif($invoice->payment_status === 'partial_dp')
                        <span class="badge badge-partial">DP PAID (TERBAYAR SEBAGIAN)</span>
                    @else
                        <span class="badge badge-unpaid">UNPAID / MENUNGGU PEMBAYARAN</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Billing Info -->
    <table class="info-grid">
        <tr>
            <td class="info-col">
                <div class="info-label">DITUJUKAN KEPADA (KLIEN):</div>
                <div class="info-value" style="font-size: 11pt; font-weight: bold;">
                    {{ $invoice->client->contact_name }}
                </div>
                @if($invoice->client->company_name)
                    <div style="font-weight: 600; color: #334155;">{{ $invoice->client->company_name }}</div>
                @endif
                @if($invoice->client->address)
                    <div style="font-size: 8.5pt; color: #64748b; margin-top: 3px;">{{ $invoice->client->address }}</div>
                @endif
                <div style="font-size: 8.5pt; color: #475569; margin-top: 3px;">
                    WhatsApp: {{ $invoice->client->whatsapp_number }} | Email: {{ $invoice->client->email ?? '-' }}
                </div>
            </td>
            <td class="info-col" style="text-align: right;">
                <div class="info-label">RINCIAN DOKUMEN:</div>
                <div style="font-size: 9pt;">
                    <strong>Tanggal Terbit:</strong> {{ $invoice->issue_date->translatedFormat('d F Y') }}<br>
                    <strong>Jatuh Tempo:</strong> <span style="color: #b91c1c; font-weight: bold;">{{ $invoice->due_date->translatedFormat('d F Y') }}</span><br>
                    <strong>Skema Pembayaran:</strong> 
                    @if($invoice->billing_type === 'down_payment') Uang Muka (Down Payment)
                    @elseif($invoice->billing_type === 'milestone_termin') Termin Berkelanjutan
                    @elseif($invoice->billing_type === 'final_settlement') Pelunasan Akhir
                    @elseif($invoice->billing_type === 'recurring') Langganan Bulanan
                    @else Sekali Bayar (Full)
                    @endif
                    <br>
                    <strong>Proyek / Produk:</strong> {{ $invoice->project_title }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 50%;">Deskripsi Layanan &amp; Spesifikasi Produk</th>
                <th style="width: 12%;" class="text-center">Kuantitas</th>
                <th style="width: 16%;" class="text-right">Harga Satuan</th>
                <th style="width: 17%;" class="text-right">Total (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $idx => $item)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>
                        <strong style="color: #0f172a;">{{ $item->item_name }}</strong>
                        @if($item->item_description)
                            <div style="font-size: 8.5pt; color: #64748b; margin-top: 2px;">
                                {{ $item->item_description }}
                            </div>
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }} {{ $item->unit_name }}</td>
                    <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals Calculation -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                @if($invoice->admin_notes)
                    <div style="background-color: #f8fafc; border-left: 3px solid #2563eb; padding: 8px 12px; font-size: 8.5pt;">
                        <strong style="color: #1e40af;">Catatan Khusus / Garansi:</strong><br>
                        {{ $invoice->admin_notes }}
                    </div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table class="calc-table">
                    <tr>
                        <td class="text-right" style="color: #64748b;">Subtotal:</td>
                        <td class="text-right" style="width: 140px; font-weight: 600;">
                            Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                        <tr>
                            <td class="text-right" style="color: #15803d;">Diskon Disepakati:</td>
                            <td class="text-right" style="color: #15803d; font-weight: 600;">
                                - Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                    @if($invoice->tax_amount > 0)
                        <tr>
                            <td class="text-right" style="color: #64748b;">PPN ({{ $invoice->tax_percentage }}%):</td>
                            <td class="text-right" style="font-weight: 600;">
                                + Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td class="text-right">NILAI TOTAL PROYEK:</td>
                        <td class="text-right">{{ $invoice->formatted_grand_total }}</td>
                    </tr>
                    @if($invoice->amount_paid > 0)
                        <tr>
                            <td class="text-right" style="color: #15803d; font-weight: bold;">Telah Dibayar (DP):</td>
                            <td class="text-right" style="color: #15803d; font-weight: bold;">
                                {{ $invoice->formatted_amount_paid }}
                            </td>
                        </tr>
                    @endif
                    <tr class="balance-due-row">
                        <td class="text-right">TAGIHAN SAAT INI:</td>
                        <td class="text-right">{{ $invoice->formatted_balance_due }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer: Bank Accounts, QR Code Verification, Stamp -->
    <table class="footer-table">
        <tr>
            <td style="width: 48%; vertical-align: top;">
                <div class="bank-box">
                    <strong style="color: #1e40af; font-size: 9pt;">REKENING PEMBAYARAN RESMI CYBICHI:</strong><br>
                    <div style="margin-top: 4px; line-height: 1.4;">
                        <strong>BCA:</strong> 8800-1234-5678 a/n PT CYBICHI TEKNOLOGI NUSANTARA<br>
                        <strong>Mandiri:</strong> 137-00-9876543-2 a/n PT CYBICHI TEKNOLOGI NUSANTARA<br>
                        <strong>BRI:</strong> 0341-01-000987-30-5 a/n PT CYBICHI TEKNOLOGI NUSANTARA
                    </div>
                    <div style="margin-top: 6px; font-size: 7.5pt; color: #64748b;">
                        *Mohon cantumkan nomor invoice <strong>{{ $invoice->invoice_number }}</strong> pada berita transfer dan konfirmasi via WhatsApp.
                    </div>
                </div>
            </td>
            <td style="width: 22%;" class="qr-box">
                <img src="{{ $qrDataUri }}" class="qr-img" alt="QR Code Verifikasi"><br>
                <div style="font-size: 7pt; color: #64748b; margin-top: 4px;">
                    <strong>PINDAI UNTUK VERIFIKASI</strong><br>
                    Keaslian Dokumen Terdaftar
                </div>
            </td>
            <td style="width: 30%;" class="stamp-box">
                <div style="font-size: 8.5pt; color: #64748b;">Jakarta, {{ $invoice->issue_date->translatedFormat('d F Y') }}</div>
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; margin-top: 2px;">
                    PT CYBICHI TEKNOLOGI NUSANTARA
                </div>
                <div class="sign-line">
                    FOUNDER / MANAGEMENT CYBICHI
                </div>
                <div style="font-size: 7.5pt; color: #15803d; font-weight: 600; margin-top: 2px;">
                    [TERVERIFIKASI SISTEM DIGITAL]
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
