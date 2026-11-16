<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notifikasiDefault = [
            'pesanan' => true,
            'chat' => true,
            'cod' => true,
            'promo' => false,
            'whatsapp' => false,
        ];

        $privasiDefault = [
            'whatsapp' => false,
            'riwayat_belanja' => false,
            'jangkauan_lapak' => 'kampus',
        ];

        return view('auth.pengaturan', [
            'user' => $user,
            'notifikasi' => array_merge(
                $notifikasiDefault,
                $user->preferensi_notifikasi ?? []
            ),
            'privasi' => array_merge(
                $privasiDefault,
                $user->preferensi_privasi ?? []
            ),
        ]);
    }

    public function updateNotifikasi(Request $request)
    {
        $data = $request->validate([
            'pesanan' => 'nullable|boolean',
            'chat' => 'nullable|boolean',
            'cod' => 'nullable|boolean',
            'promo' => 'nullable|boolean',
            'whatsapp' => 'nullable|boolean',
        ]);

        $request->user()->update([
            'preferensi_notifikasi' => [
                'pesanan' => $request->boolean('pesanan'),
                'chat' => $request->boolean('chat'),
                'cod' => $request->boolean('cod'),
                'promo' => $request->boolean('promo'),
                'whatsapp' => $request->boolean('whatsapp'),
            ],
        ]);

        return back()->with('ok_notifikasi', 'Preferensi notifikasi berhasil disimpan.');
    }

    public function updatePrivasi(Request $request)
    {
        $data = $request->validate([
            'whatsapp' => 'nullable|boolean',
            'riwayat_belanja' => 'nullable|boolean',
            'jangkauan_lapak' => 'required|in:kampus,kota,semua',
        ]);

        $request->user()->update([
            'preferensi_privasi' => [
                'whatsapp' => $request->boolean('whatsapp'),
                'riwayat_belanja' => $request->boolean('riwayat_belanja'),
                'jangkauan_lapak' => $request->jangkauan_lapak,
            ],
        ]);

        return back()->with('ok_privasi', 'Pengaturan privasi berhasil disimpan.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->password_lama, $user->password_hash)) {
            return back()->withErrors([
                'password_lama' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $user->update([
            'password_hash' => Hash::make($request->password_baru),
        ]);

        return back()->with('ok_password', 'Password berhasil diperbarui.');
    }
}
