@extends('layouts.admin')

@section('title', 'Tambah Produk Demo Baru')
@section('header_title', 'Form Penambahan Produk & Direct Demo')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    credentials: [
        { role: 'Super Admin', username: 'admin@demo.com', password: 'demo12345' }
    ],
    addCred() {
        this.credentials.push({ role: '', username: '', password: '' });
    },
    removeCred(index) {
        this.credentials.splice(index, 1);
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Tambah Produk &amp; Akses Demo Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan aplikasi web, tentukan link demo eksternal, dan siapkan kredensial login uji coba.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            ← Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-8">
        @csrf

        <!-- Section 1: Informasi Dasar -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                1. Informasi Dasar Produk
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori Layanan *</label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Produk *</label>
                    <input type="text" name="product_code" required placeholder="PRD-WEB-007" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Harga Acuan Dasar (IDR)</label>
                    <input type="number" name="base_price" placeholder="15000000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul / Nama Sistem *</label>
                    <input type="text" name="title" required placeholder="Contoh: POS Retail & Omnichannel" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Target Industri / Klien</label>
                    <input type="text" name="client_or_industry" placeholder="Contoh: Food & Beverage, Kafe Chain" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ringkasan Singkat (Short Summary) *</label>
                <input type="text" name="short_summary" required placeholder="Penjelasan 1-2 kalimat untuk kartu katalog..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Lengkap Sistem</label>
                <textarea name="full_description" rows="3" placeholder="Penjelasan arsitektur, latar belakang proyek, dan kapabilitas lengkap..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600"></textarea>
            </div>
        </div>

        <!-- Section 2: Fitur & Tech Stack -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                2. Spesifikasi Teknis &amp; Fitur Unggulan
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Daftar Fitur Utama (Pisahkan dengan baris baru / Enter)
                </label>
                <textarea name="key_features" rows="4" placeholder="Manajemen Transaksi Kasir Touchscreen&#10;Cetak Struk Bluetooth &amp; USB&#10;Laporan Laba Rugi Harian&#10;Multi-Outlet Sync" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 font-mono"></textarea>
                <p class="text-[10px] text-slate-500 mt-1">*Fitur ini otomatis ditarik ke dalam Scope of Work saat Admin menerbitkan MoU/SPK.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Tech Stack (Pisahkan dengan koma)
                    </label>
                    <input type="text" name="tech_stack" placeholder="Laravel 13, MySQL 8.0, Tailwind, Alpine.js" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Path Gambar Thumbnail
                    </label>
                    <input type="text" name="thumbnail_path" value="/assets/images/products/metani-thumb.svg" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
            </div>
        </div>

        <!-- Section 3: Konfigurasi Direct Demo & Akun Login -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                3. Direct Demo URL &amp; Kredensial Uji Coba
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">URL Domain Demo (Wajib https:// atau http://)</label>
                    <input type="url" name="demo_url" placeholder="https://demo-pos.cybichi.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Reset Data Demo</label>
                    <input type="text" name="demo_reset_notice" value="Server demo di-reset otomatis setiap hari pukul 00:00 WIB." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Petunjuk Singkat Akses Demo</label>
                <input type="text" name="demo_usage_guide" placeholder="Contoh: Masuk sebagai Store Manager untuk mencoba kelola menu kafe..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Credentials Builder (Alpine.js) -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700 uppercase">Daftar Akun Login Demo (Multi-Role Support)</span>
                    <button type="button" @click="addCred()" class="text-xs text-blue-600 hover:text-blue-800 font-bold">
                        + Tambah Baris Akun
                    </button>
                </div>

                <template x-for="(cred, index) in credentials" :key="index">
                    <div class="flex flex-col sm:flex-row items-center gap-2 bg-white p-2.5 rounded-xl border border-slate-200">
                        <div class="w-full sm:w-1/3">
                            <input type="text" name="demo_roles[]" x-model="cred.role" placeholder="Peran (misal: Kasir)" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs">
                        </div>
                        <div class="w-full sm:w-1/3">
                            <input type="text" name="demo_usernames[]" x-model="cred.username" placeholder="Username / Email" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-mono">
                        </div>
                        <div class="w-full sm:w-1/3">
                            <input type="text" name="demo_passwords[]" x-model="cred.password" placeholder="Password" class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs font-mono">
                        </div>
                        <button type="button" @click="removeCred(index)" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded" title="Hapus Baris">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Toggles -->
            <div class="flex flex-wrap items-center gap-6 pt-2 text-xs">
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                    <input type="checkbox" name="show_credentials_publicly" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Tampilkan Kredensial Login di Halaman Publik</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Jadikan Produk Unggulan di Landing Page</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Status Aktif</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
                Simpan Produk &amp; Aktifkan Demo
            </button>
        </div>
    </form>

</div>

@endsection
