
@extends('layouts.app')

@section('title', 'Chat Saya')

@section('content')
<div class="max-w-[1450px] mx-auto">

    <div class="mb-6">
        <p class="text-xs text-gray-400 font-semibold">UB Mager / Chat</p>
        <h1 class="text-3xl font-extrabold text-[#24232a] mt-2">Pesan Saya</h1>
        <p class="text-sm text-gray-500 mt-1">
            Hubungi penjual dan lanjutkan percakapan tentang barang yang kamu minati.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[370px_1fr] gap-5">

        {{-- DAFTAR PERCAKAPAN --}}
        <section class="bg-white rounded-2xl border border-[#eceae3] overflow-hidden">

            <div class="p-5 border-b border-gray-100">
                <h2 class="font-extrabold text-lg">Semua Pesan</h2>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $threads->count() }} percakapan
                </p>

                <form method="GET" action="{{ route('chat.index') }}" class="mt-4 relative">
                    <input
                        type="text"
                        name="q"
                        value="{{ $q }}"
                        placeholder="Cari toko atau barang..."
                        class="w-full !rounded-xl !pl-10 !bg-[#faf9f7]"
                    >
                    <svg class="absolute left-3 top-3 text-gray-400"
                         width="19" height="19" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>
                </form>
            </div>

            <div class="divide-y divide-gray-100">

                @forelse($threads as $thread)
                    <a href="{{ route('chat.show', $thread->barang->id_katalog) }}"
                       class="flex gap-3 p-4 hover:bg-[#faf7f8] transition">

                        <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden shrink-0">
                            @if($thread->barang->foto_utama)
                                <img src="{{ $thread->barang->foto_utama }}"
                                     class="w-full h-full object-cover"
                                     alt="Foto barang">
                            @else
                                <div class="h-full grid place-items-center text-gray-400">▧</div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between gap-2">
                                <h3 class="font-bold text-sm truncate">
                                    {{ $thread->nama_lawan_bicara }}
                                </h3>

                                <span class="text-[10px] text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($thread->waktu_kirim)->format('H:i') }}
                                </span>
                            </div>

                            <p class="text-xs text-[#781d40] font-semibold mt-1 truncate">
                                {{ $thread->barang->nama_barang }}
                            </p>

                            <p class="text-xs text-gray-500 truncate mt-1">
                                {{ $thread->isi_pesan }}
                            </p>
                        </div>

                        @if($thread->jumlah_belum_dibaca > 0)
                            <span class="w-5 h-5 rounded-full bg-[#781d40] text-white text-[10px] grid place-items-center shrink-0">
                                {{ $thread->jumlah_belum_dibaca }}
                            </span>
                        @endif

                    </a>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-16 h-16 rounded-full bg-[#f8edf1] text-[#781d40] mx-auto grid place-items-center mb-4">
                            <svg width="30" height="30" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5z"/>
                            </svg>
                        </div>

                        <h3 class="font-bold text-gray-800">Belum ada percakapan</h3>
                        <p class="text-xs text-gray-500 mt-2">
                            Pesan kepada penjual akan muncul di sini.
                        </p>

                        <a href="{{ route('katalog.index') }}"
                           class="inline-block mt-5 px-5 py-3 rounded-xl bg-[#781d40] text-white text-xs font-bold">
                            Jelajahi Katalog
                        </a>
                    </div>
                @endforelse

            </div>
        </section>

        {{-- PANEL KANAN --}}
        <section class="bg-white rounded-2xl border border-[#eceae3] min-h-[550px] flex flex-col items-center justify-center text-center p-8">

            <div class="w-24 h-24 rounded-full bg-[#f8edf1] text-[#781d40] grid place-items-center mb-5">
                <svg width="42" height="42" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5z"/>
                </svg>
            </div>

            <h2 class="text-xl font-extrabold text-gray-800">
                Pilih Percakapan
            </h2>

            <p class="text-sm text-gray-500 mt-2 max-w-sm">
                Pilih salah satu percakapan di sebelah kiri untuk mulai membaca dan mengirim pesan.
            </p>

        </section>

    </div>
</div>
@endsection
