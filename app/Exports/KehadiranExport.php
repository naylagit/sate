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
use Maatwebsite\Excel\Excel;
use Carbon\Carbon;
use DateTime;

class KehadiranExport implements WithEvents
{

    protected $month;
    protected $id;

    public function __construct($month = null, $id)
    {
        $this->month = $month;
        $this->id = $id;
    }


    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/kehadiran.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);



                if($this->month == 'all'){

                    $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$this->id )->get()->map(function ($item) {
                        $item->nama = $item->user->nama;
                        return $item;
                    });
        
                } else {
        
                    $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$this->id )->whereMonth('tanggal', $this->month)->get()->map(function ($item) {
                        $item->nama = $item->user->nama;
                        return $item;
                    });
        
                }


                if($this->month == 'all'){
                    $monthName = 'all'; 
                } else {

                    $dateObj = DateTime::createFromFormat('!m', $this->month);
                    $monthName = $dateObj->format('F'); 
                    
                   
                }

                $user = User::findOrFail($this->id);

                $sheet->setCellValue('C4', $user->nama);
                $sheet->setCellValue('C5', $monthName);
                
                $rowIndex = 8;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->tanggal);
                    $sheet->setCellValue('D' . $rowIndex, $item->waktu);
                    $sheet->setCellValue('E' . $rowIndex, $item->status);
                    $sheet->setCellValue('F' . $rowIndex, $item->foto);
                    $sheet->setCellValue('G' . $rowIndex, $item->verifikasi);
                    $rowIndex++;
                }

                return $sheet;
            },
        ];
    }
}
