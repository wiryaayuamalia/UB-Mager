@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
@php
    $user = auth()->user();

    $jumlahSemua = $pesanan->count();
    $jumlahBelumBayar = $pesanan->where('status_pesanan', 'menunggu pembayaran')->count();
    $jumlahDisiapkan = $pesanan->whereIn('status_pesanan', ['disiapkan', 'diproses', 'menunggu penjual'])->count();
    $jumlahDikirim = $pesanan->where('status_pesanan', 'dikirim')->count();
    $jumlahSelesai = $pesanan->where('status_pesanan', 'selesai')->count();
    $jumlahDibatalkan = $pesanan->whereIn('status_pesanan', ['dibatalkan', 'ditolak', 'dibatalkan penjual'])->count();
@endphp

<div class="account-page min-h-screen w-full bg-[#faf9f4] text-[#35101f]">
    <div class="w-full mx-auto px-3 md:px-4 py-7 md:py-8">

        {{-- BREADCRUMB --}}
        <div class="flex items-center gap-2 text-[12px] md:text-[13px] mb-6">
            <a href="{{ route('profil.edit') }}"
               class="inline-flex items-center gap-1.5 text-[#796e70] hover:text-[#781d40] transition">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 10 9-7 9 7"/>
                    <path d="M5 9v11h14V9"/>
                    <path d="M9 20v-6h6v6"/>
                </svg>
                Akun Saya
            </a>
            <span class="text-[#c8c1bb]">/</span>
            <span class="font-bold text-[#781d40]">Pesanan Saya</span>
        </div>

                {{-- HEADER PROFIL --}}
        <section class="account-header bg-white rounded-xl border border-[#eeeae5] p-5 mb-4 shadow-[0_1px_3px_rgba(40,20,20,0.04)]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-[72px] h-[72px] shrink-0 rounded-full bg-[#e9e8e3] overflow-hidden">
                        @if($user->foto)
                            <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto profil" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#a39a94]">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path d="M5 21c0-3.8 3.1-6.5 7-6.5s7 2.7 7 6.5"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-2xl font-extrabold text-[#35101f] leading-tight">{{ $user->nama }}</h1>
                        <p class="text-[12px] md:text-[13px] text-[#796e70] mt-1">
                            {{ $user->fakultas ?: 'Identitas kampus belum dilengkapi' }}
                            @if($user->program_studi ?? false) <span class="mx-1">•</span>{{ $user->program_studi }} @endif
                            <span class="mx-1">•</span>Angkatan {{ $user->angkatan ?: '—' }}
                        </p>
                        <span class="inline-flex items-center gap-1.5 mt-2.5 rounded-full bg-[#781d40] text-white px-3 py-1 text-[10px] md:text-[11px] font-bold">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 2.5 2 3.2-.1.8 3.1 2.5 2-1.2 3 1.2 3-2.5 2-.8 3.1-3.2-.1L12 23l-2.5-2-3.2.1-.8-3.1-2.5-2 1.2-3-1.2-3 2.5-2 .8-3.1 3.2.1L12 3Z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            {{ $user->status_verifikasi === 'terverifikasi' ? 'Mahasiswa Terverifikasi UB' : 'Menunggu Verifikasi' }}
                        </span>
                    </div>
                </div>
                <div class="account-header-actions flex flex-col gap-2 w-full md:w-[164px] shrink-0">
                    <a href="{{ route('pengajuan.form') }}" class="min-h-[37px] inline-flex items-center justify-center gap-2 rounded-lg bg-[#781d40] text-white px-3 py-2 text-[11px] md:text-xs font-bold hover:bg-[#5e1531] transition">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10h18"/><path d="M5 10V20h14V10"/><path d="M3 10 5 4h14l2 6"/><path d="M9 20v-6h6v6"/></svg>
                        <span>Daftar sebagai Penjual</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full min-h-[37px] inline-flex items-center justify-center gap-2 rounded-lg border border-[#e8e4df] bg-white px-3 py-2 text-[11px] md:text-xs font-semibold text-[#62595b] hover:bg-[#f8f7f3] transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </section>

{{-- NAVIGASI PROFIL --}}
        <nav class="grid grid-cols-3 gap-1.5 md:gap-2 bg-[#eeece4] rounded-xl p-1.5 md:p-2 mb-4">

            <a href="{{ route('profil.edit') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 rounded-lg text-[#51494a] py-3 px-1.5 text-[10px] sm:text-xs font-bold hover:bg-white/70 transition">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="3.5"/>
                    <path d="M5 21c0-3.8 3.1-6.5 7-6.5s7 2.7 7 6.5"/>
                </svg>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('pesanan.saya') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 rounded-lg bg-[#781d40] text-white py-3 px-1.5 text-[10px] sm:text-xs font-bold">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 3h10l3 3v15H4V3h3Z"/>
                    <path d="M8 3v5h8V3"/>
                    <path d="M8 13h8M8 17h6"/>
                </svg>
                <span>Pesanan Saya</span>
                <span class="rounded-full bg-white text-[#781d40] min-w-[17px] h-[17px] px-1 grid place-items-center text-[9px]">
                    {{ $jumlahSemua }}
                </span>
            </a>

            <a href="{{ route('pengaturan.index') }}"
               class="flex items-center justify-center gap-1.5 md:gap-2 rounded-lg text-[#51494a] py-3 px-1.5 text-[10px] sm:text-xs font-bold hover:bg-white/70 transition">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 shrink-0" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="m19.4 15 .1.1 1.1 1.9-2 3.4-2.2-.5a8 8 0 0 1-1.8 1l-.7 2.1h-4l-.7-2.1a8 8 0 0 1-1.8-1l-2.2.5-2-3.4 1.1-1.9a8 8 0 0 1 0-2l-1.1-1.9 2-3.4 2.2.5a8 8 0 0 1 1.8-1L9.9 5h4l.7 2.1a8 8 0 0 1 1.8 1l2.2-.5 2 3.4-1.1 1.9a8 8 0 0 1-.1 2.1Z" transform="translate(0 -2) scale(1 .95)"/>
                </svg>
                <span>Pengaturan Akun</span>
            </a>
        </nav>

        {{-- FILTER PESANAN --}}
        <section class="bg-white rounded-xl border border-[#eeeae5] p-3 md:p-4 mb-4 shadow-[0_1px_3px_rgba(40,20,20,0.04)]">

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-1.5 md:gap-2 mb-3">
                @php
                    $filterTabs = [
                        ['semua', 'Semua', $jumlahSemua],
                        ['belum-bayar', 'Belum Bayar', $jumlahBelumBayar],
                        ['disiapkan', 'Disiapkan', $jumlahDisiapkan],
                        ['dikirim', 'Dikirim', $jumlahDikirim],
                        ['selesai', 'Selesai', $jumlahSelesai],
                        ['dibatalkan', 'Dibatalkan', $jumlahDibatalkan],
                    ];
                @endphp

                @foreach($filterTabs as $tab)
                    <button type="button"
                            data-filter="{{ $tab[0] }}"
                            class="filter-tab {{ $tab[0] === 'semua' ? 'active bg-[#781d40] text-white' : 'bg-[#f4f3ee] text-[#51494a]' }} rounded-lg py-2.5 md:py-3 px-2 text-[10px] md:text-[11px] font-bold transition hover:brightness-95">
                        {{ $tab[1] }}
                        <span class="ml-0.5 opacity-80">({{ $tab[2] }})</span>
                    </button>
                @endforeach
            </div>

            <div class="flex flex-col sm:flex-row gap-2.5">
                <div class="relative flex-1 min-w-0">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#796e70] pointer-events-none"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round">
                        <circle cx="10.8" cy="10.8" r="6.8"/>
                        <path d="m16 16 5 5"/>
                    </svg>
                    <input id="cari-pesanan"
                           type="search"
                           placeholder="Cari berdasarkan ID pesanan atau nama barang..."
                           class="w-full h-[42px] rounded-lg border border-[#eeeae5] bg-white pl-10 pr-4 text-[12px] md:text-[13px] text-[#35101f] placeholder:text-[#a29aa0] focus:ring-2 focus:ring-[#781d40]/20 focus:border-[#781d40] focus:outline-none">
                </div>

                <select id="filter-waktu"
                        class="w-full sm:w-[175px] h-[42px] rounded-lg border border-[#eeeae5] bg-white px-3 text-[12px] md:text-[13px] text-[#51494a] focus:ring-2 focus:ring-[#781d40]/20 focus:border-[#781d40] focus:outline-none">
                    <option value="semua">Semua Waktu</option>
                    <option value="7">7 Hari Terakhir</option>
                    <option value="30">30 Hari Terakhir</option>
                    <option value="90">90 Hari Terakhir</option>
                    <option value="365">1 Tahun Terakhir</option>
                </select>

                <button type="button" id="reset-filter"
                        class="inline-flex items-center justify-center gap-1.5 h-[42px] px-4 rounded-lg border border-[#eeeae5] text-[12px] font-semibold text-[#51494a] hover:bg-[#f4f3ee] transition">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 2.6-6.4L3 8"/>
                        <path d="M3 3v5h5"/>
                    </svg>
                    Reset
                </button>
            </div>
        </section>

        {{-- DAFTAR PESANAN --}}
        <div id="daftar-pesanan" class="space-y-3 md:space-y-4">

            @forelse($pesanan as $p)
                @php
                    $status = strtolower(trim($p->status_pesanan ?? ''));

                    $kategoriStatus = match($status) {
                        'menunggu pembayaran' => 'belum-bayar',
                        'diproses', 'disiapkan', 'menunggu penjual' => 'disiapkan',
                        'dikirim' => 'dikirim',
                        'selesai' => 'selesai',
                        'dibatalkan', 'ditolak', 'dibatalkan penjual' => 'dibatalkan',
                        default => 'lainnya',
                    };

                    $namaBarang = $p->katalog->nama_barang ?? 'Barang tidak tersedia';
                    $tanggal = \Carbon\Carbon::parse($p->tanggal_pesanan);

                    $statusStyle = match($kategoriStatus) {
                        'belum-bayar' => 'bg-[#fff4ce] text-[#84620a]',
                        'disiapkan' => 'bg-[#fff0dc] text-[#95601c]',
                        'dikirim' => 'bg-[#dceaff] text-[#315c9c]',
                        'selesai' => 'bg-[#d9f7e9] text-[#147a51]',
                        'dibatalkan' => 'bg-[#ffe1df] text-[#bd3933]',
                        default => 'bg-[#f0efeb] text-[#62595b]',
                    };

                    $statusIcon = match($kategoriStatus) {
                        'belum-bayar' => 'clock',
                        'disiapkan' => 'package',
                        'dikirim' => 'truck',
                        'selesai' => 'check',
                        'dibatalkan' => 'x',
                        default => 'file',
                    };
                @endphp

                <article class="order-card bg-white rounded-xl border border-[#eeeae5] p-4 md:p-5 shadow-[0_1px_3px_rgba(40,20,20,0.04)]"
                         data-status="{{ $kategoriStatus }}"
                         data-search="{{ strtolower(''.$p->id_pesanan.' '.$namaBarang) }}"
                         data-date="{{ $tanggal->timestamp }}">

                    {{-- IDENTITAS PESANAN --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#eeeae5] pb-3 mb-4">
                        <div>
                            <p class="text-[13px] md:text-sm font-extrabold text-[#35101f]">
                                Pesanan #{{ $p->id_pesanan }}
                            </p>
                            <p class="text-[11px] md:text-xs text-[#796e70] mt-1">
                                {{ $tanggal->format('d M Y, H:i') }} WIB
                            </p>
                        </div>

                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[10px] md:text-[11px] font-bold {{ $statusStyle }}">
                            @if($statusIcon === 'clock')
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 2"/>
                                </svg>
                            @elseif($statusIcon === 'package')
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                                    <path d="M3 8v9l9 5 9-5V8"/>
                                    <path d="M12 13v9"/>
                                </svg>
                            @elseif($statusIcon === 'truck')
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h11v12H3z"/>
                                    <path d="M14 10h4l3 4v4h-7"/>
                                    <circle cx="7.5" cy="18" r="2"/>
                                    <circle cx="17.5" cy="18" r="2"/>
                                </svg>
                            @elseif($statusIcon === 'check')
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="m8 12 2.5 2.5L16 9"/>
                                </svg>
                            @elseif($statusIcon === 'x')
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="m9 9 6 6m0-6-6 6"/>
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 3h10l3 3v15H4V3h3Z"/>
                                    <path d="M8 3v5h8V3"/>
                                    <path d="M8 13h8M8 17h6"/>
                                </svg>
                            @endif
                            {{ ucfirst($p->status_pesanan) }}
                        </span>
                    </div>

                    {{-- INFORMASI BARANG --}}
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                        <div class="w-[76px] h-[76px] md:w-[84px] md:h-[84px] rounded-lg bg-[#f0efe9] overflow-hidden shrink-0">
                            @if($p->katalog?->foto_utama)
                                <img src="{{ $p->katalog->foto_utama }}"
                                     alt="{{ $namaBarang }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full grid place-items-center text-[#b4aaa4]">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="16" rx="2"/>
                                        <circle cx="8.5" cy="9" r="1.5"/>
                                        <path d="m21 15-5-5L5 20"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h2 class="text-[13px] md:text-sm font-extrabold text-[#29252a] leading-snug">
                                {{ $namaBarang }}
                            </h2>

                            <p class="text-[11px] md:text-xs text-[#796e70] mt-1.5">
                                {{ $p->metode_pengiriman }} · {{ $p->metode_pembayaran }}
                            </p>

                            @if($p->alasan_penolakan)
                                <p class="text-[11px] text-red-600 mt-2">
                                    Alasan: {{ $p->alasan_penolakan }}
                                </p>
                            @endif
                        </div>

                        <div class="sm:text-right shrink-0">
                            <p class="text-[10px] md:text-[11px] text-[#796e70]">Total pesanan</p>
                            <p class="text-base md:text-lg font-extrabold text-[#35101f] mt-0.5">
                                Rp {{ number_format($p->total_bayar, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- INFORMASI PENGIRIMAN --}}
                    @if($p->pengiriman)
                        <div class="mt-4 rounded-lg bg-[#f4f3ee] p-3 flex items-start gap-2 text-[11px] md:text-xs text-[#62595b]">
                            <svg class="w-4 h-4 shrink-0 mt-0.5" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h11v12H3z"/>
                                <path d="M14 10h4l3 4v4h-7"/>
                                <circle cx="7.5" cy="18" r="2"/>
                                <circle cx="17.5" cy="18" r="2"/>
                            </svg>
                            <div>
                                Status pengiriman:
                                <strong>{{ $p->pengiriman->status_pengiriman }}</strong>

                                @if($p->alamat_pengiriman)
                                    <span class="block mt-1">
                                        Tujuan: {{ $p->alamat_pengiriman }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- TOMBOL AKSI --}}
                    <div class="flex flex-wrap justify-end gap-2 mt-4 border-t border-[#eeeae5] pt-3">

                        @if($p->status_pesanan === 'menunggu pembayaran')
                            <a href="{{ route('bayar.form', $p) }}"
                               class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#781d40] text-white px-4 md:px-5 py-2.5 text-[11px] md:text-xs font-bold hover:bg-[#5e1531] transition">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.8"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2.5" y="5" width="19" height="14" rx="2"/>
                                    <path d="M2.5 10h19"/>
                                    <path d="M7 15h3"/>
                                </svg>
                                Bayar Sekarang
                            </a>

                        @elseif($p->status_pesanan === 'dikirim')
                            <form method="POST"
                                  action="{{ route('pesanan.terima', $p) }}"
                                  onsubmit="return confirm('Konfirmasi bahwa barang sudah diterima?')">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#0b9568] text-white px-4 md:px-5 py-2.5 text-[11px] md:text-xs font-bold hover:bg-[#087b56] transition">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.8"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                    Pesanan Diterima
                                </button>
                            </form>

                        @elseif($p->status_pesanan === 'selesai')
                            <span class="inline-flex items-center gap-1.5 text-[11px] text-[#147a51] font-bold self-center">
                                <svg class="w-4 h-4" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.8"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="m8 12 2.5 2.5L16 9"/>
                                </svg>
                                Transaksi selesai
                            </span>
                        @endif
                    </div>
                </article>

            @empty
            @endforelse

        </div>

        {{-- EMPTY STATE --}}
        <div id="pesanan-kosong"
             class="{{ $pesanan->isEmpty() ? '' : 'hidden' }} bg-white rounded-xl border border-[#eeeae5] p-9 md:p-12 text-center shadow-[0_1px_3px_rgba(40,20,20,0.04)] mt-4">

            <div class="w-14 h-14 md:w-16 md:h-16 mx-auto rounded-full bg-[#f4f3ee] grid place-items-center text-[#781d40]">
                <svg class="w-7 h-7 md:w-8 md:h-8" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 3h10l3 3v15H4V3h3Z"/>
                    <path d="M8 3v5h8V3"/>
                    <path d="M8 13h8M8 17h6"/>
                </svg>
            </div>

            <h3 id="pesanan-kosong-judul" class="font-extrabold text-base md:text-lg mt-4 text-[#35101f]">
                {{ $pesanan->isEmpty() ? 'Belum Ada Pesanan' : 'Pesanan Tidak Ditemukan' }}
            </h3>

            <p id="pesanan-kosong-deskripsi" class="text-[12px] md:text-sm text-[#796e70] mt-2">
                {{ $pesanan->isEmpty()
                    ? 'Pesanan yang kamu buat akan muncul di halaman ini.'
                    : 'Coba ubah kata kunci pencarian atau filter yang kamu pilih.' }}
            </p>

            @if($pesanan->isEmpty())
                <a href="{{ route('katalog.index') }}"
                   class="inline-flex items-center justify-center gap-2 mt-5 rounded-lg bg-[#781d40] text-white px-5 py-2.5 text-xs md:text-sm font-bold hover:bg-[#5e1531] transition">
                    Jelajahi Katalog
                    <svg class="w-4 h-4" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14m-6-6 6 6-6 6"/>
                    </svg>
                </a>
            @endif
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.order-card');
    const searchInput = document.getElementById('cari-pesanan');
    const timeFilter = document.getElementById('filter-waktu');
    const resetButton = document.getElementById('reset-filter');
    const emptyState = document.getElementById('pesanan-kosong');
    const emptyTitle = document.getElementById('pesanan-kosong-judul');
    const emptyDescription = document.getElementById('pesanan-kosong-deskripsi');

    let activeFilter = 'semua';

    function filterPesanan() {
        const keyword = searchInput.value.toLowerCase().trim();
        const period = timeFilter.value;
        const now = Math.floor(Date.now() / 1000);

        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.dataset.status;
            const search = card.dataset.search || '';
            const date = Number(card.dataset.date);

            const matchStatus =
                activeFilter === 'semua' || status === activeFilter;

            const matchSearch = search.includes(keyword);

            const matchTime =
                period === 'semua' ||
                (date >= now - (Number(period) * 86400));

            const visible = matchStatus && matchSearch && matchTime;

            card.classList.toggle('hidden', !visible);

            if (visible) visibleCount++;
        });

        emptyState.classList.toggle('hidden', visibleCount > 0);

        if (visibleCount === 0 && emptyTitle && emptyDescription) {
            emptyTitle.textContent = cards.length === 0
                ? 'Belum Ada Pesanan'
                : 'Pesanan Tidak Ditemukan';

            emptyDescription.textContent = cards.length === 0
                ? 'Pesanan yang kamu buat akan muncul di halaman ini.'
                : 'Coba ubah kata kunci pencarian atau filter yang kamu pilih.';
        }
    }

    function updateActiveTab(selectedTab) {
        tabs.forEach(tab => {
            const active = tab === selectedTab;

            tab.classList.toggle('active', active);
            tab.classList.toggle('bg-[#781d40]', active);
            tab.classList.toggle('text-white', active);
            tab.classList.toggle('bg-[#f4f3ee]', !active);
            tab.classList.toggle('text-[#51494a]', !active);
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            activeFilter = this.dataset.filter;
            updateActiveTab(this);
            filterPesanan();
        });
    });

    searchInput.addEventListener('input', filterPesanan);
    timeFilter.addEventListener('change', filterPesanan);

    resetButton.addEventListener('click', function () {
        activeFilter = 'semua';
        searchInput.value = '';
        timeFilter.value = 'semua';

        const allTab = document.querySelector('[data-filter="semua"]');
        updateActiveTab(allTab);

        filterPesanan();
    });

    filterPesanan();
});
</script>

<style>
/* UB Mager: penyamaan ukuran komponen halaman akun */
.page-shell .account-page, .page-shell .account-page * { box-sizing: border-box; }
.account-page .account-card { border:1px solid #eeeae5; border-radius:12px; background:#fff; box-shadow:0 1px 3px rgba(40,20,20,.04); }
.account-page input:not([type=checkbox]):not([type=radio]), .account-page select, .account-page textarea { min-height:42px; border-radius:8px; }
.account-page button, .account-page a { -webkit-tap-highlight-color:transparent; }
.account-page svg { flex-shrink:0; }
@media (max-width: 640px) { .account-page .account-header-actions { width:100%; } }
</style>
@endsection
