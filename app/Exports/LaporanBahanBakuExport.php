<?php


namespace App\Exports;

use App\Models\BahanBaku;
use App\Models\Pengelolaan;
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
use Carbon\Carbon;
use DateTime;

class LaporanBahanBakuExport implements WithEvents
{

    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }


    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/laporan_bahan_baku.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                if($this->month == 'all'){
                    $data = Pengelolaan::with('bahanbaku')->get()->map(function ($pengelolaan) {
                        if ($pengelolaan->bahanbaku) {
                            $pengelolaan->nama_bahanbaku = $pengelolaan->bahanbaku->nama;
                        }
                        return $pengelolaan;
                    });
    
                } else {
                    $data = Pengelolaan::with('bahanbaku')->whereMonth('updated_at', $this->month)->get()->map(function ($pengelolaan) {
                        if ($pengelolaan->bahanbaku) {
                            $pengelolaan->nama_bahanbaku = $pengelolaan->bahanbaku->nama;
                        }
                        return $pengelolaan;
                    });
    
                }


                if($this->month == 'all'){
                    $monthName = 'all'; 
                } else {

                    $dateObj = DateTime::createFromFormat('!m', $this->month);
                    $monthName = $dateObj->format('F'); 
                    
                   
                }

               
                $sheet->setCellValue('C4', $monthName);
                $rowIndex = 7;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->nama_bahanbaku);
                    $sheet->setCellValue('D' . $rowIndex, $item->kategori);
                    $sheet->setCellValue('E' . $rowIndex, $item->created_at);
                    $sheet->setCellValue('F' . $rowIndex, $item->jumlah);
                    $sheet->setCellValue('G' . $rowIndex, $item->supplier);
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
