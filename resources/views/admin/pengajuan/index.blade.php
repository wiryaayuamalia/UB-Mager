@extends('layouts.app')

@section('title', 'Panel Verifikasi Penjual')

@section('content')

<style>
    .verifikasi-page {
        max-width: 1440px;
        margin: auto;
        padding: 30px 24px 55px;
        color: #351b28;
    }

    .verifikasi-card {
        background: #fff;
        border: 1px solid #f0edf0;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(40, 20, 30, .025);
    }

    .verifikasi-tab {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 800;
        color: #51494d;
        transition: .2s;
    }

    .verifikasi-tab.active {
        background: #791c40;
        color: white;
    }

    .verifikasi-tab .count {
        background: #e9e6df;
        color: #51494d;
        border-radius: 20px;
        padding: 2px 7px;
        font-size: 10px;
    }

    .verifikasi-tab.active .count {
        background: #fff;
        color: #791c40;
    }

    .verifikasi-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 780px;
    }

    .verifikasi-table thead {
        background: #f8f6d9;
    }

    .verifikasi-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 850;
        color: #64152f;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .verifikasi-table td {
        padding: 15px 16px;
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f5f2f0;
    }

    .verifikasi-table tbody tr:hover {
        background: #fdfbf8;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #faf5d7;
        color: #6b5200;
    }

    .status-disetujui {
        background: #e3f5e8;
        color: #19733a;
    }

    .status-ditolak {
        background: #fde8e8;
        color: #b42336;
    }

    .detail-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 13px;
        border-radius: 8px;
        background: #f0efeb;
        color: #30262b;
        font-size: 11px;
        font-weight: 800;
        transition: .2s;
    }

    .detail-button:hover {
        background: #791c40;
        color: white;
    }

    .filter-input {
        width: 100%;
        min-height: 44px;
        border: 0;
        outline: none;
        border-radius: 9px;
        background: #f0efeb;
        padding: 11px 14px;
        font-size: 12px;
    }

    .filter-input:focus {
        box-shadow: 0 0 0 2px rgba(121,28,64,.2);
    }

    .pagination-area nav {
        display: flex;
        justify-content: flex-end;
    }

    .pagination-area nav div:first-child {
        display: none;
    }

    .pagination-area nav div:last-child {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pagination-area nav a,
    .pagination-area nav span[aria-current="page"] span,
    .pagination-area nav span[aria-disabled="true"] span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 9px;
        border-radius: 7px;
        font-size: 11px;
    }

    .pagination-area nav span[aria-current="page"] span {
        background: #791c40;
        color: white;
    }

    .pagination-area nav a {
        background: #f0efeb;
        color: #4b3b43;
    }

    @media(max-width: 768px) {
        .verifikasi-page {
            padding: 20px 12px 40px;
        }

        .verifikasi-tab {
            justify-content: flex-start;
        }
    }
</style>

<div class="verifikasi-page">

    {{-- BREADCRUMB --}}
    <div class="mb-6">
        <p class="text-xs text-gray-500">
            <i class="fa-solid fa-house mr-1"></i>
            Verifikasi /
            <span class="font-bold text-[#791c40]">
                Panel Verifikasi Penjual
            </span>
        </p>
    </div>

    {{-- JUDUL --}}
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold">
            Panel Verifikasi Penjual
        </h1>

        <p class="text-sm text-gray-600 mt-2">
            Validasi legalitas identitas KTM civitas akademika Malang-Batu
            untuk integritas peer-commerce UB Mager.
        </p>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('ok'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-800 p-4 text-sm">
            <i class="fa-solid fa-circle-check mr-2"></i>
            {{ session('ok') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-800 p-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- TAB STATUS --}}
    <div class="rounded-xl bg-[#eeece5] p-2 mb-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">

            <a
                href="{{ route('admin.pengajuan.index', ['status' => 'semua']) }}"
                class="verifikasi-tab {{ $status === 'semua' ? 'active' : '' }}"
            >
                <i class="fa-regular fa-folder-open"></i>
                Semua Pengajuan
                <span class="count">{{ $jumlah['semua'] }}</span>
            </a>

            <a
                href="{{ route('admin.pengajuan.index', ['status' => 'menunggu']) }}"
                class="verifikasi-tab {{ $status === 'menunggu' ? 'active' : '' }}"
            >
                <i class="fa-regular fa-clipboard"></i>
                Menunggu Review
                <span class="count">{{ $jumlah['menunggu'] }}</span>
            </a>

            <a
                href="{{ route('admin.pengajuan.index', ['status' => 'disetujui']) }}"
                class="verifikasi-tab {{ $status === 'disetujui' ? 'active' : '' }}"
            >
                <i class="fa-regular fa-circle-check"></i>
                Disetujui
                <span class="count">{{ $jumlah['disetujui'] }}</span>
            </a>

            <a
                href="{{ route('admin.pengajuan.index', ['status' => 'ditolak']) }}"
                class="verifikasi-tab {{ $status === 'ditolak' ? 'active' : '' }}"
            >
                <i class="fa-regular fa-circle-xmark"></i>
                Ditolak
                <span class="count">{{ $jumlah['ditolak'] }}</span>
            </a>

        </div>
    </div>

    {{-- PENCARIAN --}}
    <form method="GET" action="{{ route('admin.pengajuan.index') }}"
          class="verifikasi-card p-4 mb-6">

        <input type="hidden" name="status" value="{{ $status }}">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">

            <div class="md:col-span-9 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-gray-500 text-sm"></i>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama mahasiswa, toko, atau NIM..."
                    class="filter-input pl-11"
                >
            </div>

            <div class="md:col-span-3 flex gap-2">

                <button type="submit"
                        class="flex-1 rounded-lg bg-[#791c40] text-white text-xs font-extrabold px-5 hover:bg-[#5e1230]">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i>
                    Cari
                </button>

                <a
                    href="{{ route('admin.pengajuan.index', ['status' => $status]) }}"
                    class="rounded-lg bg-[#f0efeb] text-gray-700 text-xs font-bold px-4 flex items-center justify-center"
                >
                    <i class="fa-solid fa-rotate-left mr-1"></i>
                    Reset
                </a>

            </div>

        </div>
    </form>

    {{-- TABEL PENGAJUAN --}}
    <div class="flex items-center justify-between mb-3 px-1">
        <h2 class="text-lg font-extrabold">
            Antrean Pengajuan
        </h2>

        <span class="hidden md:block text-xs text-gray-500">
            Pilih baris untuk membuka audit dokumen
        </span>
    </div>

    <div class="verifikasi-card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="verifikasi-table">

                <thead>
                    <tr>
                        <th>ID & Tanggal</th>
                        <th>Mahasiswa & Toko</th>
                        <th>Kampus / Fakultas</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($list as $p)

                        @php
                            $statusClass = [
                                'menunggu' => 'status-menunggu',
                                'disetujui' => 'status-disetujui',
                                'ditolak' => 'status-ditolak',
                            ][$p->status_pengajuan] ?? 'status-menunggu';

                            $statusLabel = [
                                'menunggu' => 'Menunggu Review',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                            ][$p->status_pengajuan] ?? ucfirst($p->status_pengajuan);
                        @endphp

                        <tr>

                            {{-- ID DAN TANGGAL --}}
                            <td>
                                <div class="font-extrabold text-gray-800">
                                    REQ-{{ $p->id_pengajuan }}
                                </div>

                                <div class="text-gray-500 mt-1 text-[11px]">
                                    {{ $p->tanggal_pengajuan
                                        ? \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d M Y')
                                        : '-' }}
                                </div>
                            </td>

                            {{-- MAHASISWA DAN TOKO --}}
                            <td>
                                <div class="font-extrabold text-gray-800">
                                    {{ $p->pengguna->nama ?? 'Pengguna tidak ditemukan' }}
                                </div>

                                <div class="text-gray-500 mt-1">
                                    <i class="fa-solid fa-store text-[#92712d] mr-1"></i>
                                    {{ $p->nama_toko }}
                                </div>

                                <div class="text-gray-400 text-[10px] mt-1">
                                    NIM: {{ $p->pengguna->nim ?? '-' }}
                                </div>
                            </td>

                            {{-- FAKULTAS --}}
                            <td>
                                <span class="inline-block rounded-full bg-[#e9e6df] px-3 py-1 text-[10px] font-bold text-gray-700">
                                    {{ $p->pengguna->fakultas ?? 'Tidak tersedia' }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fa-solid fa-circle text-[6px]"></i>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <a
                                    href="{{ route('admin.pengajuan.show', $p) }}"
                                    class="detail-button"
                                >
                                    Detail
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-14">

                                <div class="text-3xl text-gray-300 mb-3">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>

                                <p class="font-bold text-gray-600">
                                    Tidak ada pengajuan.
                                </p>

                                <p class="text-xs text-gray-400 mt-1">
                                    Belum ada data yang sesuai dengan filter ini.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- FOOTER TABEL --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 p-4 bg-[#fbfaf7]">

            <p class="text-xs text-gray-500">
                Menampilkan
                <b>{{ $list->count() }}</b>
                dari
                <b>{{ $list->total() }}</b>
                pengajuan
            </p>

            <div class="pagination-area">
                {{ $list->links() }}
            </div>

        </div>

    </div>

    {{-- PROTOKOL VERIFIKASI --}}
    <div class="rounded-xl bg-[#f3f2ec] p-4 mt-4">

        <h3 class="font-extrabold text-sm">
            <i class="fa-solid fa-shield-halved text-[#92712d] mr-2"></i>
            Protokol Verifikasi Mahasiswa Malang-Batu
        </h3>

        <p class="text-xs text-gray-600 mt-1 pl-6 max-w-3xl">
            Pastikan keselarasan nama lengkap pemohon dengan NIM terdaftar
            di PDDikti/Siam UB, serta lokasi radius maksimal 15 km dari
            gerbang kampus utama untuk kemudahan COD.
        </p>

    </div>

</div>

@endsection
