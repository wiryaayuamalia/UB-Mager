@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-4">Daftar Akun UB Mager</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf
        <div><label class="text-sm font-semibold">Nama</label>
            <input name="nama" value="{{ old('nama') }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="text-sm font-semibold">Email / No. HP</label>
            <input name="kontak" value="{{ old('kontak') }}" placeholder="nama@student.ub.ac.id atau 08xxxxxxxxxx" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="text-sm font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="text-sm font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2" required></div>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Daftar & Kirim OTP</button>
    </form>
    <p class="text-sm mt-4 text-center">Sudah punya akun? <a class="text-maroon font-semibold" href="{{ route('login') }}">Masuk</a></p>
</div>
@endsection
