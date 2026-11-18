
@extends('layouts.app')

@section('title', 'Pasar Preloved Mahasiswa Malang–Batu')

@section('content')

<div class="katalog-page w-full max-w-[1054px] mx-auto">

    {{-- HERO --}}
    <section class="hero-section mb-7 rounded-2xl bg-[#f8f5cf] px-6 py-8 md:px-9 md:py-9">

        <div class="max-w-4xl">
            <h1 class="text-[25px] md:text-[28px] font-extrabold leading-tight text-[#650d2b]">
                Pasar Preloved Mahasiswa Malang–Batu
            </h1>

            <p class="mt-2 max-w-2xl text-[13px] leading-relaxed text-[#695d56]">
                Beli & lego barang bekas berkualitas: buku kuliah, perlengkapan kos,
                fashion, hingga elektronik dengan sistem COD aman di area kampus.
            </p>

            {{-- ZONA COD --}}
            <div class="mt-5">
                <span class="text-[10px] font-extrabold tracking-wide text-[#695d56]">
                    ZONA TITIK TEMU:
                </span>

                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach([
                        'Dekat Gerbang Veteran UB',
                        'Jl. Soekarno-Hatta (Suhat)',
                        'Sigura-gura',
                        'Kampus UM',
                        'Area Batu'
                    ] as $zona)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1.5 text-[10px] font-bold leading-none text-[#650d2b] whitespace-nowrap">
                        <svg class="h-3 w-3 shrink-0 block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                            <circle cx="12" cy="10" r="2.5"/>
                        </svg>
                        <span class="leading-none">{{ $zona }}</span>
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- KEUNGGULAN --}}
        <div class="feature-banner mt-7 grid grid-cols-1 gap-5 rounded-xl bg-[#650d2b] px-5 py-5 text-white md:grid-cols-3 md:gap-4 md:px-6">

            {{-- TERVERIFIKASI --}}
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#ffe18c] text-[#3e1425]">
                    <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 11 2 2 4-4"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-[16px] font-extrabold leading-snug text-[#ffe18c]">
                        2.400+ Barang Terverifikasi
                    </h3>
                    <p class="mt-1 text-[12px] leading-snug text-white/80">
                        Disortir oleh tim kurasi
                    </p>
                </div>
            </div>

            {{-- MAHASISWA --}}
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#ffe18c] text-[#3e1425]">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m2 10 10-5 10 5-10 5-10-5Z"/>
                        <path d="M6 12v5c3.5 3 8.5 3 12 0v-5"/>
                        <path d="M22 10v6"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-[16px] font-extrabold leading-snug text-[#ffe18c]">
                        100% Khusus Mahasiswa
                    </h3>
                    <p class="mt-1 text-[12px] leading-snug text-white/80">
                        Wajib validasi email SSO Kampus
                    </p>
                </div>
            </div>

            {{-- PENGANTARAN --}}
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#ffe18c] text-[#3e1425]">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 13h11"/>
                        <path d="M5 13V8h8v5"/>
                        <path d="M13 10h4l4 4v3h-2"/>
                        <circle cx="9" cy="17" r="2"/>
                        <circle cx="17" cy="17" r="2"/>
                        <path d="M17 10V7"/>
                        <path d="m15.5 8.5 1.5-1.5 1.5 1.5"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-[16px] font-extrabold leading-snug text-[#ffe18c]">
                        Bebas Ongkir Antar Kampus
                    </h3>
                    <p class="mt-1 text-[12px] leading-snug text-white/80">
                        Janjian COD langsung sesuai kesepakatan
                    </p>
                </div>
            </div>

        </div>
    </section>


    {{-- FILTER --}}
    <form method="GET"
          action="{{ route('katalog.index') }}"
          class="mb-8 rounded-2xl border border-[#eeeaf0] bg-white p-5 shadow-sm md:p-6">

        <div class="mb-5 flex items-center gap-2">
            <svg class="h-[17px] w-[17px] text-[#650d2b]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M4 6h16M4 12h16M4 18h16"/>
                <path d="M8 3v6M16 9v6M10 15v6"/>
            </svg>

            <h2 class="text-[15px] font-extrabold text-[#35232b]">
                Filter & Pencarian Terpadu
            </h2>
        </div>

        @if(request('q'))
            <input type="hidden" name="q" value="{{ request('q') }}">
        @endif

        @if(request('kategori'))
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        @endif

        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

            {{-- LOKASI --}}
            <div class="min-w-0 md:col-span-8">
                <label class="mb-2 block text-[12px] font-bold text-gray-600">
                    Titik Lokasi COD
                </label>

                <div class="relative w-full">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#81717a]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                            <path d="M16 3v4M8 3v4M3 10h18"/>
                            <path d="M8 14h.01M12 14h.01M16 14h.01M8 17h.01M12 17h.01"/>
                        </svg>
                    </span>

                    <select name="lokasi"
                            class="lokasi-select w-full cursor-pointer appearance-none rounded-xl border-0 bg-[#f5f4ef] text-[13px] text-[#35232b]">
                        <option value="">Semua Area Malang–Batu</option>

                        @foreach($lokasi as $l)
                            <option value="{{ $l }}" @selected(request('lokasi') === $l)>
                                {{ $l }}
                            </option>
                        @endforeach
                    </select>

                    <span class="pointer-events-none absolute right-[18px] top-1/2 -translate-y-1/2 text-[#35232b]">
                        <svg class="h-[17px] w-[17px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </div>
            </div>

            {{-- HARGA --}}
            <div class="min-w-0 md:col-span-4">
                <label class="mb-2 block text-[12px] font-bold text-gray-600">
                    Rentang Harga (Rp)
                </label>

                <div class="grid grid-cols-2 gap-2">
                    <input type="number"
                           min="0"
                           name="min"
                           value="{{ request('min') }}"
                           placeholder="Min"
                           class="harga-input w-full rounded-xl border-0 bg-[#f5f4ef] text-[13px]">

                    <input type="number"
                           min="0"
                           name="maks"
                           value="{{ request('maks') }}"
                           placeholder="Maks"
                           class="harga-input w-full rounded-xl border-0 bg-[#f5f4ef] text-[13px]">
                </div>
            </div>
        </div>

        {{-- TOMBOL --}}
        <div class="mt-5 flex flex-wrap justify-end gap-2">
            <a href="{{ route('katalog.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#edf2ff] px-5 py-2.5 text-[11px] font-bold text-[#405b9b] transition hover:bg-[#dfe8ff]">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
                Hapus Filter
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#650d2b] px-6 py-2.5 text-[11px] font-bold text-white transition hover:bg-[#801d43]">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-4-4"/>
                </svg>
                Cari Barang
            </button>
        </div>
    </form>


{{-- KATEGORI --}}
<section class="mb-8" id="kategori-cepat">
    <h2 class="mb-3 text-[12px] font-extrabold tracking-wide text-[#51414a]">
        KATEGORI CEPAT PILIHAN MAHASISWA
    </h2>

    @php
        $kategoriSlides = $kategori->chunk(12);
    @endphp

    <div class="relative">

        {{-- SLIDE KATEGORI --}}
        <div id="kategori-track" class="overflow-hidden">
            @foreach($kategoriSlides as $slideIndex => $slide)
                <div
                    class="kategori-slide grid grid-cols-2 gap-2.5 sm:grid-cols-3 md:grid-cols-6"
                    data-slide="{{ $slideIndex }}"
                    style="{{ $slideIndex === 0 ? '' : 'display:none;' }}"
                >
                    @foreach($slide as $k)
                        @php
                            $nama = strtolower($k->nama_kategori);
                            $ikon = 'package';

                            if (str_contains($nama, 'buku')) {
                                $ikon = 'book';
                            } elseif (
                                str_contains($nama, 'kemeja') ||
                                str_contains($nama, 'batik') ||
                                str_contains($nama, 'fashion')
                            ) {
                                $ikon = 'shirt';
                            } elseif (
                                str_contains($nama, 'masak') ||
                                str_contains($nama, 'dapur')
                            ) {
                                $ikon = 'cooking';
                            } elseif (str_contains($nama, 'laptop')) {
                                $ikon = 'laptop';
                            } elseif (str_contains($nama, 'tablet')) {
                                $ikon = 'tablet';
                            } elseif (
                                str_contains($nama, 'tulis') ||
                                str_contains($nama, 'pensil')
                            ) {
                                $ikon = 'pencil';
                            } elseif (
                                str_contains($nama, 'meja') ||
                                str_contains($nama, 'kursi')
                            ) {
                                $ikon = 'chair';
                            } elseif (
                                str_contains($nama, 'headset') ||
                                str_contains($nama, 'speaker')
                            ) {
                                $ikon = 'headphones';
                            } elseif (str_contains($nama, 'lab')) {
                                $ikon = 'flask';
                            } elseif (
                                str_contains($nama, 'lemari') ||
                                str_contains($nama, 'rak')
                            ) {
                                $ikon = 'cabinet';
                            } elseif (
                                str_contains($nama, 'kasur') ||
                                str_contains($nama, 'bantal')
                            ) {
                                $ikon = 'bed';
                            } elseif (str_contains($nama, 'olahraga')) {
                                $ikon = 'dumbbell';
                            } elseif (str_contains($nama, 'hp')) {
                                $ikon = 'phone';
                            } elseif (str_contains($nama, 'motor')) {
                                $ikon = 'motorcycle';
                            } elseif (
                                str_contains($nama, 'kamera') ||
                                str_contains($nama, 'tripod')
                            ) {
                                $ikon = 'camera';
                            } elseif (
                                str_contains($nama, 'sepatu') ||
                                str_contains($nama, 'sandal')
                            ) {
                                $ikon = 'shoe';
                            } elseif (
                                str_contains($nama, 'makeup') ||
                                str_contains($nama, 'skincare')
                            ) {
                                $ikon = 'beauty';
                            } elseif (str_contains($nama, 'kesehatan')) {
                                $ikon = 'health';
                            } elseif (str_contains($nama, 'musik')) {
                                $ikon = 'music';
                            } elseif (str_contains($nama, 'aksesori')) {
                                $ikon = 'accessories';
                            } elseif (str_contains($nama, 'dekorasi')) {
                                $ikon = 'decor';
                            } elseif (
                                str_contains($nama, 'tas') ||
                                str_contains($nama, 'ransel')
                            ) {
                                $ikon = 'bag';
                            } elseif (
                                str_contains($nama, 'game') ||
                                str_contains($nama, 'konsol')
                            ) {
                                $ikon = 'game';
                            } elseif (
                                str_contains($nama, 'makanan') ||
                                str_contains($nama, 'minuman')
                            ) {
                                $ikon = 'food';
                            }
                        @endphp

                        <a
                            href="{{ route('katalog.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $k->id_kategori])) }}"
                            class="category-card group flex h-[88px] min-w-0 flex-col items-center justify-center gap-1.5 rounded-xl border border-[#eeeaf0] bg-white p-2 transition hover:-translate-y-0.5 hover:shadow-md"
                        >
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#c6dcff] text-[#30283c] transition group-hover:bg-[#a9caff]">
                                <svg
                                    class="h-[21px] w-[21px]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    @switch($ikon)
                                        @case('book')
                                            <path d="M12 7v14"/>
                                            <path d="M3 18V5a2 2 0 0 1 2-2h4a3 3 0 0 1 3 3v15a3 3 0 0 0-3-3H5a2 2 0 0 0-2 0Z"/>
                                            <path d="M21 18V5a2 2 0 0 0-2-2h-4a3 3 0 0 0-3 3v15a3 3 0 0 1 3-3h4a2 2 0 0 1 2 0Z"/>
                                        @break

                                        @case('shirt')
                                            <path d="M8 4 10.5 6h3L16 4l5 3-2.5 5-3-1.5V20h-9v-9.5L3.5 12 1 7l7-3Z"/>
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

                                        @case('phone')
                                            <rect x="7" y="2" width="10" height="20" rx="2"/>
                                            <path d="M11 18h2"/>
                                        @break

                                        @case('motorcycle')
                                            <circle cx="6" cy="17" r="3"/>
                                            <circle cx="18" cy="17" r="3"/>
                                            <path d="m6 17 4-7h4l4 7M10 10l-3-2M14 10h3"/>
                                        @break

                                        @case('camera')
                                            <rect x="3" y="7" width="18" height="13" rx="2"/>
                                            <path d="m8 7 2-3h4l2 3"/>
                                            <circle cx="12" cy="13.5" r="3"/>
                                        @break

                                        @case('shoe')
                                            <path d="M3 15c3 0 5-2 7-5l3 3 6 2c2 1 3 2 2 4H4a2 2 0 0 1-1-4Z"/>
                                        @break

                                        @case('beauty')
                                            <path d="M9 3h6l1 5H8l1-5Z"/>
                                            <path d="M8 8h8v13H8z"/>
                                            <path d="M10 12h4"/>
                                        @break

                                        @case('health')
                                            <rect x="4" y="5" width="16" height="16" rx="2"/>
                                            <path d="M12 9v8M8 13h8"/>
                                            <path d="M9 5V3h6v2"/>
                                        @break

                                        @case('music')
                                            <path d="M9 18V5l12-2v13"/>
                                            <circle cx="6" cy="18" r="3"/>
                                            <circle cx="18" cy="16" r="3"/>
                                        @break

                                        @case('accessories')
                                            <circle cx="8" cy="8" r="2"/>
                                            <circle cx="16" cy="16" r="2"/>
                                            <path d="m10 10 4 4M16 4v4M8 16v4"/>
                                        @break

                                        @case('decor')
                                            <path d="M5 10h14l-1 11H6L5 10Z"/>
                                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                            <path d="M9 4 7 2M15 4l2-2"/>
                                        @break

                                        @case('bag')
                                            <path d="M4 8h16l1 13H3L4 8Z"/>
                                            <path d="M9 8V6a3 3 0 0 1 6 0v2"/>
                                        @break

                                        @case('game')
                                            <path d="M6 9h12a4 4 0 0 1 3.8 5l-1 4a2 2 0 0 1-3.3 1l-3-2h-5l-3 2a2 2 0 0 1-3.3-1l-1-4A4 4 0 0 1 6 9Z"/>
                                            <path d="M8 12v4M6 14h4M16 13h.01M18 15h.01"/>
                                        @break

                                        @case('food')
                                            <path d="M4 3v8M7 3v8M4 7h3M5.5 11v10"/>
                                            <path d="M15 3v18M15 3c4 2 5 6 0 9"/>
                                        @break

                                        @default
                                            <path d="M3 7h18v13H3z"/>
                                            <path d="M3 7l9-4 9 4"/>
                                            <path d="M9 12h6"/>
                                    @endswitch
                                </svg>
                            </span>

                            <span class="line-clamp-2 text-center text-[10px] font-extrabold leading-tight text-[#30232d]">
                                {{ $k->nama_kategori }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- TOMBOL NAVIGASI --}}
        @if($kategoriSlides->count() > 1)
            <button
                type="button"
                id="kategori-prev"
                aria-label="Kategori sebelumnya"
                class="absolute -left-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-[#781d40] text-xl text-white shadow-lg transition hover:bg-[#5e1531]"
            >
                ‹
            </button>

            <button
                type="button"
                id="kategori-next"
                aria-label="Kategori berikutnya"
                class="absolute -right-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-[#781d40] text-xl text-white shadow-lg transition hover:bg-[#5e1531]"
            >
                ›
            </button>
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.kategori-slide');
    const prev = document.getElementById('kategori-prev');
    const next = document.getElementById('kategori-next');

    if (!slides.length || !prev || !next) return;

    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'grid' : 'none';
        });

        prev.style.opacity = index === 0 ? '0.45' : '1';
        prev.disabled = index === 0;

        next.style.opacity = index === slides.length - 1 ? '0.45' : '1';
        next.disabled = index === slides.length - 1;
    }

    prev.addEventListener('click', function () {
        if (currentSlide > 0) {
            currentSlide--;
            showSlide(currentSlide);
        }
    });

    next.addEventListener('click', function () {
        if (currentSlide < slides.length - 1) {
            currentSlide++;
            showSlide(currentSlide);
        }
    });

    showSlide(currentSlide);
});
</script>

    {{-- DAFTAR BARANG --}}
    <section id="katalog">

        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('katalog.index', request()->except('tab', 'page')) }}"
                   class="rounded-lg px-4 py-2 text-[11px] font-extrabold {{ !request('tab') ? 'bg-[#650d2b] text-white' : 'bg-[#eeede7] text-gray-600' }}">
                    Semua Barang
                </a>

                <a href="{{ route('katalog.index', array_merge(request()->except('page'), ['tab' => 'terbaru'])) }}"
                   class="rounded-lg px-4 py-2 text-[11px] font-extrabold {{ request('tab') === 'terbaru' ? 'bg-[#650d2b] text-white' : 'bg-[#eeede7] text-gray-600' }}">
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

            {{-- KATALOG KOSONG --}}
            <div class="rounded-2xl border border-[#eeeaf0] bg-white p-8 text-center md:p-12">

                <div class="mb-5 flex justify-center">
                    <svg class="h-[65px] w-[65px]" viewBox="0 0 64 64" fill="none" stroke="#801d43" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 23h40l-4 32H16l-4-32Z"/>
                        <path d="M23 25v-7a9 9 0 0 1 18 0v7"/>
                        <path d="M24 34v8"/>
                        <path d="M40 34v8"/>
                    </svg>
                </div>

                <h3 class="text-base font-bold text-[#650d2b]">
                    Belum Ada Barang Tersedia
                </h3>

                <p class="mx-auto mt-1 max-w-md text-[13px] text-gray-500">
                    Saat ini belum ada barang yang tersedia. Yuk, cek kembali nanti
                    untuk menemukan barang preloved menarik!
                </p>

                <a href="{{ route('katalog.index') }}"
                   class="mt-5 inline-block text-[13px] font-bold text-[#650d2b]">
                    Lihat semua barang
                </a>
            </div>

        @else

            {{-- GRID PRODUK --}}
            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 xl:grid-cols-4 md:gap-4">

                @foreach($katalog as $k)

                    <article class="group overflow-hidden rounded-xl border border-[#eeeaf0] bg-white transition hover:shadow-lg">

                        {{-- FOTO --}}
                        <a href="{{ route('katalog.show', $k) }}"
                           class="relative block h-40 overflow-hidden bg-[#f1efed] md:h-44">

                            @if($k->foto_utama)
                                <img src="{{ $k->foto_utama }}"
                                     alt="{{ $k->nama_barang }}"
                                     class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-105"
                                     loading="lazy">
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center bg-[#f4f0e9] text-[#8c7d75]">
                                    <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="m21 15-5-5L5 21"/>
                                    </svg>
                                    <span class="mt-2 text-[10px]">
                                        Foto belum tersedia
                                    </span>
                                </div>
                            @endif

                            <span class="absolute left-2 top-2 rounded-full bg-[#d9e8ff] px-2 py-1 text-[9px] font-bold text-[#263b5b]">
                                {{ $k->kategori?->nama_kategori ?? 'Lainnya' }}
                            </span>

                            @if($k->kondisi)
                                <span class="absolute left-2 top-9 rounded-full bg-[#fff1bd] px-2 py-1 text-[9px] font-bold text-[#66501b]">
                                    {{ $k->kondisi }}
                                </span>
                            @endif
                        </a>

                        {{-- INFORMASI --}}
                        <div class="p-3">

                            <p class="text-[13px] font-extrabold text-[#650d2b]">
                                Rp {{ number_format($k->harga, 0, ',', '.') }}
                            </p>

                            <a href="{{ route('katalog.show', $k) }}"
                               class="mt-1 block min-h-9 text-[12px] font-extrabold leading-snug text-[#33252d]">
                                {{ $k->nama_barang }}
                            </a>

                            <p class="mt-2 flex items-center gap-1 truncate text-[10px] text-gray-500">
                                <svg class="h-3.5 w-3.5 shrink-0 text-[#92711c]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="2.5"/>
                                </svg>
                                {{ $k->lokasi }}
                            </p>

                            <div class="mt-2 flex items-center justify-between gap-1">
                                <span class="truncate text-[10px] text-gray-600">
                                    {{ $k->penjual?->nama_toko ?? 'Penjual UB Mager' }}
                                </span>

                                <span class="shrink-0 text-[10px] font-bold text-[#b18a32]">
                                    ★ {{ number_format($k->penjual?->rating_rata_rata ?? 0, 1) }}
                                </span>
                            </div>

                            {{-- AKSI --}}
                            <div class="mt-3 flex gap-2">

                                @auth

                                    <form method="POST"
                                          action="{{ route('keranjang.tambah', $k) }}"
                                          class="min-w-0 flex-1">
                                        @csrf

                                        <button type="submit"
                                                class="flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#eeede7] py-2 text-[10px] font-extrabold text-[#51414a] transition hover:bg-[#e3e0d8]">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                                                <circle cx="10" cy="20" r="1"/>
                                                <circle cx="18" cy="20" r="1"/>
                                            </svg>
                                            Keranjang
                                        </button>
                                    </form>

                                    <a href="{{ route('chat.show', $k) }}"
                                       class="flex h-[34px] w-9 shrink-0 items-center justify-center rounded-lg bg-[#650d2b] text-white transition hover:bg-[#801d43]"
                                       title="Chat penjual">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                                        </svg>
                                    </a>

                                @else

                                    <a href="{{ route('login') }}"
                                       class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-[#eeede7] py-2 text-[10px] font-extrabold text-[#51414a]">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                            <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                                            <circle cx="10" cy="20" r="1"/>
                                            <circle cx="18" cy="20" r="1"/>
                                        </svg>
                                        Keranjang
                                    </a>

                                    <a href="{{ route('login') }}"
                                       class="flex h-[34px] w-9 shrink-0 items-center justify-center rounded-lg bg-[#650d2b] text-white"
                                       title="Login untuk chat">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                                        </svg>
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
</div>


{{-- STYLE KHUSUS KATALOG --}}
<style>
    .katalog-page {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        color: #35232b;
    }

    .katalog-page,
    .katalog-page * {
        box-sizing: border-box;
    }

    .katalog-page .lokasi-select,
    .katalog-page .harga-input {
        width: 100%;
        height: 42px !important;
        min-height: 42px !important;
        max-height: 42px;
        border-radius: 12px !important;
        background-color: #f5f4ef !important;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px !important;
        line-height: 1.4;
        box-shadow: none !important;
    }

    .katalog-page .lokasi-select {
        appearance: none;
        -webkit-appearance: none;
        padding: 0 48px 0 42px !important;
        border: 0 !important;
    }

    .katalog-page .harga-input {
        padding: 0 16px !important;
        border: 0 !important;
    }

    .katalog-page .harga-input::placeholder {
        color: #99939a;
        opacity: 1;
    }

    .katalog-page .lokasi-select:focus,
    .katalog-page .harga-input:focus {
        outline: 2px solid rgba(101, 13, 43, .15);
        outline-offset: 1px;
    }

    .katalog-page .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .katalog-page .category-card {
        min-width: 0;
    }

    .katalog-page .feature-banner > div {
        min-width: 0;
    }

    @media (min-width: 768px) {
        .katalog-page .feature-banner {
            min-height: 88px;
        }
    }

    @media (max-width: 767px) {
        .katalog-page h1 {
            font-size: 22px !important;
        }

        .katalog-page .hero-section {
            padding: 24px 20px;
        }

        .katalog-page .feature-banner {
            gap: 16px;
        }

        .katalog-page .feature-banner h3 {
            font-size: 14px;
        }

        .katalog-page .category-card {
            height: 88px;
        }
    }
</style>

@endsection
