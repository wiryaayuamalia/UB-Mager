<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    protected $table = 'komplain';
    protected $primaryKey = 'id_komplain';
    public $timestamps = false;
    protected $guarded = [];
}
