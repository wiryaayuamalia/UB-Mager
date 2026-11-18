
@extends('layouts.app')

@section('title', 'Detail Verifikasi Penjual')

@section('content')

<div class="max-w-4xl mx-auto px-3 sm:px-0">

    {{-- HEADER HALAMAN --}}
    <div class="mb-5">

        <a href="{{ route('admin.pengajuan.index') }}"
           class="text-sm font-bold text-maroon">
            ← Kembali ke antrean
        </a>

        <h1 class="text-2xl font-extrabold mt-3">
            Detail Verifikasi Penjual
        </h1>

        <p class="text-xs text-gray-500 mt-1">
            REQ-{{ str_pad($pengajuan->id_pengajuan, 5, '0', STR_PAD_LEFT) }}
            ·
            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y H:i') }}
        </p>

    </div>

    {{-- KARTU DETAIL PENGAJUAN --}}
    <div class="card-polish p-5 sm:p-6">

        {{-- IDENTITAS PEMOHON --}}
        <div class="flex flex-wrap justify-between items-start gap-3 border-b pb-4">

            <div class="min-w-0">

                <h2 class="font-extrabold text-lg">
                    {{ $pengajuan->pengguna->nama }}
                </h2>

                <p class="text-sm text-gray-500 mt-1 break-words">
                    {{ $pengajuan->pengguna->email }}
                    ·
                    {{ $pengajuan->pengguna->no_hp }}
                </p>

            </div>

            <span class="status-pill">
                {{ ucfirst($pengajuan->status_pengajuan) }}
            </span>

        </div>

        {{-- INFORMASI MAHASISWA DAN LAPAK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-5">

            {{-- INFORMASI MAHASISWA --}}
            <section>

                <h3 class="font-extrabold mb-4">
                    Informasi Mahasiswa
                </h3>

                <dl class="space-y-4 text-sm">

                    <div>
                        <dt class="text-xs text-gray-500">
                            NIM
                        </dt>

                        <dd class="font-bold mt-1">
                            {{ $pengajuan->pengguna->nim ?: 'Belum diisi' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">
                            Fakultas / Program Studi
                        </dt>

                        <dd class="font-bold mt-1 break-words">
                            {{ $pengajuan->pengguna->fakultas ?: '—' }}
                            /
                            {{ $pengajuan->pengguna->program_studi ?: '—' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">
                            Angkatan
                        </dt>

                        <dd class="font-bold mt-1">
                            {{ $pengajuan->pengguna->angkatan ?: '—' }}
                        </dd>
                    </div>

                </dl>

            </section>

            {{-- INFORMASI LAPAK --}}
            <section>

                <h3 class="font-extrabold mb-4">
                    Informasi Lapak
                </h3>

                <dl class="space-y-4 text-sm">

                    <div>
                        <dt class="text-xs text-gray-500">
                            Nama Toko
                        </dt>

                        <dd class="font-bold mt-1 break-words">
                            {{ $pengajuan->nama_toko }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">
                            Spesialisasi
                        </dt>

                        <dd class="font-bold mt-1">
                            {{ $pengajuan->kategori_spesialisasi ?: '—' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">
                            Lokasi
                        </dt>

                        <dd class="font-bold mt-1 break-words">
                            {{ $pengajuan->lokasi_toko }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-gray-500">
                            Koordinat
                        </dt>

                        <dd class="mt-1 break-words">
                            {{ $pengajuan->latitude }},
                            {{ $pengajuan->longitude }}

                            <a
                                href="https://www.google.com/maps?q={{ $pengajuan->latitude }},{{ $pengajuan->longitude }}"
                                target="_blank"
                                rel="noopener"
                                class="text-maroon font-bold ml-1"
                            >
                                Lihat Peta
                            </a>
                        </dd>
                    </div>

                </dl>

            </section>

        </div>

        {{-- DOKUMEN IDENTITAS --}}
        <div class="border-t pt-5">

            <h3 class="font-extrabold">
                Dokumen Identitas · {{ $pengajuan->jenis_dokumen }}
            </h3>

            <p class="text-xs text-gray-500 mt-1">
                Periksa dokumen identitas yang diunggah oleh pemohon.
            </p>

            <a
                href="{{ route('admin.pengajuan.dokumen', $pengajuan) }}"
                target="_blank"
                class="inline-flex mt-3 rounded-xl bg-[#f8f3f5] text-maroon px-4 py-3 text-sm font-bold"
            >
                Buka Dokumen Identitas
            </a>

        </div>

        {{-- TINDAKAN ADMIN --}}
        @if($pengajuan->status_pengajuan === 'menunggu')

            <div class="border-t mt-5 pt-5 grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- SETUJUI PENGAJUAN --}}
                <form
                    method="POST"
                    action="{{ route('admin.pengajuan.setujui', $pengajuan) }}"
                    onsubmit="return confirm('Setujui pengajuan dan aktifkan akun penjual?')"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-full bg-green-700 text-white py-3 font-bold hover:bg-green-800 transition"
                    >
                        Setujui Pengajuan
                    </button>

                </form>

                {{-- TOLAK PENGAJUAN --}}
                <form
                    method="POST"
                    action="{{ route('admin.pengajuan.tolak', $pengajuan) }}"
                    class="space-y-2"
                >

                    @csrf

                    <textarea
                        name="alasan_penolakan"
                        rows="3"
                        required
                        placeholder="Tuliskan alasan penolakan secara jelas..."
                        class="w-full rounded-xl"
                    ></textarea>

                    <button
                        type="submit"
                        class="w-full rounded-full bg-red-50 text-red-700 py-3 font-bold hover:bg-red-100 transition"
                    >
                        Tolak Pengajuan
                    </button>

                </form>

            </div>

        @elseif($pengajuan->alasan_penolakan)

            {{-- ALASAN PENOLAKAN --}}
            <div class="mt-5 rounded-xl bg-red-50 text-red-700 p-4 text-sm">

                <h3 class="font-bold mb-1">
                    Alasan Penolakan
                </h3>

                <p class="break-words">
                    {{ $pengajuan->alasan_penolakan }}
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
