@extends('layouts.admin')

@section('title', 'Detail Invoice ' . $invoice->invoice_number)
@section('header_title', 'Detail E-Invoice')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold font-heading text-slate-900">{{ $invoice->invoice_number }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                    @if($invoice->payment_status === 'paid') bg-emerald-100 text-emerald-800 border border-emerald-200
                    @elseif($invoice->payment_status === 'partial_dp') bg-blue-100 text-blue-800 border border-blue-200
                    @elseif($invoice->payment_status === 'unpaid') bg-amber-100 text-amber-800 border border-amber-200
                    @elseif($invoice->payment_status === 'overdue') bg-rose-100 text-rose-800 border border-rose-200
                    @else bg-slate-100 text-slate-700 border border-slate-200
                    @endif">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                        @if($invoice->payment_status === 'paid') bg-emerald-500
                        @elseif($invoice->payment_status === 'partial_dp') bg-blue-500
                        @elseif($invoice->payment_status === 'unpaid') bg-amber-500
                        @else bg-rose-500 @endif"></span>
                    {{ strtoupper(str_replace('_', ' ', $invoice->payment_status)) }}
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Diterbitkan pada {{ $invoice->issue_date->translatedFormat('d F Y') }} • Jatuh Tempo: {{ $invoice->due_date->translatedFormat('d F Y') }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Share WhatsApp -->
            @if($invoice->client)
            <a href="{{ $invoice->whats_app_share_url }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.888 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Kirim via WhatsApp
            </a>
            @endif

            <!-- Download PDF -->
            <a href="{{ route('admin.invoices.download-pdf', $invoice) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh PDF
            </a>

            <!-- Client Portal Link -->
            <a href="{{ $invoice->signed_portal_url }}" target="_blank"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Portal Klien
            </a>

            <!-- Edit -->
            <a href="{{ route('admin.invoices.edit', $invoice) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                Edit
            </a>

            <!-- Generate MoU Contract -->
            @if($invoice->agreements->isEmpty())
            <a href="{{ route('admin.agreements.create', ['invoice_id' => $invoice->id, 'client_id' => $invoice->client_id, 'product_id' => $invoice->product_id]) }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Buat MoU / SPK
            </a>
            @endif
        </div>
    </div>

    <!-- Quick Status Update Card -->
    <div class="bg-gradient-to-r from-blue-50/50 via-slate-50 to-teal-50/30 p-5 rounded-2xl border border-blue-100/70 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600/10 flex items-center justify-center text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Ubah Status Pembayaran</h4>
                <p class="text-xs text-slate-500">Perbarui status tagihan secara instan untuk memperbarui saldo sisa klien.</p>
            </div>
        </div>

        <form action="{{ route('admin.invoices.update-status', $invoice) }}" method="POST" class="flex flex-wrap items-center gap-2">
            @csrf
            @method('PATCH')
            <button type="submit" name="payment_status" value="paid"
                    class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $invoice->payment_status === 'paid' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white text-emerald-700 border border-emerald-300 hover:bg-emerald-50' }}">
                ✓ Lunaskan (PAID)
            </button>
            <button type="submit" name="payment_status" value="partial_dp"
                    class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $invoice->payment_status === 'partial_dp' ? 'bg-blue-700 text-white shadow-xs' : 'bg-white text-blue-700 border border-blue-300 hover:bg-blue-50' }}">
                ✓ Uang Muka (DP)
            </button>
            <button type="submit" name="payment_status" value="unpaid"
                    class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $invoice->payment_status === 'unpaid' ? 'bg-amber-700 text-white shadow-xs' : 'bg-white text-amber-700 border border-amber-300 hover:bg-amber-50' }}">
                Set Belum Bayar
            </button>
        </form>
    </div>

    <!-- Financial Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Subtotal Tagihan</span>
            <div class="text-xl font-bold font-heading text-slate-900 mt-1">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-1">Total rincian sebelum diskon/pajak</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Diskon & PPN</span>
            <div class="text-xl font-bold font-heading text-slate-900 mt-1">
                @if($invoice->discount_amount > 0)
                    -Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}
                @else
                    Rp 0
                @endif
                <span class="text-xs font-normal text-slate-500">/ PPN: Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }} ({{ $invoice->tax_percentage }}%)</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Penyesuaian nilai final</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Nilai Tagihan</span>
            <div class="text-xl font-bold font-heading text-blue-700 mt-1">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</div>
            <p class="text-xs text-slate-400 mt-1">Telah dibayar: Rp {{ number_format($invoice->amount_paid, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs {{ $invoice->balance_due > 0 ? 'border-amber-200 bg-amber-50/20' : 'border-emerald-200 bg-emerald-50/20' }}">
            <span class="text-xs font-semibold {{ $invoice->balance_due > 0 ? 'text-amber-700' : 'text-emerald-700' }} uppercase tracking-wider">Sisa Tagihan (Balance Due)</span>
            <div class="text-xl font-bold font-heading {{ $invoice->balance_due > 0 ? 'text-amber-900' : 'text-emerald-900' }} mt-1">
                Rp {{ number_format($invoice->balance_due, 0, ',', '.') }}
            </div>
            <p class="text-xs {{ $invoice->balance_due > 0 ? 'text-amber-600' : 'text-emerald-600' }} mt-1">
                {{ $invoice->balance_due > 0 ? 'Menunggu pelunasan klien' : 'LUNAS SEPENUHNYA' }}
            </p>
        </div>
    </div>

    <!-- Main Grid: Invoice Data + Client & Notes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Line Items & Scope (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Rincian Pos Tagihan</h3>
                        <p class="text-xs text-slate-500">Proyek: <strong class="text-slate-800">{{ $invoice->project_title }}</strong></p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-slate-100 text-slate-600">
                        {{ strtoupper(str_replace('_', ' ', $invoice->billing_type)) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50/70 text-slate-500 text-xs font-semibold border-b border-slate-200/60 uppercase tracking-wider">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Deskripsi Item</th>
                                <th class="py-3 px-4 text-center w-24">Kuantitas</th>
                                <th class="py-3 px-4 text-right w-36">Harga Satuan</th>
                                <th class="py-3 px-4 text-right w-36">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($invoice->items as $index => $item)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-3.5 px-4 text-center text-slate-400 font-mono text-xs">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-900">{{ $item->item_name }}</div>
                                    @if($item->item_description)
                                    <p class="text-xs text-slate-500 mt-0.5 whitespace-pre-line">{{ $item->item_description }}</p>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-medium">{{ $item->quantity }} {{ $item->unit_name }}</td>
                                <td class="py-3.5 px-4 text-right font-mono text-slate-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50/50 font-semibold text-slate-800 border-t border-slate-200">
                            <tr>
                                <td colspan="4" class="py-3 px-4 text-right text-xs uppercase text-slate-500">Subtotal</td>
                                <td class="py-3 px-4 text-right font-mono">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @if($invoice->discount_amount > 0)
                            <tr>
                                <td colspan="4" class="py-2.5 px-4 text-right text-xs uppercase text-slate-500">Potongan Diskon</td>
                                <td class="py-2.5 px-4 text-right font-mono text-emerald-600">-Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            @if($invoice->tax_amount > 0)
                            <tr>
                                <td colspan="4" class="py-2.5 px-4 text-right text-xs uppercase text-slate-500">PPN ({{ $invoice->tax_percentage }}%)</td>
                                <td class="py-2.5 px-4 text-right font-mono">+Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="text-base bg-blue-50/40 text-blue-900 font-bold">
                                <td colspan="4" class="py-3.5 px-4 text-right">TOTAL TAGIHAN</td>
                                <td class="py-3.5 px-4 text-right font-mono">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="py-2.5 px-4 text-right text-xs uppercase text-slate-500">Telah Dibayar</td>
                                <td class="py-2.5 px-4 text-right font-mono text-emerald-600">Rp {{ number_format($invoice->amount_paid, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="text-base {{ $invoice->balance_due > 0 ? 'bg-amber-50/50 text-amber-900' : 'bg-emerald-50/50 text-emerald-900' }} font-bold">
                                <td colspan="4" class="py-3.5 px-4 text-right">SISA TAGIHAN (BALANCE DUE)</td>
                                <td class="py-3.5 px-4 text-right font-mono">Rp {{ number_format($invoice->balance_due, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($invoice->payment_method_info)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-2">Instruksi Pembayaran & Rekening Resmi</h3>
                <div class="text-xs text-slate-600 whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-200/70 font-mono">
                    {{ $invoice->payment_method_info }}
                </div>
            </div>
            @endif

            <!-- Associated Agreement (MoU) -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Perjanjian Kerja Sama (MoU / SPK) Terkait</h3>
                        <p class="text-xs text-slate-500">Kontrak hukum yang menaungi proyek ini</p>
                    </div>
                    @if($invoice->agreements->isEmpty())
                    <a href="{{ route('admin.agreements.create', ['invoice_id' => $invoice->id, 'client_id' => $invoice->client_id, 'product_id' => $invoice->product_id]) }}"
                       class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                        + Buat Dokumen MoU Sekarang
                    </a>
                    @endif
                </div>

                @if($invoice->agreements->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($invoice->agreements as $agr)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200 bg-slate-50/60">
                            <div>
                                <span class="text-xs font-bold text-blue-700 font-mono">{{ $agr->agreement_number }}</span>
                                <h4 class="text-sm font-semibold text-slate-900 mt-0.5">{{ $agr->project_name }}</h4>
                                <p class="text-xs text-slate-500">Masa Garansi: {{ $agr->warranty_period_months }} Bulan • Status: {{ strtoupper($agr->status) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.agreements.show', $agr) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg">
                                    Buka Detail
                                </a>
                                <a href="{{ route('admin.agreements.download-pdf', $agr) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    Unduh PDF
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic">Belum ada dokumen MoU / SPK yang diterbitkan untuk invoice ini.</p>
                @endif
            </div>

        </div>

        <!-- Sidebar: Client info & Cryptographic Hash -->
        <div class="space-y-6">

            <!-- Client Info Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Informasi Klien</h3>
                    @if($invoice->client)
                    <a href="{{ route('admin.clients.edit', $invoice->client) }}" class="text-xs text-blue-600 hover:underline">Edit Klien</a>
                    @endif
                </div>

                @if($invoice->client)
                <div class="space-y-3 text-sm text-slate-600">
                    <div>
                        <span class="text-xs text-slate-400 block">Nama Kontak / Instansi</span>
                        <span class="font-bold text-slate-900">{{ $invoice->client->contact_name }}</span>
                        @if($invoice->client->company_name)
                        <span class="block text-xs font-semibold text-slate-700">{{ $invoice->client->company_name }}</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">WhatsApp / Telepon</span>
                        <a href="https://wa.me/{{ $invoice->client->clean_whatsapp }}" target="_blank" class="font-mono text-emerald-600 hover:underline">
                            {{ $invoice->client->whatsapp_number }}
                        </a>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Alamat Email</span>
                        <span class="text-slate-800">{{ $invoice->client->email ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Alamat Kantor</span>
                        <span class="text-xs text-slate-700 leading-relaxed">{{ $invoice->client->address ?? '-' }}</span>
                    </div>
                </div>
                @else
                <p class="text-xs text-slate-400">Data klien tidak ditemukan.</p>
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
                        {{ $invoice->verification_hash }}
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ $invoice->verification_url }}" target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-slate-950 bg-teal-400 hover:bg-teal-300 rounded-lg transition-colors">
                        Buka Portal Verifikasi Publik
                    </a>
                </div>
            </div>

            <!-- Internal Admin Notes -->
            @if($invoice->admin_notes)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Internal Admin</h3>
                <p class="text-xs text-slate-600 bg-amber-50/50 p-3 rounded-lg border border-amber-200/50 leading-relaxed whitespace-pre-line">
                    {{ $invoice->admin_notes }}
                </p>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection
