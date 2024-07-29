<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesananmenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'jumlah',
        'subtotal',
        'keterangan'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

}
