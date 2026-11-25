<?php

namespace App\Http\Controllers;

use App\Models\{Katalog, Pesanan, Pembayaran, Notifikasi, Keranjang};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function form(Request $r, Katalog $katalog)
    {
        abort_if(
            $r->user()->penjual &&
            $r->user()->penjual->id_penjual === $katalog->id_penjual,
            403,
            'Anda tidak dapat membeli barang dari lapak sendiri.'
        );

        if ($katalog->stok < 1 || $katalog->status_katalog !== 'aktif') {
            return redirect()->route('keranjang.index')
                ->with('error', 'Stok barang habis.');
        }

        return view('checkout.form', [
            'katalog' => $katalog->load('foto'),
            'alamat' => $r->user()->alamat
        ]);
    }

    public function proses(Request $r, Katalog $katalog)
    {
        $r->validate([
            'alamat' => 'required|string|max:255',
            'metode_pengiriman' => 'required|in:kurir instan,cod',
            'metode_pembayaran' => 'required|in:transfer,e-wallet,tunai cod',
        ]);

        // COD menggunakan pembayaran tunai.
        // Kurir instan menggunakan transfer atau e-wallet.
        if (($r->metode_pengiriman === 'cod') !== ($r->metode_pembayaran === 'tunai cod')) {
            return back()
                ->withErrors([
                    'metode_pembayaran' => 'COD harus memakai Tunai COD, sedangkan Kurir Instan memakai Transfer/E-Wallet.'
                ])
                ->withInput();
        }

        try {
            $pesanan = DB::transaction(function () use ($r, $katalog) {

                $barang = Katalog::lockForUpdate()
                    ->findOrFail($katalog->id_katalog);

                if ($barang->stok < 1 || $barang->status_katalog !== 'aktif') {
                    throw new \RuntimeException('Stok barang habis.');
                }

                // Kurangi stok barang.
                $barang->decrement('stok');

                // Ongkir tidak dihitung oleh sistem.
                // Biaya kurir diatur langsung oleh penjual dan pembeli.
                $ongkir = 0;

                // Total pembayaran sistem hanya harga barang.
                $total = $barang->harga;

                $batas = $r->metode_pembayaran === 'tunai cod'
                    ? null
                    : now()->addMinutes(10);

                $p = Pesanan::create([
                    'id_pembeli' => $r->user()->id_pengguna,
                    'id_penjual' => $barang->id_penjual,
                    'id_katalog' => $barang->id_katalog,
                    'alamat_pengiriman' => $r->alamat,
                    'metode_pengiriman' => $r->metode_pengiriman,
                    'metode_pembayaran' => $r->metode_pembayaran,
                    'harga_barang' => $barang->harga,
                    'ongkir' => $ongkir,
                    'total_bayar' => $total,
                    'status_pesanan' => $r->metode_pembayaran === 'tunai cod'
                        ? 'dikonfirmasi'
                        : 'menunggu pembayaran',
                    'batas_bayar' => $batas,
                    'tanggal_pesanan' => now(),
                ]);

                // Buat data pembayaran.
                Pembayaran::create([
                    'id_pesanan' => $p->id_pesanan,
                    'metode' => $r->metode_pembayaran,
                    'jumlah' => $total,
                    'status_pembayaran' => 'menunggu',
                ]);

                // Notifikasi untuk penjual.
                Notifikasi::create([
                    'id_pengguna' => $barang->penjual->id_pengguna,
                    'judul' => 'Pesanan baru',
                    'isi' => 'Ada pesanan baru: ' . $barang->nama_barang,
                    'jenis' => 'pesanan',
                    'waktu' => now(),
                ]);

                // Notifikasi untuk pembeli.
                Notifikasi::create([
                    'id_pengguna' => $r->user()->id_pengguna,
                    'judul' => 'Pesanan berhasil dibuat',
                    'isi' => 'Pesanan ' . $barang->nama_barang .
                        ' berhasil dibuat. Silakan cek status pesanan kamu.',
                    'jenis' => 'pesanan',
                    'waktu' => now(),
                ]);

                // Hapus barang dari keranjang.
                Keranjang::where('id_pengguna', $r->user()->id_pengguna)
                    ->where('id_katalog', $barang->id_katalog)
                    ->delete();

                return $p;
            });

        } catch (\RuntimeException $e) {
            return redirect()->route('keranjang.index')
                ->with('error', $e->getMessage());
        }

        return $pesanan->metode_pembayaran === 'tunai cod'
            ? redirect()->route('pesanan.saya')
                ->with('ok', 'Pesanan COD berhasil dikonfirmasi.')
            : redirect()->route('bayar.form', $pesanan)
                ->with('ok', 'Pesanan dibuat. Silakan selesaikan pembayaran barang dalam 10 menit.');
    }
}
