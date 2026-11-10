<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit() { return view('auth.profil'); }

    // PGN-UR-03: lengkapi profil & ubah password
    public function update(Request $r)
    {
        $r->validate([
            'nama' => 'required|max:100',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $u = $r->user();
        $data = ['nama' => $r->nama, 'alamat' => $r->alamat];
        if ($r->hasFile('foto')) $data['foto'] = $r->file('foto')->store('foto-profil', 'public');
        if ($r->filled('password')) $data['password_hash'] = Hash::make($r->password);
        $u->update($data);
        return back()->with('ok', 'Profil diperbarui.');
    }
}
