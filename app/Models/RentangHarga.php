<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentangHarga extends Model
{
    protected $table = 'rentang_harga';
    protected $primaryKey = 'id_rentang';
    public $timestamps = false;
    protected $guarded = [];
}
