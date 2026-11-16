
@extends('layouts.app')

@section('title', 'Moderasi Katalog & Regulasi Kategori')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 md:px-6 py-5">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
        <div>
            <div class="text-[11px] text-gray-500 mb-2">
                Admin / Moderasi Katalog & Regulasi Kategori
            </div>

            <h1 class="text-xl md:text-2xl font-extrabold text-[#351522]">
                Moderasi Katalog & Regulasi Kategori
            </h1>

            <p class="text-xs text-gray-500 mt-1 max-w-2xl leading-relaxed">
                Panel pengawasan barang preloved UB Mager. Menegakkan SOP keamanan
                transaksi kos, verifikasi identitas sivitas akademika, dan menjaga
                stabilitas harga wajar mahasiswa.
            </p>
        </div>

        <a href="{{ route('admin.pengajuan.index') }}"
           class="bg-white border border-[#e9e5df] rounded-lg px-4 py-2 text-xs font-bold text-[#51434a] hover:bg-gray-50">
            ← Verifikasi Penjual
        </a>
    </div>

    {{-- STATISTIK --}}
    @php
        $totalKatalog = \App\Models\Katalog::count();
        $katalogAktif = \App\Models\Katalog::where('status_katalog', 'aktif')->count();
        $menungguReview = \App\Models\Katalog::where('status_katalog', 'menunggu pemeriksaan')->count();
        $jumlahKategori = $kategori->count();
        $jumlahRentang = $rentang->count();
    @endphp

    <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 mb-5">

        {{-- TOTAL KATALOG AKTIF --}}
        <div class="bg-white border border-[#eeeae3] rounded-xl p-4 shadow-sm min-h-[125px] flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <p class="text-[11px] font-extrabold tracking-wide text-[#66575c]">
                    TOTAL KATALOG AKTIF
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#e1ecff] flex items-center justify-center text-[#496887] shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                        <path d="M8 8h8M9 12h6"/>
                    </svg>
                </div>
            </div>

            <div>
                <p class="text-4xl font-extrabold leading-none text-[#351522]">
                    {{ number_format($katalogAktif) }}
                </p>
                <p class="text-[10px] text-gray-500 mt-2">
                    Total seluruh katalog: {{ number_format($totalKatalog) }}
                </p>
            </div>
        </div>

        {{-- PELANGGARAN / REVIEW --}}
        <div class="bg-white border border-[#eeeae3] rounded-xl p-4 shadow-sm min-h-[125px] flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <p class="text-[11px] font-extrabold tracking-wide text-[#66575c]">
                    MENUNGGU PEMERIKSAAN
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#ffe8e6] flex items-center justify-center text-red-600 shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 3 2.8 20h18.4L12 3Z"/>
                        <path d="M12 9v5m0 3h.01"/>
                    </svg>
                </div>
            </div>

            <div>
                <p class="text-4xl font-extrabold leading-none text-red-600">
                    {{ number_format($menungguReview) }}
                </p>
                <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span class="bg-[#ffe1df] text-red-700 rounded-full px-2.5 py-1 text-[10px] font-bold">
                        {{ number_format($menungguReview) }} Perlu Review
                    </span>
                    <span class="text-[10px] text-gray-500">Butuh tindakan</span>
                </div>
            </div>
        </div>

        {{-- KATEGORI --}}
        <div class="bg-white border border-[#eeeae3] rounded-xl p-4 shadow-sm min-h-[125px] flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <p class="text-[11px] font-extrabold tracking-wide text-[#66575c]">
                    KATEGORI AKTIF
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#f8f4d8] flex items-center justify-center text-[#89721d] shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m12 3 4 7H8l4-7Z"/>
                        <circle cx="7" cy="17" r="3"/>
                        <circle cx="17" cy="17" r="3"/>
                    </svg>
                </div>
            </div>

            <div>
                <p class="text-4xl font-extrabold leading-none text-[#351522]">
                    {{ number_format($jumlahKategori) }}
                </p>
                <p class="text-[10px] text-gray-500 mt-2">
                    Kategori terdaftar di marketplace
                </p>
            </div>
        </div>

        {{-- RENTANG HARGA --}}
        <div class="bg-white border border-[#eeeae3] rounded-xl p-4 shadow-sm min-h-[125px] flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <p class="text-[11px] font-extrabold tracking-wide text-[#66575c]">
                    RENTANG HARGA WAJAR
                </p>

                <div class="w-10 h-10 rounded-xl bg-[#fce9f0] flex items-center justify-center text-[#852047] shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M8 10h.01M16 14h.01M12 8v8m2-6h-3a1.5 1.5 0 0 0 0 3h2a1.5 1.5 0 0 1 0 3H10"/>
                    </svg>
                </div>
            </div>

            <div>
                <p class="text-3xl font-extrabold leading-none text-[#6e1235]">
                    {{ number_format($jumlahRentang) }}
                    <span class="text-xl">Skema</span>
                </p>
                <p class="text-[10px] text-gray-500 mt-2">
                    Referensi harga barang mahasiswa
                </p>
            </div>
        </div>

    </div>

    {{-- TABEL MODERASI --}}
    <section class="bg-white border border-[#eeeae3] rounded-xl shadow-sm overflow-hidden mb-5">

        <div class="p-4 border-b border-[#eeeae3] flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-extrabold text-[#351522] flex items-center gap-2">
                    <span class="w-2 h-5 rounded-sm bg-[#781c40]"></span>
                    Tabel Moderasi Katalog
                </h2>
                <p class="text-[10px] text-gray-500 mt-1">
                    Daftar pengajuan dan barang mahasiswa. Pantau flag anomali harga serta laporan komunitas COD.
                </p>
            </div>

            <form method="GET" action="{{ route('admin.katalog.index') }}"
                  class="flex flex-wrap items-center gap-2">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama barang..."
                    class="!w-40 md:!w-48 !py-2 !px-3 !text-xs !rounded-lg border border-[#e8e4e2]"
                >

                <select name="status"
                        class="!w-32 !py-2 !px-2 !text-xs !rounded-lg border border-[#e8e4e2]">
                    <option value="">Semua Status</option>
                    @foreach(['menunggu pemeriksaan', 'aktif', 'nonaktif'] as $st)
                        <option value="{{ $st }}" @selected(request('status') === $st)>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="bg-[#781c40] hover:bg-[#5f1533] text-white rounded-lg px-4 py-2 text-xs font-bold">
                    Cari
                </button>

                <a href="{{ route('admin.katalog.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-2 text-xs font-bold text-gray-700">
                    Reset
                </a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[850px]">
                <thead class="bg-[#f5f3ee] text-[#6e1235]">
                    <tr class="text-[10px] uppercase tracking-wide">
                        <th class="px-4 py-3 font-extrabold">Foto & Item</th>
                        <th class="px-3 py-3 font-extrabold">Penjual</th>
                        <th class="px-3 py-3 font-extrabold">Harga</th>
                        <th class="px-3 py-3 font-extrabold">Kategori</th>
                        <th class="px-3 py-3 font-extrabold">Tanggal Unggah</th>
                        <th class="px-3 py-3 font-extrabold">Status</th>
                        <th class="px-4 py-3 font-extrabold">Aksi Moderasi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#f0ede8]">
                    @forelse($list as $k)
                        <tr class="text-xs hover:bg-[#fcfbf8]">

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5 min-w-[180px]">
                                    <div class="w-10 h-10 rounded-lg bg-[#f0efe9] overflow-hidden shrink-0">
                                        @if($k->foto_utama)
                                            <img src="{{ $k->foto_utama }}"
                                                 class="w-full h-full object-cover"
                                                 alt="{{ $k->nama_barang }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-[9px]">
                                                Foto
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <a href="{{ route('katalog.show', $k) }}"
                                           class="font-bold text-[#351522] hover:text-[#781c40] line-clamp-2">
                                            {{ $k->nama_barang }}
                                        </a>
                                        <p class="text-[9px] text-gray-400 mt-1">
                                            ID: KTL-{{ $k->id_katalog }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-3 py-3">
                                <p class="font-bold text-[#351522]">
                                    {{ $k->penjual->nama_toko ?? '—' }}
                                </p>
                                <p class="text-[9px] text-gray-400 mt-1">
                                    {{ $k->penjual->pengguna->nama ?? 'Penjual' }}
                                </p>
                            </td>

                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="font-extrabold text-[#6e1235]">
                                    Rp{{ number_format($k->harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-3 py-3">
                                <span class="bg-[#e5efff] text-[#496887] rounded-full px-2.5 py-1 text-[9px] font-bold">
                                    {{ $k->kategori->nama_kategori ?? '—' }}
                                </span>
                            </td>

                            <td class="px-3 py-3 whitespace-nowrap">
                                <p class="text-[10px] text-gray-600">
                                    {{ $k->created_at ? \Carbon\Carbon::parse($k->created_at)->format('d M Y') : '—' }}
                                </p>
                                <p class="text-[9px] text-gray-400">
                                    {{ $k->created_at ? \Carbon\Carbon::parse($k->created_at)->format('H:i') . ' WIB' : '' }}
                                </p>
                            </td>

                            <td class="px-3 py-3">
                                @if($k->status_katalog === 'aktif')
                                    <span class="bg-[#e4f5e9] text-green-700 rounded-full px-2.5 py-1 text-[9px] font-bold whitespace-nowrap">
                                        ● Aktif
                                    </span>
                                @elseif($k->status_katalog === 'menunggu pemeriksaan')
                                    <span class="bg-[#fff2d5] text-[#896516] rounded-full px-2.5 py-1 text-[9px] font-bold whitespace-nowrap">
                                        ● Menunggu Review
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 rounded-full px-2.5 py-1 text-[9px] font-bold whitespace-nowrap">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <a href="{{ route('katalog.show', $k) }}"
                                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md px-2.5 py-1.5 text-[10px] font-bold">
                                        Detail
                                    </a>

                                    @if($k->status_katalog !== 'aktif')
                                        <form method="POST"
                                              action="{{ route('admin.katalog.periksa', $k) }}">
                                            @csrf
                                            <input type="hidden" name="aksi" value="aktifkan">
                                            <button type="submit"
                                                    class="bg-[#e4f5e9] hover:bg-green-100 text-green-700 rounded-md px-2.5 py-1.5 text-[10px] font-bold">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    @if($k->status_katalog !== 'nonaktif')
                                        <form method="POST"
                                              action="{{ route('admin.katalog.periksa', $k) }}">
                                            @csrf
                                            <input type="hidden" name="aksi" value="nonaktifkan">
                                            <button type="submit"
                                                    class="bg-[#ffe5e3] hover:bg-red-100 text-red-700 rounded-md px-2.5 py-1.5 text-[10px] font-bold">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-xs text-gray-500">
                                Tidak ada katalog yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-t border-[#eeeae3] flex flex-wrap items-center justify-between gap-3">
            <p class="text-[10px] text-gray-500">
                Menampilkan {{ $list->count() }} dari {{ $list->total() }} katalog terdaftar.
            </p>
            <div class="text-xs">
                {{ $list->links() }}
            </div>
        </div>
    </section>

    {{-- KELOLA KATEGORI DAN RENTANG HARGA --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- KATEGORI --}}
        <section class="bg-white border border-[#eeeae3] rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-[#eeeae3]">
                <h2 class="text-base font-extrabold text-[#351522] flex items-center gap-2">
                    <span class="w-2 h-5 rounded-sm bg-[#94721d]"></span>
                    Tabel Kelola Kategori
                </h2>
                <p class="text-[10px] text-gray-500 mt-1">
                    Standar kategori barang UB Mager.
                </p>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ route('admin.kategori.store') }}"
                      class="flex gap-2">
                    @csrf

                    <input
                        type="text"
                        name="nama_kategori"
                        placeholder="Nama kategori baru"
                        required
                        maxlength="50"
                        class="flex-1 min-w-0 !py-2 !px-3 !text-xs !rounded-lg border border-[#e8e4e2]"
                    >

                    <button type="submit"
                            class="bg-[#781c40] hover:bg-[#5f1533] text-white rounded-lg px-3 py-2 text-xs font-bold whitespace-nowrap">
                        + Tambah
                    </button>
                </form>

                @error('nama_kategori')
                    <p class="text-red-600 text-[10px] mt-2">{{ $message }}</p>
                @enderror

                <div class="divide-y divide-[#f0ede8] mt-3">
                    @forelse($kategori as $cat)
                        <div class="py-3 flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold text-[#351522]">
                                    {{ $cat->nama_kategori }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ $cat->katalog_count }} barang
                                </p>
                            </div>

                            <form method="POST"
                                  action="{{ route('admin.kategori.destroy', $cat) }}"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-gray-100 hover:bg-red-50 text-red-600 rounded-md px-3 py-1.5 text-[10px] font-bold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 py-5 text-center">
                            Belum ada kategori.
                        </p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- RENTANG HARGA --}}
        <section class="bg-white border border-[#eeeae3] rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-[#eeeae3]">
                <h2 class="text-base font-extrabold text-[#351522] flex items-center gap-2">
                    <span class="w-2 h-5 rounded-sm bg-[#94721d]"></span>
                    Tabel Rentang Harga Wajar
                </h2>
                <p class="text-[10px] text-gray-500 mt-1">
                    Atur referensi harga untuk panduan kategori barang mahasiswa.
                </p>
            </div>

            <div class="p-4 space-y-3">
                @forelse($rentang as $r)
                    <form method="POST"
                          action="{{ route('admin.rentang.update', $r) }}"
                          class="border-b border-[#f0ede8] pb-3 last:border-0">
                        @csrf
                        @method('PUT')

                        <label class="block text-[10px] font-bold text-gray-500 mb-1">
                            Label Rentang
                        </label>

                        <input
                            type="text"
                            name="label"
                            value="{{ $r->label }}"
                            required
                            maxlength="50"
                            class="w-full !py-2 !px-3 !text-xs !rounded-lg border border-[#e8e4e2] mb-2"
                        >

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] text-gray-500 mb-1">
                                    Harga Minimum
                                </label>
                                <input
                                    type="number"
                                    name="harga_min"
                                    value="{{ (int) $r->harga_min }}"
                                    min="0"
                                    required
                                    class="w-full !py-2 !px-3 !text-xs !rounded-lg border border-[#e8e4e2]"
                                >
                            </div>

                            <div>
                                <label class="block text-[10px] text-gray-500 mb-1">
                                    Harga Maksimum
                                </label>
                                <input
                                    type="number"
                                    name="harga_maks"
                                    value="{{ (int) $r->harga_maks }}"
                                    min="0"
                                    required
                                    class="w-full !py-2 !px-3 !text-xs !rounded-lg border border-[#e8e4e2]"
                                >
                            </div>
                        </div>

                        <div class="flex justify-end mt-2">
                            <button type="submit"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md px-3 py-1.5 text-[10px] font-bold">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                @empty
                    <p class="text-xs text-gray-500 text-center py-5">
                        Belum ada rentang harga.
                    </p>
                @endforelse
            </div>
        </section>

    </div>

    {{-- INFORMASI --}}
    <div class="mt-4 bg-[#f0efe8] rounded-xl p-3 flex flex-wrap items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-[#ffe69a] text-[#725817] flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 3 4 6v5c0 5 3.5 8 8 10 4.5-2 8-5 8-10V6l-8-3Z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
        </div>

        <div class="flex-1 min-w-0">
            <p class="text-xs font-extrabold text-[#351522]">
                Maklumat Satgas Usaha Mahasiswa UB
            </p>
            <p class="text-[10px] text-gray-500">
                Katalog dengan nilai di atas batas atas wajar otomatis dialihkan ke status verifikasi manual sebelum dapat dicari di beranda publik.
            </p>
        </div>

        <span class="text-[10px] font-bold text-[#80651d]">
            SK BEM 08/UB-MGR/2025
        </span>
    </div>

</div>
@endsection
