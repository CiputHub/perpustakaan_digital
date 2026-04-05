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
        'stok',
        'deskripsi',
        'kategori_id'
    ];

     public $timestamps = false;

     public function peminjaman()
{
    return $this->hasMany(Peminjaman::class, 'buku_id', 'id_buku');
}

public function kategori()
{
    return $this->belongsTo(Kategori::class, 'kategori_id');
}

public function user(){
    return $this->belongsTo(User::class);
}

}
