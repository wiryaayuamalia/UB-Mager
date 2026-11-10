<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PengajuanPenjual, Penjual, Notifikasi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};

class PengajuanController extends Controller
{
    public function index(Request $r)
    {
        $status = $r->get('status', 'menunggu');
        $list = PengajuanPenjual::with('pengguna')->where('status_pengajuan', $status)->latest('tanggal_pengajuan')->paginate(10);
        return view('admin.pengajuan.index', compact('list', 'status'));
    }

    public function show(PengajuanPenjual $pengajuan)
    {
        $pengajuan->load('pengguna');
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    // Dokumen identitas hanya bisa diakses admin
    public function dokumen(PengajuanPenjual $pengajuan)
    {
        return Storage::response($pengajuan->dokumen_identitas);
    }

    public function setujui(Request $r, PengajuanPenjual $pengajuan)
    {
        abort_unless($pengajuan->status_pengajuan === 'menunggu', 422);
        DB::transaction(function () use ($r, $pengajuan) {
            $pengajuan->update(['status_pengajuan' => 'disetujui', 'id_admin' => $r->user()->admin->id_admin]);
            Penjual::updateOrCreate(['id_pengguna' => $pengajuan->id_pengguna], [
                'nama_toko' => $pengajuan->nama_toko, 'lokasi_toko' => $pengajuan->lokasi_toko,
                'latitude' => $pengajuan->latitude, 'longitude' => $pengajuan->longitude,
                'status_toko' => 'aktif',
            ]);
            $pengajuan->pengguna->update(['role' => 'penjual']);
            Notifikasi::create([
                'id_pengguna' => $pengajuan->id_pengguna, 'judul' => 'Pengajuan disetujui',
                'isi' => 'Selamat! Toko ' . $pengajuan->nama_toko . ' aktif.', 'jenis' => 'verifikasi', 'waktu' => now(),
            ]);
        });
        return redirect()->route('admin.pengajuan.index')->with('ok', 'Pengajuan disetujui.');
    }

    public function tolak(Request $r, PengajuanPenjual $pengajuan)
    {
        $r->validate(['alasan_penolakan' => 'required|string|min:3']);
        $pengajuan->update([
            'status_pengajuan' => 'ditolak', 'alasan_penolakan' => $r->alasan_penolakan,
            'id_admin' => $r->user()->admin->id_admin,
        ]);
        Notifikasi::create([
            'id_pengguna' => $pengajuan->id_pengguna, 'judul' => 'Pengajuan ditolak',
            'isi' => 'Alasan: ' . $r->alasan_penolakan . '. Anda dapat mengajukan ulang.', 'jenis' => 'verifikasi', 'waktu' => now(),
        ]);
        return redirect()->route('admin.pengajuan.index')->with('ok', 'Pengajuan ditolak.');
    }
}
