@extends('layouts.app')
@section('title', 'Keranjang')
@section('content')
<h1 class="text-xl font-bold text-maroon mb-4">Keranjang</h1>
<div class="space-y-3">
@forelse($items as $i)
    @php $k = $i->katalog; $habis = $k->stok < 1 || $k->status_katalog !== 'aktif'; @endphp
    <div class="bg-white rounded-xl p-4 flex items-center gap-4 shadow-sm">
        <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">@if($k->foto_utama)<img src="{{ $k->foto_utama }}" class="w-full h-full object-cover">@endif</div>
        <div class="flex-1">
            <div class="font-semibold">{{ $k->nama_barang }}</div>
            <div class="text-maroon font-bold">Rp {{ number_format($k->harga, 0, ',', '.') }}</div>
            @if($habis)<div class="text-xs text-red-600">⚠ Barang sudah dibeli orang lain / stok habis</div>@endif
        </div>
        @unless($habis)<a href="{{ route('checkout.form', $k) }}" class="bg-maroon text-white rounded-lg px-4 py-2 text-sm">Checkout</a>@endunless
        <form method="POST" action="{{ route('keranjang.hapus', $i) }}">@csrf @method('DELETE') <button class="text-sm text-gray-500">Hapus</button></form>
    </div>
@empty
    <div class="bg-white rounded-xl p-8 text-center text-gray-500">Keranjang kosong.</div>
@endforelse
</div>
@endsection
