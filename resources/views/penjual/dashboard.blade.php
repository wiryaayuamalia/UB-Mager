@extends('layouts.app')
@section('title', 'Dashboard Penjual')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold text-maroon">Katalog Saya</h1>
    <div class="flex gap-2">
        <a href="{{ route('penjual.pesanan') }}" class="bg-white border rounded-lg px-4 py-2 text-sm">Pesanan Masuk</a>
        <a href="{{ route('penjual.katalog.create') }}" class="bg-maroon text-white rounded-lg px-4 py-2 text-sm">+ Unggah Katalog</a>
    </div>
</div>
<div class="space-y-3">
@forelse($katalog as $k)
    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-4">
        <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">@if($k->foto_utama)<img src="{{ $k->foto_utama }}" class="w-full h-full object-cover">@endif</div>
        <div class="flex-1">
            <div class="font-semibold">{{ $k->nama_barang }}</div>
            <div class="text-sm text-gray-500">Rp {{ number_format($k->harga, 0, ',', '.') }} · stok {{ $k->stok }} · <b>{{ $k->status_katalog }}</b> · {{ $k->status_kelengkapan }}</div>
        </div>
        <form method="POST" action="{{ route('penjual.katalog.destroy', $k) }}" onsubmit="return confirm('Nonaktifkan katalog ini?')">@csrf @method('DELETE')
            <button class="text-sm text-red-600">Hapus</button></form>
    </div>
@empty
    <div class="bg-white rounded-xl p-8 text-center text-gray-500">Belum ada katalog.</div>
@endforelse
</div>
@endsection
