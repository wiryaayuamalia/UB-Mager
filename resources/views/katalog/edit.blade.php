@extends('layouts.app')
@section('title','Edit Katalog')
@section('content')
<div class="max-w-3xl mx-auto card-polish p-6 md:p-8"><div class="mb-6"><p class="text-xs text-gray-500">Dashboard Penjual / Inventaris</p><h1 class="text-2xl font-extrabold mt-1">Edit Informasi Barang</h1><p class="text-sm text-gray-500 mt-1">Perubahan akan masuk antrean pemeriksaan admin sebelum ditayangkan kembali.</p></div>
<form method="POST" action="{{ route('penjual.katalog.update',$katalog) }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">@csrf @method('PUT')
<div class="md:col-span-2"><label class="text-sm font-bold">Nama Barang</label><input name="nama_barang" value="{{ old('nama_barang',$katalog->nama_barang) }}" required class="w-full mt-1"></div>
<div><label class="text-sm font-bold">Kategori</label><select name="id_kategori" required class="w-full mt-1">@foreach($kategori as $k)<option value="{{ $k->id_kategori }}" @selected(old('id_kategori',$katalog->id_kategori)==$k->id_kategori)>{{ $k->nama_kategori }}</option>@endforeach</select></div>
<div><label class="text-sm font-bold">Harga (Rp)</label><input type="number" min="1" name="harga" value="{{ old('harga',$katalog->harga) }}" required class="w-full mt-1"></div>
<div><label class="text-sm font-bold">Kondisi</label><input name="kondisi" value="{{ old('kondisi',$katalog->kondisi) }}" required class="w-full mt-1"></div>
<div><label class="text-sm font-bold">Stok</label><input type="number" min="0" name="stok" value="{{ old('stok',$katalog->stok) }}" required class="w-full mt-1"></div>
<div class="md:col-span-2"><label class="text-sm font-bold">Lokasi</label><select name="lokasi" required class="w-full mt-1">@foreach($lokasi as $l)<option @selected(old('lokasi',$katalog->lokasi)===$l)>{{ $l }}</option>@endforeach</select></div>
<div class="md:col-span-2"><label class="flex gap-2 items-center text-sm font-bold"><input type="checkbox" name="bisa_nego" value="1" @checked(old('bisa_nego',$katalog->bisa_nego))> Bisa nego tipis saat COD</label></div>
<div class="md:col-span-2"><label class="text-sm font-bold">Deskripsi</label><textarea name="deskripsi" rows="5" required class="w-full mt-1">{{ old('deskripsi',$katalog->deskripsi) }}</textarea></div>
<div class="md:col-span-2"><label class="text-sm font-bold">Foto Saat Ini</label><div class="flex gap-2 mt-2 flex-wrap">@foreach($katalog->foto as $f)<img src="{{ asset('storage/'.$f->path_foto) }}" class="w-20 h-20 object-cover rounded-xl">@endforeach</div><label class="block text-sm font-bold mt-4">Tambah Foto (opsional, maks. 5)</label><input type="file" name="foto[]" multiple accept="image/*" class="w-full mt-1"></div>
<div class="md:col-span-2 flex justify-end gap-2 pt-3"><a href="{{ route('penjual.dashboard') }}" class="rounded-full bg-gray-100 px-5 py-3 text-sm font-bold">Batal</a><button class="rounded-full bg-maroon text-white px-6 py-3 text-sm font-bold">Simpan Perubahan</button></div></form></div>
@endsection
