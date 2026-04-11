<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Nama tabel
    protected $table = 'buku';

    // Primary key custom
    protected $primaryKey = 'id_buku';

    public $incrementing = true;
    protected $keyType = 'int';

    // Field yang boleh diisi
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

    // Tidak pakai timestamps
    public $timestamps = false;

    /**
     * Relasi ke peminjaman
     * 1 buku bisa dipinjam berkali-kali
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id', 'id_buku');
    }

    /**
     * Relasi ke kategori
     * 1 buku hanya punya 1 kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke user (opsional kalau ada)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
