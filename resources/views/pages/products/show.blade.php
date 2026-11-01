@extends('layouts.app')

@section('title', $product->title . ' — CYBICHI Demo Hub')
@section('meta_description', $product->short_summary)

@section('content')

<div class="bg-white border-b border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-blue-600">Katalog Produk</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate">{{ $product->title }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                        {{ $product->category->name }}
                    </span>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold uppercase bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $product->product_code }}
                    </span>
                    @if($product->isOnline())
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live Demo Online
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-amber-100 text-amber-800">
                            Server Maintenance
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 font-heading">
                    {{ $product->title }}
                </h1>
            </div>

            <!-- Stats Views & Clicks -->
            <div class="flex items-center gap-4 text-xs text-slate-500 shrink-0">
                <span title="Dilihat">{{ number_format($product->view_count) }} Views</span>
                <span>•</span>
                <span title="Demo Diklik">{{ number_format($product->demo_click_count) }} Demo Clicks</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Details Layout -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left: Product Full Overview -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Large Image Preview -->
            <div class="bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 shadow-lg">
                <img src="{{ asset($product->thumbnail_path) }}" alt="{{ $product->title }}" class="w-full h-auto object-cover">
            </div>

            <!-- Summary & Long Description -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm space-y-4">
                <h2 class="text-xl font-bold text-slate-900 font-heading">Deskripsi &amp; Arsitektur Sistem</h2>
                <p class="text-base text-slate-700 leading-relaxed font-medium">
                    {{ $product->short_summary }}
                </p>
                @if($product->full_description)
                    <div class="text-sm text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                        {!! nl2br(e($product->full_description)) !!}
                    </div>
                @endif
            </div>

            <!-- Key Features Checklist -->
            @if(!empty($product->key_features))
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-6 flex items-center gap-2">
                        <span>Fitur Unggulan &amp; Spesifikasi Fungsional</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">
                            {{ count($product->key_features) }} Modul
                        </span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($product->key_features as $feature)
                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-800">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                <span class="font-medium leading-relaxed">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tech Stack & Architecture -->
            @if(!empty($product->tech_stack))
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 font-heading mb-4">Teknologi &amp; Framework yang Digunakan</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->tech_stack as $tech)
                            <span class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Sticky Demo Access Box & Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl p-7 border border-slate-200 shadow-lg sticky top-28 space-y-6">
                
                <!-- Base Reference Price -->
                <div class="pb-6 border-b border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Estimasi Investasi Proyek</span>
                    <div class="text-3xl font-extrabold text-slate-900 font-mono mt-1">
                        @if($product->base_price > 0)
                            Rp {{ number_format($product->base_price, 0, ',', '.') }}
                        @else
                            Sesuai Kustomisasi
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">
                        *Dapat disesuaikan berdasarkan jumlah outlet, server VPS, atau penambahan modul.
                    </p>
                </div>

                <!-- Demo Access & Credentials Box -->
                @if($product->show_credentials_publicly && !empty($product->public_credentials))
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                PANDUAN LOGIN DEMO
                            </span>
                            <span class="text-[10px] text-slate-500 font-normal">1-Click Copy</span>
                        </div>

                        @if($product->demo_usage_guide)
                            <p class="text-[11px] text-slate-600 leading-relaxed italic">
                                "{{ $product->demo_usage_guide }}"
                            </p>
                        @endif

                        <div class="space-y-2">
                            @foreach($product->public_credentials as $cred)
                                <div class="bg-white p-2.5 rounded-lg border border-slate-200 space-y-1.5 font-mono text-xs">
                                    <div class="text-[10px] font-bold text-blue-700 font-sans uppercase">
                                        {{ $cred['role'] }}
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500 text-[11px]">User:</span>
                                        <span class="text-slate-800 font-semibold">{{ $cred['username'] }}</span>
                                        <button type="button" 
                                                onclick="copyToClipboard('{{ $cred['username'] }}', 'Username {{ $cred['username'] }} berhasil disalin!')" 
                                                class="text-blue-600 hover:text-blue-800 text-[10px] font-sans font-bold">
                                            [Salin]
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-500 text-[11px]">Pass:</span>
                                        <span class="text-slate-800 font-semibold">{{ $cred['password'] }}</span>
                                        <button type="button" 
                                                onclick="copyToClipboard('{{ $cred['password'] }}', 'Password berhasil disalin!')" 
                                                class="text-blue-600 hover:text-blue-800 text-[10px] font-sans font-bold">
                                            [Salin]
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($product->demo_reset_notice)
                            <div class="text-[10px] text-slate-500 pt-1 flex items-center gap-1">
                                <span>ℹ️</span> {{ $product->demo_reset_notice }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Primary Action Buttons -->
                <div class="space-y-3 pt-2">
                    @if($product->has_live_demo && !empty($product->demo_url))
                        <a href="{{ route('demo.redirect', $product->slug) }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5">
                            <span>Buka Live Demo di Tab Baru</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @else
                        <button disabled class="w-full py-3.5 px-6 rounded-xl bg-slate-100 text-slate-400 font-bold text-sm cursor-not-allowed">
                            Demo Sedang Dalam Pemeliharaan
                        </button>
                    @endif

                    <a href="{{ $product->whats_app_inquiry_message }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-500/20 transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Diskusi / Pesan via WhatsApp</span>
                    </a>
                </div>

                <div class="pt-4 border-t border-slate-100 text-center">
                    <p class="text-[11px] text-slate-500">
                        Tertarik? Admin CYBICHI dapat segera menerbitkan <strong>Invoice</strong> dan <strong>draf MoU</strong> resmi untuk proyek ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
