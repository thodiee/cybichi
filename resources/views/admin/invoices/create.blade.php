@extends('layouts.admin')

@section('title', 'Terbitkan E-Invoice Baru')
@section('header_title', 'Form Pembuatan Invoice Tagihan Proyek')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    products: {{ json_encode($products) }},
    selectedProductId: '{{ $selectedProductId ?? '' }}',
    projectTitle: '',
    billingType: 'down_payment',
    discountAmount: 0,
    taxPercentage: 0,
    dpPercent: 50,
    amountPaid: 0,
    items: [
        { item_name: 'Pemasangan & Lisensi Sistem', item_description: 'Instalasi server, konfigurasi database, dan deployment', quantity: 1, unit_name: 'Paket', unit_price: 15000000, total_price: 15000000 }
    ],

    onProductSelect() {
        if (!this.selectedProductId) return;
        const prod = this.products.find(p => p.id == this.selectedProductId);
        if (prod) {
            this.projectTitle = 'Pemasangan & Lisensi ' + prod.title;
            const price = parseFloat(prod.base_price) || 10000000;
            this.items = [
                {
                    item_name: 'Lisensi & Instalasi ' + prod.title,
                    item_description: prod.short_summary || '',
                    quantity: 1,
                    unit_name: 'Paket',
                    unit_price: price,
                    total_price: price
                }
            ];
            this.calculate();
        }
    },

    addItem() {
        this.items.push({ item_name: '', item_description: '', quantity: 1, unit_name: 'Paket', unit_price: 0, total_price: 0 });
    },

    removeItem(index) {
        if (this.items.length > 1) {
            this.items.splice(index, 1);
            this.calculate();
        }
    },

    updateItemTotal(index) {
        const item = this.items[index];
        item.total_price = (parseFloat(item.quantity) || 0) * (parseFloat(item.unit_price) || 0);
        this.calculate();
    },

    get subtotal() {
        return this.items.reduce((acc, it) => acc + (parseFloat(it.total_price) || 0), 0);
    },

    get taxAmount() {
        const taxable = Math.max(0, this.subtotal - (parseFloat(this.discountAmount) || 0));
        return taxable * ((parseFloat(this.taxPercentage) || 0) / 100);
    },

    get grandTotal() {
        return Math.max(0, this.subtotal - (parseFloat(this.discountAmount) || 0) + this.taxAmount);
    },

    get balanceDue() {
        if (this.billingType === 'down_payment') {
            return this.grandTotal * ((parseFloat(this.dpPercent) || 50) / 100);
        } else if (this.billingType === 'one_time' || this.billingType === 'recurring') {
            return this.grandTotal;
        } else {
            return Math.max(0, this.grandTotal - (parseFloat(this.amountPaid) || 0));
        }
    },

    calculate() {
        // Reactive getters update view automatically
    },

    formatRupiah(num) {
        return 'Rp ' + Math.round(num).toLocaleString('id-ID');
    }
}" x-init="if (selectedProductId) { onProductSelect(); }">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Terbitkan E-Invoice Resmi Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pilih produk katalog untuk autofill otomatis atau buat tagihan kustom dari awal.</p>
        </div>
        <a href="{{ route('admin.invoices.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            ← Kembali
        </a>
    </div>

    <!-- Quick Autofill Helper Banner -->
    <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-blue-900 uppercase">Quick Generate dari Produk Katalog</h4>
                <p class="text-xs text-blue-700">Pilih produk yang disepakati di WhatsApp untuk mengisi nama item dan harga acuan seketika.</p>
            </div>
        </div>
        <div class="w-full sm:w-72">
            <select x-model="selectedProductId" @change="onProductSelect()" class="w-full px-3.5 py-2 rounded-xl border border-blue-300 text-xs bg-white font-semibold text-blue-900 focus:ring-2 focus:ring-blue-600">
                <option value="">-- Pilih Produk Showcase --</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->id }}" {{ ($selectedProductId == $prod->id) ? 'selected' : '' }}>
                        {{ $prod->product_code }} - {{ $prod->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <form action="{{ route('admin.invoices.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-8">
        @csrf
        <input type="hidden" name="product_id" :value="selectedProductId">

        <!-- Hidden calculated fields submitted to backend -->
        <input type="hidden" name="subtotal" :value="subtotal">
        <input type="hidden" name="grand_total" :value="grandTotal">
        <input type="hidden" name="balance_due" :value="balanceDue">
        <input type="hidden" name="tax_amount" :value="taxAmount">

        <!-- Section 1: Header Info -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700 border-b border-slate-100 pb-2">
                1. Informasi Klien &amp; Nomor Tagihan
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor Invoice *</label>
                    <input type="text" name="invoice_number" value="{{ old('invoice_number', $nextNumber) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Klien Tujuan *</label>
                    <select name="client_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600">
                        <option value="">-- Pilih Klien --</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ ($selectedClientId == $c->id) ? 'selected' : '' }}>
                                {{ $c->contact_name }} ({{ $c->company_name ?? 'Personal' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Skema Pembayaran *</label>
                    <select name="billing_type" x-model="billingType" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600 font-semibold">
                        <option value="down_payment">Uang Muka (Down Payment / DP)</option>
                        <option value="milestone_termin">Termin Progres Pengerjaan</option>
                        <option value="one_time">Pembayaran Penuh Sekaligus (100%)</option>
                        <option value="final_settlement">Pelunasan Akhir (BAST)</option>
                        <option value="recurring">Langganan Bulanan (Internet/SLA)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Proyek / Pengadaan *</label>
                <input type="text" name="project_title" x-model="projectTitle" required placeholder="Contoh: Pemasangan Paket POS Ngafe Cloud Multi-Outlet" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Terbit *</label>
                    <input type="date" name="issue_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Jatuh Tempo *</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Awal Invoice</label>
                    <select name="payment_status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-blue-600 font-bold text-amber-800">
                        <option value="unpaid">UNPAID (Menunggu Pembayaran)</option>
                        <option value="partial_dp">PARTIAL DP (DP Diterima)</option>
                        <option value="paid">PAID (Lunas 100%)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Items Builder -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h3 class="text-sm font-bold uppercase tracking-wider text-blue-700">
                    2. Rincian Item Tagihan &amp; Komponen Biaya
                </h3>
                <button type="button" @click="addItem()" class="text-xs font-bold text-blue-600 hover:text-blue-800">
                    + Tambah Baris Item
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(item, index) in items" :key="index">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-600" x-text="'Item #' + (index + 1)"></span>
                            <button type="button" @click="removeItem(index)" class="text-rose-600 hover:text-rose-800 text-xs" x-show="items.length > 1">
                                Hapus Item
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Item / Modul *</label>
                                <input type="text" :name="'items[' + index + '][item_name]'" x-model="item.item_name" required placeholder="Nama komponen..." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Spesifikasi</label>
                                <input type="text" :name="'items[' + index + '][item_description]'" x-model="item.item_description" placeholder="Keterangan singkat..." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kuantitas</label>
                                <input type="number" step="0.01" :name="'items[' + index + '][quantity]'" x-model="item.quantity" @input="updateItemTotal(index)" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-mono">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Satuan</label>
                                <input type="text" :name="'items[' + index + '][unit_name]'" x-model="item.unit_name" placeholder="Paket, Unit, Bulan" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Harga Satuan (IDR)</label>
                                <input type="number" :name="'items[' + index + '][unit_price]'" x-model="item.unit_price" @input="updateItemTotal(index)" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-mono">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Total Item</label>
                                <input type="number" :name="'items[' + index + '][total_price]'" :value="item.total_price" readonly class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-100 text-xs font-mono font-bold text-slate-800">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 3: Perhitungan & Diskon & DP -->
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-200 pb-2">
                3. Perhitungan Total, Diskon &amp; Uang Muka (DP)
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Diskon Kesepakatan (IDR)</label>
                    <input type="number" name="discount_amount" x-model="discountAmount" @input="calculate()" value="0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pajak PPN (%)</label>
                    <input type="number" step="0.1" name="tax_percentage" x-model="taxPercentage" @input="calculate()" value="0" placeholder="0 untuk non-pajak" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono bg-white">
                </div>
                <div x-show="billingType === 'down_payment'">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Persentase DP (%)</label>
                    <input type="number" x-model="dpPercent" @input="calculate()" value="50" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono bg-white">
                </div>
            </div>

            <!-- Summary Table Calculation -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-2 text-xs font-medium">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal Semua Item:</span>
                    <span class="font-mono font-bold" x-text="formatRupiah(subtotal)"></span>
                </div>
                <div class="flex justify-between text-emerald-600" x-show="discountAmount > 0">
                    <span>Potongan Diskon:</span>
                    <span class="font-mono font-bold" x-text="'- ' + formatRupiah(discountAmount)"></span>
                </div>
                <div class="flex justify-between text-slate-600" x-show="taxPercentage > 0">
                    <span x-text="'PPN (' + taxPercentage + '%):'"></span>
                    <span class="font-mono font-bold" x-text="'+ ' + formatRupiah(taxAmount)"></span>
                </div>
                <div class="flex justify-between border-t border-slate-200 pt-2 text-sm font-bold text-slate-900">
                    <span>NILAI TOTAL KONTRAK:</span>
                    <span class="font-mono text-base text-blue-700" x-text="formatRupiah(grandTotal)"></span>
                </div>
                <div class="flex justify-between bg-blue-50/80 p-3 rounded-lg text-blue-900 font-bold border border-blue-200">
                    <span>NOMINAL TAGIHAN SAAT INI (YANG HARUS DIBAYAR):</span>
                    <span class="font-mono text-base font-black" x-text="formatRupiah(balanceDue)"></span>
                </div>
            </div>
        </div>

        <!-- Section 4: Rekening & Catatan -->
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Informasi Rekening Tujuan Pembayaran</label>
                <textarea name="payment_method_info" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">{{ $bankInfo }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Khusus di Lembar Invoice</label>
                <textarea name="admin_notes" rows="2" placeholder="Ketentuan garansi purnajual, batas waktu konfirmasi bukti transfer..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">Garansi pemeliharaan sistem & perbaikan bug kritis berlaku selama 90 hari kalender sejak BAST.</textarea>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.invoices.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-7 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition-all">
                Terbitkan Invoice &amp; Siapkan Dokumen Resmi
            </button>
        </div>
    </form>

</div>

@endsection
