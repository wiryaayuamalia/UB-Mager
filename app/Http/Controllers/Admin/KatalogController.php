<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Katalog, Kategori, RentangHarga};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Katalog::with(['penjual.pengguna','kategori','foto'])->latest('created_at');
        if ($request->filled('status')) $query->where('status_katalog', $request->status);
        if ($request->filled('q')) $query->where('nama_barang','like','%'.$request->q.'%');
        $list = $query->paginate(15)->withQueryString();
        $kategori = Kategori::withCount('katalog')->orderBy('nama_kategori')->get();
        $rentang = RentangHarga::orderBy('harga_min')->get();
        return view('admin.katalog', compact('list','kategori','rentang'));
    }

    public function periksa(Request $request, Katalog $katalog)
    {
        $request->validate(['aksi' => 'required|in:aktifkan,nonaktifkan']);
        $katalog->update(['status_katalog' => $request->aksi === 'aktifkan' ? 'aktif' : 'nonaktif', 'status_kelengkapan' => 'lengkap']);
        return back()->with('ok', $request->aksi === 'aktifkan' ? 'Katalog berhasil ditayangkan.' : 'Katalog dinonaktifkan.');
    }

    public function tambahKategori(Request $request)
    {
        $request->validate(['nama_kategori'=>'required|string|max:50|unique:kategori,nama_kategori']);
        Kategori::create(['nama_kategori'=>trim($request->nama_kategori)]);
        return back()->with('ok','Kategori baru ditambahkan.');
    }

    public function hapusKategori(Kategori $kategori)
    {
        if ($kategori->katalog()->exists()) return back()->with('error','Kategori tidak dapat dihapus karena masih digunakan katalog.');
        $kategori->delete();
        return back()->with('ok','Kategori dihapus.');
    }

    public function rentangHarga(Request $request, RentangHarga $rentang)
    {
        $request->validate(['label'=>'required|string|max:50','harga_min'=>'required|numeric|min:0','harga_maks'=>'required|numeric|gte:harga_min']);
        $rentang->update($request->only('label','harga_min','harga_maks'));
        return back()->with('ok','Rentang harga diperbarui.');
    }
}
