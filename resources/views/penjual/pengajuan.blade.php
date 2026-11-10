@extends('layouts.app')
@section('title', 'Pengajuan Penjual')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-2">Pengajuan Menjadi Penjual</h1>
    @if($terakhir)
        <div class="mb-4 p-3 rounded-lg text-sm {{ $terakhir->status_pengajuan === 'ditolak' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-800' }}">
            Status pengajuan terakhir: <b>{{ $terakhir->status_pengajuan }}</b>
            @if($terakhir->alasan_penolakan) — {{ $terakhir->alasan_penolakan }} @endif
        </div>
    @endif
    @if(!$terakhir || $terakhir->status_pengajuan === 'ditolak')
    <form method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <input name="nama_toko" value="{{ old('nama_toko') }}" placeholder="Nama toko" class="w-full border rounded-lg px-3 py-2">
        <select name="jenis_dokumen" class="w-full border rounded-lg px-3 py-2"><option>KTM</option><option>KTP</option></select>
        <div><label class="text-sm font-semibold">Dokumen identitas (JPG/PNG/PDF, maks 5 MB)</label><input type="file" name="dokumen"></div>
        <input name="lokasi_toko" value="{{ old('lokasi_toko') }}" placeholder="Alamat/lokasi toko" class="w-full border rounded-lg px-3 py-2">
        <div class="grid grid-cols-2 gap-2">
            <input name="latitude" value="{{ old('latitude', '-7.9525') }}" placeholder="Latitude" class="border rounded-lg px-3 py-2">
            <input name="longitude" value="{{ old('longitude', '112.6141') }}" placeholder="Longitude" class="border rounded-lg px-3 py-2">
        </div>
        <p class="text-xs text-gray-500">Titik peta harus di wilayah Malang–Batu. Cari koordinat di Google Maps (klik kanan → salin koordinat).</p>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Ajukan</button>
    </form>
    @endif
</div>
@endsection
