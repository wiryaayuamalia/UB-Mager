@extends('layouts.app')
@section('title', $katalog->nama_barang)
@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <div>
        <div class="bg-gray-200 rounded-2xl overflow-hidden aspect-square">
            @if($katalog->foto_utama)<img src="{{ $katalog->foto_utama }}" class="w-full h-full object-cover">@endif
        </div>
        <div class="flex gap-2 mt-2">
            @foreach($katalog->foto as $f)<img src="{{ asset('storage/'.$f->path_foto) }}" class="w-16 h-16 rounded-lg object-cover">@endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">{{ $katalog->kategori->nama_kategori }}</span>
        <h1 class="text-2xl font-bold mt-2">{{ $katalog->nama_barang }}</h1>
        <div class="text-3xl font-extrabold text-maroon my-3">Rp {{ number_format($katalog->harga, 0, ',', '.') }}</div>
        <dl class="text-sm space-y-1 mb-4">
            <div><dt class="inline font-semibold">Kondisi:</dt> {{ $katalog->kondisi }}</div>
            <div><dt class="inline font-semibold">Lokasi:</dt> {{ $katalog->lokasi }}</div>
            <div><dt class="inline font-semibold">Stok:</dt> {{ $katalog->stok }}</div>
            <div><dt class="inline font-semibold">Penjual:</dt> {{ $katalog->penjual->nama_toko }} (★ {{ $katalog->penjual->rating_rata_rata }})</div>
        </dl>
        <p class="text-gray-700 mb-6">{{ $katalog->deskripsi }}</p>
        @if($katalog->stok > 0 && $katalog->status_katalog === 'aktif')
        <div class="flex gap-2">
            @auth
            <form method="POST" action="{{ route('keranjang.tambah', $katalog) }}">@csrf
                <button class="bg-gray-100 rounded-lg px-5 py-2 font-semibold">+ Keranjang</button></form>
            @endauth
            <a href="{{ route('checkout.form', $katalog) }}" class="bg-maroon text-white rounded-lg px-5 py-2 font-semibold">Beli Sekarang</a>
        </div>
        @else
            <div class="p-3 bg-red-50 text-red-700 rounded-lg text-sm">Barang sudah tidak tersedia.</div>
        @endif
    </div>
</div>
@endsection
