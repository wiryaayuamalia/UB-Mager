@extends('layouts.app')
@section('title', 'Profil')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-4">Profil Saya</h1>
    <p class="text-sm mb-4">Status verifikasi: <b>{{ auth()->user()->status_verifikasi }}</b></p>
    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <div><label class="text-sm font-semibold">Nama</label>
            <input name="nama" value="{{ old('nama', auth()->user()->nama) }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="text-sm font-semibold">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('alamat', auth()->user()->alamat) }}</textarea></div>
        <div><label class="text-sm font-semibold">Foto</label>
            @if(auth()->user()->foto)<img src="{{ asset('storage/'.auth()->user()->foto) }}" class="w-16 h-16 rounded-full object-cover mb-2">@endif
            <input type="file" name="foto" accept="image/*"></div>
        <hr>
        <div><label class="text-sm font-semibold">Password baru (opsional)</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2"></div>
        <div><input type="password" name="password_confirmation" placeholder="Konfirmasi password" class="w-full border rounded-lg px-3 py-2"></div>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Simpan</button>
    </form>
</div>
@endsection
