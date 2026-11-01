@extends('layouts.app')

@section('title', 'Verifikasi Keaslian Dokumen — CYBICHI Official Verification Portal')

@section('content')

<div class="py-16 bg-slate-50 min-h-[75vh] flex items-center justify-center">
    <div class="max-w-xl w-full mx-4">
        
        @if($isValid)
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-2xl text-center relative overflow-hidden">
                <div class="w-16 h-16 rounded-full bg-emerald-100 border-2 border-emerald-400 text-emerald-600 flex items-center justify-center mx-auto mb-5 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>

                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 mb-2">
                    TERVERIFIKASI SAH &amp; TERDAFTAR
                </span>

                <h1 class="text-2xl font-black text-slate-900 font-heading">
                    Dokumen Asli PT CYBICHI TEKNOLOGI NUSANTARA
                </h1>
                <p class="text-xs text-slate-500 mt-2">
                    Dokumen ini telah dipindai dari lembar resmi dan sesuai dengan data transaksi pada server aman CYBICHI.
                </p>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 my-6 text-left text-xs space-y-3 font-medium">
                    @if($invoice)
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Jenis Dokumen:</span>
                            <span class="font-bold text-slate-900">E-Invoice Resmi</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nomor Invoice:</span>
                            <span class="font-bold font-mono text-blue-700">{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nama Klien / Perusahaan:</span>
                            <span class="font-bold text-slate-900">{{ $invoice->client->contact_name }} ({{ $invoice->client->company_name ?? '-' }})</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Proyek / Layanan:</span>
                            <span class="font-bold text-slate-900 text-right">{{ $invoice->project_title }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nilai Kontrak:</span>
                            <span class="font-bold font-mono text-slate-900">{{ $invoice->formatted_grand_total }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal Terbit:</span>
                            <span class="font-bold text-slate-900">{{ $invoice->issue_date->translatedFormat('d F Y') }}</span>
                        </div>
                    @elseif($agreement)
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Jenis Dokumen:</span>
                            <span class="font-bold text-slate-900">Surat Perjanjian Kerja Sama (MoU)</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nomor Perjanjian:</span>
                            <span class="font-bold font-mono text-blue-700">{{ $agreement->agreement_number }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nama Pihak Kedua:</span>
                            <span class="font-bold text-slate-900">{{ $agreement->client->contact_name }} ({{ $agreement->client->company_name ?? '-' }})</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200/80 pb-2">
                            <span class="text-slate-500">Nama Proyek:</span>
                            <span class="font-bold text-slate-900 text-right">{{ $agreement->project_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal Tanda Tangan:</span>
                            <span class="font-bold text-slate-900">{{ $agreement->agreement_date->translatedFormat('d F Y') }}</span>
                        </div>
                    @endif
                </div>

                <div class="text-[11px] font-mono text-slate-400 break-all bg-slate-100 p-2.5 rounded-xl border border-slate-200">
                    Hash Token: {{ $hash }}
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    @if($invoice)
                        <a href="{{ route('doc.view', $invoice->uuid) }}" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow transition-colors">
                            Buka Portal Dokumen Klien →
                        </a>
                    @elseif($agreement)
                        <a href="{{ route('doc.view', $agreement->uuid) }}" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 shadow transition-colors">
                            Buka Portal Dokumen Klien →
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-rose-200 shadow-2xl text-center">
                <div class="w-16 h-16 rounded-full bg-rose-100 border-2 border-rose-400 text-rose-600 flex items-center justify-center mx-auto mb-5 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>

                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-50 text-rose-800 border border-rose-200 mb-2">
                    DOKUMEN TIDAK VALID / PALSU
                </span>

                <h1 class="text-2xl font-black text-slate-900 font-heading">
                    Verifikasi Gagal
                </h1>
                <p class="text-xs text-slate-600 mt-2">
                    Hash token yang Anda pindai tidak terdaftar di basis data resmi CYBICHI. Harap berhati-hati terhadap segala bentuk pemalsuan dokumen atau penagihan palsu atas nama CYBICHI.
                </p>

                <div class="mt-6">
                    <a href="{{ route('home') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs">
                        Kembali ke Beranda CYBICHI
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
