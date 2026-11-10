<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKatalog extends Model
{
    protected $table = 'foto_katalog';
    protected $primaryKey = 'id_foto';
    public $timestamps = false;
    protected $guarded = [];
}
