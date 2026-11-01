@extends('layouts.admin')

@section('title', 'Dashboard Utama')
@section('header_title', 'Ringkasan Eksekutif & Operasional')

@section('content')

<div class="space-y-8">

    <!-- Quick Action Bar -->
    <div class="bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div>
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-blue-500/30 text-blue-200 border border-blue-400/30 mb-2">
                PUSAT AKSI BISNIS CEPAT
            </span>
            <h2 class="text-xl sm:text-2xl font-extrabold font-heading">
                Kelola Portofolio, Invoice &amp; Kontrak Kerja Sama
            </h2>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">
                Terkoneksi langsung ke katalog live demo publik dan modul otomatis pembuatan dokumen tagihan &amp; MoU saat kesepakatan WhatsApp tercapai.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <a href="{{ route('admin.invoices.create') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow transition-all">
                + Buat E-Invoice
            </a>
            <a href="{{ route('admin.agreements.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow transition-all">
                + Terbitkan MoU/SPK
            </a>
            <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition-all">
                + Tambah Demo
            </a>
        </div>
    </div>

    <!-- 4 Key Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Products & Health -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Produk Demo Aktif</span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
            </div>
            <div>
                <div class="text-3xl font-black text-slate-900 font-heading">{{ $totalProducts }}</div>
                <div class="text-[11px] text-slate-500 mt-2 flex items-center gap-2">
                    <span class="text-emerald-600 font-bold">● {{ $onlineDemos }} Online</span>
                    <span>•</span>
                    <span class="text-amber-600 font-bold">● {{ $maintenanceDemos }} Maint</span>
                </div>
            </div>
        </div>

        <!-- Total Demo Clicks -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Klik Outbound Demo</span>
                <span class="p-2 rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                </span>
            </div>
            <div>
                <div class="text-3xl font-black text-slate-900 font-heading">{{ number_format($totalDemoClicks) }}</div>
                <div class="text-[11px] text-slate-500 mt-2">
                    Tab baru dibuka pengunjung publik
                </div>
            </div>
        </div>

        <!-- Paid Revenue -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Terbayar</span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div>
                <div class="text-2xl font-black text-emerald-700 font-mono">Rp {{ number_format($paidRevenue, 0, ',', '.') }}</div>
                <div class="text-[11px] text-slate-500 mt-2">
                    Dari {{ $totalInvoices }} invoice proyek diterbitkan
                </div>
            </div>
        </div>

        <!-- Pending Receivables -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Piutang Berjalan</span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div>
                <div class="text-2xl font-black text-amber-700 font-mono">Rp {{ number_format($pendingReceivables, 0, ',', '.') }}</div>
                <div class="text-[11px] text-slate-500 mt-2">
                    Menunggu pelunasan / verifikasi BAST
                </div>
            </div>
        </div>

    </div>

    <!-- Two Column: Recent Invoices & Recent WhatsApp Leads -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Invoices Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 font-heading">E-Invoice Terbaru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar tagihan termin dan proyek yang baru diterbitkan</p>
                    </div>
                    <a href="{{ route('admin.invoices.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="p-3.5">Nomor &amp; Klien</th>
                                <th class="p-3.5">Tagihan</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentInvoices as $inv)
                                <tr>
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-900 font-mono">{{ $inv->invoice_number }}</div>
                                        <div class="text-slate-500 text-[11px]">{{ $inv->client->contact_name }}</div>
                                    </td>
                                    <td class="p-3.5 font-mono font-bold text-slate-800">
                                        {{ $inv->formatted_balance_due }}
                                    </td>
                                    <td class="p-3.5">
                                        @if($inv->payment_status === 'paid')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">PAID</span>
                                        @elseif($inv->payment_status === 'partial_dp')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">DP PAID</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">UNPAID</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-right space-x-1">
                                        <a href="{{ route('admin.invoices.show', $inv) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Lihat">
                                            Buka
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                <a href="{{ route('admin.invoices.create') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                    + Terbitkan Invoice Baru
                </a>
            </div>
        </div>

        <!-- Recent Inquiries Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 font-heading">Prospek &amp; Konsultasi WhatsApp</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Leads masuk dari formulir website dan halaman demo</p>
                    </div>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                        Lihat Semua ({{ $totalInquiries }}) →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="p-3.5">Kode &amp; Nama</th>
                                <th class="p-3.5">Kategori / Produk</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5 text-right">WA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentInquiries as $inq)
                                <tr>
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-900 font-mono">{{ $inq->inquiry_code }}</div>
                                        <div class="text-slate-500 text-[11px]">{{ $inq->client_name }} ({{ $inq->company_name ?? '-' }})</div>
                                    </td>
                                    <td class="p-3.5 text-slate-600">
                                        {{ $inq->product ? $inq->product->title : $inq->interested_category }}
                                    </td>
                                    <td class="p-3.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 uppercase">
                                            {{ $inq->status }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-right">
                                        <a href="https://wa.me/{{ $inq->clean_whatsapp }}" target="_blank" class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 font-bold text-[11px] hover:bg-emerald-100">
                                            Chat WA
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-slate-400">Belum ada formulir konsultasi masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                <span class="text-xs text-slate-500">Pipeline prospek terhubung ke kontak resmi WhatsApp</span>
            </div>
        </div>

    </div>

</div>

@endsection
