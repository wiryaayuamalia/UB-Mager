<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index()
    {
        $list = Katalog::with('penjual')->latest('created_at')->paginate(15);
        return view('admin.katalog', compact('list'));
    }

    // ADM-UR-05/06: periksa kelengkapan & aktifkan/nonaktifkan
    public function periksa(Request $r, Katalog $katalog)
    {
        $r->validate(['aksi' => 'required|in:aktifkan,nonaktifkan']);
        $lengkap = $katalog->foto()->exists() && $katalog->harga > 0 && $katalog->id_kategori && $katalog->deskripsi;
        $katalog->update([
            'status_kelengkapan' => $lengkap ? 'lengkap' : 'tidak lengkap',
            'status_katalog' => ($r->aksi === 'aktifkan' && $lengkap) ? 'aktif' : 'nonaktif',
        ]);
        return back()->with('ok', 'Katalog diperbarui (' . ($lengkap ? 'lengkap' : 'tidak lengkap') . ').');
    }
}
