
@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="max-w-[1450px] mx-auto">

    {{-- JUDUL HALAMAN --}}
    <div class="mb-4">
        <h1 class="text-2xl font-extrabold text-[#351923]">Chat</h1>
        <p class="text-sm text-gray-500 mt-1">
            Tanya kondisi barang dan sepakati COD, tanpa pindah aplikasi.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[360px_minmax(0,1fr)] border border-[#e8e5df] rounded-xl overflow-hidden bg-white min-h-[680px]">

        {{-- DAFTAR PERCAKAPAN --}}
        <aside class="border-b lg:border-b-0 lg:border-r border-[#e8e5df] flex flex-col">

            <div class="p-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <h2 class="font-extrabold text-base text-[#351923]">
                        Percakapan
                    </h2>
                    <span class="text-xs text-gray-400">
                        {{ $threads->count() }} percakapan
                    </span>
                </div>

                <form method="GET"
                      action="{{ auth()->user()->role === 'penjual' ? route('penjual.chat') : route('chat.index') }}"
                      class="mt-3">

                    <div class="relative">
                        <svg class="absolute left-3 top-3 text-gray-500"
                             width="17" height="17"
                             viewBox="0 0 24 24"
                             fill="none" stroke="currentColor"
                             stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="m20 20-4-4"/>
                        </svg>

                        <input type="text"
                               name="q"
                               value="{{ $q }}"
                               placeholder="Cari toko..."
                               class="w-full !pl-10 !py-2.5 !rounded-lg !bg-white text-sm">
                    </div>
                </form>
            </div>

            <div class="flex-1 divide-y divide-gray-100">

                @forelse($threads as $thread)

                    @php
                        $threadAktif =
                            (int) $thread->id_katalog === (int) $katalog->id_katalog
                            && (int) $thread->penerima_id === (int) $other;

                        $urlThread = auth()->user()->role === 'penjual'
                            ? route('chat.show', [
                                'katalog' => $thread->id_katalog,
                                'with' => $thread->penerima_id
                            ])
                            : route('chat.show', $thread->id_katalog);
                    @endphp

                    <a href="{{ $urlThread }}"
                       class="flex gap-3 p-4 transition
                       {{ $threadAktif ? 'bg-[#faf9f5] border-l-4 border-[#781d40]' : 'hover:bg-[#faf9f7]' }}">

                        <div class="w-11 h-11 rounded-full bg-[#efefea] overflow-hidden shrink-0 flex items-center justify-center">
                            @if($thread->barang->foto_utama)
                                <img src="{{ $thread->barang->foto_utama }}"
                                     alt="{{ $thread->barang->nama_barang }}"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">▧</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="flex justify-between gap-2">
                                <h3 class="font-bold text-sm text-[#351923] truncate">
                                    {{ $thread->nama_lawan_bicara }}
                                </h3>

                                <span class="text-[10px] text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($thread->waktu_kirim)->format('H:i') }}
                                </span>
                            </div>

                            <p class="text-xs text-gray-600 mt-2 truncate">
                                {{ $thread->isi_pesan }}
                            </p>

                            <p class="text-[11px] text-gray-400 mt-1 truncate">
                                {{ $thread->barang->nama_barang }}
                            </p>
                        </div>

                        @if($thread->jumlah_belum_dibaca > 0)
                            <span class="w-5 h-5 rounded-full bg-[#781d40] text-white text-[10px] flex items-center justify-center shrink-0">
                                {{ $thread->jumlah_belum_dibaca }}
                            </span>
                        @endif

                    </a>

                @empty

                    <div class="p-8 text-center">
                        <p class="text-sm font-bold text-gray-700">
                            Belum ada percakapan
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            Percakapan kamu akan muncul di sini.
                        </p>

                        <a href="{{ route('katalog.index') }}"
                           class="inline-block mt-4 px-5 py-3 rounded-xl bg-[#781d40] text-white text-xs font-bold">
                            Jelajahi Katalog
                        </a>
                    </div>

                @endforelse

            </div>

            <div class="p-4 text-center border-t border-gray-100">
                <p class="text-[10px] text-gray-400">
                    Tetap bertransaksi melalui UB Mager.
                </p>
            </div>

        </aside>

        {{-- DETAIL CHAT --}}
        <section class="min-w-0 flex flex-col">

            {{-- HEADER PENJUAL --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3">

                <div class="flex items-center gap-3 min-w-0">

                    <div class="w-10 h-10 rounded-full bg-[#efefea] overflow-hidden shrink-0 flex items-center justify-center">
                        @if($katalog->penjual->pengguna->foto ?? false)
                            <img src="{{ asset('storage/' . $katalog->penjual->pengguna->foto) }}"
                                 class="w-full h-full object-cover"
                                 alt="Foto penjual">
                        @else
                            <span class="text-gray-400">●</span>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <h2 class="font-extrabold text-sm text-[#351923] truncate">
                            {{ $isPembeli ? $katalog->penjual->nama_toko : ($lawanBicara->nama ?? 'Pembeli') }}
                        </h2>

                        <p class="text-xs mt-1 {{ $chatTersedia ? 'text-emerald-700' : 'text-gray-400' }}">
                            {{ $chatTersedia ? 'Online' : 'Tidak tersedia' }}
                        </p>
                    </div>

                </div>

                <span class="text-[11px] text-gray-400 whitespace-nowrap">
                    {{ $isPembeli ? 'Penjual · Terverifikasi' : 'Pembeli' }}
                </span>

            </div>

            {{-- INFORMASI BARANG --}}
            <div class="p-5 border-b border-gray-100">

                <div class="rounded-xl border border-gray-100 p-4 flex flex-wrap items-center gap-4">

                    <div class="w-16 h-16 rounded-lg bg-[#efefea] overflow-hidden shrink-0 flex items-center justify-center">
                        @if($katalog->foto_utama)
                            <img src="{{ $katalog->foto_utama }}"
                                 alt="{{ $katalog->nama_barang }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-xs text-gray-400">Foto barang</span>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-[#351923]">
                            {{ $katalog->nama_barang }}
                        </h3>

                        <p class="text-xl font-extrabold text-[#650d2b] mt-2">
                            Rp {{ number_format($katalog->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <a href="{{ route('katalog.show', $katalog) }}"
                       class="px-6 py-3 rounded-lg bg-[#c2d9ff] text-[#650d2b] text-sm font-bold hover:bg-[#a9caff] transition">
                        Lihat Barang
                    </a>

                </div>
            </div>

            {{-- RIWAYAT PESAN --}}
            <div id="chat-messages"
                 class="flex-1 min-h-[300px] max-h-[480px] overflow-y-auto bg-[#faf9f5] p-5 space-y-6">

                <p class="text-center text-[11px] text-gray-400">
                    Hari ini
                </p>

                @forelse($messages as $m)

                    @php
                        $pesanSaya =
                            (int) $m->id_pengirim === (int) auth()->user()->id_pengguna;
                    @endphp

                    <div class="flex {{ $pesanSaya ? 'justify-end' : 'justify-start' }}">

                        <div class="max-w-[82%] sm:max-w-[70%] rounded-2xl px-4 py-4
                            {{ $pesanSaya
                                ? 'bg-[#781d40] text-white rounded-br-sm'
                                : 'bg-[#efeee9] text-[#55494b] rounded-bl-sm' }}">

                            <p class="text-sm leading-relaxed whitespace-pre-line break-words">
                                {{ $m->isi_pesan }}
                            </p>

                            <p class="text-[10px] mt-3 text-right opacity-60">
                                {{ \Carbon\Carbon::parse($m->waktu_kirim)->format('H:i') }}
                            </p>

                        </div>
                    </div>

                @empty

                    <div class="flex items-center justify-center min-h-[220px]">
                        <p class="text-sm text-gray-500">
                            Belum ada pesan. Mulai percakapan.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- FORM KIRIM PESAN --}}
            <div class="p-5 bg-white border-t border-gray-100">

                @if(!$chatTersedia)

                    <div class="mb-3">
                        <h3 class="text-sm font-bold text-red-700">
                            Percakapan tidak dapat dilanjutkan
                        </h3>

                        <p class="text-xs text-gray-600 mt-2">
                            {{ $isPembeli
                                ? 'Akun penjual sedang ditangguhkan atau barang tidak tersedia.'
                                : 'Akun kamu atau lawan bicara sedang tidak aktif.' }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <input type="text"
                               disabled
                               value="Percakapan tidak tersedia"
                               class="flex-1 !bg-[#efeee9] !text-gray-400">

                        <button disabled
                                class="rounded-lg bg-gray-200 text-gray-500 px-7 py-3 text-sm font-bold cursor-not-allowed">
                            Kirim
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        Pesan sebelumnya tetap dapat dibaca.
                    </p>

                @else

                    <form method="POST"
                          action="{{ route('chat.send', $katalog) }}"
                          class="space-y-2">

                        @csrf

                        @if(!$isPembeli)
                            <input type="hidden" name="penerima" value="{{ $other }}">
                        @endif

                        <div class="flex items-end gap-3">

                            <textarea
                                name="isi_pesan"
                                rows="1"
                                required
                                maxlength="2000"
                                placeholder="Tulis pesan..."
                                class="flex-1 min-w-0 resize-none !rounded-lg !py-3 !px-4 text-sm"
                                oninput="this.style.height='auto'; this.style.height=Math.min(this.scrollHeight,120)+'px';"
                            >{{ old('isi_pesan') }}</textarea>

                            <button type="submit"
                                    class="shrink-0 rounded-lg bg-[#781d40] hover:bg-[#641632] text-white px-8 py-3 text-sm font-bold transition">
                                Kirim
                            </button>

                        </div>

                        @error('isi_pesan')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-400">
                            Sepakati titik COD di tempat umum. Hindari berbagi data pribadi.
                        </p>

                    </form>

                @endif

            </div>

        </section>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatMessages = document.getElementById('chat-messages');

    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>
@endsection
