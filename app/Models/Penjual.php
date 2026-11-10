<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjual extends Model
{
    protected $table = 'penjual';
    protected $primaryKey = 'id_penjual';
    public $timestamps = false;
    protected $guarded = [];
    public function pengguna() { return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna'); }
    public function katalog() { return $this->hasMany(Katalog::class, 'id_penjual', 'id_penjual'); }
}
