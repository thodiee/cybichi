@extends('layouts.admin')

@section('title', 'Pipeline Prospek & Konsultasi Klien')
@section('header_title', 'Pipeline Prospek & Permintaan Demo')

@section('content')
<div class="space-y-6" x-data="{
    activeModal: false,
    selectedInquiry: null,
    inquiryStatus: 'new',
    adminNotes: '',
    openModal(inq) {
        this.selectedInquiry = inq;
        this.inquiryStatus = inq.status;
        this.adminNotes = inq.admin_notes || '';
        this.activeModal = true;
    }
}">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-heading text-slate-900">Leads Pipeline & Masuk Konsultasi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola calon klien masuk dari landing page, formulir demo, dan WhatsApp Corporate Hub.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.inquiries.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, perusahaan, nomor WhatsApp, atau kode prospek..."
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                </div>
            </div>

            <div class="sm:col-span-4">
                <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                    <option value="">-- Semua Status Prospek --</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Baru Masuk (New)</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Sudah Dihubungi (Contacted)</option>
                    <option value="negotiation" {{ request('status') === 'negotiation' ? 'selected' : '' }}>Tahap Negosiasi (Negotiation)</option>
                    <option value="converted_to_invoice" {{ request('status') === 'converted_to_invoice' ? 'selected' : '' }}>Dikonversi Menjadi Invoice</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Diarsipkan (Archived)</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter Prospek
                </button>
            </div>
        </form>
    </div>

    <!-- Inquiries Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/70 text-slate-500 text-xs font-semibold border-b border-slate-200/60 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Kode Prospek</th>
                        <th class="py-3.5 px-4">Calon Klien & Perusahaan</th>
                        <th class="py-3.5 px-4">Peminatan Sistem / Budget</th>
                        <th class="py-3.5 px-4">Catatan Kebutuhan</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Tanggal Masuk</th>
                        <th class="py-3.5 px-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($inquiries as $inq)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <span class="font-mono text-xs font-bold text-blue-600 block">{{ $inq->inquiry_code }}</span>
                            <span class="text-[11px] text-slate-400">{{ $inq->timeline_requirement ?? 'Segera' }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-900">{{ $inq->client_name }}</div>
                            <div class="text-xs text-slate-500">{{ $inq->company_name ?? 'Pribadi / Retail' }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <a href="https://wa.me/{{ $inq->clean_whatsapp }}?text=Halo%20Bapak%2FIbu%20{{ urlencode($inq->client_name) }}%2C%20kami%20dari%20CYBICHI%20menindaklanjuti%20permintaan%20konsultasi%20Anda."
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 hover:text-emerald-700">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.888 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    {{ $inq->whatsapp_number }}
                                </a>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($inq->product)
                            <div class="font-semibold text-slate-900">{{ $inq->product->title }}</div>
                            @else
                            <div class="font-semibold text-slate-700">Permintaan Konsultasi Umum</div>
                            @endif
                            <div class="text-xs text-slate-500 font-mono">Budget: {{ $inq->project_budget_range ?? 'Belum ditentukan' }}</div>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">{{ $inq->message_notes }}</p>
                            @if($inq->admin_notes)
                            <div class="text-[11px] text-amber-700 bg-amber-50 p-1.5 rounded mt-1 border border-amber-200/60 line-clamp-1">
                                <strong>Admin:</strong> {{ $inq->admin_notes }}
                            </div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($inq->status === 'new') bg-rose-100 text-rose-800 border border-rose-200
                                @elseif($inq->status === 'contacted') bg-blue-100 text-blue-800 border border-blue-200
                                @elseif($inq->status === 'negotiation') bg-amber-100 text-amber-800 border border-amber-200
                                @elseif($inq->status === 'converted_to_invoice') bg-emerald-100 text-emerald-800 border border-emerald-200
                                @else bg-slate-100 text-slate-700 border border-slate-200
                                @endif">
                                {{ strtoupper(str_replace('_', ' ', $inq->status)) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center text-xs text-slate-500">
                            {{ $inq->created_at->translatedFormat('d M Y') }}<br>
                            <span class="text-[10px] text-slate-400">{{ $inq->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="py-3.5 px-4 text-right space-x-1 whitespace-nowrap">
                            <!-- Update Status Button -->
                            <button type="button" @click="openModal({{ json_encode($inq) }})"
                                    class="px-2.5 py-1 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg shadow-xs">
                                Kelola
                            </button>

                            <!-- Convert to Invoice -->
                            <a href="{{ route('admin.invoices.create', ['product_id' => $inq->product_id]) }}"
                               class="px-2.5 py-1 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-xs" title="Terbitkan Invoice">
                                Buat Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <p class="font-medium text-slate-600">Belum ada prospek konsultasi yang sesuai filter.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $inquiries->links() }}
        </div>
        @endif
    </div>

    <!-- Alpine Modal for Managing Lead Status -->
    <div x-show="activeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="activeModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="activeModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="activeModal" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                <template x-if="selectedInquiry">
                    <form :action="'/admin/inquiries/' + selectedInquiry.id + '/status'" method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Kelola Status Prospek</h3>
                                <p class="text-xs text-slate-500" x-text="selectedInquiry.client_name + ' (' + selectedInquiry.inquiry_code + ')'"></p>
                            </div>
                            <button type="button" @click="activeModal = false" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ubah Status Prospek <span class="text-rose-500">*</span></label>
                            <select name="status" x-model="inquiryStatus" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                                <option value="new">Baru Masuk (New)</option>
                                <option value="contacted">Sudah Dihubungi (Contacted)</option>
                                <option value="negotiation">Dalam Negosiasi (Negotiation)</option>
                                <option value="converted_to_invoice">Telah Diterbitkan Invoice (Converted)</option>
                                <option value="archived">Diarsipkan (Archived)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Kemajuan Prospek</label>
                            <textarea name="admin_notes" x-model="adminNotes" rows="3" placeholder="Contoh: Sudah presentasi demo online via Zoom, klien minta diskon 10%..."
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                            <button type="button" @click="activeModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800">Tutup</button>
                            <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs">
                                Perbarui Status
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

</div>
@endsection
