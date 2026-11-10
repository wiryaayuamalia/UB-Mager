<?php

namespace App\Http\Controllers;

use App\Models\{Pesanan, Pembayaran, Katalog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function form(Request $r, Pesanan $pesanan)
    {
        abort_unless($pesanan->id_pembeli === $r->user()->id_pengguna, 403);
        return view('checkout.bayar', ['pesanan' => $pesanan->load('katalog')]);
    }

    // Upload bukti bayar (UI HRP-IM-001) -> verifikasi -> escrow
    public function upload(Request $r, Pesanan $pesanan)
    {
        abort_unless($pesanan->id_pembeli === $r->user()->id_pengguna, 403);
        $r->validate(['bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120']);

        if ($pesanan->status_pesanan !== 'menunggu pembayaran') {
            return back()->with('error', 'Pesanan tidak dalam status menunggu pembayaran.');
        }
        if (now()->gt($pesanan->batas_bayar)) {
            $this->batalkanOtomatis($pesanan);
            return redirect()->route('pesanan.saya')->with('error', 'Pesanan dibatalkan: batas waktu pembayaran terlampaui.');
        }

        $path = $r->file('bukti')->store('bukti-bayar', 'public');
        Pembayaran::where('id_pesanan', $pesanan->id_pesanan)->update([
            'bukti_pembayaran' => $path, 'waktu_bayar' => now(),
        ]);

        // Verifikasi (disederhanakan: bukti ada => dana ditahan di escrow)
        $ok = Pembayaran::where('id_pesanan', $pesanan->id_pesanan)->whereNotNull('bukti_pembayaran')
            ->update(['status_pembayaran' => 'escrow']);
        if (!$ok) {
            $this->batalkanOtomatis($pesanan);
            return back()->with('error', 'Pembayaran gagal diverifikasi, pesanan dibatalkan.');
        }
        $pesanan->update(['status_pesanan' => 'dikonfirmasi']);
        return redirect()->route('pesanan.saya')->with('ok', 'Pembayaran berhasil, dana ditahan di escrow.');
    }

    private function batalkanOtomatis(Pesanan $p): void
    {
        DB::transaction(function () use ($p) {
            $p->update(['status_pesanan' => 'dibatalkan']);
            Pembayaran::where('id_pesanan', $p->id_pesanan)->update(['status_pembayaran' => 'dibatalkan']);
            Katalog::where('id_katalog', $p->id_katalog)->increment('stok');
        });
    }

    // Pembeli konfirmasi barang diterima -> cairkan escrow ke saldo penjual
    public function konfirmasiTerima(Request $r, Pesanan $pesanan)
    {
        abort_unless($pesanan->id_pembeli === $r->user()->id_pengguna, 403);
        DB::transaction(function () use ($pesanan) {
            $pesanan->update(['status_pesanan' => 'selesai']);
            $bayar = Pembayaran::where('id_pesanan', $pesanan->id_pesanan)->first();
            if ($bayar && $bayar->status_pembayaran === 'escrow') {
                $bayar->update(['status_pembayaran' => 'dicairkan', 'waktu_pencairan' => now()]);
                $pesanan->penjual()->increment('saldo', $pesanan->harga_barang);
            }
        });
        return back()->with('ok', 'Pesanan selesai, dana dicairkan ke penjual.');
    }
}
