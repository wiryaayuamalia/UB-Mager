<?php

namespace App\Http\Controllers;

use App\Models\{Katalog, Pesanan, Pembayaran, Notifikasi, Keranjang};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function hitungOngkir(string $metodePengiriman): int
    {
        return $metodePengiriman === 'kurir instan' ? 12000 : 0;   // tarif tetap
    }

    public function form(Request $r, Katalog $katalog)
    {
        abort_if($r->user()->penjual && $r->user()->penjual->id_penjual === $katalog->id_penjual, 403, 'Anda tidak dapat membeli barang dari lapak sendiri.');
        if ($katalog->stok < 1 || $katalog->status_katalog !== 'aktif') {
            return redirect()->route('keranjang.index')->with('error', 'Stok barang habis.');
        }
        return view('checkout.form', ['katalog' => $katalog->load('foto'), 'alamat' => $r->user()->alamat]);
    }

    // Langkah 6-11: kunci stok, simpan pesanan, buat tagihan, notifikasi penjual
    public function proses(Request $r, Katalog $katalog)
    {
        $r->validate([
            'alamat' => 'required|string|max:255',
            'metode_pengiriman' => 'required|in:kurir instan,cod',
            'metode_pembayaran' => 'required|in:transfer,e-wallet,tunai cod',
        ]);

        // COD hanya boleh tunai, kurir instan harus non-tunai
        if (($r->metode_pengiriman === 'cod') !== ($r->metode_pembayaran === 'tunai cod')) {
            return back()->withErrors(['metode_pembayaran' => 'COD harus memakai Tunai COD, Kurir Instan memakai Transfer/E-Wallet.'])->withInput();
        }

        try {
            $pesanan = DB::transaction(function () use ($r, $katalog) {
                $barang = Katalog::lockForUpdate()->findOrFail($katalog->id_katalog);   // cegah double checkout
                if ($barang->stok < 1 || $barang->status_katalog !== 'aktif') {
                    throw new \RuntimeException('Stok barang habis');
                }
                $barang->decrement('stok');

                $ongkir = $this->hitungOngkir($r->metode_pengiriman);
                $total = $barang->harga + $ongkir;
                $batas = $r->metode_pembayaran === 'tunai cod' ? null : now()->addMinutes(10);

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
                    'status_pesanan' => $r->metode_pembayaran === 'tunai cod' ? 'dikonfirmasi' : 'menunggu pembayaran',
                    'batas_bayar' => $batas,
                    'tanggal_pesanan' => now(),
                ]);

                Pembayaran::create([
                    'id_pesanan' => $p->id_pesanan,
                    'metode' => $r->metode_pembayaran,
                    'jumlah' => $total,
                    'status_pembayaran' => 'menunggu',
                ]);

                Notifikasi::create([
                    'id_pengguna' => $barang->penjual->id_pengguna,
                    'judul' => 'Pesanan baru',
                    'isi' => 'Ada pesanan baru: ' . $barang->nama_barang,
                    'jenis' => 'pesanan',
                    'waktu' => now(),
                ]);

                Keranjang::where('id_pengguna', $r->user()->id_pengguna)->where('id_katalog', $barang->id_katalog)->delete();
                return $p;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('keranjang.index')->with('error', $e->getMessage());
        }

        return $pesanan->metode_pembayaran === 'tunai cod'
            ? redirect()->route('pesanan.saya')->with('ok', 'Pesanan COD dikonfirmasi.')
            : redirect()->route('bayar.form', $pesanan)->with('ok', 'Pesanan dibuat. Selesaikan pembayaran dalam 10 menit.');
    }
}
