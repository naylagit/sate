<?php


namespace App\Exports;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use Carbon\Carbon;
use DateTime;

class DataKehadiranExport implements WithEvents
{

    protected $month;

    public function __construct($month = null)
    {
        $this->month = $month;
    }


    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/data_kehadiran.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);
                $month = $this->month;



                if(Auth::user()->role == 'owner'){
                    $role = ['admin','karyawan'];
                } else {
                    $role = ['karyawan'];
                }
    
                    $data = User::with(['todaysKehadiran'])->whereIn('role', $role)->get()->map(function ($item) use ($month) {
                        $item->todays_kehadiran_status = $item->todaysKehadiran ? $item->todaysKehadiran->status : false;
                        $item->verifikasi = $item->todaysKehadiran ? $item->todaysKehadiran->verifikasi : null;
        
                        $query = Kehadiran::where('user_id', $item->id)
                        ->whereYear('tanggal', Carbon::now()->year);
        
                        if ($month != 'all') {
                            $item->hadir = Kehadiran::where('user_id', $item->id)
                            ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','hadir')->whereMonth('tanggal', $month)->get()->count();
                            $item->izin = Kehadiran::where('user_id', $item->id)
                            ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','izin')->whereMonth('tanggal', $month)->get()->count();
                            $item->tidak_hadir = Kehadiran::where('user_id', $item->id)
                            ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','tidak hadir')->whereMonth('tanggal', $month)->get()->count();
                        } else {
                            $item->hadir = Kehadiran::where('user_id', $item->id)
                                ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'hadir')->get()->count();
                            $item->izin = Kehadiran::where('user_id', $item->id)
                                ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'izin')->get()->count();
                            $item->tidak_hadir = Kehadiran::where('user_id', $item->id)
                                ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'tidak hadir')->get()->count();
                        }
        
                        return $item;
                    });
        


                if($this->month == 'all'){
                    $monthName = 'all'; 
                } else {

                    $dateObj = DateTime::createFromFormat('!m', $this->month);
                    $monthName = $dateObj->format('F'); 
                    
                   
                }

                $sheet->setCellValue('C4', $monthName);
                
                $rowIndex = 8;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->nama);
                    $sheet->setCellValue('D' . $rowIndex, $item->role);
                    $sheet->setCellValue('E' . $rowIndex, $item->hadir);
                    $sheet->setCellValue('F' . $rowIndex, $item->izin);
                    $sheet->setCellValue('G' . $rowIndex, $item->tidak_hadir);
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
