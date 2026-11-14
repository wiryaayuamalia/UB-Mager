@extends('layouts.app')
@section('title', 'Verifikasi OTP')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-1">Verifikasi OTP</h1>
    <p class="text-sm text-gray-500 mb-4">Masukkan 6 digit kode (berlaku 5 menit, maks. 3 kali percobaan).</p>
    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-3">
        @csrf
        <input name="kode" maxlength="6" inputmode="numeric" class="w-full border rounded-lg px-3 py-3 text-center text-2xl tracking-[0.5em]" autofocus>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Verifikasi</button>
    </form>
    <form method="POST" action="{{ route('otp.resend') }}" class="mt-3 text-center">
        @csrf <button class="text-sm text-maroon underline">Kirim ulang OTP</button>
    </form>
    <p class="text-xs text-gray-400 mt-4">Mode dev: kode OTP ada di <code>storage/logs/laravel.log</code>.</p>
</div>
@endsection
