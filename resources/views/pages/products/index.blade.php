@extends('layouts.app')

@section('title', 'Katalog Produk & Direct Demo Showcase — CYBICHI')
@section('meta_description', 'Eksplorasi seluruh daftar portofolio sistem informasi, web aplikasi enterprise, POS, dan demo interaktif yang dikembangkan oleh CYBICHI.')

@section('content')

<!-- Header Banner -->
<div class="bg-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Katalog Produk &amp; Demo</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading">
                    Katalog Produk &amp; Direct Demo Hub
                </h1>
                <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                    Temukan sistem yang paling sesuai dengan kebutuhan industri Anda. Uji coba langsung di tab baru dengan akun demo yang tersedia.
                </p>
            </div>

            <!-- Total Results Counter -->
            <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3.5 py-1.5 rounded-xl border border-slate-200 self-start md:self-end">
                Menampilkan <span class="text-blue-600">{{ $products->total() }}</span> Solusi Sistem
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="mt-8 pt-8 border-t border-slate-100 flex flex-col md:flex-row gap-4 justify-between items-center">
            
            <!-- Category Pills -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
                <a href="{{ route('products.index', array_merge(request()->except('category', 'page'))) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ empty($categorySlug) ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-colors {{ $categorySlug === $cat->slug ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-80 flex items-center gap-2">
                @if($categorySlug)
                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif
                <div class="relative flex-1">
                    <input type="text" 
                           name="q" 
                           value="{{ $queryKeyword }}" 
                           placeholder="Cari sistem atau tech..." 
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 focus:border-blue-600 bg-white">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition-colors">
                    Cari
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Products Grid Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if($products->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-slate-200">
            <div class="text-4xl mb-3">🔍</div>
            <h3 class="text-lg font-bold text-slate-800 font-heading">Tidak Ada Produk yang Cocok</h3>
            <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori Semua.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold text-xs">
                    Reset Filter Pencarian
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 flex flex-col group">
                    
                    <!-- Thumbnail Media -->
                    <div class="relative bg-slate-900 aspect-[16/10] overflow-hidden">
                        <img src="{{ asset($product->thumbnail_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        
                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase bg-slate-900/80 backdrop-blur-md text-slate-200 border border-slate-700">
                                {{ $product->product_code }}
                            </span>
                            
                            @if($product->isOnline())
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase bg-emerald-500/90 text-white backdrop-blur-md flex items-center gap-1.5 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                    LIVE ONLINE
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase bg-amber-500/90 text-white backdrop-blur-md flex items-center gap-1.5 shadow-sm">
                                    MAINTENANCE
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            @if($product->client_or_industry)
                                <div class="text-[11px] font-semibold text-blue-600 mb-1 tracking-wide">
                                    {{ $product->client_or_industry }}
                                </div>
                            @endif
                            <h3 class="text-lg font-bold text-slate-900 font-heading mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4">
                                {{ $product->short_summary }}
                            </p>

                            <!-- Tech Stack Badges -->
                            @if(!empty($product->tech_stack))
                                <div class="flex flex-wrap gap-1.5 mb-5">
                                    @foreach(array_slice($product->tech_stack, 0, 4) as $tech)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Demo Access & Credentials Box -->
                            @if($product->show_credentials_publicly && !empty($product->public_credentials))
                                <div class="bg-slate-50 border border-slate-200/90 rounded-xl p-3.5 mb-5 text-xs">
                                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 mb-2">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                            AKUN LOGIN DEMO
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-normal">Klik untuk salin</span>
                                    </div>

                                    <div class="space-y-1.5">
                                        @foreach($product->public_credentials as $cred)
                                            <div class="flex items-center justify-between bg-white px-2.5 py-1.5 rounded-lg border border-slate-200 font-mono text-[11px]">
                                                <div class="truncate mr-2">
                                                    <span class="text-[9px] font-bold text-blue-700 bg-blue-50 px-1 py-0.5 rounded mr-1 font-sans">{{ $cred['role'] }}</span>
                                                    <span class="text-slate-800">{{ $cred['username'] }}</span>
                                                    <span class="text-slate-400">/</span>
                                                    <span class="text-slate-600">{{ $cred['password'] }}</span>
                                                </div>
                                                <button type="button" 
                                                        onclick="copyToClipboard('{{ $cred['username'] }}', 'Username {{ $cred['username'] }} berhasil disalin!')"
                                                        class="shrink-0 p-1 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" 
                                                        title="Salin Username">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                @if($product->has_live_demo && !empty($product->demo_url))
                                    <a href="{{ route('demo.redirect', $product->slug) }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-sm shadow-blue-500/20 transition-all">
                                        <span>Buka Live Demo</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @else
                                    <button disabled class="flex-1 py-2.5 px-4 rounded-xl bg-slate-100 text-slate-400 font-medium text-xs cursor-not-allowed">
                                        Demo Belum Tersedia
                                    </button>
                                @endif

                                <a href="{{ route('products.show', $product->slug) }}" class="p-2.5 rounded-xl border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 transition-colors" title="Rincian Spesifikasi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </a>
                            </div>

                            <a href="{{ $product->whats_app_inquiry_message }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 font-medium text-[11px] transition-colors">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Pesan / Tanya Produk Ini via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
