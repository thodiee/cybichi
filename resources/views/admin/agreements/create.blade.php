@extends('layouts.admin')

@section('title', 'Terbitkan Dokumen Perjanjian (MoU / SPK)')
@section('header_title', 'Pembuatan Dokumen Perjanjian Kerja Sama')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    products: {{ json_encode($products) }},
    invoices: {{ json_encode($invoices) }},
    selectedInvoiceId: '{{ old('invoice_id', $selectedInvoiceId ?? '') }}',
    selectedClientId: '{{ old('client_id', $selectedClientId ?? '') }}',
    selectedProductId: '{{ old('product_id', $selectedProductId ?? '') }}',
    templateType: '{{ old('template_type', 'software_installation') }}',
    projectName: '{{ old('project_name', '') }}',
    contractValue: {{ old('contract_value', 0) }},
    warrantyMonths: {{ old('warranty_period_months', 12) }},
    paymentTerms: '{{ old('payment_terms_summary', 'Tahap 1: Uang Muka (DP) 50% saat penandatanganan SPK\nTahap 2: Pelunasan 50% setelah serah terima sistem (UAT) dan masa garansi aktif.') }}',
    scopeOfWork: '{{ old('scope_of_work', '') }}',

    init() {
        if (this.selectedInvoiceId) {
            this.onInvoiceSelect();
        } else if (this.selectedProductId) {
            this.onProductSelect();
        }
    },

    onInvoiceSelect() {
        if (!this.selectedInvoiceId) return;
        const inv = this.invoices.find(i => i.id == this.selectedInvoiceId);
        if (inv) {
            this.selectedClientId = inv.client_id;
            if (inv.product_id) {
                this.selectedProductId = inv.product_id;
            }
            this.projectName = inv.project_title;
            this.contractValue = parseFloat(inv.grand_total) || 0;
            this.paymentTerms = 'Pembayaran terikat dengan Nomor Invoice: ' + inv.invoice_number + '\n' +
                '- Total Nilai Kontrak: Rp ' + new Intl.NumberFormat('id-ID').format(this.contractValue) + '\n' +
                '- Uang Muka Terbayar: Rp ' + new Intl.NumberFormat('id-ID').format(inv.amount_paid) + '\n' +
                '- Sisa Tagihan Akhir: Rp ' + new Intl.NumberFormat('id-ID').format(inv.balance_due);

            if (inv.product_id) {
                this.onProductSelect();
            }
        }
    },

    onProductSelect() {
        if (!this.selectedProductId) return;
        const prod = this.products.find(p => p.id == this.selectedProductId);
        if (prod) {
            if (!this.projectName) {
                this.projectName = 'Pengadaan & Implementasi ' + prod.title;
            }
            if (!this.contractValue || this.contractValue == 0) {
                this.contractValue = parseFloat(prod.base_price) || 0;
            }
            if (!this.scopeOfWork) {
                let scope = '1. Instalasi dan konfigurasi sistem ' + prod.title + ' pada infrastruktur klien.\n' +
                    '2. Pelatihan intensif pengoperasian sistem bagi tim dan administrator.\n' +
                    '3. Penyerahan akun administratif master dan dokumentasi panduan teknis.\n' +
                    '4. Dukungan perbaikan kesalahan/bug sistem gratis selama masa garansi.';
                this.scopeOfWork = scope;
            }
        }
    },

    onTemplateChange() {
        if (this.templateType === 'software_installation') {
            this.warrantyMonths = 12;
        } else if (this.templateType === 'custom_development') {
            this.warrantyMonths = 6;
        } else if (this.templateType === 'internet_network_contract') {
            this.warrantyMonths = 12;
        } else if (this.templateType === 'it_maintenance') {
            this.warrantyMonths = 12;
        }
    }
}">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Dokumen
        </a>
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

    <form action="{{ route('admin.agreements.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Section 1: Connection to Invoice & Client -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900">Relasi Tagihan & Identitas Kontrak</h3>
                <span class="text-xs font-mono font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                    {{ $nextNumber }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="invoice_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hubungkan ke E-Invoice (Otomatis Isi Data)</label>
                    <select id="invoice_id" name="invoice_id" x-model="selectedInvoiceId" @change="onInvoiceSelect"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Tanpa Invoice (Kontrak Mandiri) --</option>
                        @foreach($invoices as $inv)
                        <option value="{{ $inv->id }}">
                            {{ $inv->invoice_number }} - {{ $inv->project_title }} (Rp {{ number_format($inv->grand_total, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">Pilih invoice untuk otomatis menarik nama klien, nilai kontrak, dan ruang lingkup.</p>
                </div>

                <div>
                    <label for="agreement_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Dokumen Perjanjian <span class="text-rose-500">*</span></label>
                    <input type="text" id="agreement_number" name="agreement_number" value="{{ old('agreement_number', $nextNumber) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pihak Kedua (Klien) <span class="text-rose-500">*</span></label>
                    <select id="client_id" name="client_id" x-model="selectedClientId" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->contact_name }} {{ $client->company_name ? "({$client->company_name})" : "" }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="product_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Produk Sistem Terkait</label>
                    <select id="product_id" name="product_id" x-model="selectedProductId" @change="onProductSelect"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Proyek Kustom / Jasa Khusus --</option>
                        @foreach($products as $prod)
                        <option value="{{ $prod->id }}">
                            {{ $prod->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="template_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Templat Perjanjian <span class="text-rose-500">*</span></label>
                    <select id="template_type" name="template_type" x-model="templateType" @change="onTemplateChange" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="software_installation">Instalasi Software & Lisensi Siap Pakai</option>
                        <option value="custom_development">Pengembangan Perangkat Lunak Kustom</option>
                        <option value="internet_network_contract">Pengadaan Jaringan & Internet SLA</option>
                        <option value="it_maintenance">Perjanjian Pemeliharaan & SLA IT (Maintenance)</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Dokumen <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="issued" selected>Diterbitkan (Issued)</option>
                        <option value="signed_active">Ditandatangani & Aktif (Signed Active)</option>
                        <option value="draft">Draft Internal</option>
                        <option value="completed">Selesai (Completed)</option>
                        <option value="terminated">Dibatalkan / Berakhir (Terminated)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="project_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Pekerjaan / Pengadaan <span class="text-rose-500">*</span></label>
                <input type="text" id="project_name" name="project_name" x-model="projectName" required
                       placeholder="Contoh: Pekerjaan Pengadaan dan Implementasi Sistem Metani Agribisnis ERP"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>
        </div>

        <!-- Section 2: Values & Dates -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Nilai Kontrak & Masa Berlaku</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="contract_value" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nilai Total Kontrak (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="contract_value" name="contract_value" x-model="contractValue" min="0" step="1000" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="warranty_period_months" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Masa Garansi / SLA (Bulan) <span class="text-rose-500">*</span></label>
                    <input type="number" id="warranty_period_months" name="warranty_period_months" x-model="warrantyMonths" min="0" max="60" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="agreement_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Perjanjian <span class="text-rose-500">*</span></label>
                    <input type="date" id="agreement_date" name="agreement_date" value="{{ old('agreement_date', date('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai Efektif <span class="text-rose-500">*</span></label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="estimated_completion_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target Serah Terima</label>
                    <input type="date" id="estimated_completion_date" name="estimated_completion_date" value="{{ old('estimated_completion_date', date('Y-m-d', strtotime('+30 days'))) }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Section 3: Scope of Work & Payment Terms -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Ketentuan Pembayaran & Ruang Lingkup Kerja</h3>

            <div>
                <label for="payment_terms_summary" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Ketentuan Pembayaran <span class="text-rose-500">*</span></label>
                <textarea id="payment_terms_summary" name="payment_terms_summary" x-model="paymentTerms" rows="3" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"></textarea>
            </div>

            <div>
                <label for="scope_of_work" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ruang Lingkup Pekerjaan & Hak Cipta <span class="text-rose-500">*</span></label>
                <textarea id="scope_of_work" name="scope_of_work" x-model="scopeOfWork" rows="5" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"></textarea>
            </div>

            <div>
                <label for="agreement_clauses_html" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pasal-Pasal Tambahan (HTML Khusus)</label>
                <textarea id="agreement_clauses_html" name="agreement_clauses_html" rows="3"
                          placeholder="<p>Pasal opsional penyesuaian khusus kesepakatan...</p>"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('agreement_clauses_html') }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika menggunakan klausul standar perusahaan (Kerahasiaan data, Force Majeure, Hukum Indonesia).</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.agreements.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                Terbitkan Dokumen Perjanjian (MoU/SPK)
            </button>
        </div>

    </form>
</div>

@endsection
