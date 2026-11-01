@extends('layouts.admin')

@section('title', 'Edit Invoice ' . $invoice->invoice_number)
@section('header_title', 'Perbarui E-Invoice Proyek')

@section('content')

<div class="max-w-4xl mx-auto space-y-6" x-data="{
    products: {{ json_encode($products) }},
    selectedProductId: '{{ old('product_id', $invoice->product_id) }}',
    projectTitle: '{{ old('project_title', addslashes($invoice->project_title)) }}',
    billingType: '{{ old('billing_type', $invoice->billing_type) }}',
    discountAmount: {{ old('discount_amount', $invoice->discount_amount ?? 0) }},
    taxPercentage: {{ old('tax_percentage', $invoice->tax_percentage ?? 0) }},
    dpPercent: 50,
    amountPaid: {{ old('amount_paid', $invoice->amount_paid ?? 0) }},
    items: {{ json_encode(old('items', $invoice->items->map(fn($it) => [
        'item_name' => $it->item_name,
        'item_description' => $it->item_description ?? '',
        'quantity' => (float)$it->quantity,
        'unit_name' => $it->unit_name ?? 'Paket',
        'unit_price' => (float)$it->unit_price,
        'total_price' => (float)$it->total_price,
    ])->toArray())) }},

    onProductSelect() {
        if (!this.selectedProductId) return;
        const prod = this.products.find(p => p.id == this.selectedProductId);
        if (prod && !this.projectTitle) {
            this.projectTitle = 'Pemasangan & Lisensi ' + prod.title;
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
        return Math.max(0, this.grandTotal - (parseFloat(this.amountPaid) || 0));
    },

    applyDpPreset(pct) {
        this.dpPercent = pct;
        this.amountPaid = Math.round(this.grandTotal * (pct / 100));
        const statusSelect = document.getElementById('payment_status');
        if (pct === 100) {
            statusSelect.value = 'paid';
        } else if (pct > 0) {
            statusSelect.value = 'partial_dp';
        } else {
            statusSelect.value = 'unpaid';
        }
    },

    calculate() {
        // Alpine computed triggers automatically
    }
}">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.invoices.show', $invoice) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Detail Invoice
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

    <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Step 1: Client & Invoice Metadata -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Utama & Klien</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Invoice</label>
                    <input type="text" value="{{ $invoice->invoice_number }}" readonly
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-mono text-sm cursor-not-allowed">
                </div>

                <div>
                    <label for="client_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Klien Penerima <span class="text-rose-500">*</span></label>
                    <select id="client_id" name="client_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->contact_name }} {{ $client->company_name ? "({$client->company_name})" : "" }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="product_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Produk Portofolio Terkait</label>
                    <select id="product_id" name="product_id" x-model="selectedProductId" @change="onProductSelect" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="">-- Proyek Khusus / Custom --</option>
                        @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ old('product_id', $invoice->product_id) == $prod->id ? 'selected' : '' }}>
                            {{ $prod->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="billing_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Skema Pembayaran <span class="text-rose-500">*</span></label>
                    <select id="billing_type" name="billing_type" x-model="billingType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                        <option value="down_payment">Uang Muka (Down Payment / DP)</option>
                        <option value="milestone_termin">Termin Perkembangan (Termin)</option>
                        <option value="final_settlement">Pelunasan Akhir (Final Settlement)</option>
                        <option value="one_time">Pembayaran Penuh Sekaligus (Full 100%)</option>
                        <option value="recurring">Langganan Berkala (Recurring / Bulanan)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="project_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Proyek / Peruntukan Tagihan <span class="text-rose-500">*</span></label>
                <input type="text" id="project_title" name="project_title" x-model="projectTitle" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="issue_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Terbit <span class="text-rose-500">*</span></label>
                    <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date', $invoice->issue_date->format('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>

                <div>
                    <label for="due_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Batas Jatuh Tempo <span class="text-rose-500">*</span></label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>
        </div>

        <!-- Step 2: Line Items Dynamic Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Rincian Pos Biaya & Layanan</h3>
                    <p class="text-xs text-slate-500">Sesuaikan pos rincian pekerjaan atau lisensi</p>
                </div>
                <button type="button" @click="addItem" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Baris
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(item, index) in items" :key="index">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center shrink-0 mt-2" x-text="index + 1"></span>
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 flex-1">
                                <div class="md:col-span-8">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Nama Item / Layanan <span class="text-rose-500">*</span></label>
                                    <input type="text" :name="'items[' + index + '][item_name]'" x-model="item.item_name" required placeholder="Contoh: Modul Kasir POS & Konfigurasi Printer"
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Satuan (Unit)</label>
                                    <input type="text" :name="'items[' + index + '][unit_name]'" x-model="item.unit_name" placeholder="Paket / Bulan / Unit"
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                                </div>
                                <div class="md:col-span-12">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Deskripsi Ruang Lingkup</label>
                                    <input type="text" :name="'items[' + index + '][item_description]'" x-model="item.item_description" placeholder="Penjelasan rincian cakupan item..."
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kuantitas</label>
                                    <input type="number" step="0.1" min="0.01" :name="'items[' + index + '][quantity]'" x-model="item.quantity" @input="updateItemTotal(index)" required
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                                </div>
                                <div class="md:col-span-5">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Harga Satuan (Rp)</label>
                                    <input type="number" step="1000" min="0" :name="'items[' + index + '][unit_price]'" x-model="item.unit_price" @input="updateItemTotal(index)" required
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-mono">
                                </div>
                                <div class="md:col-span-4">
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Total Biaya (Rp)</label>
                                    <input type="number" :name="'items[' + index + '][total_price]'" :value="item.total_price" readonly
                                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-100 text-slate-700 text-sm font-mono font-bold">
                                </div>
                            </div>

                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-slate-400 hover:text-rose-600 p-2 transition-colors mt-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Step 3: Calculation & Totals -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Perhitungan Nilai & Pembayaran</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="discount_amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Potongan Diskon (Rp)</label>
                        <input type="number" id="discount_amount" name="discount_amount" x-model="discountAmount" @input="calculate" min="0" step="1000"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                    </div>

                    <div>
                        <label for="tax_percentage" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pajak Pertambahan Nilai (PPN %)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="tax_percentage" name="tax_percentage" x-model="taxPercentage" @input="calculate" min="0" max="100" step="0.5"
                                   class="w-28 px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            <button type="button" @click="taxPercentage = 0; calculate()" class="px-2.5 py-2 text-xs rounded-lg border border-slate-200 hover:bg-slate-50 font-medium">0% (Bebas PPN)</button>
                            <button type="button" @click="taxPercentage = 11; calculate()" class="px-2.5 py-2 text-xs rounded-lg border border-slate-200 hover:bg-slate-50 font-medium">11%</button>
                            <button type="button" @click="taxPercentage = 12; calculate()" class="px-2.5 py-2 text-xs rounded-lg border border-slate-200 hover:bg-slate-50 font-medium">12%</button>
                        </div>
                    </div>

                    <div>
                        <label for="payment_status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Pembayaran <span class="text-rose-500">*</span></label>
                        <select id="payment_status" name="payment_status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                            <option value="unpaid" {{ old('payment_status', $invoice->payment_status) === 'unpaid' ? 'selected' : '' }}>UNPAID (Belum Bayar)</option>
                            <option value="partial_dp" {{ old('payment_status', $invoice->payment_status) === 'partial_dp' ? 'selected' : '' }}>PARTIAL DP (Uang Muka Diterima)</option>
                            <option value="paid" {{ old('payment_status', $invoice->payment_status) === 'paid' ? 'selected' : '' }}>PAID (Lunas 100%)</option>
                            <option value="overdue" {{ old('payment_status', $invoice->payment_status) === 'overdue' ? 'selected' : '' }}>OVERDUE (Jatuh Tempo Lewat)</option>
                            <option value="cancelled" {{ old('payment_status', $invoice->payment_status) === 'cancelled' ? 'selected' : '' }}>CANCELLED (Batal)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Preset Uang Muka (DP)</label>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="applyDpPreset(30)" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 hover:bg-blue-50 hover:text-blue-700 transition-colors">DP 30%</button>
                            <button type="button" @click="applyDpPreset(50)" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 hover:bg-blue-50 hover:text-blue-700 transition-colors">DP 50%</button>
                            <button type="button" @click="applyDpPreset(100)" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 hover:bg-blue-50 hover:text-blue-700 transition-colors">Lunas 100%</button>
                        </div>
                    </div>
                </div>

                <!-- Live Summary Box -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3 font-mono text-sm">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Subtotal Rincian</span>
                        <span class="font-bold">Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal)"></span></span>
                        <input type="hidden" name="subtotal" :value="subtotal">
                    </div>

                    <div class="flex items-center justify-between text-emerald-600" x-show="discountAmount > 0">
                        <span>Potongan Diskon</span>
                        <span>- Rp <span x-text="new Intl.NumberFormat('id-ID').format(discountAmount)"></span></span>
                    </div>

                    <div class="flex items-center justify-between text-slate-600" x-show="taxPercentage > 0">
                        <span>PPN (<span x-text="taxPercentage"></span>%)</span>
                        <span class="font-bold">+ Rp <span x-text="new Intl.NumberFormat('id-ID').format(taxAmount)"></span></span>
                        <input type="hidden" name="tax_amount" :value="taxAmount">
                    </div>

                    <div class="border-t border-slate-300 pt-3 flex items-center justify-between text-base font-bold text-blue-900">
                        <span>TOTAL AKHIR (GRAND TOTAL)</span>
                        <span>Rp <span x-text="new Intl.NumberFormat('id-ID').format(grandTotal)"></span></span>
                        <input type="hidden" name="grand_total" :value="grandTotal">
                    </div>

                    <div class="pt-2 border-t border-slate-200 space-y-2">
                        <label for="amount_paid" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Jumlah Pembayaran Diterima (Rp)</label>
                        <input type="number" id="amount_paid" name="amount_paid" x-model="amountPaid" @input="calculate" min="0" step="1000"
                               class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm font-mono font-bold">
                    </div>

                    <div class="bg-amber-100/70 p-3 rounded-xl flex items-center justify-between text-amber-900 font-bold">
                        <span>SISA TAGIHAN (BALANCE DUE)</span>
                        <span>Rp <span x-text="new Intl.NumberFormat('id-ID').format(balanceDue)"></span></span>
                        <input type="hidden" name="balance_due" :value="balanceDue">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Bank & Admin Notes -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Pembayaran & Catatan</h3>

            <div>
                <label for="payment_method_info" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Instruksi Pembayaran & Rekening Bank</label>
                <textarea id="payment_method_info" name="payment_method_info" rows="3"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('payment_method_info', $invoice->payment_method_info) }}</textarea>
            </div>

            <div>
                <label for="admin_notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Internal Perusahaan (Hanya Dilihat Admin)</label>
                <textarea id="admin_notes" name="admin_notes" rows="2"
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">{{ old('admin_notes', $invoice->admin_notes) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.invoices.show', $invoice) }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs hover:shadow-md">
                Simpan Perubahan Invoice
            </button>
        </div>

    </form>
</div>

@endsection
