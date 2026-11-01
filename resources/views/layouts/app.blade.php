<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CYBICHI — Secure Technology, Empowering Futures | Healthcare & Business IT')</title>
    <meta name="description" content="@yield('meta_description', 'Pusat sistem informasi enterprise, Healthcare IT, etalase portofolio direct demo showcase, serta generator E-Invoice dan Perjanjian Kerja Sama (MoU) resmi CYBICHI.')">
    
    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- OpenGraph -->
    <meta property="og:title" content="@yield('title', 'CYBICHI — Secure Technology, Empowering Futures')">
    <meta property="og:description" content="@yield('meta_description', 'Transforming Healthcare & Business with Secure IT Solutions — CYBICHI.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/cybichi-logo-stacked.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Inter, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }
        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-blue-600 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement / SLA Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 font-medium">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                    SISTEM OPERASIONAL NORMAL
                </span>
                <span class="text-slate-300">Hub Resmi Demo Aplikasi &amp; Administrasi Kontrak IT Terpadu</span>
            </div>
            <div class="flex items-center gap-4 text-slate-300 text-[11px]">
                <a href="mailto:halo@cybichi.com" class="hover:text-white transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    halo@cybichi.com
                </a>
                <span class="text-slate-700">|</span>
                <a href="{{ route('admin.login') }}" class="hover:text-white transition-colors flex items-center gap-1 font-semibold text-blue-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Back-Office Vault
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/90 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('assets/images/cybichi-logo.svg') }}" alt="CYBICHI Logo" class="h-10 w-auto transition-transform group-hover:scale-105">
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-7 font-medium text-sm text-slate-600">
                    <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#layanan" class="hover:text-blue-600 transition-colors">
                        Layanan
                    </a>
                    <a href="{{ route('products.index') }}?category=healthcare-it-systems" class="hover:text-blue-600 transition-colors flex items-center gap-1.5 font-semibold text-blue-700 bg-blue-50/80 px-2.5 py-1 rounded-lg border border-blue-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                        Healthcare IT
                    </a>
                    <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition-colors {{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : '' }}">
                        Katalog Demo
                    </a>
                    <a href="{{ route('home') }}#keamanan" class="hover:text-blue-600 transition-colors">
                        Keamanan
                    </a>
                    <a href="{{ route('home') }}#paket-harga" class="hover:text-blue-600 transition-colors">
                        Paket IT
                    </a>
                    <a href="{{ route('home') }}#kontak" class="hover:text-blue-600 transition-colors">
                        Kontak
                    </a>
                </nav>

                <!-- Right Action CTA (Pill Button Matching Reference Mockup) -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '6281299887766')) }}?text={{ rawurlencode('Halo Tim CYBICHI, saya ingin berkonsultasi mengenai solusi IT, Healthcare IT & software.') }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-blue-600 via-blue-600 to-sky-500 hover:from-blue-700 hover:to-sky-600 text-white text-sm font-bold shadow-md shadow-blue-500/25 hover:shadow-lg hover:shadow-blue-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        <span>Hubungi Kami</span>
                        <svg class="w-4 h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-3" 
             style="display: none;">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Beranda</a>
            <a href="{{ route('home') }}#layanan" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Layanan</a>
            <a href="{{ route('products.index') }}?category=healthcare-it-systems" class="block px-3 py-2 rounded-lg font-bold text-blue-700 bg-blue-50 hover:bg-blue-100">Healthcare IT &amp; Medical</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Katalog Demo Showcase</a>
            <a href="{{ route('home') }}#keamanan" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Keamanan Siber</a>
            <a href="{{ route('home') }}#paket-harga" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Paket Internet &amp; IT</a>
            <a href="{{ route('home') }}#kontak" class="block px-3 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-50">Hubungi Kami</a>
            <div class="pt-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('contact_whatsapp', '6281299887766')) }}"
                   target="_blank"
                   class="block text-center w-full py-2.5 rounded-full bg-gradient-to-r from-blue-600 to-sky-500 text-white font-bold shadow">
                    Hubungi Kami via WhatsApp
                </a>
            </div>
        </div>
    </header>

    <!-- Global Toast / Alerts -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Corporate Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1: Brand & Legal Info -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/cybichi-logo-white.svg') }}" alt="CYBICHI" class="h-9 w-auto">
                    </div>
                    <p class="text-[11px] font-bold text-sky-400 tracking-wider uppercase font-sans">
                        SECURE TECHNOLOGY, EMPOWERING FUTURES
                    </p>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Mitra rekayasa perangkat lunak korporat, Healthcare IT &amp; Sistem Rumah Sakit, infrastruktur jaringan berkecepatan tinggi, serta sistem informasi berstandar keamanan global.
                    </p>
                    <div class="pt-2 text-xs text-slate-400 space-y-1">
                        <p class="text-slate-200 font-semibold">PT CYBICHI TEKNOLOGI NUSANTARA</p>
                        <p>NPWP: 01.234.567.8-901.000</p>
                    </div>
                </div>

                <!-- Col 2: Navigasi Lini Layanan -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4">Lini Layanan IT</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('products.index') }}?category=healthcare-it-systems" class="hover:text-blue-400 text-sky-300 font-medium transition-colors">Healthcare IT &amp; Smart Queue</a></li>
                        <li><a href="{{ route('products.index') }}?category=web-app-development" class="hover:text-blue-400 transition-colors">Web Application &amp; ERP</a></li>
                        <li><a href="{{ route('products.index') }}?category=mobile-desktop-app" class="hover:text-blue-400 transition-colors">Mobile &amp; Desktop App</a></li>
                        <li><a href="{{ route('home') }}#paket-harga" class="hover:text-blue-400 transition-colors">Internet Service Dedicated &amp; MikroTik</a></li>
                        <li><a href="{{ route('home') }}#layanan" class="hover:text-blue-400 transition-colors">Cloud VPS &amp; Hardening Keamanan</a></li>
                        <li><a href="{{ route('home') }}#layanan" class="hover:text-blue-400 transition-colors">IT Hardware &amp; Smart Security</a></li>
                        <li><a href="{{ route('home') }}#paket-harga" class="hover:text-blue-400 transition-colors">Managed SLA Support Bulanan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Produk Portofolio Pilihan -->
                <!-- Col 3: Produk Portofolio Pilihan -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4">Demo Portofolio</h3>
                    <ul class="space-y-2.5 text-xs">
                        @if(isset($footerProducts) && $footerProducts->isNotEmpty())
                            @foreach($footerProducts as $fp)
                            <li><a href="{{ route('products.show', $fp->slug) }}" class="hover:text-blue-400 transition-colors">{{ $fp->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ route('products.index') }}" class="hover:text-blue-400 transition-colors">Semua Demo Sistem</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 4: Kantor & Kontak Resmi -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4">Kantor &amp; Kontak Resmi</h3>
                    <div class="space-y-3 text-xs text-slate-400">
                        <p class="leading-relaxed whitespace-pre-line">{{ $siteSettings['office_address'] ?? 'Jakarta, Indonesia' }}</p>
                        <p>
                            <span class="text-slate-300 font-medium">WhatsApp:</span> {{ $siteSettings['contact_whatsapp'] ?? '+62 812-3456-7890' }}<br>
                            <span class="text-slate-300 font-medium">Email:</span> {{ $siteSettings['contact_email'] ?? 'corporate@cybichi.com' }}<br>
                            <span class="text-slate-300 font-medium">Jam Kerja:</span> {{ $siteSettings['business_hours'] ?? 'Senin - Jumat: 08.30 - 17.30 WIB' }}
                        </p>
                        <div class="pt-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-[11px] text-teal-300 font-medium">
                                <svg class="w-3.5 h-3.5 text-teal-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Grade A+ Strict Security Headers
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Subfooter -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} {{ $siteSettings['legal_entity_name'] ?? 'CYBICHI' }}. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-slate-200 transition-colors">Portal Staf Admin</a>
                    <span>•</span>
                    <span>Direct Demo Showcase &amp; MoU Generator</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

</body>
</html>
