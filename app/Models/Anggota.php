<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'no_telepon',
        'alamat'
    ];

    public $timestamps = false;

public function user(){
    return $this->belongsTo(User::class);
}

public function peminjaman()
{
    return $this->hasMany(Peminjaman::class, 'anggota_id', 'id_anggota');
}


}
