@extends('layouts.admin')

@section('title', 'Detail Perjanjian ' . $agreement->agreement_number)
@section('header_title', 'Detail Perjanjian Kerja Sama (MoU / SPK)')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold font-heading text-slate-900">{{ $agreement->agreement_number }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    @if($agreement->status === 'signed_active') bg-emerald-100 text-emerald-800 border border-emerald-200
                    @elseif($agreement->status === 'issued') bg-blue-100 text-blue-800 border border-blue-200
                    @elseif($agreement->status === 'completed') bg-teal-100 text-teal-800 border border-teal-200
                    @elseif($agreement->status === 'terminated') bg-rose-100 text-rose-800 border border-rose-200
                    @else bg-slate-100 text-slate-700 border border-slate-200
                    @endif">
                    {{ strtoupper(str_replace('_', ' ', $agreement->status)) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Kategori: <strong class="text-slate-700">{{ strtoupper(str_replace('_', ' ', $agreement->template_type)) }}</strong> •
                Diterbitkan pada {{ $agreement->agreement_date->translatedFormat('d F Y') }}
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Download PDF -->
            <a href="{{ route('admin.agreements.download-pdf', $agreement) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh PDF Resmi
            </a>

            <!-- Client Portal -->
            <a href="{{ $agreement->signed_portal_url }}" target="_blank"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Portal Dokumen Klien
            </a>

            <!-- Edit -->
            <a href="{{ route('admin.agreements.edit', $agreement) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                Edit Kontrak
            </a>

            <!-- Linked Invoice Link -->
            @if($agreement->invoice)
            <a href="{{ route('admin.invoices.show', $agreement->invoice) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Invoice: {{ $agreement->invoice->invoice_number }}
            </a>
            @endif
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai Total Kontrak</span>
            <div class="text-xl font-bold font-heading text-blue-700 mt-1">Rp {{ number_format($agreement->contract_value, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-1">Nilai pekerjaan yang disepakati</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Masa Garansi & SLA</span>
            <div class="text-xl font-bold font-heading text-emerald-700 mt-1">{{ $agreement->warranty_period_months }} Bulan</div>
            <p class="text-xs text-slate-400 mt-1">Dukungan teknis bebas biaya</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal Mulai Efektif</span>
            <div class="text-xl font-bold font-heading text-slate-800 mt-1">{{ $agreement->start_date->translatedFormat('d F Y') }}</div>
            <p class="text-xs text-slate-400 mt-1">Kick-off pengerjaan proyek</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Target Penyelesaian</span>
            <div class="text-xl font-bold font-heading text-slate-800 mt-1">
                {{ $agreement->estimated_completion_date ? $agreement->estimated_completion_date->translatedFormat('d F Y') : 'Sesuai SLA' }}
            </div>
            <p class="text-xs text-slate-400 mt-1">Jadwal serah terima sistem</p>
        </div>
    </div>

    <!-- Main Grid: Agreement Details & Parties -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Agreement Terms (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Title & Scope -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Judul Pekerjaan</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-1">{{ $agreement->project_name }}</h2>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <h3 class="text-sm font-bold text-slate-900 mb-2">Pasal 1: Ruang Lingkup Pekerjaan & Serah Terima</h3>
                    <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50/70 p-4 rounded-xl border border-slate-200/70">
                        {{ $agreement->scope_of_work }}
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <h3 class="text-sm font-bold text-slate-900 mb-2">Pasal 2: Nilai Kontrak & Ketentuan Pembayaran</h3>
                    <div class="text-xs text-slate-700 whitespace-pre-line leading-relaxed bg-slate-50/70 p-4 rounded-xl border border-slate-200/70">
                        {{ $agreement->payment_terms_summary }}
                    </div>
                </div>

                @if($agreement->agreement_clauses_html)
                <div class="border-t border-slate-100 pt-4">
                    <h3 class="text-sm font-bold text-slate-900 mb-2">Pasal Tambahan & Ketentuan Khusus</h3>
                    <div class="text-xs text-slate-700 leading-relaxed prose prose-sm max-w-none bg-slate-50/70 p-4 rounded-xl border border-slate-200/70">
                        {!! $agreement->agreement_clauses_html !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Linked Invoice Details -->
            @if($agreement->invoice)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">E-Invoice Terikat</h3>
                        <p class="text-xs text-slate-500">Nomor: <strong class="text-slate-800">{{ $agreement->invoice->invoice_number }}</strong></p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        @if($agreement->invoice->payment_status === 'paid') bg-emerald-100 text-emerald-800
                        @elseif($agreement->invoice->payment_status === 'partial_dp') bg-blue-100 text-blue-800
                        @else bg-amber-100 text-amber-800 @endif">
                        {{ strtoupper(str_replace('_', ' ', $agreement->invoice->payment_status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 p-4 rounded-xl text-xs font-mono">
                    <div>
                        <span class="text-slate-400 block">Total Tagihan:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($agreement->invoice->grand_total, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Terbayar:</span>
                        <span class="font-bold text-emerald-600">Rp {{ number_format($agreement->invoice->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Sisa Tagihan:</span>
                        <span class="font-bold text-amber-700">Rp {{ number_format($agreement->invoice->balance_due, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Jatuh Tempo:</span>
                        <span class="text-slate-700">{{ $agreement->invoice->due_date->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Sidebar: Client info & Cryptographic Hash -->
        <div class="space-y-6">

            <!-- Client Info Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Pihak Kedua (Klien)</h3>
                    @if($agreement->client)
                    <a href="{{ route('admin.clients.edit', $agreement->client) }}" class="text-xs text-blue-600 hover:underline">Edit Klien</a>
                    @endif
                </div>

                @if($agreement->client)
                <div class="space-y-3 text-sm text-slate-600">
                    <div>
                        <span class="text-xs text-slate-400 block">Penanggung Jawab</span>
                        <span class="font-bold text-slate-900">{{ $agreement->client->contact_name }}</span>
                        @if($agreement->client->company_name)
                        <span class="block text-xs font-semibold text-slate-700">{{ $agreement->client->company_name }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">WhatsApp / Telepon</span>
                        <a href="https://wa.me/{{ $agreement->client->clean_whatsapp }}" target="_blank" class="font-mono text-emerald-600 hover:underline">
                            {{ $agreement->client->whatsapp_number }}
                        </a>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Alamat Email</span>
                        <span class="text-slate-800">{{ $agreement->client->email ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Alamat Domisili Klien</span>
                        <span class="text-xs text-slate-700 leading-relaxed">{{ $agreement->client->address ?? '-' }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Cryptographic Verification Box -->
            <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-md space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 text-teal-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white">Digital Anti-Tampering</h4>
                        <p class="text-xs text-slate-400">Integritas dokumen terproteksi SHA-256</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="text-xs text-slate-400 block">SHA-256 Verification Hash:</span>
                    <div class="bg-slate-950 p-2.5 rounded-lg border border-slate-800 text-[11px] font-mono text-teal-400 break-all select-all">
                        {{ $agreement->verification_hash }}
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ $agreement->verification_url }}" target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-slate-950 bg-teal-400 hover:bg-teal-300 rounded-lg transition-colors">
                        Buka Portal Verifikasi Publik
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
