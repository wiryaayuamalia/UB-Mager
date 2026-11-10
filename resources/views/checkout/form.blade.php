@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-1">Checkout</h1>
    <p class="mb-4"><b>{{ $katalog->nama_barang }}</b> — Rp {{ number_format($katalog->harga, 0, ',', '.') }}</p>
    <form method="POST" action="{{ route('checkout.proses', $katalog) }}" class="space-y-3">
        @csrf
        <div><label class="text-sm font-semibold">Alamat pengiriman (area Malang–Batu)</label>
            <input name="alamat" value="{{ old('alamat', $alamat) }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="text-sm font-semibold">Metode pengiriman</label>
            <select name="metode_pengiriman" class="w-full border rounded-lg px-3 py-2">
                <option value="kurir instan">Kurir Instan (+Rp 12.000)</option>
                <option value="cod">COD (ketemuan)</option>
            </select></div>
        <div><label class="text-sm font-semibold">Metode pembayaran</label>
            <select name="metode_pembayaran" class="w-full border rounded-lg px-3 py-2">
                <option value="transfer">Transfer Bank</option>
                <option value="e-wallet">E-Wallet</option>
                <option value="tunai cod">Tunai COD</option>
            </select></div>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Konfirmasi Pesanan</button>
    </form>
</div>
@endsection
