<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    protected $table = 'katalog';
    protected $primaryKey = 'id_katalog';
    public $timestamps = false;
    protected $guarded = [];

    public function penjual() { return $this->belongsTo(Penjual::class, 'id_penjual', 'id_penjual'); }
    public function kategori() { return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori'); }
    public function foto() { return $this->hasMany(FotoKatalog::class, 'id_katalog', 'id_katalog')->orderBy('urutan'); }

    public function getFotoUtamaAttribute(): ?string
    {
        $f = $this->foto->first();
        return $f ? asset('storage/' . $f->path_foto) : null;
    }
}
