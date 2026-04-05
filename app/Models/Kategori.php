<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
     protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori'
    ];

    public $timestamps = false;

    public function buku()
{
    return $this->hasMany(Buku::class, 'kategori_id');
}
}
