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
use Carbon\Carbon;
use DateTime;


class PengeluaranExport implements WithEvents
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
                $templateFile = new LocalTemporaryFile('templates/Pengeluaran.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $data = Pengeluaran::with('kategori')->get();

               

                $sheet->setCellValue('C4', Carbon::now()->toDateString());
                
                $rowIndex = 7;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->created_at);
                    $sheet->setCellValue('D' . $rowIndex, 'Rp ' . number_format($item->nominal, 0, ',', '.'));
                    $sheet->setCellValue('E' . $rowIndex, $item->kategori->nama);
                    $sheet->setCellValue('F' . $rowIndex, $item->keterangan);
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
