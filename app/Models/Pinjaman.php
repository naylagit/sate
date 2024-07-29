<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'bulan',
        'total',
        'status',
        'tanggal',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableSalary()
    {
        $month = $this->bulan;
        $year = Carbon::now()->year; 

        $gaji = Gaji::where('user_id', $this->user_id)
            ->where('bulan', $month)
            ->whereYear('created_at', $year)
            ->first();

     
        if (!$gaji) {
            return 0;
        }

       
        $availableSalary = $gaji->total ;

        return $availableSalary;
    }
}
