@extends('layouts.admin')

@section('title', 'Manajemen E-Invoice Tagihan')
@section('header_title', 'Daftar Invoice & Penagihan Proyek')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">E-Invoice &amp; Penagihan Proyek</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola tagihan Down Payment (DP), termin progres, pelunasan software, dan tagihan bulanan.</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
            + Terbitkan Invoice Baru
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.invoices.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no invoice, proyek, klien..." class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600 w-full sm:w-64">
            
            <select name="status" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="partial_dp" {{ request('status') == 'partial_dp' ? 'selected' : '' }}>DP Paid</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Jatuh Tempo (Overdue)</option>
            </select>

            <select name="billing_type" class="px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                <option value="">Semua Skema Bayar</option>
                <option value="down_payment" {{ request('billing_type') == 'down_payment' ? 'selected' : '' }}>Uang Muka (DP)</option>
                <option value="milestone_termin" {{ request('billing_type') == 'milestone_termin' ? 'selected' : '' }}>Termin</option>
                <option value="one_time" {{ request('billing_type') == 'one_time' ? 'selected' : '' }}>Sekali Bayar</option>
                <option value="recurring" {{ request('billing_type') == 'recurring' ? 'selected' : '' }}>Langganan</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800">
                Filter
            </button>
            <a href="{{ route('admin.invoices.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">Reset</a>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="p-3.5">No. Invoice</th>
                        <th class="p-3.5">Klien &amp; Proyek</th>
                        <th class="p-3.5">Skema</th>
                        <th class="p-3.5">Tanggal / Jatuh Tempo</th>
                        <th class="p-3.5">Total Proyek</th>
                        <th class="p-3.5">Tagihan Saat Ini</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-3.5 font-mono font-bold text-blue-700">
                                <a href="{{ route('admin.invoices.show', $inv) }}" class="hover:underline">
                                    {{ $inv->invoice_number }}
                                </a>
                            </td>
                            <td class="p-3.5">
                                <div class="font-bold text-slate-900">{{ $inv->client->contact_name }}</div>
                                <div class="text-[11px] text-slate-500 truncate max-w-xs">{{ $inv->project_title }}</div>
                            </td>
                            <td class="p-3.5 capitalize text-slate-600">
                                {{ str_replace('_', ' ', $inv->billing_type) }}
                            </td>
                            <td class="p-3.5 text-slate-600">
                                <div>{{ $inv->issue_date->translatedFormat('d M Y') }}</div>
                                <div class="text-[11px] text-rose-600 font-medium">Due: {{ $inv->due_date->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="p-3.5 font-mono font-bold text-slate-900">
                                {{ $inv->formatted_grand_total }}
                            </td>
                            <td class="p-3.5 font-mono font-black text-blue-700">
                                {{ $inv->formatted_balance_due }}
                            </td>
                            <td class="p-3.5 text-center">
                                @if($inv->payment_status === 'paid')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">PAID</span>
                                @elseif($inv->payment_status === 'partial_dp')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">DP PAID</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">UNPAID</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-1 shrink-0">
                                <a href="{{ route('admin.invoices.show', $inv) }}" class="px-2 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded text-[11px]">
                                    Detail
                                </a>
                                <a href="{{ route('admin.invoices.pdf', $inv) }}" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded text-[11px]" title="Unduh PDF">
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">Belum ada invoice yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $invoices->links() }}
        </div>
    </div>

</div>

@endsection
