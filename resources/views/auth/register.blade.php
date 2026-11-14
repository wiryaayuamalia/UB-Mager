
@extends('layouts.app')

@section('title', 'Registrasi Mahasiswa')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-10 bg-[#faf9f4]">
    <div class="w-full max-w-[520px] bg-white rounded-xl shadow-lg p-6 sm:p-8">

        {{-- HEADER --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 rounded-lg bg-[#761d40] flex items-center justify-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="4" y="7" width="16" height="14" rx="2"/>
                    <path d="M8 7V5a4 4 0 0 1 8 0v2"/>
                    <path d="M9 12h6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-[#35131f] leading-tight">UB MAGER</h1>
                <p class="text-[11px] font-bold tracking-wide text-[#66545a]">
                    PRELOVED MAHASISWA MALANG – BATU
                </p>
            </div>
        </div>

        {{-- STEPPER --}}
        <div class="grid grid-cols-2 gap-2 bg-[#f4f3ee] rounded-lg p-1.5 mb-7">
            <div class="flex items-center justify-center gap-2 bg-white rounded-md py-2 shadow-sm">
                <span class="w-5 h-5 rounded-full bg-[#5c102d] text-white text-xs font-bold flex items-center justify-center">1</span>
                <span class="text-sm font-bold text-[#5c102d]">Registrasi Akun</span>
            </div>
            <div class="flex items-center justify-center gap-2 py-2">
                <span class="w-5 h-5 rounded-full bg-[#e7e5df] text-[#66545a] text-xs font-bold flex items-center justify-center">2</span>
                <span class="text-sm font-semibold text-[#66545a]">Verifikasi OTP</span>
            </div>
        </div>

        {{-- JUDUL --}}
        <h2 class="text-2xl font-extrabold text-[#35131f] mb-1">
            Buat Akun Mahasiswa
        </h2>
        <p class="text-sm text-[#66545a] mb-5">
            Daftarkan akunmu untuk bergabung dengan komunitas UB Mager.
        </p>

        {{-- INFORMASI KEAMANAN --}}
        <div class="flex gap-3 bg-[#f8f6d8] rounded-lg p-3 mb-5">
            <div class="text-[#5c102d] pt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                     viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2 3.5 5v6c0 5.2 3.6 9.8 8.5 11 4.9-1.2 8.5-5.8 8.5-11V5L12 2zm-1 14-3.5-3.5 1.4-1.4 2.1 2.1 4.1-4.1 1.4 1.4L11 16z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-extrabold text-[#5c102d]">
                    Jaminan Identitas Terverifikasi
                </p>
                <p class="text-xs leading-relaxed text-[#49353b]">
                    Gunakan email kampus aktif (@student.ub.ac.id, @um.ac.id, dsb.)
                    untuk badge verifikasi otomatis instan.
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- NAMA --}}
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="text-sm font-bold text-[#35131f]">Nama Lengkap</label>
                    <span class="text-xs text-[#66545a]">Sesuai KTM / KTP</span>
                </div>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama sesuai KTM/identitas mahasiswa"
                    required
                    class="w-full rounded-lg border border-[#eeeae8] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#761d40]">
                @error('nama')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- KONTAK --}}
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="text-sm font-bold text-[#35131f]">No. HP / Email Mahasiswa</label>
                    <span class="text-xs text-[#5c102d]">Prioritas Email Kampus</span>
                </div>
                <input
                    type="text"
                    name="kontak"
                    value="{{ old('kontak') }}"
                    placeholder="contoh: mahasiswa@student.ub.ac.id atau 0812xxxx"
                    required
                    class="w-full rounded-lg border border-[#eeeae8] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#761d40]">
                @error('kontak')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-bold text-[#35131f] mb-1.5">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        minlength="8"
                        placeholder="Min. 8 karakter"
                        required
                        class="w-full rounded-lg border border-[#eeeae8] px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#761d40]">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#35131f] mb-1.5">
                        Konfirmasi Sandi
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        minlength="8"
                        placeholder="Ulangi sandi"
                        required
                        class="w-full rounded-lg border border-[#eeeae8] px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#761d40]">
                </div>
            </div>

            {{-- PERSETUJUAN --}}
            <label class="flex gap-2 items-start text-xs leading-relaxed text-[#66545a] pt-1">
                <input
                    type="checkbox"
                    name="setuju"
                    value="1"
                    required
                    class="mt-0.5 accent-[#761d40]">
                <span>
                    Saya menyetujui
                    <a href="#" class="font-bold underline text-[#5c102d]">
                        Syarat & Ketentuan Transaksi Preloved
                    </a>
                    kampus Malang–Batu, larangan barang terlarang, serta kesepakatan
                    titik temu (COD) publik yang aman.
                </span>
            </label>

            @error('setuju')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full rounded-lg bg-[#761d40] hover:bg-[#5c102d] text-white py-3 font-extrabold text-sm shadow-md transition">
                Daftar Sekarang →
            </button>
        </form>

        <p class="text-sm text-center mt-5 text-[#66545a]">
            Sudah punya akun?
            <a class="text-[#761d40] font-bold hover:underline"
               href="{{ route('login') }}">
                Masuk
            </a>
        </p>
    </div>
</div>
@endsection
