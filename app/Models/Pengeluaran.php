<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nominal',
        'kategori_id',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->keterangan) || $model->keterangan === '') {
                $model->keterangan = '-';
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPengeluaran::class);
    }
}
