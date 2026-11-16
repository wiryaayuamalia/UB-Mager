<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notifikasi = DB::table('notifikasi')
            ->where('id_pengguna', $user->id_pengguna)
            ->orderByDesc('waktu')
            ->paginate(10);

        $jumlahBelumDibaca = DB::table('notifikasi')
            ->where('id_pengguna', $user->id_pengguna)
            ->where('sudah_dibaca', false)
            ->count();

        return view('notifikasi.index', compact(
            'notifikasi',
            'jumlahBelumDibaca'
        ));
    }

    public function baca(Request $request, $id)
    {
        DB::table('notifikasi')
            ->where('id_notifikasi', $id)
            ->where('id_pengguna', $request->user()->id_pengguna)
            ->update([
                'sudah_dibaca' => true
            ]);

        return back()->with('ok', 'Notifikasi ditandai sudah dibaca.');
    }

    public function bacaSemua(Request $request)
    {
        DB::table('notifikasi')
            ->where('id_pengguna', $request->user()->id_pengguna)
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true
            ]);

        return back()->with('ok', 'Semua notifikasi sudah dibaca.');
    }
}
