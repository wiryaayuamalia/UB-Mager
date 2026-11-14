<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;
    protected $guarded = [];
    public function katalog() { return $this->belongsTo(Katalog::class, 'id_katalog', 'id_katalog'); }
}
