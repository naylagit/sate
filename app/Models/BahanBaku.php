<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_bahan_baku_id', 'nama', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBahanBaku::class, 'kategori_bahan_baku_id');
    }

    public function laporan()
    {
        return $this->hasMany(LaporanBahanBaku::class);
    }
}
