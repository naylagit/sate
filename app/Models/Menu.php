<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kategori_id', 'harga', 'status'];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'kategori_id', 'id');
    }


    public function pesananMenu()
    {
        return $this->hasMany(PesananMenu::class);
    }
}
