@extends('layouts.app')
@section('title', 'Detail Pengajuan')
@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-4">Detail Pengajuan #{{ $pengajuan->id_pengajuan }}</h1>
    <dl class="grid grid-cols-2 gap-2 text-sm mb-4">
        <dt class="font-semibold">Pemohon</dt><dd>{{ $pengajuan->pengguna->nama }}</dd>
        <dt class="font-semibold">Nama toko</dt><dd>{{ $pengajuan->nama_toko }}</dd>
        <dt class="font-semibold">Lokasi</dt><dd>{{ $pengajuan->lokasi_toko }}</dd>
        <dt class="font-semibold">Koordinat</dt>
        <dd>{{ $pengajuan->latitude }}, {{ $pengajuan->longitude }}
            — <a target="_blank" class="text-maroon underline" href="https://www.google.com/maps?q={{ $pengajuan->latitude }},{{ $pengajuan->longitude }}">Lihat di peta</a></dd>
        <dt class="font-semibold">Dokumen ({{ $pengajuan->jenis_dokumen }})</dt>
        <dd><a target="_blank" class="text-maroon underline" href="{{ route('admin.pengajuan.dokumen', $pengajuan) }}">Buka dokumen</a></dd>
        <dt class="font-semibold">Status</dt><dd>{{ $pengajuan->status_pengajuan }}</dd>
    </dl>
    @if($pengajuan->status_pengajuan === 'menunggu')
    <div class="flex gap-3 items-start">
        <form method="POST" action="{{ route('admin.pengajuan.setujui', $pengajuan) }}">@csrf
            <button class="bg-green-600 text-white rounded-lg px-5 py-2">Setujui</button></form>
        <form method="POST" action="{{ route('admin.pengajuan.tolak', $pengajuan) }}" class="flex-1 flex gap-2">@csrf
            <input name="alasan_penolakan" placeholder="Alasan penolakan (wajib)" class="flex-1 border rounded-lg px-3 py-2" required>
            <button class="bg-red-600 text-white rounded-lg px-5 py-2">Tolak</button></form>
    </div>
    @endif
</div>
@endsection
