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

    public function updateTitikCod(Request $r)
    {
        $r->validate(['titik_cod_favorit' => 'required|string|max:150']);
        $r->user()->penjual()->update(['titik_cod_favorit' => $r->titik_cod_favorit]);
        return back()->with('ok', 'Titik temu COD favorit lapak diperbarui.');
    }

    public function dashboardPenjual(Request $r)
    {
        $query = Katalog::with(['foto','kategori'])->where('id_penjual', $r->user()->penjual->id_penjual);
        if ($r->filled('q')) $query->where('nama_barang', 'like', '%' . $r->q . '%');
        if ($r->filled('status')) $query->where('status_katalog', $r->status);
        $katalog = $query->latest('created_at')->get();
        return view('penjual.dashboard', compact('katalog'));
    }
}
