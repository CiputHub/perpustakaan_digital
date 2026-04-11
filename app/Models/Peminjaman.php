<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    //nama table
    protected $table = 'peminjaman';

    //primary key id
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    // Field yang boleh diisi
    protected $fillable = [
        'buku_id',
        'anggota_id',
        'petugas_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status',
    ];

    //relasi ke table buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id_buku');
    }

    // ke table anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id_anggota');
    }

    //relasi ke table user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
