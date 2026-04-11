<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{

//nama table
    protected $table = 'petugas';

    //
    protected $primaryKey = 'id_petugas';

    //field yang boleh di isi
    protected $fillable = [
        'user_id',
        'nama',
        'no_telepon',
        'alamat'
    ];

    public $timestamps = false;

    //relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
