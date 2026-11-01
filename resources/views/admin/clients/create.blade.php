@extends('layouts.admin')

@section('title', 'Tambah Data Klien Baru')
@section('header_title', 'Form Registrasi Klien Rekanan')

@section('content')

<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-heading">Tambah Data Klien Rekanan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Data penanggung jawab yang sah untuk dicantumkan pada kop Invoice dan lembar MoU.</p>
        </div>
        <a href="{{ route('admin.clients.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.clients.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Klien *</label>
                <input type="text" name="client_code" value="{{ old('client_code', $nextCode) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor WhatsApp Aktif *</label>
                <input type="text" name="whatsapp_number" required placeholder="081234567890" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap Penanggung Jawab *</label>
                <input type="text" name="contact_name" required placeholder="Bpk. Budi Santoso, S.T." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Resmi</label>
                <input type="text" name="job_title" placeholder="Direktur Utama / Pemilik Usaha" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Perusahaan / Instansi</label>
                <input type="text" name="company_name" placeholder="PT Nusantara Agro Mandiri" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Resmi</label>
                <input type="email" name="email" placeholder="budi@agro-mandiri.co.id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nomor KTP / NIK / NPWP (Untuk Klausul MoU)</label>
            <input type="text" name="identity_number" placeholder="317105xxxxxxxxxx atau NPWP Badan Usaha" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Kantor / Domisili Lengkap</label>
            <textarea name="address" rows="3" placeholder="Gedung, Jalan, Kelurahan, Kecamatan, Kota..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Khusus Klien</label>
            <textarea name="notes" rows="2" placeholder="Catatan internal mengenai preferensi termin pembayaran..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-600"></textarea>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.clients.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all">
                Simpan Data Klien
            </button>
        </div>
    </form>

</div>

@endsection
