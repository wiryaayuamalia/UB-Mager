@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<h1 class="text-xl font-bold text-maroon mb-4">Pesanan Saya</h1>
<div class="space-y-3">
@forelse($pesanan as $p)
    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-4">
        <div class="flex-1">
            <div class="font-semibold">#{{ $p->id_pesanan }} — {{ $p->katalog->nama_barang }}</div>
            <div class="text-sm text-gray-500">Rp {{ number_format($p->total_bayar, 0, ',', '.') }} · {{ $p->metode_pembayaran }}</div>
            <div class="text-sm">Status: <b>{{ $p->status_pesanan }}</b>
                @if($p->pengiriman) · Pengiriman: {{ $p->pengiriman->status_pengiriman }} @endif</div>
        </div>
        @if($p->status_pesanan === 'menunggu pembayaran')
            <a href="{{ route('bayar.form', $p) }}" class="bg-maroon text-white rounded-lg px-4 py-2 text-sm">Bayar</a>
        @elseif($p->status_pesanan === 'dikirim')
            <form method="POST" action="{{ route('pesanan.terima', $p) }}">@csrf
                <button class="bg-green-600 text-white rounded-lg px-4 py-2 text-sm">Barang Diterima</button></form>
        @endif
    </div>
@empty
    <div class="bg-white rounded-xl p-8 text-center text-gray-500">Belum ada pesanan.</div>
@endforelse
</div>
@endsection
