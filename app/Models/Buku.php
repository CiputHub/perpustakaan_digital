<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'judul',
        'gambar',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok'
    ];

     public $timestamps = false;
}
