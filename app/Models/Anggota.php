<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    // Nama tabel
    protected $table = 'anggota';

    // Primary key custom
    protected $primaryKey = 'id_anggota';

    // Field yang boleh diisi
    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'no_telepon',
        'alamat'
    ];

    // Tidak menggunakan timestamps
    public $timestamps = false;

    /**
     * Relasi ke tabel user
     * 1 anggota = 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke peminjaman
     * 1 anggota bisa punya banyak peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id', 'id_anggota');
    }
}
