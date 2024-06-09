<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function bahanBaku()
    {
        return $this->hasMany(BahanBaku::class);
    }
}
