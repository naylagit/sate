<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Pemasukan;
use App\Models\Pengelolaan;
use App\Exports\PemasukanExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class PemasukanController extends Controller
{
     public function pemasukan()
     {

         $data = Pemasukan::get();
         $page = 'pemasukan';

         $fields = [
             ['type' => 'text', 'name' => 'created_at', 'label' => 'Tanggal'],
             ['type' => 'text', 'name' => 'nominal', 'label' => 'Nominal'],
             ['type' => 'text', 'name' => 'keterangan', 'label' => 'Keterangan'],
         ];
 
         return view('crud.pemasukan.list', compact('fields', 'data', 'page'));
     }

      public function export()
      {
        return Excel::download(new PemasukanExport, 'Pemasukan-'.Carbon::now()->toDateString().'.xlsx');
      }


}
