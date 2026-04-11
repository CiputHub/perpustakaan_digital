<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaPerpus extends Model
{
    //nama table
    protected $table = 'kepala_perpus';

    // Primary key
    protected $primaryKey = 'id_kepala';

      // Field yang boleh diisi
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_telepon'
    ];

    public $timestamps = false;

     /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
