<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPenjual;
use Illuminate\Http\Request;

class PengajuanPenjualController extends Controller
{
    public function form(Request $r)
    {
        $terakhir = PengajuanPenjual::where('id_pengguna', $r->user()->id_pengguna)->latest('id_pengajuan')->first();
        return view('penjual.pengajuan', compact('terakhir'));
    }

    public function store(Request $r)
    {
        $u = $r->user();
        abort_if($u->status_verifikasi !== 'terverifikasi', 403, 'Verifikasi OTP dulu.');
        $r->validate([
            'nama_toko' => 'required|max:100',
            'jenis_dokumen' => 'required|in:KTP,KTM',
            'dokumen' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',   // NFR-15
            'lokasi_toko' => 'required|max:255',
            'latitude' => 'required|numeric|between:-8.3,-7.8',     // area Malang-Batu
            'longitude' => 'required|numeric|between:112.4,112.8',
        ], [
            'latitude.between' => 'Lokasi di luar wilayah Malang–Batu.',
            'longitude.between' => 'Lokasi di luar wilayah Malang–Batu.',
        ]);

        if (PengajuanPenjual::where('id_pengguna', $u->id_pengguna)->where('status_pengajuan', 'menunggu')->exists()) {
            return back()->with('error', 'Pengajuan Anda masih menunggu review.');
        }

        PengajuanPenjual::create([
            'id_pengguna' => $u->id_pengguna,
            'nama_toko' => $r->nama_toko,
            'jenis_dokumen' => $r->jenis_dokumen,
            'dokumen_identitas' => $r->file('dokumen')->store('dokumen-identitas'),   // disk private
            'lokasi_toko' => $r->lokasi_toko,
            'latitude' => $r->latitude,
            'longitude' => $r->longitude,
            'status_pengajuan' => 'menunggu',
            'tanggal_pengajuan' => now(),
        ]);
        return back()->with('ok', 'Pengajuan terkirim, menunggu verifikasi admin.');
    }
}
