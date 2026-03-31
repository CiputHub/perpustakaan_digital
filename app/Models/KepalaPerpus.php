<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaPerpus extends Model
{
    protected $table = 'kepala_perpus';
    protected $primaryKey = 'id_kepala';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telepon'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

