<?php

namespace App\Http\Controllers;

use App\Models\{Pesanan, Katalog};
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function saya(Request $r)
    {
        $pesanan = Pesanan::with(['katalog', 'pembayaran', 'pengiriman'])
            ->where('id_pembeli', $r->user()->id_pengguna)->latest('tanggal_pesanan')->get();
        return view('pesanan.saya', compact('pesanan'));
    }

    public function dashboardPenjual(Request $r)
    {
        $katalog = Katalog::with('foto')->where('id_penjual', $r->user()->penjual->id_penjual)->latest('created_at')->get();
        return view('penjual.dashboard', compact('katalog'));
    }
}
