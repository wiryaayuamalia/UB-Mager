<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPenjual;
use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'semua');

        abort_unless(
            in_array($status, ['semua', 'menunggu', 'disetujui', 'ditolak']),
            404
        );

        // Hitung jumlah pengajuan untuk setiap tab.
        $jumlah = [
            'semua' => PengajuanPenjual::count(),
            'menunggu' => PengajuanPenjual::where('status_pengajuan', 'menunggu')->count(),
            'disetujui' => PengajuanPenjual::where('status_pengajuan', 'disetujui')->count(),
            'ditolak' => PengajuanPenjual::where('status_pengajuan', 'ditolak')->count(),
        ];

        // Ambil data pengajuan.
        $query = PengajuanPenjual::with('pengguna');

        if ($status !== 'semua') {
            $query->where('status_pengajuan', $status);
        }

        // Pencarian nama mahasiswa, NIM, dan nama toko.
        if ($request->filled('q')) {
            $keyword = $request->q;

            $query->where(function ($builder) use ($keyword) {
                $builder->where('nama_toko', 'like', "%{$keyword}%")
                    ->orWhereHas('pengguna', function ($user) use ($keyword) {
                        $user->where('nama', 'like', "%{$keyword}%")
                            ->orWhere('nim', 'like', "%{$keyword}%");
                    });
            });
        }

        $list = $query
            ->latest('tanggal_pengajuan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan.index', compact(
            'list',
            'status',
            'jumlah'
        ));
    }

    public function show(PengajuanPenjual $pengajuan)
    {
        $pengajuan->load('pengguna');

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function dokumen(PengajuanPenjual $pengajuan)
    {
        abort_unless(
            Storage::exists($pengajuan->dokumen_identitas),
            404
        );

        return Storage::response($pengajuan->dokumen_identitas);
    }

    public function setujui(Request $request, PengajuanPenjual $pengajuan)
    {
        abort_unless(
            $pengajuan->status_pengajuan === 'menunggu',
            422,
            'Pengajuan sudah diproses.'
        );

        DB::transaction(function () use ($request, $pengajuan) {

            $user = $pengajuan->pengguna()
                ->lockForUpdate()
                ->firstOrFail();

            Penjual::firstOrCreate(
                ['id_pengguna' => $user->id_pengguna],
                [
                    'nama_toko' => $pengajuan->nama_toko,
                    'lokasi_toko' => $pengajuan->lokasi_toko,
                    'kategori_spesialisasi' => $pengajuan->kategori_spesialisasi,
                    'titik_cod_favorit' => $user->titik_cod_favorit,
                    'latitude' => $pengajuan->latitude,
                    'longitude' => $pengajuan->longitude,
                    'saldo' => 0,
                    'rating_rata_rata' => 0,
                    'status_toko' => 'aktif',
                ]
            );

            $user->update([
                'role' => 'penjual'
            ]);

            $pengajuan->update([
                'status_pengajuan' => 'disetujui',
                'id_admin' => $request->user()->admin?->id_admin,
            ]);
        });

        return redirect()
            ->route('admin.pengajuan.show', $pengajuan)
            ->with('ok', 'Pengajuan disetujui. Akun kini memiliki akses penjual.');
    }

    public function tolak(Request $request, PengajuanPenjual $pengajuan)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:5|max:1000'
        ]);

        abort_unless(
            $pengajuan->status_pengajuan === 'menunggu',
            422,
            'Pengajuan sudah diproses.'
        );

        $pengajuan->update([
            'status_pengajuan' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'id_admin' => $request->user()->admin?->id_admin,
        ]);

        return back()->with('ok', 'Pengajuan ditolak dan alasan disimpan.');
    }
}
