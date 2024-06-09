<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Kehadiran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KehadiranExport implements FromCollection, WithHeadings
{
    protected $month;

    public function __construct($month = null)
    {
        $this->month = $month;
    }

    public function collection()
    {
        $month = $this->month;

        $data = User::with(['todaysKehadiran'])->whereIn('role', ['admin', 'karyawan'])->get()->map(function ($item) use ($month) {
            $item->todays_kehadiran_status = $item->todaysKehadiran ? $item->todaysKehadiran->status : false;
            $item->verifikasi = $item->todaysKehadiran ? $item->todaysKehadiran->verifikasi : null;

            $query = Kehadiran::where('user_id', $item->id)
                ->whereYear('tanggal', Carbon::now()->year);

            if ($month) {
                $query->whereMonth('tanggal', $month);
            } else {
                $query->whereMonth('tanggal', Carbon::now()->month);
            }

            $attendances = $query->get();

            $item->monthly_attendance = $attendances->count();

            return [
               
                'nama' => $item->nama,
                'email' => $item->email,
                'monthly_attendance' => $item->monthly_attendance,
            ];
        });

        return collect($data);
    }

    public function headings(): array
    {
        return [
          
            'Nama',
            'Email',
            'Total Kehadiran Bulanan',
        ];
    }
}
