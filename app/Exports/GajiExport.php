<?php


namespace App\Exports;

use App\Models\Kehadiran;
use App\Models\User;
use App\Models\Gaji;
use App\Models\Pinjaman;
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

class GajiExport implements WithEvents
{

    protected $id;

    public function __construct($id)
    {

        $this->id = $id;
    }


    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile('templates/gaji.xlsx');
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->reopen($templateFile, Excel::XLSX);
                $sheet = $event->writer->getSheetByIndex(0);

                $id = $this->id;

                $data = Gaji::where('user_id', $id)->with('user')->get()->map(function ($item) use ($id) {

                    $pinjaman = Pinjaman::where('user_id', $id)->where('bulan', $item->bulan)->get();
                    $item->pinjaman = $pinjaman->sum('total');

                    $item->user_name = $item->user->nama;



                    $query = Kehadiran::where('user_id', $id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi');



                    $item->total_gaji = $item->total - $item->pinjaman;

                    $item->hadir = Kehadiran::where('user_id', $id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'hadir')->get()->count();
                    $item->izin = Kehadiran::where('user_id', $id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'izin')->get()->count();
                    $item->tidak_hadir = Kehadiran::where('user_id', $id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'tidak hadir')->get()->count();

                    $dateObj = DateTime::createFromFormat('!m', $item->bulan);
                    $item->bulan = $dateObj->format('F');

                    return $item;
                });


                $user = User::findOrFail($this->id);

                $sheet->setCellValue('C4', $user->nama);

                $rowIndex = 8;
                foreach ($data as $key =>  $item) {
                    $sheet->setCellValue('B' . $rowIndex, $key + 1);
                    $sheet->setCellValue('C' . $rowIndex, $item->bulan);
                    $sheet->setCellValue('D' . $rowIndex, $item->hadir);
                    $sheet->setCellValue('E' . $rowIndex, $item->izin);
                    $sheet->setCellValue('F' . $rowIndex, $item->tidak_hadir);
                    $sheet->setCellValue('G' . $rowIndex, $item->total);
                    if ($item->status == 1) {
                        $sheet->setCellValue('H' . $rowIndex, 'belum jatuh tempo');
                    } elseif ($item->status == 2) {
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
