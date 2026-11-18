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

@if($user->role === 'admin')

    {{-- HALAMAN KHUSUS ADMIN --}}
    <div class="min-h-screen bg-[#faf9f4] px-4 py-10">
        <div class="mx-auto max-w-4xl">

            <div class="mb-6">
                <p class="text-xs text-[#796e70]">
                    Akun Saya / Administrator
                </p>

                <h1 class="mt-2 text-2xl font-extrabold text-[#35101f]">
                    Pengaturan Akun Administrator
                </h1>

                <p class="mt-1 text-sm text-[#796e70]">
                    Kelola informasi dan keamanan akun administrator UB Mager.
                </p>
            </div>

            <div class="rounded-xl border border-[#eeeae5] bg-white p-6 shadow-sm">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#781d40] text-white">
                            <svg class="h-8 w-8"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M5 21c0-4 3-7 7-7s7 3 7 7"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-[#35101f]">
                                {{ $user->nama }}
                            </h2>

                            <p class="mt-1 text-sm text-[#796e70]">
                                Administrator UB Mager
                            </p>

                            <span class="mt-2 inline-flex rounded-full bg-[#f5e8ee] px-3 py-1 text-xs font-bold text-[#781d40]">
                                Administrator
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                                class="rounded-lg border border-[#e8e4df] px-5 py-3 text-sm font-bold text-[#62595b] transition hover:bg-[#f8f7f3]">
                            Logout
                        </button>
                    </form>

                </div>

                <div class="mt-6 border-t border-[#eeeae5] pt-5">

                    <h3 class="font-extrabold text-[#35101f]">
                        Informasi Akun
                    </h3>

                    <div class="mt-4 grid gap-3 sm:grid-cols-2">

                        <div class="rounded-lg bg-[#f4f3ee] p-4">
                            <p class="text-xs text-[#796e70]">Nama Administrator</p>
                            <p class="mt-1 text-sm font-bold">
                                {{ $user->nama }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-[#f4f3ee] p-4">
                            <p class="text-xs text-[#796e70]">Email</p>
                            <p class="mt-1 text-sm font-bold">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-[#f4f3ee] p-4">
                            <p class="text-xs text-[#796e70]">Role Akun</p>
                            <p class="mt-1 text-sm font-bold">
                                Administrator
                            </p>
                        </div>

                    </div>

                    <div class="mt-5">
                        <a href="{{ route('pengaturan.index') }}"
                           class="inline-flex items-center justify-center rounded-lg bg-[#781d40] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#5e1531]">
                            Pengaturan Akun
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@else

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
    <div id="flash-berhasil"
        class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 shadow-sm">

        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-100">
            <svg class="h-5 w-5 text-green-700"
                viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m5 12 4 4L19 6"/>
            </svg>
        </div>

        <div class="min-w-0 flex-1">
            <h3 class="text-sm font-extrabold text-green-800">
                Berhasil Melakukan Perubahan!
            </h3>
            <p class="mt-1 text-xs leading-5 text-green-700">
                {{ session('ok') }}
            </p>
        </div>

        <button type="button"
            onclick="document.getElementById('flash-berhasil').remove()"
            class="text-lg leading-none text-green-700 hover:text-green-900"
            aria-label="Tutup">
            &times;
        </button>
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
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <h3 class="text-sm md:text-base font-bold text-[#35101f]">
                                    <span class="inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 4h-4L8 6H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-3l-2-2Z"/>
                                            <circle cx="12" cy="13" r="3"/>
                                        </svg>
                                        Unggah Foto
                                    </span>
                                </h3>

                                <span class="rounded bg-[#dbeafe] text-[#17365d] px-2.5 py-1 text-[10px] font-bold whitespace-nowrap">
                                    Maks. 5 MB
                                </span>
                            </div>

                            <label
                                id="area-upload-foto"
                                for="input-foto-profil"
                                class="group flex min-h-[205px] w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-transparent bg-[#f4f3ee] px-5 py-6 text-center transition hover:border-[#781d40]/30 hover:bg-[#f0eee8]"
                            >
                                <div id="preview-foto-container"
                                    class="mb-3 hidden h-20 w-20 overflow-hidden rounded-full border-4 border-white shadow-sm">
                                    <img id="preview-foto"
                                        src=""
                                        alt="Pratinjau foto profil"
                                        class="h-full w-full object-cover">
                                </div>

                                <h4 id="judul-upload-foto"
                                    class="text-base font-extrabold text-[#35101f]">
                                    Klik atau Tarik Berkas ke Sini
                                </h4>

                                <p class="mt-1 text-xs text-[#796e70]">
                                    Mendukung format JPG atau PNG (Ukuran maksimal 5 MB)
                                </p>

                                <span class="mt-3 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-xs font-bold text-[#781d40] shadow-sm group-hover:bg-[#fffafc]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 16V4"/>
                                        <path d="m7 9 5-5 5 5"/>
                                        <path d="M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"/>
                                    </svg>
                                    Pilih Foto Profil
                                </span>

                                <input
                                    id="input-foto-profil"
                                    type="file"
                                    name="foto"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    class="hidden"
                                >
                            </label>

                            <p id="nama-file-foto"
                                class="mt-2 text-xs text-[#781d40] text-center"></p>

                            <p id="error-foto"
                                class="mt-2 hidden text-xs font-semibold text-red-600 text-center">
                            </p>
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


{{-- MODAL KONFIRMASI SIMPAN --}}
<div id="modal-konfirmasi-simpan"
    class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/40 px-4">

    <div class="w-full max-w-[420px] rounded-2xl bg-white p-6 shadow-2xl">

        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6 shrink-0 text-green-600"
                    viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m8 12 3 3 5-6"/>
                </svg>

                <h3 class="text-lg font-extrabold text-[#222]">
                    Simpan Perubahan
                </h3>
            </div>

            <button type="button"
                id="tutup-konfirmasi-simpan"
                class="text-2xl leading-none text-gray-500 hover:text-gray-800">
                &times;
            </button>
        </div>

        <p class="mt-4 text-sm leading-5 text-[#62595b]">
            Perubahan profil Anda akan disimpan. Pastikan seluruh data yang dimasukkan sudah benar.
        </p>

        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row">
            <button type="button"
                id="batal-konfirmasi-simpan"
                class="flex-1 rounded-lg bg-[#eeede7] px-4 py-3 text-sm font-bold text-[#222] hover:bg-[#e4e2da]">
                Batal
            </button>

            <button type="button"
                id="lanjut-simpan-profil"
                class="flex-1 rounded-lg bg-[#781d40] px-4 py-3 text-sm font-bold text-white hover:bg-[#5e1531]">
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- MODAL PERUBAHAN BELUM DISIMPAN --}}
<div id="modal-perubahan"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 px-4">

    <div class="w-full max-w-[420px] rounded-2xl bg-white p-6 shadow-2xl">

        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6 shrink-0 text-red-600"
                    viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 3h11l4 4v14H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                    <path d="M8 3v6h8V3"/>
                    <path d="M8 21v-7h8v7"/>
                </svg>

                <h3 class="text-lg font-extrabold text-[#222]">
                    Perubahan Belum Disimpan
                </h3>
            </div>

            <button type="button"
                id="tutup-modal-perubahan"
                class="text-2xl leading-none text-gray-500 hover:text-gray-800"
                aria-label="Tutup">
                &times;
            </button>
        </div>

        <p class="mt-4 text-sm leading-5 text-[#62595b]">
            Anda memiliki perubahan yang belum disimpan.
            Jika keluar sekarang, perubahan tersebut akan hilang.
        </p>

        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row">
            <button type="button"
                id="tetap-di-halaman"
                class="flex-1 rounded-lg bg-[#eeede7] px-4 py-3 text-sm font-bold text-[#222] hover:bg-[#e4e2da]">
                Tetap di Halaman
            </button>

            <button type="button"
                id="buang-perubahan"
                class="flex-1 rounded-lg bg-[#781d40] px-4 py-3 text-sm font-bold text-white hover:bg-[#5e1531]">
                Buang Perubahan
            </button>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action="{{ route('profil.update') }}"]');
    const modal = document.getElementById('modal-perubahan');

    if (!form || !modal) return;

    let isDirty = false;
    let tujuanNavigasi = null;
    let sedangMenyimpan = false;

    const inputFoto = document.getElementById('input-foto-profil');
    const areaUpload = document.getElementById('area-upload-foto');
    const preview = document.getElementById('preview-foto');
    const previewContainer = document.getElementById('preview-foto-container');
    const namaFile = document.getElementById('nama-file-foto');
    const errorFoto = document.getElementById('error-foto');
    const ikonUpload = document.getElementById('ikon-upload-foto');
    const judulUpload = document.getElementById('judul-upload-foto');

    // Deteksi perubahan pada form.
    form.addEventListener('input', function () {
        isDirty = true;
    });

    form.addEventListener('change', function () {
        isDirty = true;
    });

    // Periksa apakah file foto valid.
    function tampilkanFoto(file) {
        errorFoto.classList.add('hidden');
        errorFoto.textContent = '';

        if (!file) return;

        const formatValid = ['image/jpeg', 'image/png'];
        const ukuranMaksimal = 5 * 1024 * 1024;

        if (!formatValid.includes(file.type)) {
            errorFoto.textContent = 'Format foto harus JPG atau PNG.';
            errorFoto.classList.remove('hidden');
            inputFoto.value = '';
            return;
        }

        if (file.size > ukuranMaksimal) {
            errorFoto.textContent = 'Ukuran foto maksimal 5 MB.';
            errorFoto.classList.remove('hidden');
            inputFoto.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            previewContainer.classList.remove('hidden');
            ikonUpload.classList.add('hidden');

            judulUpload.textContent = 'Foto Berhasil Dipilih';
            namaFile.textContent = file.name;
            isDirty = true;
        };

        reader.readAsDataURL(file);
    }

    inputFoto.addEventListener('change', function () {
        tampilkanFoto(this.files[0]);
    });

    // Drag and drop.
    ['dragenter', 'dragover'].forEach(function (eventName) {
        areaUpload.addEventListener(eventName, function (event) {
            event.preventDefault();
            areaUpload.classList.add('border-[#781d40]', 'bg-[#f0e8ec]');
        });
    });

    ['dragleave', 'drop'].forEach(function (eventName) {
        areaUpload.addEventListener(eventName, function (event) {
            event.preventDefault();
            areaUpload.classList.remove('border-[#781d40]', 'bg-[#f0e8ec]');
        });
    });

    areaUpload.addEventListener('drop', function (event) {
        const file = event.dataTransfer.files[0];

        if (!file) return;

        const transfer = new DataTransfer();
        transfer.items.add(file);
        inputFoto.files = transfer.files;

        tampilkanFoto(file);
    });

    // Modal peringatan.
    function bukaModal(url) {
        tujuanNavigasi = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        tujuanNavigasi = null;
    }

    document.getElementById('tutup-modal-perubahan')
        .addEventListener('click', tutupModal);

    document.getElementById('tetap-di-halaman')
        .addEventListener('click', tutupModal);

    document.getElementById('buang-perubahan')
        .addEventListener('click', function () {
            if (tujuanNavigasi) {
                window.location.href = tujuanNavigasi;
            }
        });

    // Tangkap klik tautan internal.
    document.addEventListener('click', function (event) {
        const link = event.target.closest('a[href]');

        if (!link || !isDirty || sedangMenyimpan) return;

        if (
            link.target === '_blank' ||
            link.hasAttribute('download') ||
            event.ctrlKey ||
            event.metaKey ||
            event.shiftKey ||
            event.altKey
        ) return;

        const url = new URL(link.href, window.location.href);

        if (url.origin !== window.location.origin) return;
        if (url.href === window.location.href) return;

        event.preventDefault();
        bukaModal(url.href);
    });

// KONFIRMASI SIMPAN PROFIL
const modalSimpan = document.getElementById('modal-konfirmasi-simpan');
const tombolLanjutSimpan = document.getElementById('lanjut-simpan-profil');
const tombolBatalSimpan = document.getElementById('batal-konfirmasi-simpan');
const tombolTutupSimpan = document.getElementById('tutup-konfirmasi-simpan');

let konfirmasiDiberikan = false;

form.addEventListener('submit', function (event) {
    if (konfirmasiDiberikan) {
        sedangMenyimpan = true;
        isDirty = false;
        return;
    }

    event.preventDefault();

    modalSimpan.classList.remove('hidden');
    modalSimpan.classList.add('flex');
});

function tutupKonfirmasiSimpan() {
    modalSimpan.classList.add('hidden');
    modalSimpan.classList.remove('flex');
}

tombolBatalSimpan.addEventListener('click', tutupKonfirmasiSimpan);
tombolTutupSimpan.addEventListener('click', tutupKonfirmasiSimpan);

tombolLanjutSimpan.addEventListener('click', function () {
    konfirmasiDiberikan = true;
    sedangMenyimpan = true;
    isDirty = false;

    modalSimpan.classList.add('hidden');
    modalSimpan.classList.remove('flex');

    form.requestSubmit();
});

    // Peringatan bawaan browser saat refresh atau menutup tab.
    window.addEventListener('beforeunload', function (event) {
        if (isDirty && !sedangMenyimpan) {
            event.preventDefault();
            event.returnValue = '';
        }
    });
});
</script>

@endif

@endsection