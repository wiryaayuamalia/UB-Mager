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
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:15|unique:pengguna,no_hp,' . $r->user()->id_pengguna . ',id_pengguna',
            'nim' => 'nullable|string|max:30',
            'fakultas' => 'required|string|max:120',
            'program_studi' => 'nullable|string|max:120',
            'angkatan' => 'nullable|digits:4',
            'titik_cod_favorit' => 'required|string|max:150',
            'foto' => 'nullable|image|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $u = $r->user();
        $data = $r->only('nama','alamat','no_hp','nim','fakultas','program_studi','angkatan','titik_cod_favorit');
        if ($r->hasFile('foto')) $data['foto'] = $r->file('foto')->store('foto-profil', 'public');
        if ($r->filled('password')) $data['password_hash'] = Hash::make($r->password);
        $u->update($data);
        return back()->with('ok', 'Profil diperbarui.');
    }
}
