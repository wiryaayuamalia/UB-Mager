
@extends('layouts.app')

@section('title', 'Masuk')

@section('content')

<div class="max-w-md mx-auto bg-white rounded-2xl shadow p-6">

    {{-- JUDUL --}}
    <h1 class="text-xl font-bold text-maroon mb-4">
        Masuk
    </h1>

    {{-- FORM LOGIN --}}
    <form
        method="POST"
        action="{{ route('login') }}"
        class="space-y-3"
    >

        @csrf

        {{-- EMAIL / NOMOR HP --}}
        <div>

            <label class="text-sm font-semibold">
                Email / No. HP
            </label>

            <input
                type="text"
                name="kontak"
                value="{{ old('kontak') }}"
                class="w-full border rounded-lg px-3 py-2"
                required
            >

            @error('kontak')
                <p class="text-xs text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- PASSWORD --}}
        <div>

            <label class="text-sm font-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-lg px-3 py-2"
                required
            >

            @error('password')
                <p class="text-xs text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- TOMBOL MASUK --}}
        <button
            type="submit"
            class="w-full bg-maroon text-white rounded-lg py-2 font-semibold"
        >
            Masuk
        </button>

    </form>

    {{-- AKUN DEMO --}}
    <div class="text-xs text-gray-500 mt-4 leading-relaxed">

        Akun demo (password:
        <code>password</code>):

        <p class="mt-2">
            admin@ubmager.test
        </p>

        <p>
            penjual@ubmager.test
        </p>

        <p>
            pembeli@ubmager.test
        </p>

    </div>

</div>

@endsection
