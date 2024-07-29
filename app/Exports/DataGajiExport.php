<?php


namespace App\Exports;

use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Gaji;
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

class DataGajiExport implements WithEvents
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
                $templateFile = new LocalTemporaryFile('templates/data_gaji.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);
                $month = $this->month;


                $data = Gaji::with('user')->get()->map(function ($item){

                    $item->user_name = $item->user->nama;
    
                    $query = Kehadiran::where('user_id', $item->user->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' );
    
                    if ($this->month != 'all') {
                        $query->whereMonth('tanggal', $this->month);
                    } 
    
                    $item->hadir = Kehadiran::where('user_id', $item->user->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'hadir')->get()->count();
                $item->izin = Kehadiran::where('user_id', $item->user->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'izin')->get()->count();
                $item->tidak_hadir = Kehadiran::where('user_id', $item->user->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'tidak hadir')->get()->count();
                    return $item;
                });



            
    
                // if ($month == 'all') {
                //     $data = Gaji::with(['user' => function ($query) {
                //         $query->whereIn('role', ['admin', 'karyawan']);
                //     }])->get()->map(function ($item) {
                //         if ($item->user) {
                //             $item->user_name = $item->user->nama;
                //             $item->total_kehadiran = Kehadiran::where('user_id', $item->user_id)->count();
                //             return $item;
                //         }
                //     })->filter();
                // } else {
                //     $data = Gaji::with(['user' => function ($query) {
                //         $query->whereIn('role', ['admin', 'karyawan']);
                //     }])->where('bulan', $month)->get()->map(function ($item) use ($month) {
                //         if ($item->user) {
                //             $item->user_name = $item->user->nama;
                //             $item->total_kehadiran = Kehadiran::where('user_id', $item->user_id)
                //                                               ->whereMonth('tanggal', $month)
                //                                               ->count();
                //             return $item;
                //         }
                //     })->filter();
                // }

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
                    $sheet->setCellValue('C' . $rowIndex, $item->user_name);
                    $sheet->setCellValue('D' . $rowIndex, $item->hadir);
                    $sheet->setCellValue('E' . $rowIndex, $item->izin);
                    $sheet->setCellValue('F' . $rowIndex, $item->tidak_hadir);
                    $sheet->setCellValue('G' . $rowIndex, 'Rp ' . number_format($item->total, 0, ',', '.'));


                    if($item->status == 1){
                        $sheet->setCellValue('H' . $rowIndex, 'belum jatuh tempo');
                    } elseif( $item->status == 2){
                        $sheet->setCellValue('H' . $rowIndex, 'menunggu pembayaran');
                    } else {
                        $sheet->setCellValue('H' . $rowIndex, 'dibayarkan');
                    }

                   
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
