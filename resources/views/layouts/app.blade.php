
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'UB Mager — Pasar Preloved Mahasiswa')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: '#781d40',
                        cream: '#faf9f4',
                        sun: '#fff4cc',
                        wine: '#781d40'
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['DM Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
    :root {
        --wine: #781d40;
        --wine2: #650d2b;
        --cream: #faf9f4;
        --ink: #30232d;
        --muted: #777782;
        --line: #eceae3;
        --gold: #f4d77c;

        /* Standar ukuran teks */
        --font-xs: 11px;
        --font-sm: 13px;
        --font-base: 14px;
        --font-lg: 17px;
        --font-xl: 23px;

        /* Standar lebar halaman */
        --layout-width: 1170px;
        --layout-gutter: 48px;

        /* Standar komponen */
        --card-radius: 12px;
        --input-radius: 8px;
        --section-gap: 16px;
    }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 14px;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif !important;
            font-size: var(--font-base);
            background: var(--cream);
            color: var(--ink);
            line-height: 1.5;
        }

        h1, h2, h3, h4, h5, h6,
        button, input, select, textarea {
            font-family: 'DM Sans', sans-serif;
        }

        h1 {
            font-size: 25px;
            line-height: 1.25;
            font-weight: 800;
        }

        h2 {
            font-size: 18px;
            line-height: 1.35;
            font-weight: 800;
        }

        h3 {
            font-size: 15px;
            line-height: 1.4;
            font-weight: 700;
        }

        p {
            line-height: 1.55;
        }

        /* NAVBAR */
        nav.site-nav {
            position: sticky;
            top: 0;
            z-index: 40;
            width: 100%;
            background: rgba(250,249,244,.98);
            border-bottom: 1px solid #eeeae2;
            box-shadow: 0 2px 10px #26132308;
        }

        .nav-content {
            width: calc(100% - var(--layout-gutter));
            max-width: var(--layout-width);
            min-height: 70px;
            margin: 0 auto;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            background: var(--wine);
            color: #fff;
            border-radius: 9px;
            font-weight: 800;
            font-size: 22px;
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 17px !important;
            line-height: 1.2;
            font-weight: 800;
        }

        .brand-subtitle {
            font-size: 10px !important;
            line-height: 1.3;
        }

        .site-nav a {
            transition: .18s;
        }

        .site-nav a:hover {
            color: var(--wine);
        }

        .site-search {
            flex: 1;
            max-width: 375px;
            min-width: 160px;
            position: relative;
        }

        .site-search input {
            width: 100%;
            height: 38px;
            padding: 0 12px 0 38px !important;
            border: 1px solid #efedf0 !important;
            border-radius: 9px !important;
            background: #fff !important;
            box-shadow: none !important;
            font-size: 11px !important;
        }

        .nav-links {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            color: #51494a;
            font-size: 12px;
            font-weight: 700;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            border-radius: 8px;
            padding: 8px 11px;
            min-height: 34px;
            font-size: 12px;
        }

        .nav-link.active {
            background: var(--wine);
            color: #fff !important;
        }

        .nav-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #51494a;
            border-radius: 9px;
            flex-shrink: 0;
        }

        .nav-icon:hover {
            background: #f1ecee;
            color: var(--wine);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--wine2);
            color: white;
            display: grid;
            place-items: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-name {
            font-size: 11px;
            line-height: 1.3;
        }

        /* AREA KONTEN */
        .page-shell {
            width: min(
                var(--layout-width),
                calc(100% - var(--layout-gutter))
            );
            max-width: var(--layout-width);
            margin: 0 auto;
            padding: 24px 0 40px;
            flex: 1 0 auto;
            min-width: 0;
        }

        .page-shell > * {
            min-width: 0;
        }

        main {
            min-height: 0;
        }

        /* INPUT GLOBAL */
        input, select, textarea {
            font: inherit;
        }

        input:not([type=checkbox]):not([type=radio]),
        select, textarea {
            border: 1px solid #e4e1e7;
            border-radius: 9px;
            background: #fff;
            padding: 9px 12px;
            outline: none;
            max-width: 100%;
            font-size: 13px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #a75b78 !important;
            box-shadow: 0 0 0 3px #650d2b12;
        }

        button, .btn {
            transition: transform .15s, box-shadow .15s;
            cursor: pointer;
            font-size: 13px;
        }

        button:hover, .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px #25102012;
        }

        /* WARNA */
        .bg-maroon {
            background: var(--wine) !important;
        }

        .text-maroon {
            color: var(--wine) !important;
        }

        .bg-cream {
            background: var(--cream) !important;
        }

        .bg-sun {
            background: #fff4cc !important;
        }

        /* KARTU */
        .card-polish {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 3px 14px #1c152008;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 9px;
            font-size: 10px;
            font-weight: 700;
            background: #f3edf0;
            color: var(--wine);
        }

        /* STANDAR KARTU HALAMAN AKUN */
        .page-shell section.bg-white,
        .page-shell article.bg-white,
        .page-shell aside section.bg-white {
            border-radius: var(--card-radius);
            border-color: var(--line);
        }

        /* STANDAR INPUT */
        .page-shell input:not([type="checkbox"]):not([type="radio"]),
        .page-shell select,
        .page-shell textarea {
            border-radius: var(--input-radius);
            font-family: 'DM Sans', sans-serif;
        }

        /* STANDAR JARAK ANTAR BAGIAN */
        .page-shell .rounded-xl {
            scroll-margin-top: 90px;
        }

        /* GAMBAR PROFIL DAN BARANG */
        .page-shell img {
            max-width: 100%;
        }

        /* MENCEGAH KONTEN MELEBAR KELUAR */
        .page-shell .min-w-0 {
            min-width: 0;
        }

        /* TABEL */
        .table-polish {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .table-polish th {
            background: #f5f4ef;
            color: #650d2b;
            font-weight: 700;
            text-align: left;
            padding: 12px;
            font-size: 11px;
        }

        .table-polish td {
            padding: 12px;
            border-top: 1px solid var(--line);
        }

        /* UKURAN FONT KONSISTEN */
        .page-shell .text-xs {
            font-size: 11px !important;
        }

        .page-shell .text-sm {
            font-size: 13px !important;
        }

        .page-shell .text-base {
            font-size: 14px !important;
        }

        .page-shell .text-lg {
            font-size: 18px !important;
        }

        .page-shell .text-xl {
            font-size: 20px !important;
        }

        .page-shell .text-2xl {
            font-size: 25px !important;
        }

        .page-shell .text-3xl {
            font-size: 28px !important;
        }

        /* DROPDOWN */
        .page-shell select {
            min-width: 0;
        }

        .page-shell select.appearance-none {
            padding-right: 44px !important;
        }

        /* FOOTER */
        .ub-footer {
            width: 100%;
            margin-top: 42px;
            background: #f4f3ec;
            border-top: 0;
            color: #40343a;
        }

        .ub-footer-inner {
            width: calc(100% - var(--layout-gutter));
            max-width: var(--layout-width);
            margin: 0 auto;
            padding: 36px 0 24px;
        }

        .ub-footer-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr 1fr;
            gap: 48px;
        }

        .ub-footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 9px;
            color: #650d2b;
            font-size: 17px;
            font-weight: 800;
            text-decoration: none;
        }

        .ub-footer-logo-icon {
            width: 27px;
            height: 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 7px;
            background: #801d43;
            color: white;
            font-size: 19px;
            font-weight: 800;
        }

        .ub-footer-grid h3 {
            margin: 3px 0 10px;
            color: #302c2a;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .35px;
        }

        .ub-footer-grid p,
        .ub-footer-grid li {
            color: #5d5053;
            font-size: 11px;
            line-height: 1.55;
        }

        .ub-footer-grid ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .ub-footer-grid li {
            margin-bottom: 3px;
        }

        .ub-footer-brand p {
            max-width: 280px;
        }

        .ub-footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-top: 65px;
            color: #5d5053;
            font-size: 10px;
        }

        .ub-footer-bottom p {
            margin: 0;
        }

        .ub-footer-credit {
            font-weight: 700;
            text-align: right;
        }

        /* RESPONSIVE LAPTOP KECIL */
        @media (max-width: 1200px) {
            .nav-content,
            .page-shell,
            .ub-footer-inner {
                width: calc(100% - 40px);
            }

            .ub-footer-grid {
                gap: 30px;
            }
        }

        /* RESPONSIVE TABLET */
        @media (max-width: 900px) {
            .nav-content {
                gap: 12px;
            }

            .site-search {
                max-width: 280px;
            }

            .nav-links {
                gap: 4px;
            }

            .profile-name {
                display: none;
            }

            .ub-footer-grid {
                gap: 25px;
            }
        }

        /* RESPONSIVE HP */
        @media (max-width: 760px) {
            .nav-content {
                width: calc(100% - 28px);
                flex-wrap: wrap;
                gap: 9px;
                padding: 10px 0;
            }

            .site-search {
                order: 3;
                display: block;
                width: 100%;
                max-width: none;
                flex-basis: 100%;
            }

            .nav-links {
                gap: 3px;
                flex-wrap: wrap;
                margin-left: auto;
            }

            .nav-link {
                font-size: 11px;
                padding: 7px 8px;
                min-height: 32px;
            }

            .brand-mark {
                width: 34px;
                height: 34px;
                font-size: 20px;
            }

            .brand-title {
                font-size: 16px !important;
            }

            .brand-subtitle {
                font-size: 9px !important;
            }

            .profile-name {
                display: none;
            }

            .page-shell {
                width: calc(100% - 28px);
                padding: 18px 0 30px;
            }

            h1 {
                font-size: 22px;
            }

            h2 {
                font-size: 17px;
            }

            .ub-footer-inner {
                width: calc(100% - 28px);
                padding: 30px 0 22px;
            }

            .ub-footer-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .ub-footer-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                margin-top: 35px;
            }

            .ub-footer-credit {
                text-align: left;
            }
        }

        /* HP SANGAT KECIL */
        @media (max-width: 420px) {
            .nav-content {
                gap: 7px;
            }

            .brand-title {
                font-size: 15px !important;
            }

            .nav-links {
                gap: 2px;
            }

            .nav-link {
                padding: 6px 7px;
                font-size: 10px;
            }

            .nav-icon {
                width: 30px;
                height: 30px;
            }

            .page-shell {
                width: calc(100% - 24px);
            }

            .ub-footer-inner {
                width: calc(100% - 24px);
            }
        }
    </style>

    @stack('head')
</head>

<body class="min-h-screen flex flex-col">

    {{-- NAVBAR UB MAGER --}}
    @if(!request()->routeIs('register', 'otp*', 'verification*'))
    <nav class="site-nav">
        <div class="nav-content">

            {{-- LOGO --}}
            <a href="{{ route('katalog.index') }}"
               class="flex items-center gap-2 shrink-0 no-underline">
                <span class="brand-mark">M</span>

                <span class="leading-tight">
                    <span class="brand-title block text-[#781d40]">
                        UB Mager
                    </span>
                    <span class="brand-subtitle block font-bold text-[#665b5c]">
                        Malang-Batu Thrift
                    </span>
                </span>
            </a>

            {{-- PENCARIAN --}}
            <form action="{{ route('katalog.index') }}"
                  method="GET"
                  class="site-search">

                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-[#62595b]"
                     width="17" height="17"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-4-4"/>
                </svg>

                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari jaket, buku kuliah, kos gear di UB / Batu..."
                >
            </form>

            {{-- MENU NAVIGASI --}}
            <div class="nav-links">

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.katalog.index') }}"
                       class="nav-link {{ request()->routeIs('admin.katalog.*') ? 'active' : '' }}">
                        Katalog
                    </a>
                @else
                    <a href="{{ route('katalog.index') }}"
                       class="nav-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}">
                        Katalog
                    </a>
                @endif

                @auth
                    <a href="{{ route('pesanan.saya') }}"
                       class="nav-link {{ request()->routeIs('pesanan.saya', 'penjual.pesanan*') ? 'active' : '' }}">
                        Pesanan Saya
                    </a>

                    @if(auth()->user()->role === 'penjual' && Route::has('penjual.chat'))
                        <a href="{{ route('penjual.chat') }}"
                           class="nav-link {{ request()->routeIs('penjual.chat', 'chat.*') ? 'active' : '' }}">
                            Chat
                        </a>
                    @elseif(Route::has('chat.index'))
                        <a href="{{ route('chat.index') }}"
                           class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                            Chat
                        </a>
                    @endif

                    {{-- NOTIFIKASI --}}
                    @php
                        $jumlahNotifikasiBelumDibaca = \Illuminate\Support\Facades\DB::table('notifikasi')
                            ->where('id_pengguna', auth()->user()->id_pengguna)
                            ->where('sudah_dibaca', false)
                            ->count();
                    @endphp

                    @if(Route::has('notifikasi.index'))
                        <a href="{{ route('notifikasi.index') }}"
                           aria-label="Notifikasi"
                           title="Notifikasi"
                           class="nav-icon">

                            <svg width="19" height="19"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.9"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                                <path d="M10 21h4"/>
                            </svg>

                            @if($jumlahNotifikasiBelumDibaca > 0)
                                <span class="absolute top-0 right-0 min-w-[15px] h-[15px] px-1
                                             flex items-center justify-center rounded-full
                                             bg-[#781d40] text-white text-[9px] font-bold
                                             border-2 border-[#faf9f4]">
                                    {{ $jumlahNotifikasiBelumDibaca > 99 ? '99+' : $jumlahNotifikasiBelumDibaca }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- KERANJANG --}}
                    @if(Route::has('keranjang.index'))
                        <a href="{{ route('keranjang.index') }}"
                           aria-label="Keranjang"
                           title="Keranjang"
                           class="nav-icon">
                            <svg width="19" height="19"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M5 8h14l1 13H4L5 8Z"/>
                                <path d="M9 8V6a3 3 0 0 1 6 0v2"/>
                            </svg>
                        </a>
                    @endif

                    {{-- PROFIL --}}
                    <a href="{{ route('profil.edit') }}"
                       class="flex items-center gap-2 no-underline ml-1">

                        <span class="profile-avatar">
                            @if(auth()->user()->foto)
                                <img
                                    src="{{ asset('storage/'.auth()->user()->foto) }}"
                                    alt="Foto profil"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <svg width="18" height="18"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M5 21a7 7 0 0 1 14 0"/>
                                </svg>
                            @endif
                        </span>

                        <span class="profile-name whitespace-nowrap">
                            <span class="block font-extrabold text-[#24232a]">
                                {{ auth()->user()->nama }}
                            </span>
                            <span class="block text-[10px] font-semibold text-[#665b5c]">
                                Mahasiswa UB
                            </span>
                        </span>
                    </a>

                @else
                    <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                    <a href="{{ route('register') }}"
                       class="nav-link bg-[#781d40] text-white">
                        Daftar
                    </a>
                @endauth

            </div>
        </div>
    </nav>
    @endif

    {{-- KONTEN HALAMAN --}}
    <main class="page-shell flex-1">

        @if(session('ok'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm">
                ✓ {{ session('ok') }}
            </div>
        @endif

        @if(session('info') && !request()->routeIs('otp*'))
            <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 text-blue-800 px-4 py-3 text-sm">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm">
                <b>Periksa kembali data yang dimasukkan:</b>
                <ul class="list-disc ml-5 mt-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- FOOTER UB MAGER --}}
    @if(!request()->routeIs('register', 'otp*', 'verification*'))
        <footer class="ub-footer">
            <div class="ub-footer-inner">

                <div class="ub-footer-grid">

                    {{-- IDENTITAS UB MAGER --}}
                    <div class="ub-footer-brand">
                        <a href="{{ route('katalog.index') }}" class="ub-footer-logo">
                            <span class="ub-footer-logo-icon">M</span>
                            <span>UB Mager</span>
                        </a>

                        <p>
                            Platform peer-commerce mahasiswa Malang–Batu.
                            Transaksi terverifikasi, hemat, dan mudah dijangkau
                            antar kos dan kampus.
                        </p>
                    </div>

                    {{-- TITIK COD --}}
                    <div>
                        <h3>TITIK TEMU COD KAMPUS</h3>
                        <ul>
                            <li>Gazebo FIA & FILKOM UB</li>
                            <li>Gerbang Veteran - UB Coffee</li>
                            <li>Bundaran Pascasarjana UMM</li>
                            <li>Kopitiam Jalan Suhat & Borobudur</li>
                            <li>Kawasan Payung & Alun-Alun Batu</li>
                        </ul>
                    </div>

                    {{-- PANDUAN TRANSAKSI --}}
                    <div>
                        <h3>PANDUAN TRANSAKSI AMAN</h3>
                        <ul>
                            <li>Verifikasi KTM atau Email @student.campus.ac.id</li>
                            <li>Pilih titik COD publik saat jam terang</li>
                            <li>Cek fisik barang sebelum pelunasan saldo</li>
                            <li>Gunakan Rekber UB Mager untuk pesanan Batu</li>
                        </ul>
                    </div>

                </div>

                {{-- COPYRIGHT --}}
                <div class="ub-footer-bottom">
                    <p>
                        © 2026 UB Mager (Malang-Batu Campus Thrift).
                        Hak Cipta Dilindungi.
                    </p>

                    <p class="ub-footer-credit">
                        Dibuat untuk Mahasiswa Malang Raya
                    </p>
                </div>

            </div>
        </footer>
    @endif

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons({
                    attrs: {
                        'stroke-width': 1.8
                    }
                });
            }
        });
    </script>
</body>
</html>
