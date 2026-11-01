@extends('layouts.admin')

@section('title', 'Manajemen Perjanjian Kerja Sama (MoU & SPK)')
@section('header_title', 'Perjanjian Kerja Sama (MoU & SPK)')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-heading text-slate-900">Daftar Dokumen Kontrak & MoU</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola seluruh perjanjian kerja sama, SPK pengadaan sistem, dan kontrak SLA berpayung hukum.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.agreements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Terbitkan Dokumen Baru
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.agreements.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor dokumen, klien, atau judul proyek..."
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="sm:col-span-3">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                    <option value="">-- Semua Status --</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="issued" {{ request('status') === 'issued' ? 'selected' : '' }}>Diterbitkan (Issued)</option>
                    <option value="signed_active" {{ request('status') === 'signed_active' ? 'selected' : '' }}>Ditandatangani & Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Berakhir (Terminated)</option>
                </select>
            </div>

            <div class="sm:col-span-3">
                <select name="template_type" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                    <option value="">-- Semua Template --</option>
                    <option value="software_installation" {{ request('template_type') === 'software_installation' ? 'selected' : '' }}>Instalasi Software & Lisensi</option>
                    <option value="custom_development" {{ request('template_type') === 'custom_development' ? 'selected' : '' }}>Pengembangan Kustom</option>
                    <option value="internet_network_contract" {{ request('template_type') === 'internet_network_contract' ? 'selected' : '' }}>Jaringan & Internet SLA</option>
                    <option value="it_maintenance" {{ request('template_type') === 'it_maintenance' ? 'selected' : '' }}>Pemeliharaan (Maintenance)</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex items-center">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Agreements Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/70 text-slate-500 text-xs font-semibold border-b border-slate-200/60 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">No. Perjanjian</th>
                        <th class="py-3.5 px-4">Klien & Lembaga</th>
                        <th class="py-3.5 px-4">Judul Proyek & Kategori</th>
                        <th class="py-3.5 px-4 text-right">Nilai Kontrak</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Tanggal</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($agreements as $agr)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <a href="{{ route('admin.agreements.show', $agr) }}" class="font-mono text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                {{ $agr->agreement_number }}
                            </a>
                            <div class="text-[11px] text-slate-400 mt-0.5">
                                Garansi: {{ $agr->warranty_period_months }} Bln
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($agr->client)
                            <div class="font-medium text-slate-900">{{ $agr->client->contact_name }}</div>
                            <div class="text-xs text-slate-500">{{ $agr->client->company_name ?? '-' }}</div>
                            @else
                            <span class="text-xs text-slate-400 italic">Klien tidak terdaftar</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-medium text-slate-900 line-clamp-1">{{ $agr->project_name }}</div>
                            <span class="inline-block text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                                {{ str_replace('_', ' ', $agr->template_type) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900">
                            Rp {{ number_format($agr->contract_value, 0, ',', '.') }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($agr->status === 'signed_active') bg-emerald-100 text-emerald-800 border border-emerald-200
                                @elseif($agr->status === 'issued') bg-blue-100 text-blue-800 border border-blue-200
                                @elseif($agr->status === 'completed') bg-teal-100 text-teal-800 border border-teal-200
                                @elseif($agr->status === 'terminated') bg-rose-100 text-rose-800 border border-rose-200
                                @else bg-slate-100 text-slate-700 border border-slate-200
                                @endif">
                                {{ strtoupper(str_replace('_', ' ', $agr->status)) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center text-xs text-slate-500">
                            {{ $agr->agreement_date->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-1 whitespace-nowrap">
                            <a href="{{ route('admin.agreements.show', $agr) }}" class="p-1.5 inline-flex text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition-colors" title="Detail Dokumen">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.agreements.download-pdf', $agr) }}" class="p-1.5 inline-flex text-slate-400 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors" title="Unduh PDF Resmi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                            <a href="{{ route('admin.agreements.edit', $agr) }}" class="p-1.5 inline-flex text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 transition-colors" title="Edit Kontrak">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="font-medium text-slate-600">Belum ada dokumen perjanjian yang sesuai.</p>
                            <p class="text-xs text-slate-400 mt-1">Gunakan tombol di atas untuk menerbitkan dokumen perjanjian baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($agreements->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $agreements->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
