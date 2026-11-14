<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPenjual extends Model
{
    protected $table = 'pengajuan_penjual';
    protected $primaryKey = 'id_pengajuan';
    public $timestamps = false;
    protected $guarded = [];
    public function pengguna() { return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna'); }
}
