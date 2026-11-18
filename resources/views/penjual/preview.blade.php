
@extends('layouts.app')

@section('title', 'Pratinjau Lapak')

@section('content')
    {{-- HEADER PROFIL LAPAK --}}
    <div class="card-polish overflow-hidden mb-6">

        {{-- BANNER LAPAK --}}
        <div class="h-36 bg-gradient-to-r from-[#4d1028] to-[#a65a69]"></div>

        {{-- INFORMASI PENJUAL --}}
        <div class="px-6 pb-6">
            <h1 class="text-2xl font-extrabold mt-3">
                {{ $seller->nama_toko }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                {{ $seller->lokasi_toko }}
                ·
                <span class="text-amber-500">★</span>
                {{ number_format($seller->rating_rata_rata, 1) }}
            </p>

            <p class="text-xs text-gray-500 mt-3">
                Lapak preloved mahasiswa UB di area Malang–Batu.
            </p>
        </div>
    </div>

    {{-- HEADER DAFTAR BARANG --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-extrabold">
                Barang di Lapak
            </h2>

            <p class="text-xs text-gray-500 mt-1">
                {{ $katalog->count() }} barang aktif ditayangkan.
            </p>
        </div>

        <a
            href="{{ route('penjual.dashboard') }}"
            class="text-sm font-bold text-maroon"
        >
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- DAFTAR KATALOG --}}
    @if($katalog->isEmpty())

        {{-- KONDISI BELUM ADA BARANG --}}
        <div class="card-polish p-10 text-center text-sm text-gray-500">
            Belum ada barang yang ditayangkan.
        </div>

    @else

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($katalog as $k)

                {{-- KARTU BARANG --}}
                <a
                    href="{{ route('katalog.show', $k) }}"
                    class="card-polish overflow-hidden"
                >
                    {{-- FOTO BARANG --}}
                    <div class="h-40 bg-gray-100">
                        @if($k->foto_utama)
                            <img
                                src="{{ $k->foto_utama }}"
                                class="w-full h-full object-cover"
                            >
                        @endif
                    </div>

                    {{-- INFORMASI BARANG --}}
                    <div class="p-3">
                        <b class="text-maroon">
                            Rp {{ number_format($k->harga, 0, ',', '.') }}
                        </b>

                        <p class="text-sm font-bold mt-1">
                            {{ $k->nama_barang }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $k->lokasi }}
                        </p>
                    </div>
                </a>

            @endforeach
        </div>

    @endif
@endsection
