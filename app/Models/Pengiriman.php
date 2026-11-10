<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    public $timestamps = false;
    protected $guarded = [];
}
