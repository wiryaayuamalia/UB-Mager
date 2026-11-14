<?php

namespace App\Http\Controllers;

use App\Models\{Pesanan, Pembayaran, Pengiriman, Katalog, Penjual};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderProcessingController extends Controller
{
    public function masuk(Request $r)
    {
        $pesanan = Pesanan::with(['katalog','pembeli'])->where('id_penjual', $r->user()->penjual->id_penjual)
            ->whereIn('status_pesanan', ['dikonfirmasi', 'disiapkan', 'dikirim'])->latest('tanggal_pesanan')->get();
        return view('penjual.pesanan', compact('pesanan'));
    }

    public function tolak(Request $r, Pesanan $pesanan)
    {
        $r->validate(['alasan_penolakan' => 'required|string|min:3']);
        abort_unless($pesanan->id_penjual === $r->user()->penjual->id_penjual, 403);
        abort_unless($pesanan->status_pesanan === 'dikonfirmasi', 422, 'Pesanan sudah diproses.');

        DB::transaction(function () use ($r, $pesanan) {
            $pesanan->update(['status_pesanan' => 'ditolak', 'alasan_penolakan' => $r->alasan_penolakan]);
            Pembayaran::where('id_pesanan', $pesanan->id_pesanan)->update(['status_pembayaran' => 'refund']);
            Katalog::where('id_katalog', $pesanan->id_katalog)->increment('stok');
        });
        return back()->with('ok', 'Pesanan ditolak, dana dikembalikan.');
    }

    public function setuju(Request $r, Pesanan $pesanan)
    {
        $penjual = $r->user()->penjual;
        abort_unless($pesanan->id_penjual === $penjual->id_penjual, 403);
        abort_unless($pesanan->status_pesanan === 'dikonfirmasi', 422, 'Pesanan tidak menunggu keputusan.');

        DB::transaction(function () use ($pesanan, $penjual) {
            $pesanan->update(['status_pesanan' => 'disiapkan']);
            Pengiriman::firstOrCreate(['id_pesanan' => $pesanan->id_pesanan], [
                'mitra_kurir' => $pesanan->metode_pengiriman === 'cod' ? 'COD' : 'GoSend',
                'alamat_jemput' => $penjual->lokasi_toko,
                'alamat_antar' => $pesanan->alamat_pengiriman,
                'status_pengiriman' => 'menunggu pickup',
            ]);
        });
        return back()->with('ok', 'Pesanan disiapkan.');
    }

    // Konfirmasi dari kurir: pickup | antar  (bisa dipanggil sebagai webhook / tombol simulasi)
    public function statusPengiriman(Request $r, Pesanan $pesanan)
    {
        $r->validate(['konfirmasi' => 'required|in:pickup']);
        abort_unless($pesanan->id_penjual === $r->user()->penjual->id_penjual, 403);
        abort_unless($pesanan->status_pesanan === 'disiapkan' && $r->konfirmasi === 'pickup', 422, 'Status pesanan tidak dapat diperbarui.');

        if ($r->konfirmasi === 'pickup') {
            $pesanan->update(['status_pesanan' => 'dikirim']);
            Pengiriman::where('id_pesanan', $pesanan->id_pesanan)->update(['status_pengiriman' => 'dikirim', 'waktu_pickup' => now()]);
        } else {
            Pengiriman::where('id_pesanan', $pesanan->id_pesanan)->update(['status_pengiriman' => 'diterima', 'waktu_diterima' => now()]);
        }
        return back()->with('ok', 'Status pengiriman diperbarui.');
    }
}
