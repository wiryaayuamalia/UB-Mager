<?php

namespace App\Http\Controllers;

use App\Models\{Katalog, Kategori, FotoKatalog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public const LOKASI = [
        'Dekat Gerbang Veteran UB', 'Jl. Soekarno-Hatta (Suhat)', 'Sigura-gura',
        'Kampus UM', 'Area Batu', 'Dinoyo', 'Gedung FILKOM UB', 'Fakultas Teknik UB',
    ];

    // PGN-UR-04/05/06/07: dashboard + search + filter + validasi
    public function index(Request $r)
    {
        $r->validate([
            'min' => 'nullable|numeric|min:0',
            'maks' => 'nullable|numeric|min:0|gte:min',
            'lokasi' => 'nullable|in:' . implode(',', self::LOKASI),
        ], [
            'maks.gte' => 'Harga minimum tidak boleh lebih besar dari harga maksimum.',
            'min.numeric' => 'Harga hanya boleh angka.',
            'maks.numeric' => 'Harga hanya boleh angka.',
        ]);

        $q = Katalog::with(['foto', 'kategori', 'penjual'])
            ->where('status_katalog', 'aktif')->where('stok', '>', 0);   // SRS-08: hanya katalog aktif

        if ($r->filled('q'))        $q->where('nama_barang', 'like', '%' . $r->q . '%');
        if ($r->filled('kategori')) $q->where('id_kategori', $r->kategori);
        if ($r->filled('lokasi'))   $q->where('lokasi', $r->lokasi);
        if ($r->filled('min'))      $q->where('harga', '>=', $r->min);
        if ($r->filled('maks'))     $q->where('harga', '<=', $r->maks);
        if ($r->tab === 'terbaru')  $q->where('created_at', '>=', now()->startOfDay());

        return view('katalog.index', [
            'katalog' => $q->latest('created_at')->paginate(8)->withQueryString(),
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'lokasi' => self::LOKASI,
        ]);
    }

    public function show(Katalog $katalog)
    {
        $katalog->load(['foto', 'kategori', 'penjual.pengguna']);
        return view('katalog.show', compact('katalog'));
    }

    // ---- Penjual: unggah katalog (PNJ-UR-04) ----
    public function create()
    {
        return view('katalog.create', ['kategori' => Kategori::all(), 'lokasi' => self::LOKASI]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'nama_barang' => 'required|max:150',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|gt:0',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'kondisi' => 'required|max:50',
            'lokasi' => 'required|in:' . implode(',', self::LOKASI),
            'stok' => 'nullable|integer|min:1',
            'foto' => 'required|array|min:1|max:6',
            'foto.*' => 'image|max:5120',
        ]);

        DB::transaction(function () use ($r, &$k) {
            $k = Katalog::create([
                'id_penjual' => $r->user()->penjual->id_penjual,
                'id_kategori' => $r->id_kategori,
                'nama_barang' => $r->nama_barang,
                'deskripsi' => $r->deskripsi,
                'harga' => $r->harga,
                'kondisi' => $r->kondisi,
                'lokasi' => $r->lokasi,
                'stok' => $r->stok ?? 1,
                'bisa_nego' => $r->boolean('bisa_nego'),
                'status_katalog' => 'menunggu pemeriksaan',
            ]);
            foreach ($r->file('foto') as $i => $f) {
                FotoKatalog::create(['id_katalog' => $k->id_katalog, 'path_foto' => $f->store('katalog', 'public'), 'urutan' => $i + 1]);
            }
        });
        return redirect()->route('penjual.dashboard')->with('ok', 'Katalog tersimpan, menunggu pemeriksaan admin.');
    }

    public function export(Request $r)
    {
        $sellerId = $r->user()->penjual->id_penjual;
        $items = Katalog::with('kategori')->where('id_penjual', $sellerId)->orderBy('nama_barang')->get();
        return response()->streamDownload(function () use ($items) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID','Nama Barang','Kategori','Harga','Kondisi','Lokasi','Stok','Status']);
            foreach ($items as $item) fputcsv($out, [$item->id_katalog,$item->nama_barang,$item->kategori?->nama_kategori,$item->harga,$item->kondisi,$item->lokasi,$item->stok,$item->status_katalog]);
            fclose($out);
        }, 'inventaris-ub-mager.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function edit(Request $r, Katalog $katalog)
    {
        abort_unless($katalog->id_penjual === $r->user()->penjual->id_penjual, 403);
        return view('katalog.edit', ['katalog' => $katalog->load('foto'), 'kategori' => Kategori::all(), 'lokasi' => self::LOKASI]);
    }

    public function update(Request $r, Katalog $katalog)
    {
        abort_unless($katalog->id_penjual === $r->user()->penjual->id_penjual, 403);
        $r->validate([
            'nama_barang' => 'required|max:150', 'deskripsi' => 'required', 'harga' => 'required|numeric|gt:0',
            'id_kategori' => 'required|exists:kategori,id_kategori', 'kondisi' => 'required|max:50',
            'lokasi' => 'required|in:' . implode(',', self::LOKASI), 'stok' => 'required|integer|min:0',
            'foto' => 'nullable|array|max:6', 'foto.*' => 'image|max:5120',
        ]);
        if ($katalog->foto()->count() + count($r->file('foto', [])) > 6) {
            return back()->withErrors(['foto' => 'Jumlah foto barang maksimal 6.'])->withInput();
        }
        $katalog->update($r->only('nama_barang','deskripsi','harga','id_kategori','kondisi','lokasi','stok') + ['bisa_nego' => $r->boolean('bisa_nego'), 'status_katalog' => 'menunggu pemeriksaan']);
        foreach ($r->file('foto', []) as $i => $f) {
            FotoKatalog::create(['id_katalog'=>$katalog->id_katalog,'path_foto'=>$f->store('katalog','public'),'urutan'=>$katalog->foto()->count()+$i+1]);
        }
        return redirect()->route('penjual.dashboard')->with('ok','Perubahan katalog disimpan dan masuk antrean pemeriksaan.');
    }

    public function preview(Request $r)
    {
        $seller = $r->user()->penjual;
        abort_unless($seller, 403);
        $katalog = Katalog::with(['foto','kategori'])->where('id_penjual',$seller->id_penjual)->where('status_katalog','aktif')->latest('created_at')->get();
        return view('penjual.preview', compact('seller','katalog'));
    }

    public function destroy(Request $r, Katalog $katalog)
    {
        abort_unless($katalog->id_penjual === $r->user()->penjual->id_penjual, 403);
        $katalog->update(['status_katalog' => 'nonaktif']);
        return back()->with('ok', 'Katalog dinonaktifkan.');
    }
}
