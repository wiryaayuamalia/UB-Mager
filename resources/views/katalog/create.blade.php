@extends('layouts.app')
@section('title', 'Unggah Katalog')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-xl font-bold text-maroon mb-4">Unggah Katalog Barang</h1>
    <form method="POST" action="{{ route('penjual.katalog.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <input name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Nama barang" class="w-full border rounded-lg px-3 py-2">
        <textarea name="deskripsi" rows="3" placeholder="Deskripsi" class="w-full border rounded-lg px-3 py-2">{{ old('deskripsi') }}</textarea>
        <input name="harga" value="{{ old('harga') }}" placeholder="Harga (angka)" class="w-full border rounded-lg px-3 py-2">
        <select name="id_kategori" class="w-full border rounded-lg px-3 py-2">
            <option value="">Pilih kategori</option>
            @foreach($kategori as $k)<option value="{{ $k->id_kategori }}" @selected(old('id_kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>@endforeach
        </select>
        <input name="kondisi" value="{{ old('kondisi') }}" placeholder="Kondisi (mis. Mulus 90%)" class="w-full border rounded-lg px-3 py-2">
        <select name="lokasi" class="w-full border rounded-lg px-3 py-2">
            <option value="">Pilih lokasi (Malang-Batu)</option>
            @foreach($lokasi as $l)<option @selected(old('lokasi') === $l)>{{ $l }}</option>@endforeach
        </select>
        <input name="stok" type="number" min="1" value="{{ old('stok', 1) }}" class="w-full border rounded-lg px-3 py-2">
        <div><label class="text-sm font-semibold">Foto (minimal 1)</label><input type="file" name="foto[]" multiple accept="image/*"></div>
        <button class="w-full bg-maroon text-white rounded-lg py-2 font-semibold">Simpan</button>
    </form>
</div>
@endsection
