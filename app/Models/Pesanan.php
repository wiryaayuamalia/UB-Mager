<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;
    protected $guarded = [];

    public function katalog() { return $this->belongsTo(Katalog::class, 'id_katalog', 'id_katalog'); }
    public function penjual() { return $this->belongsTo(Penjual::class, 'id_penjual', 'id_penjual'); }
    public function pembeli() { return $this->belongsTo(Pengguna::class, 'id_pembeli', 'id_pengguna'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan'); }
    public function pengiriman() { return $this->hasOne(Pengiriman::class, 'id_pesanan', 'id_pesanan'); }
}
