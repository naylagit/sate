<?php


namespace App\Exports;

use App\Models\Pengeluaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use DateTime;


class KeuntunganExport implements WithEvents
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
                $templateFile = new LocalTemporaryFile('templates/Keuntungan.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $end = Carbon::now();
       
    
        $pemasukan = DB::table('pemasukans')
            ->select(DB::raw('SUM(nominal) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
          
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $pengeluaran = DB::table('pengeluarans')
            ->select(DB::raw('SUM(nominal) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
           
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $months = collect(range(0, 11))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('F'); // Full month name and year
        })->reverse()->values();
    
        $pemasukanData = $months->map(function ($month) use ($pemasukan) {
            return $pemasukan->firstWhere('month', Carbon::parse($month)->format('Y-m'))->total ?? 0;
        });
    
        $pengeluaranData = $months->map(function ($month) use ($pengeluaran) {
            return $pengeluaran->firstWhere('month', Carbon::parse($month)->format('Y-m'))->total ?? 0;
        });


               

                $sheet->setCellValue('C4', Carbon::now()->toDateString());
                
                $rowIndex = 7;
                foreach ($months as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item);
                    $sheet->setCellValue('D' . $rowIndex, $pemasukanData[$key]);
                    $sheet->setCellValue('E' . $rowIndex, $pengeluaranData[$key]);
                    $sheet->setCellValue('F' . $rowIndex,$pemasukanData[$key] - $pengeluaranData[$key]);
                    $rowIndex++;
                }


                return $sheet;
            },
        ];
    }
}
