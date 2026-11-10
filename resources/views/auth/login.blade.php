@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-4">Masuk</h1>
    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf
        <div><label class="text-sm font-semibold">Email / No. HP</label>
            <input name="kontak" value="{{ old('kontak') }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="text-sm font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2" required></div>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Masuk</button>
    </form>
    <div class="text-xs text-gray-500 mt-4">Akun demo (password: <code>password</code>): admin@ubmager.test · penjual@ubmager.test · pembeli@ubmager.test</div>
</div>
@endsection
