@extends('layouts.admin')

@section('title', 'Manajemen Produk & Domain Demo')
@section('header_title', 'Daftar Portofolio Produk & Direct Demo')

@section('content')

<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Katalog Produk &amp; Direct Demo Hub</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola link domain uji coba, kredensial akun login demo, dan status pemantauan uptime.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
                + Tambah Produk Demo
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode produk..." class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 w-full sm:w-64">
            
            <select name="category_id" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="status" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                <option value="">Semua Status Uptime</option>
                <option value="online" {{ request('status') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">Reset</a>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5">Kode</th>
                        <th class="p-3.5">Nama Produk</th>
                        <th class="p-3.5">Kategori</th>
                        <th class="p-3.5">Harga Dasar</th>
                        <th class="p-3.5 text-center">Status Uptime</th>
                        <th class="p-3.5 text-center">Demo Clicks</th>
                        <th class="p-3.5 text-center">Featured</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-slate-800">
                                {{ $product->product_code }}
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-slate-900">{{ $product->title }}</div>
                                <div class="text-[11px] text-slate-500 truncate max-w-xs">{{ $product->demo_url ?? 'Tidak ada URL demo' }}</div>
                            </td>
                            <td class="p-3.5 text-slate-600">
                                {{ $product->category->name }}
                            </td>
                            <td class="p-3.5 font-mono text-slate-800">
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </td>
                            <td class="p-3.5 text-center">
                                @if($product->isOnline())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        ONLINE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        MAINTENANCE
                                    </span>
                                @endif
                                <form action="{{ route('admin.products.check-health', $product) }}" method="POST" class="inline-block ml-1">
                                    @csrf
                                    <button type="submit" class="text-[10px] text-blue-600 hover:underline" title="Periksa Uptime Sekarang">
                                        [Cek]
                                    </button>
                                </form>
                            </td>
                            <td class="p-3.5 text-center font-mono font-bold text-slate-700">
                                {{ number_format($product->demo_click_count) }}
                            </td>
                            <td class="p-3.5 text-center">
                                @if($product->is_featured)
                                    <span class="text-emerald-600 font-bold">✓ Ya</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-1 shrink-0">
                                @if($product->has_live_demo && !empty($product->demo_url))
                                    <a href="{{ route('demo.redirect', $product->slug) }}" target="_blank" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded text-[11px]">
                                        Demo ↗
                                    </a>
                                @endif
                                <a href="{{ route('admin.products.edit', $product) }}" class="px-2 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded text-[11px]">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                            <td colspan="8" class="p-8 text-center text-slate-400">Belum ada produk yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

</div>

@endsection
