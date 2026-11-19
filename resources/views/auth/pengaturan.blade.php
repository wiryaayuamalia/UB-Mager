@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')

@php
    $foto = $user->foto;
@endphp

<div class="account-page min-h-screen bg-[#faf9f4] text-[#29252a]">
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
                    @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('pengajuan.form') }}" class="min-h-[37px] inline-flex items-center justify-center gap-2 rounded-lg bg-[#781d40] text-white px-3 py-2 text-[11px] md:text-xs font-bold hover:bg-[#5e1531] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10h18"/>
                            <path d="M5 10V20h14V10"/>
                            <path d="M3 10 5 4h14l2 6"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                        <span>Daftar sebagai Penjual</span>
                    </a>
                    @endif

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

        {{-- NAVIGASI AKUN --}}
        <nav class="grid {{ auth()->user()->role === 'admin' ? 'grid-cols-1' : 'grid-cols-3' }} gap-2 rounded-xl bg-[#eeece4] p-2 mb-5">

            @if(auth()->user()->role !== 'admin')
                <a href="{{ route('profil.edit') }}"
                class="flex min-h-[52px] items-center justify-center rounded-lg px-2 py-3 text-center text-xs md:text-sm font-bold text-[#51494a] hover:bg-white/70 hover:text-[#781d40]">
                    Profil Saya
                </a>

                <a href="{{ route('pesanan.saya') }}"
                class="flex min-h-[52px] items-center justify-center rounded-lg px-2 py-3 text-center text-xs md:text-sm font-bold text-[#51494a] hover:bg-white/70 hover:text-[#781d40]">
                    Pesanan Saya
                </a>
            @endif

            <a href="{{ route('pengaturan.index') }}"
            aria-current="page"
            class="flex min-h-[52px] items-center justify-center rounded-lg bg-[#781d40] px-2 py-3 text-center text-xs md:text-sm font-bold text-white shadow-sm">
                Pengaturan Akun
            </a>

        </nav>


        {{-- NOTIFIKASI BERHASIL --}}
        @if(session('ok_password') || session('ok_notifikasi') || session('ok_privasi'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                ✓ {{ session('ok_password') ?? session('ok_notifikasi') ?? session('ok_privasi') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-bold mb-1">Ada data yang perlu diperbaiki:</p>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1.35fr_0.95fr] gap-5 items-start">

            {{-- KOLOM KIRI --}}
            <div class="space-y-5">

                {{-- KEAMANAN AKUN --}}
                <section class="bg-white rounded-xl border border-[#eeeae5] p-5 md:p-7 shadow-sm">
                    <div class="flex items-start gap-3 border-b border-[#eeeae5] pb-4 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-[#f4e9ed] text-[#781d40] grid place-items-center shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                <path d="M12 14v3"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="font-extrabold text-[#35101f]">
                                Keamanan Akun & Kata Sandi
                            </h2>
                            <p class="text-xs text-[#796e70] mt-1">
                                Lindungi akun UB Mager dengan kata sandi yang kuat.
                            </p>
                        </div>
                    </div>

                    <form method="POST"
                          action="{{ route('pengaturan.password') }}"
                          onsubmit="return confirm('Apakah kamu yakin ingin memperbarui kata sandi?')">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">
                                    Kata Sandi Saat Ini
                                </label>

                                <div class="relative">
                                    <input type="password"
                                           name="password_lama"
                                           id="password-lama"
                                           required
                                           autocomplete="current-password"
                                           placeholder="Masukkan kata sandi saat ini"
                                           class="w-full rounded-lg bg-[#f4f3ee] border-0 px-4 py-3 pr-12 text-sm focus:ring-2 focus:ring-[#781d40]">

                                    <button type="button"
                                            onclick="togglePassword('password-lama', this)"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#781d40] font-bold">
                                        Lihat
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-2">
                                    Kata Sandi Baru
                                </label>

                                <div class="relative">
                                    <input type="password"
                                           name="password_baru"
                                           id="password-baru"
                                           required
                                           minlength="8"
                                           autocomplete="new-password"
                                           placeholder="Minimal 8 karakter"
                                           class="w-full rounded-lg bg-[#f4f3ee] border-0 px-4 py-3 pr-12 text-sm focus:ring-2 focus:ring-[#781d40]">

                                    <button type="button"
                                            onclick="togglePassword('password-baru', this)"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#781d40] font-bold">
                                        Lihat
                                    </button>
                                </div>

                                <div class="mt-2">
                                    <div class="h-1.5 rounded-full bg-[#eeeae5] overflow-hidden">
                                        <div id="password-strength" class="h-full w-0 rounded-full transition-all"></div>
                                    </div>

                                    <p id="password-strength-text" class="text-[10px] text-[#796e70] mt-1">
                                        Kekuatan kata sandi
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold mb-2">
                                    Konfirmasi Kata Sandi Baru
                                </label>

                                <input type="password"
                                       name="password_baru_confirmation"
                                       id="password-konfirmasi"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Ulangi kata sandi baru"
                                       class="w-full rounded-lg bg-[#f4f3ee] border-0 px-4 py-3 text-sm focus:ring-2 focus:ring-[#781d40]">
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit"
                                        class="rounded-lg bg-[#781d40] text-white px-6 py-3 text-xs font-bold hover:bg-[#5e1531] transition">
                                    Perbarui Kata Sandi
                                </button>
                            </div>
                        </div>
                    </form>
                </section>

                {{-- NOTIFIKASI --}}
                <section class="bg-white rounded-xl border border-[#eeeae5] p-5 md:p-7 shadow-sm">
                    <div class="flex items-start gap-3 border-b border-[#eeeae5] pb-4 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-[#f4e9ed] text-[#781d40] grid place-items-center shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                                <path d="M10 21h4"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="font-extrabold text-[#35101f]">
                                Preferensi Notifikasi & Komunikasi
                            </h2>
                            <p class="text-xs text-[#796e70] mt-1">
                                Atur informasi yang ingin kamu terima.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('pengaturan.notifikasi') }}">
                        @csrf

                        @php
                            $daftarNotifikasi = [
                                'pesanan' => [
                                    'judul' => 'Pembaruan Pesanan & Escrow',
                                    'deskripsi' => 'Informasi pembayaran, pesanan, dan status transaksi.',
                                ],
                                'chat' => [
                                    'judul' => 'Pesan dan Chat',
                                    'deskripsi' => 'Notifikasi pesan baru dari pembeli atau penjual.',
                                ],
                                'cod' => [
                                    'judul' => 'Pengingat COD',
                                    'deskripsi' => 'Pengingat jadwal dan lokasi pertemuan COD.',
                                ],
                                'promo' => [
                                    'judul' => 'Promo & Rekomendasi Kampus',
                                    'deskripsi' => 'Informasi promo dan rekomendasi barang.',
                                ],
                            ];
                        @endphp

                        <div class="space-y-4">
                            @foreach($daftarNotifikasi as $key => $item)
                                <label class="flex items-center justify-between gap-4 py-2 cursor-pointer">
                                    <div>
                                        <p class="text-sm font-bold">{{ $item['judul'] }}</p>
                                        <p class="text-xs text-[#796e70] mt-1">{{ $item['deskripsi'] }}</p>
                                    </div>

                                    <span class="relative shrink-0">
                                        <input type="checkbox"
                                               name="{{ $key }}"
                                               value="1"
                                               class="peer sr-only"
                                               @checked($notifikasi[$key] ?? false)>

                                        <span class="block w-11 h-6 rounded-full bg-[#dedbd4] peer-checked:bg-[#781d40] transition"></span>
                                        <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-end border-t border-[#eeeae5] pt-4 mt-4">
                            <button type="submit"
                                    class="rounded-lg bg-[#781d40] text-white px-6 py-3 text-xs font-bold hover:bg-[#5e1531]">
                                Simpan Preferensi
                            </button>
                        </div>
                    </form>
                </section>

                {{-- PRIVASI --}}
                <section class="bg-white rounded-xl border border-[#eeeae5] p-5 md:p-7 shadow-sm">
                    <div class="flex items-start gap-3 border-b border-[#eeeae5] pb-4 mb-5">
                        <div class="w-10 h-10 rounded-lg bg-[#f4e9ed] text-[#781d40] grid place-items-center shrink-0">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3 3 7v5c0 5 3.8 8 9 9 5.2-1 9-4 9-9V7l-9-4Z"/>
                                <path d="M9 12a3 3 0 0 1 6 0c0 1.5-1 2-1.5 3h-3C10 14 9 13.5 9 12Z"/>
                                <path d="M10 18h4"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="font-extrabold text-[#35101f]">
                                Privasi & Visibilitas Profil
                            </h2>
                            <p class="text-xs text-[#796e70] mt-1">
                                Kendalikan informasi yang dapat dilihat pengguna lain.
                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('pengaturan.privasi') }}">
                        @csrf

                        <div class="space-y-5">
                            <label class="flex justify-between items-center gap-4 cursor-pointer">
                                <div>
                                    <p class="text-sm font-bold">Tampilkan Nomor WhatsApp</p>
                                    <p class="text-xs text-[#796e70] mt-1">
                                        Izinkan pengguna melihat nomor WhatsApp pada profil.
                                    </p>
                                </div>

                                <span class="relative shrink-0">
                                    <input type="checkbox"
                                           name="whatsapp"
                                           value="1"
                                           class="peer sr-only"
                                           @checked($privasi['whatsapp'] ?? false)>

                                    <span class="block w-11 h-6 rounded-full bg-[#dedbd4] peer-checked:bg-[#781d40] transition"></span>
                                    <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                                </span>
                            </label>

                            <label class="flex justify-between items-center gap-4 cursor-pointer">
                                <div>
                                    <p class="text-sm font-bold">Privasi Riwayat Belanja</p>
                                    <p class="text-xs text-[#796e70] mt-1">
                                        Atur apakah riwayat belanja dapat dilihat pengguna lain.
                                    </p>
                                </div>

                                <span class="relative shrink-0">
                                    <input type="checkbox"
                                           name="riwayat_belanja"
                                           value="1"
                                           class="peer sr-only"
                                           @checked($privasi['riwayat_belanja'] ?? false)>

                                    <span class="block w-11 h-6 rounded-full bg-[#dedbd4] peer-checked:bg-[#781d40] transition"></span>
                                    <span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                                </span>
                            </label>

                            <div>
                                <label class="block text-sm font-bold mb-2">
                                    Jangkauan Visibilitas Lapak
                                </label>

                                <div class="relative">
                                    <select
                                        name="jangkauan_lapak"
                                        required
                                        class="w-full appearance-none rounded-lg bg-[#f4f3ee] border-0 px-4 py-3 pr-10 text-sm focus:ring-2 focus:ring-[#781d40]"
                                    >
                                        <option
                                            value="kampus"
                                            @selected(($privasi['jangkauan_lapak'] ?? 'kampus') === 'kampus')
                                        >
                                            Area Kampus
                                        </option>

                                        <option
                                            value="kota"
                                            @selected(($privasi['jangkauan_lapak'] ?? '') === 'kota')
                                        >
                                            Malang Raya
                                        </option>

                                        <option
                                            value="semua"
                                            @selected(($privasi['jangkauan_lapak'] ?? '') === 'semua')
                                        >
                                            Semua Pengguna
                                        </option>
                                    </select>

                                    {{-- IKON PANAH DROPDOWN --}}
                                    <svg
                                        class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#796e70]"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="m7 10 5 5 5-5"/>
                                    </svg>
                                </div>
                            </div>

                                                    <div class="flex justify-end border-t border-[#eeeae5] pt-4 mt-5">
                                                        <button type="submit"
                                                                class="rounded-lg bg-[#781d40] text-white px-6 py-3 text-xs font-bold hover:bg-[#5e1531]">
                                                            Simpan Pengaturan Privasi
                                                        </button>
                                                    </div>
                                                </form>
                                            </section>

                                        </div>

                                        {{-- KOLOM KANAN --}}
                                        <aside class="space-y-5">

                                            {{-- SSO --}}
                                            <section class="bg-white rounded-xl border border-[#eeeae5] p-5 shadow-sm">
                                                <div class="flex items-center gap-3 border-b border-[#eeeae5] pb-4 mb-4">
                                                    <div class="w-10 h-10 rounded-lg bg-[#e8eef8] text-[#315c9c] grid place-items-center">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M3 21h18"/>
                                                            <path d="M5 21V8l7-5 7 5v13"/>
                                                            <path d="M9 21v-5h6v5"/>
                                                            <path d="M9 10h.01M15 10h.01"/>
                                                        </svg>
                                                    </div>

                                                    <div>
                                                        <h3 class="font-extrabold text-sm text-[#35101f]">
                                                            Autentikasi SSO Brawijaya
                                                        </h3>
                                                        <p class="text-xs text-[#796e70] mt-1">
                                                            Integrasi akun universitas
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="rounded-lg bg-[#f4f3ee] p-4">
                                                    <div class="flex items-center gap-2 text-amber-700 text-xs font-bold">
                                                        <span>●</span> Belum terintegrasi
                                                    </div>

                                                    <p class="text-xs text-[#796e70] mt-2 leading-relaxed">
                                                        Login SSO Universitas Brawijaya belum tersedia pada aplikasi ini.
                                                        Akun kamu saat ini menggunakan autentikasi UB Mager.
                                                    </p>
                                                </div>
                                            </section>

                                            {{-- SESI AKTIF --}}
                                            <section class="bg-white rounded-xl border border-[#eeeae5] p-5 shadow-sm">
                                                <div class="flex items-center gap-3 border-b border-[#eeeae5] pb-4 mb-4">
                                                    <div class="w-10 h-10 rounded-lg bg-[#e8eef8] text-[#315c9c] grid place-items-center">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="5" width="18" height="13" rx="2"/>
                                                            <path d="M8 21h8"/>
                                                            <path d="M12 18v3"/>
                                                            <circle cx="12" cy="11.5" r="2"/>
                                                        </svg>
                                                    </div>

                                                    <div>
                                                        <h3 class="font-extrabold text-sm text-[#35101f]">
                                                            Sesi & Perangkat Aktif
                                                        </h3>
                                                        <p class="text-xs text-[#796e70] mt-1">
                                                            Informasi keamanan perangkat
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="rounded-lg bg-[#f4f3ee] p-4">
                                                    <p class="text-sm font-bold text-[#51494a]">
                                                        Pengelolaan perangkat belum tersedia
                                                    </p>

                                                    <p class="text-xs text-[#796e70] mt-2 leading-relaxed">
                                                        Aplikasi belum memiliki pencatatan sesi dan perangkat aktif.
                                                        Untuk keamanan, selalu logout setelah menggunakan perangkat bersama.
                                                    </p>
                                                </div>

                                                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                                    @csrf

                                                    <button type="submit"
                                                            class="w-full rounded-lg border border-[#781d40] text-[#781d40] px-4 py-3 text-xs font-bold hover:bg-[#f8edf1]">
                                                        Logout dari Perangkat Ini
                                                    </button>
                                                </form>
                                            </section>

                                            {{-- ZONA TINDAKAN AKUN --}}
                                            <section class="bg-white rounded-xl border border-red-100 p-5 shadow-sm">
                                                <div class="flex items-center gap-3 border-b border-red-100 pb-4 mb-4">
                                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 grid place-items-center">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M12 3 2.8 20h18.4L12 3Z"/>
                                                            <path d="M12 9v5"/>
                                                            <path d="M12 17h.01"/>
                                                        </svg>
                                                    </div>

                                                    <div>
                                                        <h3 class="font-extrabold text-sm text-red-800">
                                                            Zona Tindakan Akun
                                                        </h3>
                                                        <p class="text-xs text-[#796e70] mt-1">
                                                            Tindakan penting terkait akun
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="space-y-4">
                                                    <div>
                                                        <p class="text-sm font-bold text-[#51494a]">
                                                            Nonaktifkan Akun Sementara
                                                        </p>

                                                        <p class="text-xs text-[#796e70] mt-1 leading-relaxed">
                                                            Fitur penonaktifan akun sementara belum tersedia.
                                                            Jangan gunakan tindakan ini sebelum mekanisme pemulihan akun disiapkan.
                                                        </p>

                                                        <button type="button"
                                                                disabled
                                                                class="w-full mt-3 rounded-lg bg-gray-100 text-gray-400 px-4 py-3 text-xs font-bold cursor-not-allowed">
                                                            Nonaktifkan Akun
                                                        </button>
                                                    </div>

                                                    <div class="border-t border-red-100 pt-4">
                                                        <p class="text-sm font-bold text-red-700">
                                                            Hapus Akun Permanen
                                                        </p>

                                                        <p class="text-xs text-[#796e70] mt-1 leading-relaxed">
                                                            Penghapusan akun belum tersedia. Tindakan ini memerlukan prosedur
                                                            konfirmasi dan pemeriksaan transaksi terlebih dahulu.
                                                        </p>

                                                        <button type="button"
                                                                disabled
                                                                class="w-full mt-3 rounded-lg border border-red-200 text-red-300 px-4 py-3 text-xs font-bold cursor-not-allowed">
                                                            Hapus Akun
                                                        </button>
                                                    </div>
                                                </div>
                                            </section>

                                            {{-- BANTUAN --}}
                                            <section class="rounded-xl bg-[#781d40] text-white p-5 shadow-sm">
                                                <h3 class="font-extrabold text-sm">Butuh Bantuan?</h3>

                                                <p class="text-xs text-white/80 mt-2 leading-relaxed">
                                                    Jika mengalami masalah keamanan akun, hubungi pengelola UB Mager.
                                                </p>
                                            </section>

                                        </aside>
                                    </div>
                                </div>
                            </div>

<script>
function togglePassword(id, button) {
    const input = document.getElementById(id);

    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Sembunyikan';
    } else {
        input.type = 'password';
        button.textContent = 'Lihat';
    }
}

const passwordInput = document.getElementById('password-baru');
const strengthBar = document.getElementById('password-strength');
const strengthText = document.getElementById('password-strength-text');

if (passwordInput && strengthBar && strengthText) {
    passwordInput.addEventListener('input', function () {
        const value = this.value;
        let score = 0;

        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[a-z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        const levels = [
            { width: '0%', text: 'Kekuatan kata sandi', color: 'bg-gray-200' },
            { width: '20%', text: 'Sangat lemah', color: 'bg-red-500' },
            { width: '40%', text: 'Lemah', color: 'bg-orange-500' },
            { width: '60%', text: 'Cukup', color: 'bg-yellow-500' },
            { width: '80%', text: 'Kuat', color: 'bg-green-500' },
            { width: '100%', text: 'Sangat kuat', color: 'bg-green-700' }
        ];

        const level = levels[score];

        strengthBar.style.width = level.width;
        strengthBar.className = 'h-full rounded-full transition-all ' + level.color;
        strengthText.textContent = level.text;
    });
}
</script>

<style>
/* UB Mager: penyamaan ukuran komponen halaman akun */

.page-shell .account-page,
.page-shell .account-page * {
    box-sizing: border-box;
}

.account-page .account-card {
    border: 1px solid #eeeae5;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(40,20,20,.04);
}

.account-page input:not([type=checkbox]):not([type=radio]),
.account-page select,
.account-page textarea {
    min-height: 42px;
    border-radius: 8px;
}

.account-page button,
.account-page a {
    -webkit-tap-highlight-color: transparent;
}

.account-page svg {
    flex-shrink: 0;
}

@media (max-width: 640px) {
    .account-page .account-header-actions {
        width: 100%;
    }
}
</style>

@endsection