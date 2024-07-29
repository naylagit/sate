<?php


namespace App\Exports;

use App\Models\Pemasukan;
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
use App\Models\PesananMenu;
use Illuminate\Support\Facades\DB;
use DateTime;


class PenjualanExport implements WithEvents
{



    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/penjualan.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $data = PesananMenu::with('menu')->select('menu_id', DB::raw('SUM(jumlah) as total_sum'), DB::raw('SUM(subtotal) as total_subtotal'))
                    ->groupBy('menu_id')
                    ->with(['menu.kategori'])
                    ->get();

                $sheet->setCellValue('C4', Carbon::now()->toDateString());

                $rowIndex = 7;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->menu->nama);
                    $sheet->setCellValue('D' . $rowIndex, $item->total_sum);
                    $sheet->setCellValue( 'E' . $rowIndex,'Rp ' . number_format($item->total_subtotal, 0, ',', '.'));
                    $sheet->setCellValue('F' . $rowIndex, 'Rp ' . number_format($item->total_subtotal * $item->total_sum, 0, ',', '.'));
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
