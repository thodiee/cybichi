@extends('layouts.app')

@section('title', 'Portal Dokumen Resmi & E-Invoice — CYBICHI')

@section('content')

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Verification Banner Badge -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xl relative overflow-hidden">
            <!-- Glow background -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-8 border-b border-slate-100 gap-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>DOKUMEN RESMI TERVERIFIKASI SISTEM</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                        Portal Tagihan &amp; Perjanjian Klien
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Diterbitkan oleh PT CYBICHI TEKNOLOGI NUSANTARA untuk {{ $invoice->client->contact_name }}
                    </p>
                </div>

                <!-- Status Badge -->
                <div class="sm:text-right">
                    <span class="text-xs font-bold text-slate-400 block uppercase tracking-wider mb-1">Status Pembayaran</span>
                    @if($invoice->payment_status === 'paid')
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            PAID / LUNAS
                        </span>
                    @elseif($invoice->payment_status === 'partial_dp')
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            DP TELAH DIBAYAR (50%)
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                            UNPAID / MENUNGGU TRANSFER
                        </span>
                    @endif
                </div>
            </div>

            <!-- Summary Key-Value Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 my-8">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Nomor Invoice</span>
                    <div class="text-sm font-bold text-slate-900 font-mono mt-1">{{ $invoice->invoice_number }}</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Terbit: {{ $invoice->issue_date->translatedFormat('d M Y') }}</div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Tagihan Saat Ini</span>
                    <div class="text-lg font-black text-blue-700 font-mono mt-1">{{ $invoice->formatted_balance_due }}</div>
                    <div class="text-[11px] text-rose-600 font-semibold mt-0.5">Jatuh Tempo: {{ $invoice->due_date->translatedFormat('d M Y') }}</div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] font-bold text-slate-400 uppercase">Nomor Perjanjian MoU</span>
                    <div class="text-sm font-bold text-slate-900 font-mono mt-1">
                        {{ $agreement ? $agreement->agreement_number : 'Belum Ditautkan' }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Garansi: 3 Bulan Dukungan Teknis</div>
                </div>
            </div>

            <!-- Download Buttons Block -->
            <div class="bg-blue-50/60 border border-blue-200/80 rounded-2xl p-6 mb-8">
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Unduh Berkas Resmi (PDF Ber-QR Code)</span>
                </h3>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('doc.download.invoice', $invoice->uuid) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Unduh PDF Invoice Resmi</span>
                    </a>

                    @if($agreement)
                        <a href="{{ route('doc.download.agreement', $agreement->uuid) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unduh PDF Perjanjian MoU &amp; SPK</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Items Table -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-3">Rincian Komponen Tagihan</h3>
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                            <tr>
                                <th class="p-3.5">Deskripsi Item</th>
                                <th class="p-3.5 text-center">Kuantitas</th>
                                <th class="p-3.5 text-right">Harga Satuan</th>
                                <th class="p-3.5 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-800">{{ $item->item_name }}</div>
                                        @if($item->item_description)
                                            <div class="text-slate-500 text-[11px] mt-0.5">{{ $item->item_description }}</div>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center text-slate-600">{{ number_format($item->quantity, 0) }} {{ $item->unit_name }}</td>
                                    <td class="p-3.5 text-right font-mono text-slate-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="p-3.5 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-200 font-semibold">
                            <tr>
                                <td colspan="3" class="p-3 text-right text-slate-500">Nilai Total Proyek:</td>
                                <td class="p-3 text-right font-mono font-bold text-slate-900">{{ $invoice->formatted_grand_total }}</td>
                            </tr>
                            @if($invoice->amount_paid > 0)
                                <tr>
                                    <td colspan="3" class="p-3 text-right text-emerald-600">Telah Dibayar (DP):</td>
                                    <td class="p-3 text-right font-mono font-bold text-emerald-600">- {{ $invoice->formatted_amount_paid }}</td>
                                </tr>
                            @endif
                            <tr class="bg-blue-50/80 text-blue-900 text-sm">
                                <td colspan="3" class="p-3.5 text-right font-bold">Sisa Tagihan yang Harus Dibayar:</td>
                                <td class="p-3.5 text-right font-mono font-black">{{ $invoice->formatted_balance_due }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Bank Accounts Info -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-8 text-xs">
                <h4 class="font-bold text-slate-900 uppercase tracking-wider text-xs mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Rekening Pembayaran Resmi CYBICHI</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-3 rounded-xl border border-slate-200 font-mono">
                        <div class="font-bold font-sans text-blue-800 text-sm">BCA</div>
                        <div class="text-sm font-bold text-slate-900 my-1">8800-1234-5678</div>
                        <div class="text-[10px] text-slate-500 font-sans">a/n PT CYBICHI TEKNOLOGI NUSANTARA</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200 font-mono">
                        <div class="font-bold font-sans text-blue-800 text-sm">Mandiri</div>
                        <div class="text-sm font-bold text-slate-900 my-1">137-00-9876543-2</div>
                        <div class="text-[10px] text-slate-500 font-sans">a/n PT CYBICHI TEKNOLOGI NUSANTARA</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200 font-mono">
                        <div class="font-bold font-sans text-blue-800 text-sm">BRI</div>
                        <div class="text-sm font-bold text-slate-900 my-1">0341-01-000987-30-5</div>
                        <div class="text-[10px] text-slate-500 font-sans">a/n PT CYBICHI TEKNOLOGI NUSANTARA</div>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Confirmation Button -->
            <div class="text-center pt-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '6281299887766')) }}?text={{ rawurlencode('Halo Tim CYBICHI, saya ingin konfirmasi pembayaran Invoice ' . $invoice->invoice_number . ' senilai ' . $invoice->formatted_balance_due . '. Berikut saya lampirkan bukti transfer.') }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Konfirmasi Bukti Transfer ke WhatsApp Admin</span>
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
