@extends('layouts.admin')

@section('title', 'Edit Klien: ' . $client->contact_name)
@section('header_title', 'Perbarui Data Klien')

@section('content')

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Edit Data Klien: {{ $client->contact_name }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kode: {{ $client->client_code }}</p>
        </div>
        <a href="{{ route('admin.clients.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Klien *</label>
                <input type="text" name="client_code" value="{{ old('client_code', $client->client_code) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp Aktif *</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $client->whatsapp_number) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap Penanggung Jawab *</label>
                <input type="text" name="contact_name" value="{{ old('contact_name', $client->contact_name) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Resmi</label>
                <input type="text" name="job_title" value="{{ old('job_title', $client->job_title) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Perusahaan / Instansi</label>
                <input type="text" name="company_name" value="{{ old('company_name', $client->company_name) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Resmi</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor KTP / NIK / NPWP</label>
            <input type="text" name="identity_number" value="{{ old('identity_number', $client->identity_number) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Kantor / Domisili Lengkap</label>
            <textarea name="address" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">{{ old('address', $client->address) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Khusus Klien</label>
            <textarea name="notes" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">{{ old('notes', $client->notes) }}</textarea>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.clients.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>

@endsection
