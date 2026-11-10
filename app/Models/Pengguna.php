<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
    protected $guarded = [];
    protected $hidden = ['password_hash'];

    public function getAuthPassword() { return $this->password_hash; }
    public function getRememberTokenName() { return ''; } // tabel tidak punya remember_token

    public function penjual() { return $this->hasOne(Penjual::class, 'id_pengguna', 'id_pengguna'); }
    public function admin() { return $this->hasOne(Admin::class, 'id_pengguna', 'id_pengguna'); }
    public function keranjang() { return $this->hasMany(Keranjang::class, 'id_pengguna', 'id_pengguna'); }
}
