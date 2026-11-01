@extends('layouts.app')

@section('title', 'CYBICHI — Digital Solutions, Software Engineering & IT Infrastructure Hub')
@section('meta_description', 'Sistem Platform Corporate Landing Page, Direct Demo Showcase, E-Invoicing & MoU Generator, serta Dynamic Content Management System (CMS) CYBICHI.')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden pt-12 pb-24 lg:pt-20 lg:pb-32 bg-white border-b border-slate-100">
    <!-- Ambient Gradient & Circuit Vectors (Light Theme) -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 left-1/4 w-96 h-96 bg-blue-400/15 rounded-full blur-3xl"></div>
        <div class="absolute top-20 right-1/4 w-96 h-96 bg-sky-300/20 rounded-full blur-3xl"></div>

        <!-- Tech Circuit Lines (Light Cyan / Slate Traces Matching Mockup) -->
        <svg class="absolute inset-0 w-full h-full opacity-35" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#93C5FD" stroke-width="1.3">
            <path d="M -50 140 H 160 L 210 190 H 380 M 210 190 V 270 H 320 M 480 90 H 660 L 700 130 H 940 L 980 90 H 1300 M 700 130 V 240 H 830 M 120 420 H 290 L 330 460 H 520 M 780 370 H 980 L 1030 420 H 1320" stroke-dasharray="8 4"/>
            <circle cx="160" cy="140" r="3.5" fill="#2563EB" stroke="none" />
            <circle cx="380" cy="190" r="3.5" fill="#0EA5E9" stroke="none" />
            <circle cx="320" cy="270" r="3.5" fill="#2563EB" stroke="none" />
            <circle cx="660" cy="90" r="3.5" fill="#2563EB" stroke="none" />
            <circle cx="940" cy="130" r="3.5" fill="#0EA5E9" stroke="none" />
            <circle cx="830" cy="240" r="3.5" fill="#2563EB" stroke="none" />
            <circle cx="520" cy="460" r="3.5" fill="#0EA5E9" stroke="none" />
            <circle cx="1030" cy="420" r="3.5" fill="#2563EB" stroke="none" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-200/90 text-blue-800 text-xs font-bold mb-6 shadow-xs">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                <span>{{ $settings['hero_badge'] ?? 'Enterprise IT & Healthcare Solutions 2026' }}</span>
                <span class="text-blue-300">|</span>
                <span class="text-blue-600 font-semibold text-[11px]">SECURE TECHNOLOGY, EMPOWERING FUTURES</span>
            </div>

            <!-- Headline -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15] mb-6 font-heading">
                Transforming <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 via-blue-600 to-sky-500">Healthcare &amp; Business</span> with Secure IT Solutions
            </h1>

            <!-- Subheadline -->
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed mb-10 max-w-3xl mx-auto">
                {{ $settings['hero_subheadline'] ?? 'Mitra teknologi strategis untuk rekayasa perangkat lunak enterprise, sistem antrean & rekam medis rumah sakit (Healthcare IT), infrastruktur jaringan berkecepatan tinggi, serta sistem informasi berstandar keamanan global.' }}
            </p>

            <!-- CTA Buttons (Pill Shapes Matching Mockup) -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#demos" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 via-blue-600 to-sky-500 hover:from-blue-700 hover:to-sky-600 text-white font-bold text-sm shadow-xl shadow-blue-500/25 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $settings['hero_cta_demo_text'] ?? 'Eksplorasi Live Demo' }}</span>
                </a>

                <a href="#kontak" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm border-2 border-slate-200/90 shadow-sm transition-all hover:border-blue-400">
                    <span>{{ $settings['hero_cta_wa_text'] ?? 'Konsultasi Proyek Gratis' }}</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Features Highlights Micro-pill -->
            <div class="mt-12 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-500 font-medium">
                <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200/80">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Healthcare IT &amp; Enterprise Ready
                </span>
                <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200/80">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Direct Tab Demo (Tanpa Iframe)
                </span>
                <span class="flex items-center gap-1.5 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200/80">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Generator E-Invoice &amp; MoU Resmi
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Trust Statistics Bar -->
<section class="border-y border-slate-200 bg-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-700 font-heading mb-1">{{ $settings['stats_projects_completed'] ?? '120+' }}</div>
                <div class="text-xs sm:text-sm font-medium text-slate-600">Proyek Web &amp; Aplikasi Selesai</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-700 font-heading mb-1">{{ $settings['stats_active_clients'] ?? '85+' }}</div>
                <div class="text-xs sm:text-sm font-medium text-slate-600">Perusahaan &amp; Klien Korporat</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-teal-600 font-heading mb-1">{{ $settings['stats_uptime_guarantee'] ?? '99.98%' }}</div>
                <div class="text-xs sm:text-sm font-medium text-slate-600">SLA Jaminan Uptime Jaringan</div>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-700 font-heading mb-1">{{ $settings['stats_years_experience'] ?? '8+ Tahun' }}</div>
                <div class="text-xs sm:text-sm font-medium text-slate-600">Dedikasi Solusi IT Terpadu</div>
            </div>
        </div>
    </div>
</section>

<!-- Lini Layanan IT Section -->
<section id="layanan" class="py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">KAPABILITAS MENYELURUH</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 font-heading">
                Lini Layanan Digital &amp; Infrastruktur IT
            </h2>
            <p class="text-sm sm:text-base text-slate-600 mt-4 leading-relaxed">
                CYBICHI memadukan keahlian rekayasa kode mutakhir, manajemen jaringan telekomunikasi, dan tata kelola keamanan informasi kelas enterprise.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-white rounded-2xl p-7 border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 group flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-5 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            @if(str_contains($category->slug, 'health'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0zM12 9v4m-2-2h4"/></svg>
                            @elseif(str_contains($category->slug, 'web'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @elseif(str_contains($category->slug, 'mobile'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            @elseif(str_contains($category->slug, 'internet'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                            @elseif(str_contains($category->slug, 'cloud'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                            @elseif(str_contains($category->slug, 'hardware'))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 font-heading mb-2.5">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                            {{ $category->short_description }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 group-hover:gap-1.5 transition-all">
                            <span>Lihat Demo Produk Terkait</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Direct Demo Showcase Section -->
<section id="demos" class="py-24 bg-white" x-data="{ activeCategory: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">DIRECT DEMO HUB</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 font-heading">
                    Katalog Unggulan &amp; Akses Demo Langsung
                </h2>
                <p class="text-sm text-slate-600 mt-2 max-w-2xl">
                    Salin kredensial login uji coba di bawah ini, lalu klik tombol demo untuk membuka sistem di <strong>tab baru</strong> tanpa batasan iframe.
                </p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors shrink-0">
                <span>Lihat Seluruh Katalog Demo ({{ \App\Models\Product::count() }} Produk)</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <!-- Product Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 flex flex-col group">
                    
                    <!-- Thumbnail Media -->
                    <div class="relative bg-slate-900 aspect-[16/10] overflow-hidden">
                        <img src="{{ asset($product->thumbnail_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        
                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase bg-slate-900/80 backdrop-blur-md text-slate-200 border border-slate-700">
                                {{ $product->product_code }}
                            </span>
                            
                            <!-- Health Status -->
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
                                            AKUN LOGIN UJI COBA
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

                                    @if($product->demo_reset_notice)
                                        <div class="text-[10px] text-slate-500 mt-2 italic flex items-center gap-1">
                                            <span>ℹ️</span> {{ $product->demo_reset_notice }}
                                        </div>
                                    @endif
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

    </div>
</section>

<!-- Mengapa Memilih CYBICHI (Strict Security & Architecture) - Light Theme -->
<section id="keamanan" class="py-24 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-b border-slate-200 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#2563eb_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3.5 py-1 rounded-full border border-teal-200">STANDAR ARSITEKTUR KETAT</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 font-heading">
                Keunggulan Arsitektur &amp; Keamanan CYBICHI
            </h2>
            <p class="text-sm text-slate-600 mt-4 leading-relaxed">
                Kami membangun setiap sistem dengan prinsip Defense-in-Depth dan standar regulasi data medis &amp; finansial, memastikan transaksi dan kontrak terlindungi tanpa celah.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading mb-3 group-hover:text-blue-600 transition-colors">Origin-Aware CSRF &amp; Strict CSP</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Memvalidasi header Origin peramban secara ketat, mencegah serangan injeksi XSS, clickjacking, dan pemalsuan request lintas domain (Cross-Origin Request Forgery).
                </p>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-teal-400 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 text-teal-600 flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading mb-3 group-hover:text-teal-600 transition-colors">QR Code &amp; Kriptografi Dokumen</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Setiap dokumen Invoice dan Perjanjian Kerja Sama (MoU) dilengkapi tanda tangan kriptografi SHA-256 yang dapat diverifikasi keasliannya secara publik lewat QR Code terintegrasi.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 font-heading mb-3 group-hover:text-amber-600 transition-colors">Performa Ultra-Cepat (LCP &lt; 1 Detik)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Dioptimasi menggunakan view caching, pipeline asset Vite, dan lazy-loading cerdas menghasilkan skor Google Lighthouse tinggi dengan waktu muat instan di semua perangkat klien.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Paket Internet & Managed IT (Pricing Cards) -->
<section id="paket-harga" class="py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">TRANSPARANSI BIAYA</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 font-heading">
                Paket Internet Dedicated &amp; Managed IT
            </h2>
            <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                Konektivitas stabil simetris dan pemeliharaan server profesional tanpa biaya tersembunyi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($servicePackages as $package)
                <div class="bg-white rounded-2xl border {{ $package->is_highlighted ? 'border-blue-600 shadow-xl ring-2 ring-blue-600/20' : 'border-slate-200 shadow-sm' }} p-7 flex flex-col justify-between relative">
                    @if($package->is_highlighted)
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider shadow">
                            {{ $package->badge_text ?? 'PALING POPULER' }}
                        </div>
                    @endif

                    <div>
                        <div class="text-xs font-bold uppercase text-slate-500 mb-2">{{ $package->category->name }}</div>
                        <h3 class="text-base font-bold text-slate-900 font-heading mb-4">{{ $package->package_name }}</h3>
                        
                        <div class="mb-6 pb-6 border-b border-slate-100">
                            <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono">{{ $package->formatted_price }}</span>
                            <span class="text-xs text-slate-500">{{ $package->billing_period }}</span>
                        </div>

                        <!-- Specs List -->
                        <ul class="space-y-3 text-xs text-slate-600 mb-8">
                            @foreach($package->specifications as $spec)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    <span>{{ $spec }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ $package->whats_app_url }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full text-center py-2.5 px-4 rounded-xl {{ $package->is_highlighted ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-800' }} font-bold text-xs transition-colors">
                        Pesan via WhatsApp
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Alur Pemesanan & Kerja Sama (MoU Process) -->
<section id="alur-kerja" class="py-24 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">ALUR SATU PINTU</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 font-heading">
                Bagaimana Kerja Sama Berjalan di CYBICHI?
            </h2>
            <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                Mulai dari eksplorasi demo hingga penerbitan kontrak resmi secara instan oleh Admin.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Step 1 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 relative text-center">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-sm flex items-center justify-center mx-auto mb-4 shadow">1</div>
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-2">Coba Live Demo</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Eksplorasi aplikasi di tab baru menggunakan akun login uji coba yang telah disediakan di katalog.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 relative text-center">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-sm flex items-center justify-center mx-auto mb-4 shadow">2</div>
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-2">Diskusi WhatsApp</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Klik tombol pesan untuk berdiskusi spesifikasi kustom, jadwal survei lokasi, dan negosiasi harga.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-blue-200 bg-blue-50/50 relative text-center">
                <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-bold text-sm flex items-center justify-center mx-auto mb-4 shadow">3</div>
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-2">Terbit Invoice &amp; MoU</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Admin menerbitkan PDF Invoice &amp; Perjanjian Kerja Sama resmi lengkap dengan QR Code verifikasi ke WA Anda.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 relative text-center">
                <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold text-sm flex items-center justify-center mx-auto mb-4 shadow">4</div>
                <h3 class="text-sm font-bold text-slate-900 font-heading mb-2">Pemasangan &amp; BAST</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Tim teknis menginstal sistem, melatih staf Anda, dan mengaktifkan garansi purnajual hingga Go-Live.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Formulir Konsultasi Proyek Cepat -->
<section id="kontak" class="py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-xl">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">KONSULTASI GRATIS</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 font-heading">
                    Mulai Proyek IT Anda Bersama CYBICHI
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-2">
                    Kirimkan gambaran kebutuhan Anda. Sistem kami akan meneruskan pesan secara instan ke WhatsApp Admin.
                </p>
            </div>

            <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nama Lengkap *</label>
                        <input type="text" name="client_name" required placeholder="Contoh: Bpk. Budi Santoso" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Perusahaan / Instansi</label>
                        <input type="text" name="company_name" placeholder="Contoh: PT Agro Mandiri" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Nomor WhatsApp Aktif *</label>
                        <input type="text" name="whatsapp_number" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Kategori Kebutuhan</label>
                        <select name="interested_category" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors bg-white">
                            <option value="Pembuatan Aplikasi Web / ERP">Pembuatan Aplikasi Web / ERP</option>
                            <option value="Aplikasi Mobile Android & iOS">Aplikasi Mobile Android &amp; iOS</option>
                            <option value="Pemasangan Internet Dedicated & MikroTik">Pemasangan Internet Dedicated &amp; MikroTik</option>
                            <option value="Setup Cloud Server & Keamanan">Setup Cloud Server &amp; Keamanan</option>
                            <option value="Managed IT Support & Maintenance">Managed IT Support &amp; Maintenance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Gambaran Singkat Proyek *</label>
                    <textarea name="project_brief" rows="4" required placeholder="Jelaskan kebutuhan spesifikasi, lokasi pemasangan, atau fitur yang ingin dibangun..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-colors"></textarea>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold text-sm shadow-xl shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                    <span>Kirim &amp; Lanjutkan ke WhatsApp Admin</span>
                    <svg class="w-4 h-4 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
