<?php


namespace App\Exports;

use App\Models\BahanBaku;
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

class BahanBakuExport implements WithEvents
{
    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/bahan_baku.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $data = BahanBaku::get();

                $sheet->setCellValue('C4', Carbon::now()->toDateString());
                $rowIndex = 7;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->nama);
                    $sheet->setCellValue('D' . $rowIndex, $item->stok);
                    $sheet->setCellValue('E' . $rowIndex, $item->updated_at);
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
