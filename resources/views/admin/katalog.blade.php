@extends('layouts.app')
@section('title', 'Kelola Katalog')
@section('content')
<h1 class="text-xl font-bold text-maroon mb-4">Dashboard Katalog (Admin)</h1>
<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-50 text-left"><tr><th class="p-3">Barang</th><th>Penjual</th><th>Status</th><th>Kelengkapan</th><th></th></tr></thead>
    <tbody>
    @foreach($list as $k)
        <tr class="border-t">
            <td class="p-3"><a class="text-maroon" href="{{ route('katalog.show', $k) }}">{{ $k->nama_barang }}</a></td>
            <td>{{ $k->penjual->nama_toko }}</td><td>{{ $k->status_katalog }}</td><td>{{ $k->status_kelengkapan }}</td>
            <td class="flex gap-2 py-2">
                <form method="POST" action="{{ route('admin.katalog.periksa', $k) }}">@csrf <input type="hidden" name="aksi" value="aktifkan"><button class="text-green-700">Aktifkan</button></form>
                <form method="POST" action="{{ route('admin.katalog.periksa', $k) }}">@csrf <input type="hidden" name="aksi" value="nonaktifkan"><button class="text-red-700">Nonaktifkan</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table></div>
<div class="mt-4">{{ $list->links() }}</div>
@endsection
