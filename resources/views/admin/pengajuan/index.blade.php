@extends('layouts.app')
@section('title', 'Verifikasi Penjual')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold text-maroon">Verifikasi Penjual</h1>
    <div class="flex gap-2 text-sm">
        @foreach(['menunggu','disetujui','ditolak'] as $s)
            <a href="{{ route('admin.pengajuan.index', ['status' => $s]) }}" class="px-3 py-1.5 rounded-lg {{ $status === $s ? 'bg-maroon text-white' : 'bg-white' }}">{{ ucfirst($s) }}</a>
        @endforeach
        <a href="{{ route('admin.katalog.index') }}" class="px-3 py-1.5 rounded-lg bg-white">Kelola Katalog</a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-50 text-left"><tr><th class="p-3">Pemohon</th><th>Toko</th><th>Dokumen</th><th>Tanggal</th><th></th></tr></thead>
    <tbody>
    @forelse($list as $p)
        <tr class="border-t">
            <td class="p-3">{{ $p->pengguna->nama }}</td><td>{{ $p->nama_toko }}</td><td>{{ $p->jenis_dokumen }}</td>
            <td>{{ $p->tanggal_pengajuan }}</td>
            <td><a href="{{ route('admin.pengajuan.show', $p) }}" class="text-maroon font-semibold">Periksa</a></td>
        </tr>
    @empty
        <tr><td colspan="5" class="p-6 text-center text-gray-500">Tidak ada pengajuan.</td></tr>
    @endforelse
    </tbody>
</table></div>
<div class="mt-4">{{ $list->links() }}</div>
@endsection
