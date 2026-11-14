@extends('layouts.app')
@section('title', 'Konfirmasi Pembayaran')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-center text-maroon mb-4">KONFIRMASI PEMBAYARAN</h1>
    <div class="mb-4 text-sm space-y-1">
        <div><b>Barang:</b> {{ $pesanan->katalog->nama_barang }}</div>
        <div><b>Total bayar:</b> Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</div>
        <div><b>Metode:</b> {{ $pesanan->metode_pembayaran }}</div>
        <div class="text-red-600"><b>Batas bayar:</b> {{ \Carbon\Carbon::parse($pesanan->batas_bayar)->format('H:i:s') }} (10 menit)</div>
    </div>
    <form method="POST" action="{{ route('bayar.upload', $pesanan) }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <label class="font-semibold text-sm">Upload Bukti Pembayaran (JPG/PNG/PDF, maks 5 MB)</label>
        <input type="file" name="bukti" required>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Submit</button>
    </form>
</div>
@endsection
