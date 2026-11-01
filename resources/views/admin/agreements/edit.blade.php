@extends('layouts.admin')

@section('title', 'Edit Perjanjian ' . $agreement->agreement_number)
@section('header_title', 'Perbarui Dokumen Perjanjian Kerja Sama')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.agreements.show', $agreement) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Detail Perjanjian
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

    <form action="{{ route('admin.agreements.update', $agreement) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Section 1: Connection & Metadata -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900">Relasi Tagihan & Identitas Kontrak</h3>
                <span class="text-xs font-mono font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                    {{ $agreement->agreement_number }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="invoice_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Hubungkan ke E-Invoice</label>
                    <select id="invoice_id" name="invoice_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Tanpa Invoice (Kontrak Mandiri) --</option>
                        @foreach($invoices as $inv)
                        <option value="{{ $inv->id }}" {{ old('invoice_id', $agreement->invoice_id) == $inv->id ? 'selected' : '' }}>
                            {{ $inv->invoice_number }} - {{ $inv->project_title }} (Rp {{ number_format($inv->grand_total, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Dokumen Perjanjian</label>
                    <input type="text" value="{{ $agreement->agreement_number }}" readonly
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-mono text-sm cursor-not-allowed">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pihak Kedua (Klien) <span class="text-rose-500">*</span></label>
                    <select id="client_id" name="client_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $agreement->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->contact_name }} {{ $client->company_name ? "({$client->company_name})" : "" }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="product_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Produk Sistem Terkait</label>
                    <select id="product_id" name="product_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Proyek Kustom / Jasa Khusus --</option>
                        @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ old('product_id', $agreement->product_id) == $prod->id ? 'selected' : '' }}>
                            {{ $prod->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="template_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Templat Perjanjian <span class="text-rose-500">*</span></label>
                    <select id="template_type" name="template_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="software_installation" {{ old('template_type', $agreement->template_type) === 'software_installation' ? 'selected' : '' }}>Instalasi Software & Lisensi Siap Pakai</option>
                        <option value="custom_development" {{ old('template_type', $agreement->template_type) === 'custom_development' ? 'selected' : '' }}>Pengembangan Perangkat Lunak Kustom</option>
                        <option value="internet_network_contract" {{ old('template_type', $agreement->template_type) === 'internet_network_contract' ? 'selected' : '' }}>Pengadaan Jaringan & Internet SLA</option>
                        <option value="it_maintenance" {{ old('template_type', $agreement->template_type) === 'it_maintenance' ? 'selected' : '' }}>Perjanjian Pemeliharaan & SLA IT (Maintenance)</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Dokumen <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="issued" {{ old('status', $agreement->status) === 'issued' ? 'selected' : '' }}>Diterbitkan (Issued)</option>
                        <option value="signed_active" {{ old('status', $agreement->status) === 'signed_active' ? 'selected' : '' }}>Ditandatangani & Aktif (Signed Active)</option>
                        <option value="draft" {{ old('status', $agreement->status) === 'draft' ? 'selected' : '' }}>Draft Internal</option>
                        <option value="completed" {{ old('status', $agreement->status) === 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                        <option value="terminated" {{ old('status', $agreement->status) === 'terminated' ? 'selected' : '' }}>Dibatalkan / Berakhir (Terminated)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="project_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Pekerjaan / Pengadaan <span class="text-rose-500">*</span></label>
                <input type="text" id="project_name" name="project_name" value="{{ old('project_name', $agreement->project_name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>
        </div>

        <!-- Section 2: Values & Dates -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Nilai Kontrak & Masa Berlaku</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="contract_value" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nilai Total Kontrak (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="contract_value" name="contract_value" value="{{ old('contract_value', $agreement->contract_value) }}" min="0" step="1000" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="warranty_period_months" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Masa Garansi / SLA (Bulan) <span class="text-rose-500">*</span></label>
                    <input type="number" id="warranty_period_months" name="warranty_period_months" value="{{ old('warranty_period_months', $agreement->warranty_period_months) }}" min="0" max="60" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="agreement_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Perjanjian <span class="text-rose-500">*</span></label>
                    <input type="date" id="agreement_date" name="agreement_date" value="{{ old('agreement_date', $agreement->agreement_date->format('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai Efektif <span class="text-rose-500">*</span></label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $agreement->start_date->format('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="estimated_completion_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target Serah Terima</label>
                    <input type="date" id="estimated_completion_date" name="estimated_completion_date" value="{{ old('estimated_completion_date', $agreement->estimated_completion_date ? $agreement->estimated_completion_date->format('Y-m-d') : '') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Section 3: Scope of Work & Payment Terms -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Ketentuan Pembayaran & Ruang Lingkup Kerja</h3>

            <div>
                <label for="payment_terms_summary" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan Ketentuan Pembayaran <span class="text-rose-500">*</span></label>
                <textarea id="payment_terms_summary" name="payment_terms_summary" rows="3" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('payment_terms_summary', $agreement->payment_terms_summary) }}</textarea>
            </div>

            <div>
                <label for="scope_of_work" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ruang Lingkup Pekerjaan & Hak Cipta <span class="text-rose-500">*</span></label>
                <textarea id="scope_of_work" name="scope_of_work" rows="5" required
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('scope_of_work', $agreement->scope_of_work) }}</textarea>
            </div>

            <div>
                <label for="agreement_clauses_html" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pasal-Pasal Tambahan (HTML Khusus)</label>
                <textarea id="agreement_clauses_html" name="agreement_clauses_html" rows="3"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('agreement_clauses_html', $agreement->agreement_clauses_html) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.agreements.show', $agreement) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                Simpan Perubahan Perjanjian
            </button>
        </div>

    </form>
</div>

@endsection
