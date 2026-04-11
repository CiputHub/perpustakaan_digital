<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Nama tabel
    protected $table = 'kategori';

    // Primary key
    protected $primaryKey = 'id';

    // Field yang boleh diisi
    protected $fillable = [
        'nama_kategori'
    ];

    // Tidak pakai timestamps
    public $timestamps = false;

    /**
     * Relasi ke buku
     * 1 kategori punya banyak buku
     */
    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
