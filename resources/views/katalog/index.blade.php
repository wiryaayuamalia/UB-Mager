@extends('layouts.app')
@section('title', 'Katalog UB Mager')
@section('content')
<section class="bg-sun rounded-3xl p-8 mb-6">
    <h1 class="text-3xl font-extrabold text-maroon">Pasar Preloved Mahasiswa Malang–Batu</h1>
    <p class="text-gray-600 mt-2 max-w-xl">Beli & lego barang bekas berkualitas: buku kuliah, perlengkapan kos, fashion, hingga elektronik dengan sistem COD aman di area kampus.</p>
</section>

{{-- Filter & Pencarian Terpadu (SYA-SR-13..17, 21) --}}
<form method="GET" action="{{ route('katalog.index') }}" class="bg-white rounded-2xl shadow-sm p-5 mb-6">
    <h2 class="font-bold mb-3">Filter & Pencarian Terpadu</h2>
    <div class="grid md:grid-cols-4 gap-3">
        <input name="q" value="{{ request('q') }}" placeholder="Kata kunci nama barang" class="border rounded-lg px-3 py-2 md:col-span-2">
        <select name="lokasi" class="border rounded-lg px-3 py-2">
            <option value="">Semua Area Malang-Batu</option>
            @foreach($lokasi as $l)<option value="{{ $l }}" @selected(request('lokasi') === $l)>{{ $l }}</option>@endforeach
        </select>
        <select name="kategori" class="border rounded-lg px-3 py-2">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)<option value="{{ $k->id_kategori }}" @selected(request('kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>@endforeach
        </select>
        <input name="min" value="{{ request('min') }}" placeholder="Harga Min" class="border rounded-lg px-3 py-2">
        <input name="maks" value="{{ request('maks') }}" placeholder="Harga Maks" class="border rounded-lg px-3 py-2">
        <div class="md:col-span-2 flex gap-2 justify-end">
            <a href="{{ route('katalog.index') }}" class="px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-semibold">Hapus Filter</a>
            <button class="px-5 py-2 rounded-lg bg-maroon text-white font-semibold">Cari Barang</button>
        </div>
    </div>
</form>

{{-- Kategori cepat --}}
<div class="flex flex-wrap gap-2 mb-6">
    @foreach($kategori as $k)
        <a href="{{ route('katalog.index', ['kategori' => $k->id_kategori]) }}"
           class="px-3 py-1.5 rounded-full text-sm bg-white shadow-sm {{ request('kategori') == $k->id_kategori ? 'bg-maroon text-white' : '' }}">{{ $k->nama_kategori }}</a>
    @endforeach
</div>

<div class="flex items-center justify-between mb-3">
    <div class="flex gap-2 text-sm">
        <a href="{{ route('katalog.index') }}" class="px-3 py-1.5 rounded-lg {{ request('tab') ? 'bg-gray-200' : 'bg-maroon text-white' }}">Semua Barang</a>
        <a href="{{ route('katalog.index', ['tab' => 'terbaru']) }}" class="px-3 py-1.5 rounded-lg {{ request('tab') === 'terbaru' ? 'bg-maroon text-white' : 'bg-gray-200' }}">Terbaru Hari Ini</a>
    </div>
    <span class="text-xs text-gray-500">Menampilkan {{ $katalog->count() }} dari {{ $katalog->total() }} barang</span>
</div>

@if($katalog->isEmpty())
    <div class="bg-white rounded-2xl p-10 text-center text-gray-500">
        {{ request()->hasAny(['q','kategori','lokasi','min','maks']) ? 'Barang tidak ditemukan.' : 'Belum ada katalog.' }}
    </div>
@else
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach($katalog as $k)
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
        <a href="{{ route('katalog.show', $k) }}" class="block h-44 bg-gray-200 relative">
            @if($k->foto_utama)<img src="{{ $k->foto_utama }}" class="w-full h-full object-cover">@else
                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">Tanpa foto</div>@endif
            <span class="absolute top-2 left-2 bg-blue-100 text-blue-800 text-[10px] px-2 py-0.5 rounded">{{ $k->kategori->nama_kategori }}</span>
            <span class="absolute top-2 left-24 bg-yellow-100 text-yellow-800 text-[10px] px-2 py-0.5 rounded">{{ $k->kondisi }}</span>
        </a>
        <div class="p-3 flex-1 flex flex-col">
            <div class="font-extrabold text-maroon">Rp {{ number_format($k->harga, 0, ',', '.') }}</div>
            <a href="{{ route('katalog.show', $k) }}" class="font-semibold text-sm leading-snug mb-1">{{ $k->nama_barang }}</a>
            <div class="text-xs text-gray-500 mb-2">📍 {{ $k->lokasi }}</div>
            <div class="text-xs text-gray-500 mb-3">{{ $k->penjual->nama_toko }} · ★ {{ $k->penjual->rating_rata_rata }}</div>
            <div class="mt-auto flex gap-2">
                @auth
                <form method="POST" action="{{ route('keranjang.tambah', $k) }}" class="flex-1">@csrf
                    <button class="w-full text-xs bg-gray-100 rounded-lg py-2 font-semibold">Keranjang</button></form>
                @else
                <a href="{{ route('login') }}" class="flex-1 text-center text-xs bg-gray-100 rounded-lg py-2 font-semibold">Keranjang</a>
                @endauth
                <a href="{{ route('checkout.form', $k) }}" class="text-xs bg-maroon text-white rounded-lg px-3 py-2">Beli</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-6">{{ $katalog->links() }}</div>
@endif
@endsection
