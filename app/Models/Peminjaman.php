<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'buku_id',
        'anggota_id',
        'petugas_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status',
    ];

    public function buku()
{
    return $this->belongsTo(Buku::class, 'buku_id', 'id_buku');
}

public function anggota()
{
    return $this->belongsTo(Anggota::class, 'anggota_id', 'id_anggota');
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}
