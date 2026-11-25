@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow p-6">

        {{-- JUDUL --}}
        <h1 class="text-xl font-bold text-maroon mb-1">
            Checkout
        </h1>

        {{-- INFORMASI BARANG --}}
        <p class="mb-4">
            <b>{{ $katalog->nama_barang }}</b>
            —
            Rp {{ number_format($katalog->harga, 0, ',', '.') }}
        </p>

        {{-- FORM CHECKOUT --}}
        <form
            method="POST"
            action="{{ route('checkout.proses', $katalog) }}"
            class="space-y-3"
        >
            @csrf

            {{-- ALAMAT PENGIRIMAN --}}
            <div>
                <label class="text-sm font-semibold">
                    Alamat pengiriman (area Malang–Batu)
                </label>

                <input
                    type="text"
                    name="alamat"
                    value="{{ old('alamat', $alamat) }}"
                    class="w-full border rounded-lg px-3 py-2"
                    required
                >
            </div>

            {{-- METODE PENGIRIMAN --}}
            <div>
                <label class="text-sm font-semibold">
                    Metode pengiriman
                </label>

                <select
                    name="metode_pengiriman"
                    id="metode_pengiriman"
                    class="w-full border rounded-lg px-3 py-2"
                    required
                >
                    <option value="kurir instan"
                        {{ old('metode_pengiriman', 'kurir instan') === 'kurir instan' ? 'selected' : '' }}>
                        Kurir (diatur penjual)
                    </option>

                    <option value="cod"
                        {{ old('metode_pengiriman') === 'cod' ? 'selected' : '' }}>
                        COD (ketemuan)
                    </option>
                </select>

                {{-- INFORMASI PENGIRIMAN --}}
                <div id="info-kurir"
                    class="mt-2 p-3 rounded-lg bg-yellow-50 border border-yellow-200 text-sm text-gray-700">
                    <b>Informasi pengiriman:</b>
                    <p class="mt-1">
                        Penjual akan membantu memesankan kurir untuk pengiriman barang.
                        Biaya kurir akan diinformasikan dan disepakati langsung antara
                        pembeli dan penjual, di luar pembayaran UB-Mager.
                    </p>
                </div>

                <div id="info-cod"
                    class="mt-2 p-3 rounded-lg bg-gray-50 border text-sm text-gray-700 hidden">
                    <b>Informasi COD:</b>
                    <p class="mt-1">
                        Pembeli dan penjual akan mengatur pertemuan secara langsung
                        untuk melakukan serah terima barang.
                    </p>
                </div>
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div>
                <label class="text-sm font-semibold">
                    Metode pembayaran
                </label>

                <select
                    name="metode_pembayaran"
                    id="metode_pembayaran"
                    class="w-full border rounded-lg px-3 py-2"
                    required
                >
                    <option value="transfer"
                        {{ old('metode_pembayaran', 'transfer') === 'transfer' ? 'selected' : '' }}>
                        Transfer Bank
                    </option>

                    <option value="e-wallet"
                        {{ old('metode_pembayaran') === 'e-wallet' ? 'selected' : '' }}>
                        E-Wallet
                    </option>

                    <option value="tunai cod"
                        {{ old('metode_pembayaran') === 'tunai cod' ? 'selected' : '' }}>
                        Tunai COD
                    </option>
                </select>
            </div>

            {{-- TOTAL PEMBAYARAN --}}
            <div class="border-t pt-3">
                <div class="flex justify-between text-sm">
                    <span>Harga barang</span>
                    <span>
                        Rp {{ number_format($katalog->harga, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between font-bold mt-2">
                    <span>Total pembayaran UB-Mager</span>
                    <span class="text-maroon">
                        Rp {{ number_format($katalog->harga, 0, ',', '.') }}
                    </span>
                </div>

                <p class="text-xs text-gray-500 mt-2">
                    Biaya kurir tidak termasuk dalam total pembayaran UB-Mager
                    dan akan diatur langsung oleh penjual bersama pembeli.
                </p>
            </div>

            {{-- TOMBOL KONFIRMASI --}}
            <button
                type="submit"
                class="w-full bg-maroon text-white rounded-lg py-2 font-semibold"
            >
                Konfirmasi Pesanan
            </button>
        </form>

    </div>

    {{-- INTERAKSI METODE PENGIRIMAN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pengiriman = document.getElementById('metode_pengiriman');
            const pembayaran = document.getElementById('metode_pembayaran');
            const infoKurir = document.getElementById('info-kurir');
            const infoCod = document.getElementById('info-cod');

            function updateMetode() {
                const isCod = pengiriman.value === 'cod';

                infoKurir.classList.toggle('hidden', isCod);
                infoCod.classList.toggle('hidden', !isCod);

                const opsiTunai = pembayaran.querySelector(
                    'option[value="tunai cod"]'
                );

                opsiTunai.disabled = !isCod;

                if (!isCod && pembayaran.value === 'tunai cod') {
                    pembayaran.value = 'transfer';
                }

                if (isCod && !['transfer', 'e-wallet', 'tunai cod'].includes(pembayaran.value)) {
                    pembayaran.value = 'tunai cod';
                }
            }

            pengiriman.addEventListener('change', updateMetode);
            updateMetode();
        });
    </script>
@endsection
