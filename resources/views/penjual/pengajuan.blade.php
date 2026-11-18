@extends('layouts.app')

@section('title', 'Pengajuan Menjadi Penjual')

@section('content')

<style>
    .pengajuan-page {
        max-width: 1320px;
        margin: 0 auto;
        padding: 28px 20px 60px;
        color: #351c29;
    }

    .pengajuan-card {
        background: #fff;
        border: 1px solid #f0edf0;
        border-radius: 15px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(50, 20, 35, .025);
    }

    .pengajuan-label {
        display: block;
        font-size: 12px;
        font-weight: 750;
        margin-bottom: 7px;
    }

    .pengajuan-input {
        width: 100%;
        min-height: 43px;
        border: 1px solid #e5e1e5;
        border-radius: 9px;
        padding: 10px 12px;
        font-size: 12px;
        color: #392632;
        background: #fff;
        outline: none;
    }

    .pengajuan-input:focus {
        border-color: #852044;
        box-shadow: 0 0 0 3px rgba(133,32,68,.08);
    }

    .pengajuan-input:disabled {
        background: #f5f4f0;
        color: #766d72;
        cursor: not-allowed;
    }

    .pengajuan-muted {
        color: #77717a;
        font-size: 11px;
        line-height: 1.6;
    }

    .pengajuan-section-title {
        font-size: 19px;
        font-weight: 850;
        margin-bottom: 7px;
    }

    .pengajuan-step {
        background: white;
        border-radius: 10px;
        padding: 11px 13px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 0;
    }

    .pengajuan-step-number {
        width: 26px;
        height: 26px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #791c40;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
    }

    .pengajuan-step strong {
        display: block;
        font-size: 11px;
    }

    .pengajuan-step span {
        display: block;
        color: #77717a;
        font-size: 10px;
    }

    .pengajuan-upload {
        border: 2px dashed #e5e1e5;
        background: #f7f6f2;
        border-radius: 12px;
        padding: 28px 15px;
        text-align: center;
        cursor: pointer;
        display: block;
        transition: .2s;
    }

    .pengajuan-upload:hover {
        border-color: #852044;
        background: #fbf7f8;
    }

    .pengajuan-checkbox {
        width: 15px;
        height: 15px;
        accent-color: #791c40;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .pengajuan-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #791c40;
        color: white;
        padding: 12px 22px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        transition: .2s;
    }

    .pengajuan-primary:hover {
        background: #5e1230;
    }

    .pengajuan-error {
        color: #c22d45;
        font-size: 11px;
        margin-top: 5px;
    }

    .pilih-lokasi {
        border: 1px solid #e8e3e5;
        background: white;
        border-radius: 9px;
        padding: 12px;
        text-align: left;
        transition: .2s;
        cursor: pointer;
    }

    .pilih-lokasi:hover {
        border-color: #791c40;
    }

    .pilih-lokasi.active {
        border: 1.5px solid #791c40;
        background: #f8f0f3;
    }

    @media(max-width: 768px) {
        .pengajuan-page {
            padding: 20px 12px 40px;
        }

        .pengajuan-card {
            padding: 18px;
        }

        .pengajuan-step {
            min-width: 100%;
        }
    }
</style>

<div class="pengajuan-page">

    {{-- BREADCRUMB DAN JUDUL --}}
    <div class="mb-6">
        <p class="text-xs text-gray-500 mb-2">
            <a href="{{ route('profil.edit') }}">Akun Saya</a>
            / <span class="font-bold text-[#791c40]">Pengajuan Penjual</span>
        </p>

        <h1 class="text-2xl md:text-3xl font-extrabold">
            Pengajuan Menjadi Penjual Terverifikasi Kampus UB Mager
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            Lengkapi data lapak dan unggah identitas mahasiswa untuk ditinjau admin UB Mager.
        </p>
    </div>

    {{-- STATUS PENGAJUAN --}}
    @if($terakhir)
        <div class="mb-5 rounded-xl p-4 text-sm
            {{ $terakhir->status_pengajuan === 'ditolak'
                ? 'bg-red-50 text-red-700'
                : ($terakhir->status_pengajuan === 'disetujui'
                    ? 'bg-green-50 text-green-700'
                    : 'bg-amber-50 text-amber-800') }}">

            <b>Status pengajuan terakhir:
                {{ ucfirst($terakhir->status_pengajuan) }}
            </b>

            @if($terakhir->alasan_penolakan)
                <p class="mt-1">
                    Alasan: {{ $terakhir->alasan_penolakan }}
                </p>
            @endif
        </div>
    @endif

    {{-- NOTIFIKASI --}}
    @if(session('ok'))
        <div class="mb-5 p-4 rounded-xl bg-green-50 text-green-700 text-sm">
            {{ session('ok') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 p-4 rounded-xl bg-red-50 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 text-red-700 text-sm">
            <b>Periksa kembali data pengajuan:</b>
            <ul class="list-disc pl-5 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$terakhir || $terakhir->status_pengajuan === 'ditolak')

        {{-- PROGRESS TIGA LANGKAH --}}
        <div class="bg-[#f8f6d9] rounded-xl p-3 mb-6">
            <div class="flex flex-wrap md:flex-nowrap gap-2">

                <div class="pengajuan-step">
                    <div class="pengajuan-step-number">1</div>
                    <div>
                        <strong>Step 1: Data Toko</strong>
                        <span>Identitas lapak & domisili kos</span>
                    </div>
                </div>

                <div class="pengajuan-step">
                    <div class="pengajuan-step-number">2</div>
                    <div>
                        <strong>Step 2: Verifikasi Identitas</strong>
                        <span>Unggah KTM/KTP resmi</span>
                    </div>
                </div>

                <div class="pengajuan-step">
                    <div class="pengajuan-step-number">3</div>
                    <div>
                        <strong>Step 3: Titik COD Malang-Batu</strong>
                        <span>Radius & spot aman serah terima</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- FORM PENGAJUAN --}}
        <form
            method="POST"
            action="{{ route('pengajuan.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

                {{-- KOLOM KIRI --}}
                <div class="lg:col-span-7 space-y-5">

                    {{-- 01 DATA TOKO --}}
                    <section class="pengajuan-card">

                        <div class="flex justify-between items-center mb-5">
                            <h2 class="pengajuan-section-title">
                                01. Data Toko Mahasiswa
                            </h2>

                            <span class="bg-blue-100 text-blue-800 rounded px-2 py-1 text-[10px] font-bold">
                                Wajib Diisi
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="pengajuan-label">
                                    Nama Toko / Lapak Kampus
                                    <span class="text-red-600">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nama_toko"
                                    value="{{ old('nama_toko') }}"
                                    required
                                    maxlength="100"
                                    placeholder="Contoh: Kosan Thrift Suhat atau Pojok Diktat FILKOM"
                                    class="pengajuan-input"
                                >

                                @error('nama_toko')
                                    <p class="pengajuan-error">{{ $message }}</p>
                                @enderror

                                <p class="pengajuan-muted mt-2">
                                    Gunakan nama yang mudah dikenali sesama anak kos atau teman fakultas.
                                </p>
                            </div>

                            <div>
                                <label class="pengajuan-label">
                                    Kategori Spesialisasi
                                    <span class="text-red-600">*</span>
                                </label>

                                <select
                                    name="kategori_spesialisasi"
                                    required
                                    class="pengajuan-input"
                                >
                                    <option value="">Pilih kategori</option>

                                    @foreach([
                                        'Thrift Outfit & Jaket',
                                        'Buku & Modul Kuliah',
                                        'Elektronik & Aksesori',
                                        'Perlengkapan Kos',
                                        'Alat Tulis & Praktikum',
                                        'Lainnya'
                                    ] as $kategori)
                                        <option
                                            value="{{ $kategori }}"
                                            @selected(old('kategori_spesialisasi') === $kategori)
                                        >
                                            {{ $kategori }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kategori_spesialisasi')
                                    <p class="pengajuan-error">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- NIM DARI PROFIL --}}
                            <div class="md:col-span-2">
                                <label class="pengajuan-label">
                                    NIM Mahasiswa Aktif
                                </label>

                                <input
                                    type="text"
                                    value="{{ auth()->user()->nim ?? 'NIM belum diisi pada profil' }}"
                                    disabled
                                    class="pengajuan-input"
                                >

                                <p class="pengajuan-muted mt-2">
                                    NIM ditampilkan dari informasi profil akun mahasiswa.
                                </p>
                            </div>

                            {{-- ALAMAT TOKO --}}
                            <div class="md:col-span-2">
                                <label class="pengajuan-label">
                                    Alamat Toko / Kos Penjual di Malang–Batu
                                    <span class="text-red-600">*</span>
                                </label>

                                <textarea
                                    name="lokasi_toko"
                                    required
                                    maxlength="255"
                                    rows="3"
                                    placeholder="Tuliskan alamat lengkap kos atau kontrakan Anda (misal: Kos Griya Suhat No. 14, Jl. Soekarno-Hatta, Lowokwaru, Malang. Patokan seberang gerbang barat UB)."
                                    class="pengajuan-input"
                                >{{ old('lokasi_toko') }}</textarea>

                                @error('lokasi_toko')
                                    <p class="pengajuan-error">{{ $message }}</p>
                                @enderror

                                <p class="pengajuan-muted mt-2">
                                    Alamat detail ini bersifat rahasia dan hanya dijadikan patokan jarak estimasi radius COD pembeli.
                                </p>
                            </div>

                        </div>
                    </section>

                    {{-- 02 VERIFIKASI IDENTITAS --}}
                    <section class="pengajuan-card">

                        <div class="flex justify-between items-center mb-5">
                            <h2 class="pengajuan-section-title">
                                02. Verifikasi Identitas Mahasiswa
                            </h2>

                            <span class="bg-blue-100 text-blue-800 rounded px-2 py-1 text-[10px] font-bold">
                                Maks. 5 MB
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 mb-4">
                            Unggah Kartu Tanda Mahasiswa (KTM) aktif dari UB, UM, UIN, UMM, Politeknik, atau KTP domisili Malang-Batu.
                        </p>

                        <label for="dokumen-identitas" class="pengajuan-upload">

                            <h3 class="font-extrabold mt-3 text-sm">
                                Klik atau Tarik Berkas ke Sini
                            </h3>

                            <p class="pengajuan-muted mt-1">
                                Mendukung format JPG, PNG, atau PDF (Ukuran maksimal 5 MB)
                            </p>

                            <span class="inline-flex mt-3 rounded-lg bg-white border px-4 py-2 text-xs font-bold text-[#791c40]">
                                <i class="fa-solid fa-paperclip mr-2"></i>
                                Pilih Berkas Identitas
                            </span>

                            <p id="nama-file" class="text-xs text-[#791c40] font-bold mt-3">
                                Belum ada berkas dipilih
                            </p>

                            <input
                                id="dokumen-identitas"
                                type="file"
                                name="dokumen"
                                accept=".jpg,.jpeg,.png,.pdf"
                                required
                                class="hidden"
                            >
                        </label>

                        @error('dokumen')
                            <p class="pengajuan-error">{{ $message }}</p>
                        @enderror

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-5">

                            <div>
                                <label class="pengajuan-label">Jenis Dokumen</label>

                                <select name="jenis_dokumen" class="pengajuan-input">
                                    <option value="KTM" @selected(old('jenis_dokumen', 'KTM') === 'KTM')>
                                        KTM
                                    </option>
                                    <option value="KTP" @selected(old('jenis_dokumen') === 'KTP')>
                                        KTP
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="pengajuan-label">
                                    Latitude <span class="text-red-600">*</span>
                                </label>

                                <input
                                    id="latitude"
                                    name="latitude"
                                    type="number"
                                    step="any"
                                    required
                                    value="{{ old('latitude', '-7.9525') }}"
                                    class="pengajuan-input"
                                >

                                @error('latitude')
                                    <p class="pengajuan-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="pengajuan-label">
                                    Longitude <span class="text-red-600">*</span>
                                </label>

                                <input
                                    id="longitude"
                                    name="longitude"
                                    type="number"
                                    step="any"
                                    required
                                    value="{{ old('longitude', '112.6141') }}"
                                    class="pengajuan-input"
                                >

                                @error('longitude')
                                    <p class="pengajuan-error">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <p class="pengajuan-muted mt-3">
                            Pilih area COD pada kolom sebelah kanan atau masukkan koordinat secara manual.
                            Lokasi harus berada di wilayah Malang–Batu.
                        </p>

                    </section>

                    {{-- 03 KOMITMEN --}}
                    <section class="pengajuan-card">

                        <h2 class="pengajuan-section-title mb-3">
                            03. Komitmen Penjual Kampus
                        </h2>

                        <p class="pengajuan-muted mb-4">
                            UB Mager mengedepankan lingkungan transaksi yang ramah,
                            anti penipuan, dan menjunjung etika civitas akademika Malang-Batu.
                        </p>

                        <div class="bg-[#f5f4ef] rounded-xl p-4 space-y-4">

                            <label class="flex gap-3 cursor-pointer">
                                <input type="checkbox" required class="pengajuan-checkbox">

                                <span>
                                    <b class="text-xs">
                                        Prinsip Kejujuran Mahasiswa (No Tipu-Tipu)
                                    </b>

                                    <small class="block text-xs text-gray-500">
                                        Saya menyatakan bahwa barang yang dijual merupakan milik sah saya dan foto listing adalah foto riil tanpa manipulasi kondisi barang.
                                    </small>
                                </span>
                            </label>

                            <label class="flex gap-3 cursor-pointer">
                                <input type="checkbox" required class="pengajuan-checkbox">

                                <span>
                                    <b class="text-xs">
                                        Garansi Pengecekan Fisik Saat COD
                                    </b>

                                    <small class="block text-xs text-gray-500">
                                        Saya bersedia memberikan waktu 5–10 menit bagi pembeli untuk menguji fungsi dan kelayakan barang di titik temu sebelum pembayaran diselesaikan.
                                    </small>
                                </span>
                            </label>

                            <label class="flex gap-3 cursor-pointer">
                                <input type="checkbox" required class="pengajuan-checkbox">

                                <span>
                                    <b class="text-xs">
                                        Persetujuan Rekber Khusus Wilayah Batu
                                    </b>

                                    <small class="block text-xs text-gray-500">
                                        Untuk transaksi berjarak lebih dari 15 KM (jalur Malang-Batu), saya bersedia menggunakan sistem saldo aman UB Mager demi keselamatan bersama.
                                    </small>
                                </span>
                            </label>

                            <label class="flex gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="komitmen"
                                    value="1"
                                    required
                                    class="pengajuan-checkbox"
                                    @checked(old('komitmen'))
                                >

                                <b class="text-xs">
                                    Saya menyetujui seluruh komitmen penjual.
                                </b>
                            </label>

                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">

                            <div>
                                <p class="pengajuan-muted">
                                    Proses verifikasi membutuhkan waktu:
                                </p>

                                <p class="text-xs font-extrabold mt-1">
                                    Maksimal 1 × 24 Jam Kerja Mahasiswa
                                </p>
                            </div>

                            <button type="submit" class="pengajuan-primary w-full sm:w-auto">
                                <i class="fa-solid fa-paper-plane"></i>
                                Kirim Pengajuan Penjual
                            </button>

                        </div>

                    </section>

                </div>

                {{-- KOLOM KANAN --}}
                <aside class="lg:col-span-5 space-y-5">

                    {{-- PILIHAN TITIK COD TANPA PETA --}}
                    <section class="pengajuan-card">

                        <div class="flex items-center justify-between gap-2 mb-2">

                            <h2 class="text-lg font-extrabold">
                                <i class="fa-solid fa-location-dot text-[#791c40] mr-1"></i>
                                3. Titik Lokasi COD
                            </h2>

                            <span class="bg-yellow-100 text-yellow-900 px-2 py-1 rounded text-[10px] font-bold">
                                Malang–Batu
                            </span>

                        </div>

                        <p class="pengajuan-muted mb-4">
                            Tentukan pusat basis operasional COD Anda di wilayah Malang Raya.
                            Pilih salah satu area berikut sebagai titik awal.
                        </p>

                        <div class="bg-[#f7f6f2] rounded-xl p-4">

                            <p class="text-xs font-extrabold mb-3">
                                Pilih Area Titik COD
                            </p>

                            <div class="grid grid-cols-2 gap-2">

                                <button
                                    type="button"
                                    class="pilih-lokasi"
                                    data-lat="-7.9525"
                                    data-lng="112.6141"
                                >
                                    <span class="block text-sm font-bold">Suhat / FIA</span>
                                    <span class="text-[10px] text-gray-500">Soekarno-Hatta</span>
                                </button>

                                <button
                                    type="button"
                                    class="pilih-lokasi"
                                    data-lat="-7.9565"
                                    data-lng="112.6170"
                                >
                                    <span class="block text-sm font-bold">Veteran</span>
                                    <span class="text-[10px] text-gray-500">Kawasan UB</span>
                                </button>

                                <button
                                    type="button"
                                    class="pilih-lokasi"
                                    data-lat="-7.9475"
                                    data-lng="112.6135"
                                >
                                    <span class="block text-sm font-bold">Dinoyo</span>
                                    <span class="text-[10px] text-gray-500">Area kampus</span>
                                </button>

                                <button
                                    type="button"
                                    class="pilih-lokasi"
                                    data-lat="-7.9225"
                                    data-lng="112.6010"
                                >
                                    <span class="block text-sm font-bold">Sigura-gura</span>
                                    <span class="text-[10px] text-gray-500">Area kampus</span>
                                </button>

                                <button
                                    type="button"
                                    class="pilih-lokasi col-span-2"
                                    data-lat="-7.8700"
                                    data-lng="112.5200"
                                >
                                    <span class="block text-sm font-bold">Kota Batu</span>
                                    <span class="text-[10px] text-gray-500">Area Alun-Alun Batu</span>
                                </button>

                            </div>

                            <p class="pengajuan-muted mt-3">
                                <i class="fa-solid fa-circle-info"></i>
                                Klik salah satu pilihan untuk mengisi koordinat formulir secara otomatis.
                            </p>

                        </div>

                        {{-- RADIUS COD --}}
                        <div class="mt-4 bg-[#f5f4ef] rounded-xl p-4">

                            <div class="flex justify-between items-center">
                                <span class="text-xs font-extrabold">
                                    Maksimal Jarak Radius COD
                                </span>

                                <b class="text-lg text-[#791c40]">5 KM</b>
                            </div>

                            <div class="h-2 bg-gray-200 rounded-full mt-3 overflow-hidden">
                                <div class="h-full w-full bg-[#791c40] rounded-full"></div>
                            </div>

                            <div class="flex justify-between text-[10px] text-gray-500 mt-2">
                                <span>1 KM (Jalan Kaki)</span>
                                <span>5 KM (COD)</span>
                            </div>

                            <p class="text-[10px] text-gray-600 mt-3">
                                <i class="fa-solid fa-check text-green-700"></i>
                                Cocok untuk meetup di area kampus dan titik temu publik.
                            </p>

                        </div>

                        {{-- KOORDINAT TERPILIH --}}
                        <div class="mt-4">

                            <p class="text-xs font-extrabold mb-3">
                                Koordinat Titik COD Terpilih
                            </p>

                            <div class="grid grid-cols-2 gap-3">

                                <div>
                                    <label class="pengajuan-label">Latitude</label>

                                    <input
                                        id="latitude-preview"
                                        value="{{ old('latitude', '-7.9525') }}"
                                        disabled
                                        class="pengajuan-input"
                                    >
                                </div>

                                <div>
                                    <label class="pengajuan-label">Longitude</label>

                                    <input
                                        id="longitude-preview"
                                        value="{{ old('longitude', '112.6141') }}"
                                        disabled
                                        class="pengajuan-input"
                                    >
                                </div>

                            </div>

                        </div>

                    </section>

                    {{-- REKOMENDASI TITIK TEMU --}}
                    <section class="px-1">

                        <h3 class="font-extrabold text-xs mb-3">
                            Rekomendasi Titik Temu Publik Teraman:
                        </h3>

                        <div class="space-y-2 text-[11px]">

                            <div class="bg-[#f0efeb] rounded-md p-3">
                                <i class="fa-solid fa-location-arrow text-[#791c40] mr-2"></i>
                                Gazebo FIA & Koridor Gedung FILKOM (Bebas Biaya Parkir)
                            </div>

                            <div class="bg-[#f0efeb] rounded-md p-3">
                                <i class="fa-solid fa-mug-hot text-[#791c40] mr-2"></i>
                                UB Coffee Veteran & Indomaret Point Suhat
                            </div>

                            <div class="bg-[#f0efeb] rounded-md p-3">
                                <i class="fa-solid fa-tree text-[#791c40] mr-2"></i>
                                Alun-Alun Batu Depan Masjid An-Nur
                            </div>

                        </div>

                    </section>

                    {{-- PRIVILEGE PENJUAL --}}
                    <section class="rounded-xl bg-[#791c40] text-white p-5">

                        <h3 class="font-extrabold text-base mb-4">
                            <i class="fa-solid fa-award text-yellow-300"></i>
                            Privilege Lapak Terverifikasi
                        </h3>

                        <div class="space-y-3 text-xs text-white/90">

                            <p>
                                <i class="fa-solid fa-check text-yellow-300 mr-2"></i>
                                Ikon centang hijau mahasiswa di setiap postingan etalase Anda.
                            </p>

                            <p>
                                <i class="fa-solid fa-check text-yellow-300 mr-2"></i>
                                Barang jualan Anda diprioritaskan muncul di halaman awal pencarian.
                            </p>

                            <p>
                                <i class="fa-solid fa-check text-yellow-300 mr-2"></i>
                                Garansi Rekber UB Mager: Bebas khawatir hit-and-run.
                            </p>

                        </div>

                        <div class="flex justify-between items-center mt-6 text-[10px] text-white/70 font-bold">
                            <span>Dukungan Komunitas Mahasiswa</span>
                            <span>v2.4 Malang-Batu</span>
                        </div>

                    </section>

                </aside>

            </div>

        </form>

    @elseif($terakhir->status_pengajuan === 'menunggu')

        {{-- STATUS MENUNGGU --}}
        <div class="pengajuan-card text-center py-14">

            <div class="text-5xl mb-4"></div>

            <h2 class="text-xl font-extrabold">
                Pengajuan Sedang Ditinjau
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Admin akan memeriksa identitas dan data lapak kamu.
            </p>

        </div>

    @else

        {{-- STATUS DISETUJUI --}}
        <div class="pengajuan-card text-center py-14">

            <div class="text-5xl mb-4">🎉</div>

            <h2 class="text-xl font-extrabold">
                Pengajuan Telah Disetujui
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Selamat! Lapak kamu telah terverifikasi sebagai penjual UB Mager.
            </p>

            <a
                href="{{ route('penjual.dashboard') }}"
                class="pengajuan-primary mt-5"
            >
                Buka Dashboard Penjual
            </a>

        </div>

    @endif

</div>

{{-- JAVASCRIPT PILIHAN LOKASI DAN UPLOAD --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // PILIHAN FILE IDENTITAS
    // =====================================

    const inputDokumen = document.getElementById('dokumen-identitas');
    const namaFile = document.getElementById('nama-file');

    if (inputDokumen && namaFile) {

        inputDokumen.addEventListener('change', function () {

            if (this.files.length > 0) {

                const file = this.files[0];
                const ukuranMaksimal = 5 * 1024 * 1024;

                if (file.size > ukuranMaksimal) {
                    alert('Ukuran dokumen maksimal 5 MB.');
                    this.value = '';
                    namaFile.textContent = 'Belum ada berkas dipilih';
                    return;
                }

                namaFile.textContent = file.name;

            } else {
                namaFile.textContent = 'Belum ada berkas dipilih';
            }

        });

    }

    // =====================================
    // PILIHAN TITIK COD
    // =====================================

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    const latPreview = document.getElementById('latitude-preview');
    const lngPreview = document.getElementById('longitude-preview');

    const tombolLokasi = document.querySelectorAll('.pilih-lokasi');

    function updatePreview() {

        if (!latInput || !lngInput) return;

        if (latPreview) {
            latPreview.value = latInput.value;
        }

        if (lngPreview) {
            lngPreview.value = lngInput.value;
        }

    }

    tombolLokasi.forEach(function (tombol) {

        tombol.addEventListener('click', function () {

            latInput.value = this.dataset.lat;
            lngInput.value = this.dataset.lng;

            updatePreview();

            tombolLokasi.forEach(function (item) {
                item.classList.remove('active');
            });

            this.classList.add('active');

        });

    });

    if (latInput) {
        latInput.addEventListener('input', updatePreview);
    }

    if (lngInput) {
        lngInput.addEventListener('input', updatePreview);
    }

    updatePreview();

});
</script>

@endsection
