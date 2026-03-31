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
        'tanggal_pinjam',
        'tanggal_pengembalian',
        'status'
    ];
}
