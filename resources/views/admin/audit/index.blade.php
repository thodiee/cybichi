@extends('layouts.admin')

@section('title', 'Log Keamanan & Audit Trail Sistem')
@section('header_title', 'Security Audit Trail & Compliance Log')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-heading text-slate-900">Rekam Jejak Keamanan (Audit Log)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Seluruh aktivitas autentikasi, penerbitan invoice, perubahan kontrak MoU, dan akses data tercatat secara permanen.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.audit.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-10">
                <select name="event" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600">
                    <option value="">-- Semua Jenis Peristiwa Keamanan (Events) --</option>
                    <option value="login_success" {{ request('event') === 'login_success' ? 'selected' : '' }}>Login Sukses (Login Success)</option>
                    <option value="login_failed" {{ request('event') === 'login_failed' ? 'selected' : '' }}>Login Gagal (Login Failed)</option>
                    <option value="invoice_created" {{ request('event') === 'invoice_created' ? 'selected' : '' }}>Penerbitan Invoice (Invoice Created)</option>
                    <option value="invoice_updated" {{ request('event') === 'invoice_updated' ? 'selected' : '' }}>Perubahan Invoice (Invoice Updated)</option>
                    <option value="invoice_status_changed" {{ request('event') === 'invoice_status_changed' ? 'selected' : '' }}>Perubahan Status Invoice</option>
                    <option value="mou_issued" {{ request('event') === 'mou_issued' ? 'selected' : '' }}>Penerbitan Kontrak MoU</option>
                    <option value="mou_updated" {{ request('event') === 'mou_updated' ? 'selected' : '' }}>Perubahan Kontrak MoU</option>
                    <option value="settings_updated" {{ request('event') === 'settings_updated' ? 'selected' : '' }}>Perubahan Pengaturan CMS / Sistem</option>
                    <option value="demo_redirected" {{ request('event') === 'demo_redirected' ? 'selected' : '' }}>Outbound Klik Demo Pengunjung</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center">
                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter Log
                </button>
            </div>
        </form>
    </div>

    <!-- Audit Logs Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/70 text-slate-500 text-xs font-semibold border-b border-slate-200/60 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Waktu (WIB)</th>
                        <th class="py-3.5 px-4">Peristiwa (Event)</th>
                        <th class="py-3.5 px-4">Operator / User</th>
                        <th class="py-3.5 px-4">Alamat IP & Perangkat</th>
                        <th class="py-3.5 px-4">Rincian Perubahan Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4 text-xs font-mono text-slate-500 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y') }}<br>
                            <span class="text-slate-800 font-bold">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if(str_contains($log->event_type, 'failed')) bg-rose-100 text-rose-800 border border-rose-200
                                @elseif(str_contains($log->event_type, 'created') || str_contains($log->event_type, 'issued')) bg-emerald-100 text-emerald-800 border border-emerald-200
                                @elseif(str_contains($log->event_type, 'status')) bg-amber-100 text-amber-800 border border-amber-200
                                @else bg-blue-100 text-blue-800 border border-blue-200
                                @endif">
                                {{ strtoupper(str_replace('_', ' ', $log->event_type)) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($log->user)
                            <div class="font-semibold text-slate-900">{{ $log->user->name }}</div>
                            <div class="text-xs text-slate-500 font-mono">{{ $log->user->email }}</div>
                            @else
                            <span class="text-xs text-slate-400 font-mono">Sistem / Tamu Publik</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-xs">
                            <span class="font-mono font-semibold text-slate-800">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                            <p class="text-[11px] text-slate-400 max-w-xs truncate" title="{{ $log->user_agent }}">{{ $log->user_agent ?? 'Unknown Agent' }}</p>
                        </td>
                        <td class="py-3.5 px-4 max-w-sm">
                            @if($log->new_values)
                            <pre class="text-[11px] font-mono bg-slate-50 p-2 rounded-lg border border-slate-200 text-slate-700 overflow-x-auto max-h-24">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                            <span class="text-xs text-slate-400 italic">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <p class="font-medium text-slate-600">Belum ada riwayat audit log yang tercatat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
