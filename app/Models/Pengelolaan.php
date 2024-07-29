<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengelolaan extends Model
{
    use HasFactory;

    protected $table = 'pengelolaans';

    protected $fillable = [
        'bahan_id',
        'kategori',
        'jumlah',
        'supplier'
    ];

    public function bahanbaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_id');
    }



}
