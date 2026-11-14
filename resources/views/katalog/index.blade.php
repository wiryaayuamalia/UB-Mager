@extends('layouts.app')
@section('title','Pasar Preloved Mahasiswa Malang–Batu')
@section('content')
<section class="relative overflow-hidden rounded-[28px] mb-7 bg-[#f4e9d5] min-h-[260px] flex items-center">
  <div class="relative z-10 p-7 md:p-12 max-w-2xl">
    <span class="inline-flex items-center gap-2 text-[11px] font-extrabold tracking-[.16em] uppercase text-maroon bg-white/75 rounded-full px-3 py-2 mb-4">✦ Marketplace mahasiswa UB</span>
    <h1 class="text-3xl md:text-[42px] leading-[1.12] font-extrabold text-[#4e1029]">Temukan Barang Favorit,<br><span class="text-[#a65c3d]">Harga Lebih Bersahabat.</span></h1>
    <p class="text-sm md:text-base text-[#695d56] mt-4 max-w-lg">Jual beli barang preloved berkualitas di Malang–Batu. Lebih hemat, lebih dekat, dan tetap aman dengan COD di area kampus.</p>
    <a href="#katalog" class="inline-flex mt-6 bg-maroon text-white rounded-full px-5 py-3 text-sm font-bold">Jelajahi Katalog <span class="ml-3">→</span></a>
  </div>
  <div class="absolute right-0 bottom-0 top-0 w-[43%] hidden md:flex items-center justify-center opacity-90">
    <div class="absolute w-64 h-64 rounded-full bg-[#e7cba5]"></div><div class="relative grid grid-cols-2 gap-3 rotate-[-7deg]">
      <div class="w-28 h-36 bg-white rounded-2xl shadow-xl p-2 rotate-[7deg]"><div class="h-24 rounded-xl bg-[#d7b58f] flex items-center justify-center text-4xl">📚</div><span class="block text-[10px] font-bold mt-2">Buku & Modul</span></div>
      <div class="w-28 h-36 bg-white rounded-2xl shadow-xl p-2 translate-y-7 rotate-[8deg]"><div class="h-24 rounded-xl bg-[#c8d1c1] flex items-center justify-center text-4xl">🎧</div><span class="block text-[10px] font-bold mt-2">Elektronik</span></div>
      <div class="w-28 h-36 bg-white rounded-2xl shadow-xl p-2 -translate-y-2 rotate-[-8deg]"><div class="h-24 rounded-xl bg-[#e4c4bd] flex items-center justify-center text-4xl">👕</div><span class="block text-[10px] font-bold mt-2">Fashion</span></div>
      <div class="w-28 h-36 bg-white rounded-2xl shadow-xl p-2 translate-y-5 rotate-[5deg]"><div class="h-24 rounded-xl bg-[#d9d0b4] flex items-center justify-center text-4xl">🪴</div><span class="block text-[10px] font-bold mt-2">Perlengkapan Kos</span></div>
    </div>
  </div>
</section>
<form method="GET" action="{{ route('katalog.index') }}" class="card-polish p-5 md:p-6 mb-6">
  <div class="flex items-center justify-between gap-3 mb-4"><div><h2 class="font-extrabold text-lg">Filter & Pencarian Terpadu</h2><p class="text-xs text-gray-500 mt-1">Temukan barang sesuai kebutuhan dan area terdekat.</p></div><span class="text-xl">⌕</span></div>
  <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
    <input name="q" value="{{ request('q') }}" placeholder="Cari nama barang atau kata kunci..." class="md:col-span-4">
    <select name="kategori" class="md:col-span-2"><option value="">Semua Kategori</option>@foreach($kategori as $k)<option value="{{ $k->id_kategori }}" @selected(request('kategori')==$k->id_kategori)>{{ $k->nama_kategori }}</option>@endforeach</select>
    <select name="lokasi" class="md:col-span-3"><option value="">Semua Area Malang–Batu</option>@foreach($lokasi as $l)<option value="{{ $l }}" @selected(request('lokasi')===$l)>{{ $l }}</option>@endforeach</select>
    <div class="md:col-span-3 grid grid-cols-2 gap-2"><input type="number" min="0" name="min" value="{{ request('min') }}" placeholder="Harga min"><input type="number" min="0" name="maks" value="{{ request('maks') }}" placeholder="Harga maks"></div>
  </div>
  <div class="flex justify-end gap-2 mt-4"><a href="{{ route('katalog.index') }}" class="rounded-full bg-gray-100 px-5 py-2.5 text-sm font-semibold">Reset</a><button class="rounded-full bg-maroon text-white px-6 py-2.5 text-sm font-bold">Terapkan Filter</button></div>
</form>
<div class="mb-7"><div class="flex items-center justify-between mb-3"><h2 class="font-extrabold">Kategori Cepat</h2><span class="text-xs text-gray-500">Pilih kategori favoritmu</span></div><div class="flex gap-2 overflow-x-auto pb-1">@foreach($kategori as $k)<a href="{{ route('katalog.index',['kategori'=>$k->id_kategori]) }}" class="shrink-0 rounded-full border px-4 py-2 text-xs font-bold {{ request('kategori')==$k->id_kategori?'bg-maroon text-white border-maroon':'bg-white text-gray-600 border-gray-200' }}">{{ $k->nama_kategori }}</a>@endforeach</div></div>
<div id="katalog" class="flex items-end justify-between gap-3 mb-4"><div><h2 class="text-xl font-extrabold">Pilihan untukmu</h2><p class="text-xs text-gray-500 mt-1">{{ $katalog->total() }} barang tersedia di Malang–Batu</p></div><div class="flex gap-2 text-xs font-bold"><a href="{{ route('katalog.index',request()->except('tab')) }}" class="rounded-full px-4 py-2 {{ !request('tab')?'bg-maroon text-white':'bg-white' }}">Semua</a><a href="{{ route('katalog.index',array_merge(request()->except('tab'),['tab'=>'terbaru'])) }}" class="rounded-full px-4 py-2 {{ request('tab')==='terbaru'?'bg-maroon text-white':'bg-white' }}">Terbaru</a></div></div>
@if($katalog->isEmpty())<div class="card-polish p-12 text-center"><div class="text-4xl mb-3">🛍️</div><h3 class="font-bold">Belum ada barang yang cocok</h3><p class="text-sm text-gray-500 mt-1">Coba ubah kata kunci atau filter pencarian.</p><a href="{{ route('katalog.index') }}" class="inline-block mt-4 text-maroon font-bold text-sm">Lihat semua barang</a></div>
@else
<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">@foreach($katalog as $k)
  <article class="group bg-white rounded-[18px] border border-[#eeeaf0] overflow-hidden shadow-[0_4px_18px_#25102008] hover:shadow-lg transition">
    <a href="{{ route('katalog.show',$k) }}" class="block relative h-40 md:h-48 bg-[#f1efed]">@if($k->foto_utama)<img src="{{ $k->foto_utama }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300" loading="lazy">@else<div class="w-full h-full grid place-items-center text-4xl">📦</div>@endif<span class="absolute top-3 left-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-bold">{{ $k->kategori->nama_kategori }}</span></a>
    <div class="p-3.5"><div class="text-[16px] font-extrabold text-maroon">Rp {{ number_format($k->harga,0,',','.') }}</div><a href="{{ route('katalog.show',$k) }}" class="block font-bold text-sm mt-1 line-clamp-2 min-h-10">{{ $k->nama_barang }}</a><p class="text-[11px] text-gray-500 mt-2">⌖ {{ $k->lokasi }}</p><div class="text-[11px] text-gray-500 mt-1">{{ $k->penjual->nama_toko }} <span class="text-amber-500">★</span> {{ number_format($k->penjual->rating_rata_rata,1) }}</div>
      <div class="flex gap-2 mt-3">@auth<form method="POST" action="{{ route('keranjang.tambah',$k) }}" class="flex-1">@csrf<button class="w-full rounded-full bg-[#f4f0f2] text-maroon py-2 text-[11px] font-bold">+ Keranjang</button></form>@else<a href="{{ route('login') }}" class="flex-1 text-center rounded-full bg-[#f4f0f2] text-maroon py-2 text-[11px] font-bold">+ Keranjang</a>@endauth<a href="{{ route('checkout.form',$k) }}" class="flex-1 text-center rounded-full bg-maroon text-white py-2 text-[11px] font-bold">Beli</a></div>
    </div>
  </article>
@endforeach</div><div class="mt-7">{{ $katalog->links() }}</div>@endif
@endsection
