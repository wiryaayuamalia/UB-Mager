@extends('layouts.app')
@section('title', 'Pesanan Masuk')
@section('content')
<h1 class="text-xl font-bold text-maroon mb-4">Pesanan Masuk</h1>
<div class="space-y-3">
@forelse($pesanan as $p)
    <div class="bg-white rounded-xl p-4 shadow-sm">
        <div class="font-semibold">#{{ $p->id_pesanan }} — {{ $p->katalog->nama_barang }}</div>
        <div class="text-sm text-gray-500">Antar ke: {{ $p->alamat_pengiriman }} · Rp {{ number_format($p->total_bayar, 0, ',', '.') }} · <b>{{ $p->status_pesanan }}</b></div>
        <div class="flex flex-wrap gap-2 mt-3">
            @if($p->status_pesanan === 'dikonfirmasi')
                <form method="POST" action="{{ route('penjual.pesanan.setuju', $p) }}">@csrf <button class="bg-green-600 text-white rounded-lg px-4 py-1.5 text-sm">Setujui</button></form>
                <form method="POST" action="{{ route('penjual.pesanan.tolak', $p) }}" class="flex gap-2">@csrf
                    <input name="alasan_penolakan" placeholder="Alasan penolakan (wajib)" class="border rounded-lg px-2 text-sm" required>
                    <button class="bg-red-600 text-white rounded-lg px-4 py-1.5 text-sm">Tolak</button></form>
            @elseif($p->status_pesanan === 'disiapkan')
                <form method="POST" action="{{ route('penjual.pesanan.pengiriman', $p) }}">@csrf <input type="hidden" name="konfirmasi" value="pickup">
                    <button class="bg-maroon text-white rounded-lg px-4 py-1.5 text-sm">Tandai Diserahkan ke Kurir / Dibawa ke Titik COD</button></form>
            @elseif($p->status_pesanan === 'dikirim')
                <form method="POST" action="{{ route('penjual.pesanan.pengiriman', $p) }}">@csrf <input type="hidden" name="konfirmasi" value="antar">
                    <button class="bg-gray-700 text-white rounded-lg px-4 py-1.5 text-sm">Simulasi: Kurir Konfirmasi Terantar</button></form>
            @endif
        </div>
    </div>
@empty
    <div class="bg-white rounded-xl p-8 text-center text-gray-500">Belum ada pesanan masuk.</div>
@endforelse
</div>
@endsection
