<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Pengeluaran;
use App\Models\Pengelolaan;
use App\Exports\BahanBakuExport;
use App\Exports\PengeluaranExport;
use App\Exports\LaporanBahanBakuExport;
use App\Models\KategoriPengeluaran;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class PengeluaranController extends Controller
{
     public function pengeluaran()
     {

         $data = Pengeluaran::get();
         $page = 'pengeluaran';
         $kategori = KategoriPengeluaran::all()->keyBy('id');

         $fields = [
             ['type' => 'text', 'name' => 'created_at', 'label' => 'Tanggal'],
             ['type' => 'text', 'name' => 'nominal', 'label' => 'Nominal'],
             ['type' => 'select', 'name' => 'kategori_id', 'label' => 'Kategori'],
             ['type' => 'text', 'name' => 'keterangan', 'label' => 'Keterangan'],
         ];
 
         return view('crud.pengeluaran.list', compact('fields', 'data', 'page', 'kategori'));
     }
     public function createPengeluaran()
     {
        $page = 'pengeluaran';
        $kategori = KategoriPengeluaran::get();
        $fields = [
            ['type' => 'number', 'name' => 'nominal', 'label' => 'Nominal'],
             ['type' => 'text', 'name' => 'keterangan', 'label' => 'Keterangan'],
             ['type' => 'select', 'name' => 'kategori_id', 'label' => 'Kategori'],
        ];


      
 
         return view('crud.pengeluaran.add', compact('fields','page', 'kategori'));
     }
 
     public function storePengeluaran(Request $request)
     {
         $validated = $request->validate([
             'nominal' => 'required|string|max:255',
             'kategori_id' => 'required|string|max:255',
           
         ]);
         Pengeluaran::create($validated);
 
         return redirect('pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan');
     }
 
     public function editPengeluaran($id)
     {
        $title = 'Pengeluaran';
        $page = 'pengeluaran';
        $kategori = KategoriPengeluaran::get();

         $data = Pengeluaran::findOrFail($id);
         $fields = [
            ['type' => 'text', 'name' => 'nominal', 'label' => 'Nominal', 'value' => $data->nominal],
            ['type' => 'text', 'name' => 'keterangan', 'label' => 'keterangan', 'value' => $data->keterangan],
        ];
 
         return view('crud.pengeluaran.edit',  compact('fields','page', 'title','data', 'kategori'));
     }

     public function updatePengeluaran(Request $request, $id)
     {
         $pengeluaran = Pengeluaran::findOrFail($id);
 
         $validated = $request->validate([
            'nominal' => 'required|string|max:255',
             'keterangan' => 'required|string|max:255',
         ]);
 
         $pengeluaran->update($validated);
 
         return redirect('pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui');
     }
 
      public function destroyPengeluaran($id)
      {
          $pengeluaran = Pengeluaran::findOrFail($id);
          $pengeluaran->delete();
  
          return redirect('pengeluaran')->with('success', 'Pengeluaran berhasil dihapus');
      }

      public function exportPengeluaran()
      {
        return Excel::download(new PengeluaranExport, 'Pengeluaran-'.Carbon::now()->toDateString().'.xlsx');
      }



}
