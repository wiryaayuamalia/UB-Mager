
@extends('layouts.app')

@section('title', 'Pesanan Masuk Penjual')

@section('content')
    {{-- HEADER HALAMAN --}}
    <div class="flex flex-wrap justify-between gap-3 mb-6">
        <div>
            <p class="text-xs text-gray-500">
                Dashboard Penjual / Transaksi
            </p>

            <h1 class="text-2xl font-extrabold mt-1">
                Pesanan Masuk
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Tinjau pesanan, berikan keputusan, dan perbarui proses pengiriman.
            </p>
        </div>

        <a
            href="{{ route('penjual.dashboard') }}"
            class="rounded-full bg-white border px-4 py-2 h-fit text-sm font-bold"
        >
            ← Inventaris
        </a>
    </div>

    {{-- DAFTAR PESANAN --}}
    <div class="space-y-4">
        @forelse($pesanan as $p)
            <article class="card-polish p-5">

                {{-- INFORMASI PESANAN --}}
                <div class="flex flex-wrap justify-between gap-2">
                    <div>
                        <p class="text-xs text-gray-500">
                            Pesanan #{{ $p->id_pesanan }}
                            ·
                            {{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('d M Y H:i') }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            Pembeli:
                            <b>{{ $p->pembeli->nama ?? 'Mahasiswa' }}</b>
                            ·
                            {{ $p->pembeli->fakultas ?? '' }}
                        </p>

                        <h2 class="font-extrabold mt-1">
                            {{ $p->katalog->nama_barang }}
                        </h2>
                    </div>

                    {{-- STATUS PESANAN --}}
                    <span class="status-pill">
                        {{ ucfirst($p->status_pesanan) }}
                    </span>
                </div>

                {{-- DETAIL TRANSAKSI --}}
                <div class="grid md:grid-cols-3 gap-3 mt-4 text-sm">

                    {{-- TOTAL TRANSAKSI --}}
                    <div class="rounded-xl bg-gray-50 p-3">
                        <p class="text-xs text-gray-500">
                            Total Transaksi
                        </p>

                        <b class="text-maroon">
                            Rp {{ number_format($p->total_bayar, 0, ',', '.') }}
                        </b>
                    </div>

                    {{-- METODE PEMBAYARAN DAN PENGIRIMAN --}}
                    <div class="rounded-xl bg-gray-50 p-3">
                        <p class="text-xs text-gray-500">
                            Metode
                        </p>

                        <b>
                            {{ strtoupper($p->metode_pengiriman) }}
                            ·
                            {{ $p->metode_pembayaran }}
                        </b>
                    </div>

                    {{-- ALAMAT PENGIRIMAN --}}
                    <div class="rounded-xl bg-gray-50 p-3">
                        <p class="text-xs text-gray-500">
                            Alamat / Titik Antar
                        </p>

                        <b>
                            {{ $p->alamat_pengiriman }}
                        </b>
                    </div>
                </div>

                {{-- TOMBOL AKSI PESANAN --}}
                <div class="flex flex-wrap gap-2 mt-4">

                    {{-- PESANAN DIKONFIRMASI --}}
                    @if($p->status_pesanan === 'dikonfirmasi')

                        {{-- SETUJUI PESANAN --}}
                        <form
                            method="POST"
                            action="{{ route('penjual.pesanan.setuju', $p) }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="rounded-full bg-maroon text-white px-5 py-2.5 text-xs font-bold"
                            >
                                Setujui & Siapkan
                            </button>
                        </form>

                        {{-- TOLAK PESANAN --}}
                        <form
                            method="POST"
                            action="{{ route('penjual.pesanan.tolak', $p) }}"
                            class="flex flex-wrap gap-2"
                        >
                            @csrf

                            <input
                                type="text"
                                name="alasan_penolakan"
                                required
                                placeholder="Alasan penolakan"
                                class="!py-2 text-xs"
                            >

                            <button
                                type="submit"
                                class="rounded-full bg-red-50 text-red-700 px-5 py-2 text-xs font-bold"
                            >
                                Tolak Pesanan
                            </button>
                        </form>

                    {{-- PESANAN SEDANG DISIAPKAN --}}
                    @elseif($p->status_pesanan === 'disiapkan')

                        <form
                            method="POST"
                            action="{{ route('penjual.pesanan.pengiriman', $p) }}"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="konfirmasi"
                                value="pickup"
                            >

                            <button
                                type="submit"
                                class="rounded-full bg-maroon text-white px-5 py-2.5 text-xs font-bold"
                            >
                                Tandai Diserahkan / Siap COD
                            </button>
                        </form>

                    {{-- PESANAN SEDANG DIKIRIM --}}
                    @elseif($p->status_pesanan === 'dikirim')

                        <span class="text-xs text-gray-500 self-center">
                            Menunggu pembeli mengonfirmasi barang diterima.
                        </span>

                    @endif
                </div>

            </article>

        @empty
            {{-- KONDISI BELUM ADA PESANAN --}}
            <div class="card-polish p-12 text-center">
                <div class="text-4xl"></div>

                <h3 class="font-extrabold mt-3">
                    Belum ada pesanan masuk
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Pesanan baru akan muncul di halaman ini.
                </p>
            </div>
        @endforelse
    </div>
@endsection
