
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="text-sm text-gray-500 mt-1">
                Semua informasi dan aktivitas akun kamu.
            </p>
        </div>

        @if($jumlahBelumDibaca > 0)
            <form action="{{ route('notifikasi.baca-semua') }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('ok'))
        <div class="mb-4 p-3 rounded-xl bg-green-50 text-green-700 text-sm">
            {{ session('ok') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        @forelse($notifikasi as $item)
            <div class="p-5 border-b border-gray-100 flex gap-4
                {{ $item->sudah_dibaca ? 'bg-white' : 'bg-blue-50/60' }}">

                <div class="w-11 h-11 rounded-full flex-shrink-0 flex items-center justify-center
                    {{ $item->sudah_dibaca ? 'bg-gray-100 text-gray-500' : 'bg-blue-100 text-blue-600' }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 00-4-5.65V5a2 2 0 10-4 0v.35A6 6 0 006 11v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 01-6 0" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="font-semibold text-gray-900">
                            {{ $item->judul }}
                        </h3>

                        @if(!$item->sudah_dibaca)
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                Baru
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 mt-1">
                        {{ $item->isi }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mt-3">
                        <span class="text-xs text-gray-400">
                            {{ $item->waktu }}
                        </span>

                        @if(!$item->sudah_dibaca)
                            <form action="{{ route('notifikasi.baca', $item->id_notifikasi) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                    Tandai sudah dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-16 px-5 text-center">
                <div>
                </div>
                <h3 class="font-semibold text-gray-800">
                    Belum ada notifikasi
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                    Notifikasi aktivitas akun kamu akan muncul di sini.
                </p>
            </div>
        @endforelse

    </div>

    <div class="mt-5">
        {{ $notifikasi->links() }}
    </div>

</div>
@endsection
