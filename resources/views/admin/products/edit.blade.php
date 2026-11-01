@extends('layouts.admin')

@section('title', 'Edit Produk: ' . $product->title)
@section('header_title', 'Perbarui Informasi Produk Demo')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    credentials: {{ json_encode($product->demo_credentials ?? []) }},
    addCred() {
        this.credentials.push({ role: '', username: '', password: '' });
    },
    removeCred(index) {
        this.credentials.splice(index, 1);
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Edit Produk: {{ $product->title }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kode: {{ $product->product_code }} | Slug: {{ $product->slug }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            ← Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-8">
        @csrf
        @method('PUT')

        <!-- Section 1 -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                1. Informasi Dasar Produk
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kategori Layanan *</label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Produk *</label>
                    <input type="text" name="product_code" value="{{ old('product_code', $product->product_code) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Harga Acuan Dasar (IDR)</label>
                    <input type="number" name="base_price" value="{{ old('base_price', (int)$product->base_price) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul / Nama Sistem *</label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Target Industri / Klien</label>
                    <input type="text" name="client_or_industry" value="{{ old('client_or_industry', $product->client_or_industry) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ringkasan Singkat *</label>
                <input type="text" name="short_summary" value="{{ old('short_summary', $product->short_summary) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Lengkap Sistem</label>
                <textarea name="full_description" rows="4" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">{{ old('full_description', $product->full_description) }}</textarea>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                2. Spesifikasi Teknis &amp; Fitur Unggulan
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                    Daftar Fitur Utama (Pisahkan dengan baris baru / Enter)
                </label>
                <textarea name="key_features" rows="5" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 font-mono">{{ is_array($product->key_features) ? implode("\n", $product->key_features) : '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tech Stack (Koma)</label>
                    <input type="text" name="tech_stack" value="{{ is_array($product->tech_stack) ? implode(', ', $product->tech_stack) : '' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Path Gambar Thumbnail</label>
                    <input type="text" name="thumbnail_path" value="{{ $product->thumbnail_path }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                3. Direct Demo URL &amp; Kredensial Uji Coba
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">URL Domain Demo (Tab Baru)</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $product->demo_url) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Kesehatan Uptime</label>
                    <select name="demo_health_status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600">
                        <option value="online" {{ $product->demo_health_status === 'online' ? 'selected' : '' }}>Online (Siap Dicoba)</option>
                        <option value="maintenance" {{ $product->demo_health_status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="offline" {{ $product->demo_health_status === 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Petunjuk Singkat Akses Demo</label>
                <input type="text" name="demo_usage_guide" value="{{ old('demo_usage_guide', $product->demo_usage_guide) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>

            <!-- Credentials Builder -->
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700 uppercase">Daftar Akun Login Demo</span>
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
                    <input type="checkbox" name="show_credentials_publicly" value="1" {{ $product->show_credentials_publicly ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Tampilkan Kredensial Login di Halaman Publik</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Jadikan Produk Unggulan di Landing Page</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Status Aktif</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

@endsection
