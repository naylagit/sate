<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'tanggal',
        'waktu',
        'verifikasi',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
