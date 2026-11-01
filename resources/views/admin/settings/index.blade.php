@extends('layouts.admin')

@section('title', 'Konfigurasi Sistem & CMS')
@section('header_title', 'Pengaturan Perusahaan & Landing Page')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    banks: {{ json_encode($bankAccounts ?: [
        ['bank' => 'BCA', 'account_number' => '8420912831', 'holder_name' => 'PT Siber Cybichi Solusindo', 'branch' => 'KCU Sudirman'],
    ]) }},
    addBank() {
        this.banks.push({ bank: 'Bank Mandiri', account_number: '', holder_name: 'PT Siber Cybichi Solusindo', branch: 'KCP Jakarta' });
    },
    removeBank(index) {
        if (this.banks.length > 1) {
            this.banks.splice(index, 1);
        }
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold font-heading text-slate-900">CMS & Pengaturan Identitas</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data legal perusahaan, copywriting landing page, statistik kredibilitas, dan rekening bank resmi.</p>
        </div>
    </div>

    @if (isset($errors) && $errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm">
        <div class="font-bold mb-1">Terdapat kesalahan input:</div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Brand & Legal Information -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Identitas Perusahaan & Kontak Resmi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="brand_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Merek Dagang <span class="text-rose-500">*</span></label>
                    <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $settings['brand_name'] ?? 'CYBICHI') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="legal_entity_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badan Hukum Resmi (PT / CV) <span class="text-rose-500">*</span></label>
                    <input type="text" id="legal_entity_name" name="legal_entity_name" value="{{ old('legal_entity_name', $settings['legal_entity_name'] ?? 'PT Siber Cybichi Solusindo') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="tax_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor NPWP Badan</label>
                    <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id', $settings['tax_id'] ?? '01.234.567.8-012.000') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="contact_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Kontak Resmi <span class="text-rose-500">*</span></label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'corporate@cybichi.com') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="contact_whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">WhatsApp Hotline <span class="text-rose-500">*</span></label>
                    <input type="text" id="contact_whatsapp" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '081234567890') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="office_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Kantor Operasional <span class="text-rose-500">*</span></label>
                    <textarea id="office_address" name="office_address" rows="3" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('office_address', $settings['office_address'] ?? "Cyber 2 Tower Lt. 18, Jl. H.R. Rasuna Said Blok X-5 No. 13\nJakarta Selatan 12950, Indonesia") }}</textarea>
                </div>

                <div>
                    <label for="business_hours" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jam Operasional</label>
                    <input type="text" id="business_hours" name="business_hours" value="{{ old('business_hours', $settings['business_hours'] ?? 'Senin - Jumat, 08:30 - 17:30 WIB (NOC 24/7)') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Card 2: Hero & Landing Page Copywriting -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Teks Utama Landing Page (Hero Section)</h3>

            <div>
                <label for="hero_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Header Hero</label>
                <input type="text" id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge'] ?? 'Perusahaan Solusi Teknologi Informasi & Jaringan Terpercaya') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>

            <div>
                <label for="hero_headline" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Headline Utama Hero <span class="text-rose-500">*</span></label>
                <input type="text" id="hero_headline" name="hero_headline" value="{{ old('hero_headline', $settings['hero_headline'] ?? 'Solusi Teknologi Enterprise, Siap Pakai & Bergaransi') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>

            <div>
                <label for="hero_subheadline" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sub-Headline Deskripsi <span class="text-rose-500">*</span></label>
                <textarea id="hero_subheadline" name="hero_subheadline" rows="2" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('hero_subheadline', $settings['hero_subheadline'] ?? 'CYBICHI menghadirkan portofolio aplikasi teruji untuk pertanian, retail F&B, rumah sakit, hingga infrastruktur jaringan MikroTik berskala enterprise.') }}</textarea>
            </div>
        </div>

        <!-- Card 3: Trust & Credibility Numbers -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Statistik Kredibilitas Perusahaan (Trust Badges)</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label for="stats_projects_completed" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Proyek Selesai <span class="text-rose-500">*</span></label>
                    <input type="text" id="stats_projects_completed" name="stats_projects_completed" value="{{ old('stats_projects_completed', $settings['stats_projects_completed'] ?? '120+') }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="stats_active_clients" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Klien Aktif <span class="text-rose-500">*</span></label>
                    <input type="text" id="stats_active_clients" name="stats_active_clients" value="{{ old('stats_active_clients', $settings['stats_active_clients'] ?? '85+') }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="stats_uptime_guarantee" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Garansi Uptime SLA <span class="text-rose-500">*</span></label>
                    <input type="text" id="stats_uptime_guarantee" name="stats_uptime_guarantee" value="{{ old('stats_uptime_guarantee', $settings['stats_uptime_guarantee'] ?? '99.9%') }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="stats_years_experience" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pengalaman (Tahun) <span class="text-rose-500">*</span></label>
                    <input type="text" id="stats_years_experience" name="stats_years_experience" value="{{ old('stats_years_experience', $settings['stats_years_experience'] ?? '8+ Tahun') }}" required
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Card 4: Official Bank Accounts (Dynamic List) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Rekening Bank Resmi Perusahaan</h3>
                    <p class="text-xs text-slate-500">Rekening resmi yang dicantumkan pada E-Invoice dan dokumen kontrak MoU.</p>
                </div>
                <button type="button" @click="addBank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Bank
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(b, index) in banks" :key="index">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Nama Bank</label>
                                <input type="text" name="bank_banks[]" x-model="b.bank" placeholder="Bank Central Asia (BCA)" required
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Nomor Rekening</label>
                                <input type="text" name="bank_accounts[]" x-model="b.account_number" placeholder="8420912831" required
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Atas Nama (A/N)</label>
                                <input type="text" name="bank_holders[]" x-model="b.holder_name" placeholder="PT Siber Cybichi Solusindo" required
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kantor Cabang</label>
                                <input type="text" name="bank_branches[]" x-model="b.branch" placeholder="KCU Sudirman"
                                       class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            </div>
                            <div class="sm:col-span-1 flex justify-center pt-5">
                                <button type="button" @click="removeBank(index)" x-show="banks.length > 1" class="text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Bank">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Card 5: SEO Meta -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Optimasi SEO Mesin Pencari</h3>

            <div>
                <label for="meta_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Title <span class="text-rose-500">*</span></label>
                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? 'CYBICHI - Solusi IT Korporat, Aplikasi Bisnis & Jaringan Enterprise') }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>

            <div>
                <label for="meta_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Meta Description <span class="text-rose-500">*</span></label>
                <textarea id="meta_description" name="meta_description" rows="2" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('meta_description', $settings['meta_description'] ?? 'Penyedia solusi perangkat lunak terintegrasi, e-invoice resmi, manajemen jaringan MikroTik, dan sistem antrean rumah sakit berstandar enterprise.') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                Simpan Seluruh Pengaturan Sistem
            </button>
        </div>

    </form>
</div>

@endsection
