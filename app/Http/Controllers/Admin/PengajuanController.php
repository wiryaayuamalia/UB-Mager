<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PengajuanPenjual, Penjual, Admin};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'menunggu');
        abort_unless(in_array($status, ['menunggu','disetujui','ditolak']), 404);
        $query = PengajuanPenjual::with('pengguna')->where('status_pengajuan', $status);
        if ($request->filled('q')) $query->where(function ($builder) use ($request) {
            $builder->where('nama_toko','like','%'.$request->q.'%')->orWhereHas('pengguna', fn($user) => $user->where('nama','like','%'.$request->q.'%')->orWhere('nim','like','%'.$request->q.'%'));
        });
        $list = $query->latest('tanggal_pengajuan')->paginate(12)->withQueryString();
        return view('admin.pengajuan.index', compact('list','status'));
    }

    public function show(PengajuanPenjual $pengajuan)
    {
        $pengajuan->load('pengguna');
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function dokumen(PengajuanPenjual $pengajuan)
    {
        abort_unless(Storage::exists($pengajuan->dokumen_identitas), 404);
        return Storage::response($pengajuan->dokumen_identitas);
    }

    public function setujui(Request $request, PengajuanPenjual $pengajuan)
    {
        abort_unless($pengajuan->status_pengajuan === 'menunggu', 422, 'Pengajuan sudah diproses.');
        DB::transaction(function () use ($request, $pengajuan) {
            $user = $pengajuan->pengguna()->lockForUpdate()->firstOrFail();
            Penjual::firstOrCreate(['id_pengguna' => $user->id_pengguna], [
                'nama_toko' => $pengajuan->nama_toko, 'lokasi_toko' => $pengajuan->lokasi_toko,
                'kategori_spesialisasi' => $pengajuan->kategori_spesialisasi, 'titik_cod_favorit' => $user->titik_cod_favorit,
                'latitude' => $pengajuan->latitude, 'longitude' => $pengajuan->longitude,
                'saldo' => 0, 'rating_rata_rata' => 0, 'status_toko' => 'aktif',
            ]);
            $user->update(['role' => 'penjual']);
            $pengajuan->update(['status_pengajuan' => 'disetujui', 'id_admin' => $request->user()->admin?->id_admin]);
        });
        return redirect()->route('admin.pengajuan.show', $pengajuan)->with('ok', 'Pengajuan disetujui. Akun kini memiliki akses penjual.');
    }

    public function tolak(Request $request, PengajuanPenjual $pengajuan)
    {
        $request->validate(['alasan_penolakan' => 'required|string|min:5|max:1000']);
        abort_unless($pengajuan->status_pengajuan === 'menunggu', 422, 'Pengajuan sudah diproses.');
        $pengajuan->update(['status_pengajuan' => 'ditolak', 'alasan_penolakan' => $request->alasan_penolakan, 'id_admin' => $request->user()->admin?->id_admin]);
        return back()->with('ok', 'Pengajuan ditolak dan alasan disimpan.');
    }
}
