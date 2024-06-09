<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['bahan_baku_id', 'stok', 'harga', 'kategori', 'kontak_suplier'];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
