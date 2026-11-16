@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')

@php
    $user = auth()->user();

    $titikCod = [
        'Gazebo FIA & Filkom UB',
        'Gerbang Veteran UB Coffee',
        'Bundaran Pascasarjana UMM',
        'Kopitiam Jalan Suhat & Borobudur',
        'Kawasan Payung & Alun-Alun Batu',
        'Edutech FILKOM UB (Depan Gedung F)',
    ];
@endphp

<div class="account-page min-h-screen w-full bg-[#faf9f4] text-[#35101f]">
    <div class="w-full mx-auto px-3 md:px-4 py-7 md:py-8">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-[12px] md:text-[13px] mb-6">
            <a href="{{ route('profil.edit') }}"
               class="inline-flex items-center gap-1.5 text-[#796e70] hover:text-[#781d40] transition">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v11h14V9"/>
                    <path d="M9 20v-6h6v6"/>
                </svg>
                Akun Saya
            </a>
            <span class="text-[#c8c1bb]">/</span>
            <span class="font-bold text-[#781d40]">Pesanan Saya</span>
        </div>

        {{-- HEADER PROFIL --}}
        <section class="account-header bg-white rounded-xl border border-[#eeeae5] p-5 mb-4 shadow-[0_1px_3px_rgba(40,20,20,0.04)]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-[72px] h-[72px] shrink-0 rounded-full bg-[#e9e8e3] overflow-hidden">
                        @if($user->foto)
                            <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto profil" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#a39a94]">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path d="M5 21c0-3.8 3.1-6.5 7-6.5s7 2.7 7 6.5"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <h1 class="text-2xl font-extrabold text-[#35101f] leading-tight">{{ $user->nama }}</h1>
                        <p class="text-[12px] md:text-[13px] text-[#796e70] mt-1">
                            {{ $user->fakultas ?: 'Identitas kampus belum dilengkapi' }}
                            @if($user->program_studi ?? false)
                                <span class="mx-1">•</span>{{ $user->program_studi }}
                            @endif
                            <span class="mx-1">•</span>Angkatan {{ $user->angkatan ?: '—' }}
                        </p>

                        <span class="inline-flex items-center gap-1.5 mt-2.5 rounded-full bg-[#781d40] text-white px-3 py-1 text-[10px] md:text-[11px] font-bold">
                            {{ $user->status_verifikasi === 'terverifikasi' ? 'Mahasiswa Terverifikasi UB' : 'Menunggu Verifikasi' }}
                        </span>
                    </div>
                </div>

                <div class="account-header-actions flex flex-col gap-2 w-full md:w-[164px] shrink-0">
                    <a href="{{ route('pengajuan.form') }}" class="min-h-[37px] inline-flex items-center justify-center gap-2 rounded-lg bg-[#781d40] text-white px-3 py-2 text-[11px] md:text-xs font-bold hover:bg-[#5e1531] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10h18"/>
                            <path d="M5 10V20h14V10"/>
                            <path d="M3 10 5 4h14l2 6"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                        <span>Daftar sebagai Penjual</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full min-h-[37px] inline-flex items-center justify-center gap-2 rounded-lg border border-[#e8e4df] bg-white px-3 py-2 text-[11px] md:text-xs font-semibold text-[#62595b] hover:bg-[#f8f7f3] transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 17l5-5-5-5"/>
                                <path d="M15 12H3"/>
                                <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </section>

        {{-- TAB NAVIGASI AKUN --}}
        <nav class="grid grid-cols-3 gap-2 rounded-xl bg-[#eeece4] p-2 mb-5" aria-label="Navigasi akun">

            {{-- PROFIL SAYA --}}
            <a
                href="{{ route('profil.edit') }}"
                aria-current="page"
                class="flex min-h-[52px] items-center justify-center gap-2 rounded-lg bg-[#781d40] px-2 py-3 text-center text-xs md:text-sm font-bold text-white shadow-sm transition"
            >
                <span>Profil Saya</span>
            </a>

            {{-- PESANAN SAYA --}}
            <a
                href="{{ route('pesanan.saya') }}"
                class="flex min-h-[52px] items-center justify-center gap-2 rounded-lg px-2 py-3 text-center text-xs md:text-sm font-bold text-[#51494a] transition hover:bg-white/70 hover:text-[#781d40]"
            >
                <span>Pesanan Saya</span>
            </a>

            {{-- PENGATURAN AKUN --}}
            <a
                href="{{ route('pengaturan.index') }}"
                class="flex min-h-[52px] items-center justify-center gap-2 rounded-lg px-2 py-3 text-center text-xs md:text-sm font-bold text-[#51494a] transition hover:bg-white/70 hover:text-[#781d40]"
            >
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        {{-- KOLOM KIRI DAN KANAN --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1.35fr_0.95fr] gap-5 items-start">

            {{-- FORM PROFIL --}}
            <section class="bg-white rounded-xl border border-[#eeeae5] p-5 md:p-7 shadow-sm">

                <form
                    method="POST"
                    action="{{ route('profil.update') }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="flex items-center justify-between border-b border-[#eeeae5] pb-4 mb-5">
                        <div>
                            <h2 class="font-extrabold text-[#35101f]">
                                Data Pribadi & Verifikasi Kampus
                            </h2>
                            <p class="text-xs text-[#796e70] mt-1">
                                Informasi digunakan untuk transparansi saat COD antar mahasiswa.
                            </p>
                        </div>
                    </div>

                    @if(session('ok'))
                        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                            {{ session('ok') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            <p class="font-bold mb-1">Periksa kembali data berikut:</p>
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">

                        {{-- NAMA --}}
                        <div>
                            <div class="flex justify-between gap-2 mb-1">
                                <label class="text-sm font-bold">Nama Lengkap <span class="text-red-600">*</span></label>
                                <span class="text-[10px] text-[#796e70]">Sesuai KTP / KTM</span>
                            </div>
                            <input
                                type="text"
                                name="nama"
                                required
                                value="{{ old('nama', $user->nama) }}"
                                class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                            >
                        </div>

                        {{-- IDENTITAS KAMPUS --}}
                        <div>
                            <label class="block text-sm font-bold mb-1">
                                Identitas Kampus <span class="text-red-600">*</span>
                            </label>
                            <input
                                type="text"
                                name="fakultas"
                                required
                                value="{{ old('fakultas', $user->fakultas) }}"
                                placeholder="Contoh: Fakultas Ilmu Komputer UB"
                                class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                            >
                        </div>

                        {{-- EMAIL DAN WHATSAPP --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-bold mb-1">
                                    Email Mahasiswa <span class="text-red-600">*</span>
                                </label>
                                <input
                                    type="email"
                                    value="{{ $user->email }}"
                                    readonly
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm text-[#62595b]"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-1">
                                    No. WhatsApp Aktif <span class="text-red-600">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="no_hp"
                                    required
                                    value="{{ old('no_hp', $user->no_hp) }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                                >
                            </div>
                        </div>

                        {{-- NIM DAN PROGRAM STUDI --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-bold mb-1">NIM (opsional)</label>
                                <input
                                    type="text"
                                    name="nim"
                                    value="{{ old('nim', $user->nim) }}"
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-1">Program Studi</label>
                                <input
                                    type="text"
                                    name="program_studi"
                                    value="{{ old('program_studi', $user->program_studi) }}"
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                                >
                            </div>
                        </div>

                        {{-- ANGKATAN --}}
                        <div>
                            <label class="block text-sm font-bold mb-1">Tahun Angkatan</label>
                            <input
                                type="text"
                                name="angkatan"
                                inputmode="numeric"
                                maxlength="4"
                                value="{{ old('angkatan', $user->angkatan) }}"
                                placeholder="2025"
                                class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                            >
                        </div>

                        {{-- ALAMAT --}}
                        <div>
                            <div class="flex justify-between gap-2 mb-1">
                                <label class="text-sm font-bold">
                                    Alamat Kos / Domisili Malang <span class="text-red-600">*</span>
                                </label>
                                <span class="text-[10px] text-[#796e70]">Untuk perkiraan jarak barter</span>
                            </div>
                            <textarea
                                name="alamat"
                                rows="3"
                                required
                                class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                            >{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        {{-- TITIK COD --}}
                        <div>
                            <div class="flex justify-between gap-2 mb-1">
                                <label class="text-sm font-bold">
                                    Titik Temu COD Favorit <span class="text-red-600">*</span>
                                </label>
                                <span class="text-[10px] text-[#94721d]">Zona Publik Aman</span>
                            </div>
                                    <div class="relative">
                                        <select
                                            name="titik_cod_favorit"
                                            required
                                            class="w-full appearance-none rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 pr-12 text-sm focus:ring-2 focus:ring-[#781d40]"
                                        >
                                            <option value="">Pilih titik temu publik</option>

                                            @foreach($titikCod as $point)
                                                <option
                                                    value="{{ $point }}"
                                                    @selected(old('titik_cod_favorit', $user->titik_cod_favorit) === $point)
                                                >
                                                    {{ $point }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- Ikon panah dropdown --}}
                                        <svg
                                            class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#35101f]"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="m6 9 6 6 6-6"/>
                                        </svg>
                                    </div>
                        </div>

                        {{-- FOTO PROFIL --}}
                        <div>
                            <label class="block text-sm font-bold mb-2">Foto Profil</label>
                            <div class="flex flex-wrap items-center gap-3">
                                <label class="inline-flex items-center gap-2 rounded-lg bg-[#c5dafa] text-[#35101f] px-4 py-2.5 text-xs font-bold cursor-pointer hover:bg-[#b3cdef] transition">
                                    Unggah Foto
                                    <input
                                        type="file"
                                        name="foto"
                                        accept="image/jpeg,image/png"
                                        class="hidden"
                                        onchange="document.getElementById('nama-file-foto').textContent = this.files[0]?.name || ''"
                                    >
                                </label>
                                <span class="text-xs text-[#796e70]">Format JPG/PNG, maks 2MB</span>
                                <span id="nama-file-foto" class="text-xs text-[#781d40]"></span>
                            </div>
                        </div>

                        {{-- KEAMANAN AKUN --}}
                        <div class="border-t border-[#eeeae5] pt-5 mt-5">
                            <h3 class="font-extrabold text-[#35101f]">Keamanan Akun</h3>
                            <p class="text-xs text-[#796e70] mt-1">
                                Kosongkan jika tidak ingin mengubah password.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-bold mb-1">Password Baru</label>
                                <input
                                    type="password"
                                    name="password"
                                    autocomplete="new-password"
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-1">Konfirmasi Password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    class="w-full rounded-lg border-0 bg-[#f4f3ee] px-3 py-3 text-sm focus:ring-2 focus:ring-[#781d40]"
                                >
                            </div>
                        </div>

                        {{-- TOMBOL SIMPAN --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-[#eeeae5] pt-5">
                            <p class="text-xs text-[#796e70]">
                                Data Anda dilindungi protokol internal kampus
                            </p>

                            <div class="flex gap-2">
                                <a
                                    href="{{ route('profil.edit') }}"
                                    class="rounded-lg bg-[#eeede7] px-5 py-3 text-sm font-bold hover:bg-[#e4e2da] transition"
                                >
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-[#781d40] text-white px-6 py-3 text-sm font-bold shadow hover:bg-[#5e1531] transition"
                                >
                                    Simpan Profil
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </section>

            {{-- PANEL KANAN --}}
            <aside class="space-y-5">

                {{-- VALIDASI AKADEMIK --}}
                <section class="bg-white rounded-xl border border-[#eeeae5] p-5 shadow-sm">
                    <h3 class="flex items-center gap-2 text-sm font-extrabold text-[#35101f] border-b border-[#eeeae5] pb-3">
                        VALIDASI AKADEMIK & KEAMANAN UB
                    </h3>

                    <div class="space-y-2 mt-3 text-xs">
                        <div class="flex justify-between items-center gap-3 rounded-lg bg-[#f4f3ee] p-3">
                            <span class="text-[#827a76]">Fakultas / Prodi</span>
                            <strong class="text-right">{{ $user->fakultas ?: 'Belum diisi' }}{{ $user->program_studi ? ' / '.$user->program_studi : '' }}</strong>
                        </div>

                        <div class="flex justify-between items-center gap-3 rounded-lg bg-[#f4f3ee] p-3">
                            <span class="text-[#827a76]">Tahun Angkatan</span>
                            <strong>{{ $user->angkatan ?: 'Belum diisi' }}</strong>
                        </div>

                        <div class="flex justify-between items-center gap-3 rounded-lg bg-[#f4f3ee] p-3">
                            <span class="text-[#827a76]">Status Mahasiswa</span>
                            <span class="rounded-full bg-green-100 text-green-700 px-2 py-1 font-bold">
                                ● {{ $user->status_verifikasi === 'terverifikasi' ? 'Terverifikasi' : 'Belum terverifikasi' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center gap-3 rounded-lg bg-[#f4f3ee] p-3">
                            <span class="text-[#827a76]">Skor Reputasi</span>
                            <strong class="text-[#781d40]">Belum tersedia</strong>
                        </div>
                    </div>
                </section>

                {{-- KARTU COD --}}
                <div class="grid grid-cols-2 gap-3">
                    <section class="bg-white rounded-xl border border-[#eeeae5] p-4 shadow-sm">
                        <p class="text-[10px] font-extrabold text-[#796e70]">RADIUS COD AKTIF</p>
                        <p class="text-xl font-extrabold text-[#35101f] mt-1">—</p>
                        <p class="text-[10px] text-[#796e70] mt-1">Menunggu data lokasi</p>
                    </section>

                    <section class="bg-white rounded-xl border border-[#eeeae5] p-4 shadow-sm">
                        <p class="text-[10px] font-extrabold text-[#796e70]">HEMAT SEMESTER INI</p>
                        <p class="text-xl font-extrabold text-[#781d40] mt-1">—</p>
                        <p class="text-[10px] text-[#796e70] mt-1">Data transaksi belum tersedia</p>
                    </section>
                </div>

                {{-- PETA TITIK COD --}}
                <section class="bg-white rounded-xl border border-[#eeeae5] p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <h3 class="font-extrabold text-sm text-[#35101f]">
                            Peta Titik COD Favorit Terpilih
                        </h3>
                        <span class="rounded-full bg-[#f7f2d9] text-[#806719] px-2 py-1 text-[10px] font-bold whitespace-nowrap">
                            Malang Kota
                        </span>
                    </div>

                    <p class="text-xs text-[#796e70] mb-3">
                        Lokasi:
                        <strong class="text-[#51494a]">
                            {{ $user->titik_cod_favorit ?: 'Belum memilih titik COD' }}
                        </strong>
                    </p>

                    <div class="relative h-48 rounded-xl overflow-hidden border border-[#e5e2d8] bg-[#e4e9df]">
                        {{-- Ilustrasi peta sederhana sebagai placeholder --}}
                        <div class="absolute inset-0 opacity-70"
                             style="background-image: linear-gradient(35deg, transparent 45%, #ffffff 46%, #ffffff 49%, transparent 50%), linear-gradient(120deg, transparent 40%, #ffffff 41%, #ffffff 44%, transparent 45%), linear-gradient(90deg, transparent 65%, #c4d8bd 66%, #c4d8bd 85%, transparent 86%); background-size: 110px 90px, 130px 100px, 100% 100%;">
                        </div>

                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-full shadow-md px-4 py-2 text-xs font-extrabold text-[#781d40] whitespace-nowrap">
                            ♧ {{ $user->titik_cod_favorit ?: 'Titik COD belum dipilih' }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-2 mt-3 text-xs">
                        <span class="text-[#796e70]">Lokasi titik temu pilihan Anda</span>
                        <span class="font-bold text-[#781d40]">Titik Favorit</span>
                    </div>
                </section>

            </aside>
        </div>
    </div>


@endsection