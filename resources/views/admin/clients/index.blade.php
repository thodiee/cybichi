@extends('layouts.admin')

@section('title', 'Data Klien & Rekanan')
@section('header_title', 'Database Klien & Penanda Tangan Kontrak')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Data Klien Rekanan CYBICHI</h2>
            <p class="text-xs text-slate-500 mt-0.5">Informasi penanggung jawab, instansi perusahaan, dan kontak WhatsApp untuk pembuatan Invoice &amp; MoU.</p>
        </div>
        <a href="{{ route('admin.clients.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
            + Tambah Klien Baru
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex items-center justify-between">
        <form action="{{ route('admin.clients.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, perusahaan, no WA..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800">Cari</button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5">Kode Klien</th>
                        <th class="p-3.5">Nama &amp; Perusahaan</th>
                        <th class="p-3.5">Kontak WhatsApp</th>
                        <th class="p-3.5">Identitas (NIK/NPWP)</th>
                        <th class="p-3.5 text-center">Invoices</th>
                        <th class="p-3.5 text-center">MoU/SPK</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($clients as $client)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-slate-800">
                                {{ $client->client_code }}
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-slate-900">{{ $client->contact_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $client->job_title ? $client->job_title . ' • ' : '' }}{{ $client->company_name ?? '-' }}</div>
                            </td>
                            <td class="p-3.5 font-mono text-slate-700">
                                <a href="https://wa.me/{{ $client->clean_whatsapp }}" target="_blank" class="text-emerald-700 hover:underline flex items-center gap-1 font-semibold">
                                    <span>{{ $client->whatsapp_number }}</span>
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </a>
                            </td>
                            <td class="p-3.5 font-mono text-slate-500">
                                {{ $client->identity_number ?? '-' }}
                            </td>
                            <td class="p-3.5 text-center font-bold font-mono text-blue-700">
                                {{ $client->invoices_count }}
                            </td>
                            <td class="p-3.5 text-center font-bold font-mono text-emerald-700">
                                {{ $client->agreements_count }}
                            </td>
                            <td class="p-3.5 text-right space-x-1 shrink-0">
                                <a href="{{ route('admin.invoices.create', ['client_id' => $client->id]) }}" class="px-2 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold rounded text-[11px]" title="Terbitkan Tagihan Baru untuk Klien Ini">
                                    + Invoice
                                </a>
                                <a href="{{ route('admin.clients.edit', $client) }}" class="px-2 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded text-[11px]">
                                    Edit
                                </a>
                                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data klien ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold rounded text-[11px]">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data klien rekanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $clients->links() }}
        </div>
    </div>

</div>

@endsection
