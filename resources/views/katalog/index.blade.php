
@extends('layouts.app')

@section('title', 'Pasar Preloved Mahasiswa Malang–Batu')

@section('content')

{{-- HERO UTAMA --}}
<section class="relative overflow-hidden rounded-2xl bg-[#f8f5cf] px-6 py-8 md:px-9 md:py-9 mb-7">
    <div class="max-w-4xl">
        <h1 class="text-2xl md:text-3xl font-extrabold text-[#650d2b]">
            Pasar Preloved Mahasiswa Malang–Batu
        </h1>

        <p class="text-sm text-[#695d56] mt-2 max-w-2xl leading-relaxed">
            Beli & lego barang bekas berkualitas: buku kuliah, perlengkapan kos,
            fashion, hingga elektronik dengan sistem COD aman di area kampus.
        </p>

        <div class="mt-5">
            <span class="text-[10px] font-extrabold tracking-wider text-[#695d56]">
                ZONA TITIK TEMU:
            </span>

            <div class="flex flex-wrap gap-2 mt-2">
                @foreach([
                    'Dekat Gerbang Veteran UB',
                    'Jl. Soekarno-Hatta (Suhat)',
                    'Sigura-gura',
                    'Kampus UM',
                    'Area Batu'
                ] as $zona)
                    <span class="bg-white rounded-full px-3 py-1.5 text-[10px] font-bold text-[#650d2b]">
                        ◈ {{ $zona }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- KEUNGGULAN MARKETPLACE --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-7 bg-[#650d2b] rounded-xl p-4 md:p-5 text-white">

        <div class="flex items-center gap-3">
            <div class="w-11 h-11 shrink-0 rounded-lg bg-[#ffe18c] text-[#650d2b] grid place-items-center text-xl">
                ✿
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-[#ffe18c]">
                    2.400+ Barang Terverifikasi
                </h3>
                <p class="text-[10px] text-white/80 mt-1">
                    Disortir oleh tim kurasi
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="w-11 h-11 shrink-0 rounded-lg bg-[#ffe18c] text-[#650d2b] grid place-items-center text-xl">
                🎓
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-[#ffe18c]">
                    100% Khusus Mahasiswa
                </h3>
                <p class="text-[10px] text-white/80 mt-1">
                    Wajib validasi email SSO Kampus
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="w-11 h-11 shrink-0 rounded-lg bg-[#ffe18c] text-[#650d2b] grid place-items-center text-xl">
                ⚖
            </div>
            <div>
                <h3 class="font-extrabold text-sm text-[#ffe18c]">
                    Bebas Ongkir Antar Kampus
                </h3>
                <p class="text-[10px] text-white/80 mt-1">
                    Janjian COD langsung sesuai kesepakatan
                </p>
            </div>
        </div>

    </div>
</section>


{{-- FILTER DAN PENCARIAN --}}
<form method="GET"
      action="{{ route('katalog.index') }}"
      class="bg-white rounded-2xl border border-[#eeeaf0] shadow-sm p-5 md:p-6 mb-8">

    <div class="flex items-center gap-2 mb-5">
        <span class="text-[#650d2b] text-lg">☷</span>
        <h2 class="font-extrabold text-base text-[#35232b]">
            Filter & Pencarian Terpadu
        </h2>
    </div>

    {{-- Pertahankan pencarian dari navbar --}}
    @if(request('q'))
        <input type="hidden" name="q" value="{{ request('q') }}">
    @endif

    @if(request('kategori'))
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
    @endif

    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

        <div class="md:col-span-8">
            <label class="block text-xs font-bold text-gray-600 mb-2">
                Titik Lokasi COD
            </label>

            <select name="lokasi"
                    class="w-full !bg-[#f5f4ef] !border-transparent !rounded-lg text-sm">

                <option value="">Semua Area Malang–Batu</option>

                @foreach($lokasi as $l)
                    <option value="{{ $l }}"
                        @selected(request('lokasi') === $l)>
                        {{ $l }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="md:col-span-4">
            <label class="block text-xs font-bold text-gray-600 mb-2">
                Rentang Harga (Rp)
            </label>

            <div class="grid grid-cols-2 gap-2">
                <input type="number"
                       min="0"
                       name="min"
                       value="{{ request('min') }}"
                       placeholder="Min"
                       class="w-full !bg-[#f5f4ef] !border-transparent !rounded-lg text-sm">

                <input type="number"
                       min="0"
                       name="maks"
                       value="{{ request('maks') }}"
                       placeholder="Maks"
                       class="w-full !bg-[#f5f4ef] !border-transparent !rounded-lg text-sm">
            </div>
        </div>

    </div>

    <div class="flex flex-wrap justify-end gap-2 mt-5">

        <a href="{{ route('katalog.index') }}"
           class="rounded-lg bg-[#edf2ff] text-[#405b9b] px-5 py-2.5 text-xs font-bold">
            ↺ Hapus Filter
        </a>

        <button type="submit"
                class="rounded-lg bg-[#650d2b] text-white px-6 py-2.5 text-xs font-bold">
            ⌕ Cari Barang
        </button>

    </div>
</form>



{{-- KATEGORI CEPAT --}}
<section class="mb-8">

    <h2 class="text-xs font-extrabold tracking-wide text-[#51414a] uppercase mb-3">
        KATEGORI CEPAT PILIHAN MAHASISWA
    </h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">

        @foreach($kategori as $k)

            @php
                $nama = strtolower($k->nama_kategori);

                $ikon = 'package';

                if (str_contains($nama, 'buku')) {
                    $ikon = 'book';
                } elseif (str_contains($nama, 'kemeja') || str_contains($nama, 'batik') || str_contains($nama, 'fashion')) {
                    $ikon = 'shirt';
                } elseif (str_contains($nama, 'masak') || str_contains($nama, 'dapur')) {
                    $ikon = 'cooking';
                } elseif (str_contains($nama, 'laptop')) {
                    $ikon = 'laptop';
                } elseif (str_contains($nama, 'tablet')) {
                    $ikon = 'tablet';
                } elseif (str_contains($nama, 'tulis')) {
                    $ikon = 'pencil';
                } elseif (str_contains($nama, 'meja') || str_contains($nama, 'kursi')) {
                    $ikon = 'chair';
                } elseif (str_contains($nama, 'headset') || str_contains($nama, 'speaker')) {
                    $ikon = 'headphones';
                } elseif (str_contains($nama, 'lab')) {
                    $ikon = 'flask';
                } elseif (str_contains($nama, 'lemari') || str_contains($nama, 'rak')) {
                    $ikon = 'cabinet';
                } elseif (str_contains($nama, 'kasur') || str_contains($nama, 'bantal')) {
                    $ikon = 'bed';
                } elseif (str_contains($nama, 'olahraga')) {
                    $ikon = 'dumbbell';
                }
            @endphp

            <a href="{{ route('katalog.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $k->id_kategori])) }}"
               class="group bg-white rounded-xl border border-[#eeeaf0] hover:shadow-md transition min-h-[78px] flex flex-col items-center justify-center gap-1.5 p-2">

                <span class="w-10 h-10 rounded-full bg-[#c6dcff] flex items-center justify-center text-[#30283c] group-hover:bg-[#a9caff] transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="21"
                         height="21"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        @switch($ikon)

                            @case('book')
                                <path d="M12 7v14"/>
                                <path d="M3 18V5a2 2 0 0 1 2-2h4a3 3 0 0 1 3 3v15a3 3 0 0 0-3-3H5a2 2 0 0 0-2 0Z"/>
                                <path d="M21 18V5a2 2 0 0 0-2-2h-4a3 3 0 0 0-3 3"/>
                            @break

                            @case('shirt')
                                <path d="m16 4 4 3-2 4-3-2v11H9V9l-3 2-2-4 4-3c1 2 2 3 4 3s3-1 4-3Z"/>
                            @break

                            @case('cooking')
                                <path d="M4 10h16l-1 10H5L4 10Z"/>
                                <path d="M7 10V7a5 5 0 0 1 10 0v3"/>
                                <path d="M2 10h20"/>
                                <path d="M8 4V2M16 4V2"/>
                            @break

                            @case('laptop')
                                <rect x="4" y="4" width="16" height="13" rx="1"/>
                                <path d="M2 20h20l-2-3H4l-2 3Z"/>
                            @break

                            @case('tablet')
                                <rect x="5" y="2" width="14" height="20" rx="2"/>
                                <path d="M11 18h2"/>
                            @break

                            @case('pencil')
                                <path d="m15 5 4 4"/>
                                <path d="M4 20l4-.8L19 8a2.8 2.8 0 0 0-4-4L4 15l-1 5Z"/>
                                <path d="m13 6 5 5"/>
                            @break

                            @case('chair')
                                <path d="M6 4v9h12V4"/>
                                <path d="M4 13h16v3H4z"/>
                                <path d="M6 16v5M18 16v5"/>
                            @break

                            @case('headphones')
                                <path d="M3 13v-2a9 9 0 0 1 18 0v2"/>
                                <rect x="3" y="12" width="4" height="7" rx="2"/>
                                <rect x="17" y="12" width="4" height="7" rx="2"/>
                                <path d="M17 19c0 2-2 3-5 3"/>
                            @break

                            @case('flask')
                                <path d="M9 3h6"/>
                                <path d="M10 3v7L5 19a2 2 0 0 0 2 3h10a2 2 0 0 0 2-3l-5-9V3"/>
                                <path d="M7 16h10"/>
                                <path d="M9 13h6"/>
                            @break

                            @case('cabinet')
                                <rect x="4" y="3" width="16" height="18" rx="1"/>
                                <path d="M12 3v18"/>
                                <path d="M9 11h.01M15 11h.01"/>
                            @break

                            @case('bed')
                                <path d="M3 18V6"/>
                                <path d="M3 14h18v4H3Z"/>
                                <path d="M7 14V9h5v5"/>
                                <path d="M12 14V9h5a4 4 0 0 1 4 4"/>
                                <path d="M3 18v3M21 18v3"/>
                            @break

                            @case('dumbbell')
                                <path d="M6 9v6M3 10v4M18 9v6M21 10v4"/>
                                <path d="M6 12h12"/>
                            @break

                            @default
                                <path d="M3 7h18v13H3z"/>
                                <path d="M3 7l9-4 9 4"/>
                                <path d="M9 12h6"/>
                        @endswitch

                    </svg>

                </span>

                <span class="text-[10px] font-extrabold text-[#30232d] text-center leading-tight">
                    {{ $k->nama_kategori }}
                </span>

            </a>

        @endforeach

    </div>

</section>


{{-- DAFTAR BARANG --}}
<section id="katalog">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('katalog.index', request()->except('tab', 'page')) }}"
               class="rounded-lg px-4 py-2 text-[11px] font-extrabold
               {{ !request('tab') ? 'bg-[#650d2b] text-white' : 'bg-[#eeede7] text-gray-600' }}">
                Semua Barang
            </a>

            <a href="{{ route('katalog.index', array_merge(request()->except('page'), ['tab' => 'terbaru'])) }}"
               class="rounded-lg px-4 py-2 text-[11px] font-extrabold
               {{ request('tab') === 'terbaru' ? 'bg-[#650d2b] text-white' : 'bg-[#eeede7] text-gray-600' }}">
                Terbaru Hari Ini
            </a>

        </div>

        <p class="text-[10px] text-gray-500">
            Menampilkan
            <strong>{{ $katalog->count() }}</strong>
            dari
            <strong>{{ $katalog->total() }}</strong>
            barang preloved terverifikasi di Malang–Batu
        </p>

    </div>


    @if($katalog->isEmpty())

        <div class="bg-white rounded-2xl border p-12 text-center">

            <div class="text-5xl mb-4">🛍️</div>

            <h3 class="font-bold text-[#650d2b]">
                Belum Ada Barang Tersedia
            </h3>

            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                Saat ini belum ada barang yang tersedia.
                Yuk, cek kembali nanti untuk menemukan barang preloved menarik!
            </p>
            <a href="{{ route('katalog.index') }}"
               class="inline-block mt-5 text-sm text-[#650d2b] font-bold">
                Lihat semua barang
            </a>

        </div>

    @else

        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4">

            @foreach($katalog as $k)

                <article class="group bg-white rounded-xl border border-[#eeeaf0] overflow-hidden hover:shadow-lg transition">

                    {{-- FOTO PRODUK --}}
                    <a href="{{ route('katalog.show', $k) }}"
                      class="block relative h-40 md:h-44 bg-[#f1efed] overflow-hidden">

                        @if($k->foto_utama)
                            <img
                                src="{{ $k->foto_utama }}"
                                alt="{{ $k->nama_barang }}"
                                class="w-full h-full object-cover object-center
                                      group-hover:scale-105 transition duration-300"
                                loading="lazy">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center
                                        bg-[#f4f0e9] text-[#8c7d75]">
                                <svg width="42" height="42" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.4">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="m21 15-5-5L5 21"/>
                                </svg>
                                <span class="text-[10px] mt-2">Foto belum tersedia</span>
                            </div>
                        @endif

                        <span class="absolute top-2 left-2 bg-[#d9e8ff]
                                    text-[#263b5b] rounded-full px-2 py-1
                                    text-[9px] font-bold">
                            {{ $k->kategori?->nama_kategori ?? 'Lainnya' }}
                        </span>

                        @if($k->kondisi)
                            <span class="absolute top-2 left-2 translate-y-7
                                        bg-[#fff1bd] text-[#66501b]
                                        rounded-full px-2 py-1 text-[9px] font-bold">
                                {{ $k->kondisi }}
                            </span>
                        @endif

                    </a>
                    {{-- INFORMASI PRODUK --}}
                    <div class="p-3">

                        <p class="text-sm md:text-base font-extrabold text-[#650d2b]">
                            Rp {{ number_format($k->harga, 0, ',', '.') }}
                        </p>

                        <a href="{{ route('katalog.show', $k) }}"
                           class="block text-xs md:text-sm font-extrabold text-[#33252d] mt-1 leading-snug min-h-9 line-clamp-2">
                            {{ $k->nama_barang }}
                        </a>

                        <p class="text-[10px] text-gray-500 mt-2 truncate">
                            ◈ {{ $k->lokasi }}
                        </p>

                        <div class="flex items-center justify-between gap-1 mt-2">

                            <span class="text-[10px] text-gray-600 truncate">
                                {{ $k->penjual?->nama_toko ?? 'Penjual UB Mager' }}
                            </span>

                            <span class="text-[10px] font-bold text-[#b18a32] shrink-0">
                                ★ {{ number_format($k->penjual?->rating_rata_rata ?? 0, 1) }}
                            </span>

                        </div>


                        {{-- TOMBOL AKSI --}}
                        <div class="flex gap-2 mt-3">

                            @auth

                                <form method="POST"
                                      action="{{ route('keranjang.tambah', $k) }}"
                                      class="flex-1 min-w-0">

                                    @csrf

                                    <button type="submit"
                                            class="w-full rounded-lg bg-[#eeede7] text-[#51414a] py-2 text-[10px] font-extrabold">
                                        🛒 Keranjang
                                    </button>

                                </form>

                                <a href="{{ route('chat.show', $k) }}"
                                   class="w-9 shrink-0 rounded-lg bg-[#650d2b] text-white grid place-items-center text-sm"
                                   title="Chat penjual">
                                    ▣
                                </a>

                            @else

                                <a href="{{ route('login') }}"
                                   class="flex-1 text-center rounded-lg bg-[#eeede7] text-[#51414a] py-2 text-[10px] font-extrabold">
                                    🛒 Keranjang
                                </a>

                                <a href="{{ route('login') }}"
                                   class="w-9 shrink-0 rounded-lg bg-[#650d2b] text-white grid place-items-center text-sm">
                                    ▣
                                </a>

                            @endauth

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- PAGINATION --}}
        <div class="mt-8">
            {{ $katalog->links() }}
        </div>

    @endif

</section>

@endsection
