<?php

namespace App\Http\Controllers;

use App\Models\{Keranjang, Katalog};
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index(Request $r)
    {
        $items = Keranjang::with('katalog.foto')->where('id_pengguna', $r->user()->id_pengguna)->get();
        return view('keranjang.index', compact('items'));
    }

    public function tambah(Request $r, Katalog $katalog)
    {
        abort_unless($katalog->status_katalog === 'aktif' && $katalog->stok > 0, 422, 'Barang tidak tersedia.');
        abort_if($r->user()->penjual && $r->user()->penjual->id_penjual === $katalog->id_penjual, 403, 'Anda tidak dapat membeli barang dari lapak sendiri.');
        Keranjang::firstOrCreate(
            ['id_pengguna' => $r->user()->id_pengguna, 'id_katalog' => $katalog->id_katalog],
            ['tanggal_ditambahkan' => now()]
        );
        return back()->with('ok', 'Ditambahkan ke keranjang.');
    }

    public function hapus(Request $r, Keranjang $keranjang)
    {
        abort_unless($keranjang->id_pengguna === $r->user()->id_pengguna, 403);
        $keranjang->delete();
        return back();
    }
}
