<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'otp';
    protected $primaryKey = 'id_otp';
    public $timestamps = false;
    protected $guarded = [];
}
