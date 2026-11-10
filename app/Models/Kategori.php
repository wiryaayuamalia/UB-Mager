<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $guarded = [];
    public function katalog() { return $this->hasMany(Katalog::class, 'id_kategori', 'id_kategori'); }
}
