<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\KategoriPengeluaran;
use App\Models\Pengelolaan;
use App\Exports\BahanBakuExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class KategoriPengeluaranController extends Controller
{
     public function kategoripengeluaran()
     {

         $data = KategoriPengeluaran::get();

         $fields = [
             ['type' => 'text', 'name' => 'id', 'label' => 'Id Kategori'],
             ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
         ];
 
         return view('crud.kategoripengeluaran.list', compact('fields', 'data'));
     }
     public function createKategoriPengeluaran()
     {
        $title = 'KategoriPengeluaran';
        $page = 'kategoripengeluaran';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
        ];
 
         return view('crud.kategoripengeluaran.add', compact('fields','page', 'title'));
     }
 
     public function storeKategoriPengeluaran(Request $request)
     {
         $validated = $request->validate([
             'nama' => 'required|string|max:255|unique:kategori_pengeluarans',
         ]);
         KategoriPengeluaran::create($validated);
 
         return redirect('kategoripengeluaran')->with('success', 'KategoriPengeluaran berhasil ditambahkan');
     }
 
     public function editKategoriPengeluaran($id)
     {
        $title = 'KategoriPengeluaran';
        $page = 'kategoripengeluaran';

         $data = KategoriPengeluaran::findOrFail($id);
         $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama', 'value' => $data->nama],
        ];
 
         return view('crud.kategoripengeluaran.edit',  compact('fields','page', 'title','data'));
     }

     public function updateKategoriPengeluaran(Request $request, $id)
     {
         $kategoripengeluaran = KategoriPengeluaran::findOrFail($id);
 
         $validated = $request->validate([
            'nama' => 'required|string|max:255'
         ]);
 
         $kategoripengeluaran->update($validated);
 
         return redirect('kategoripengeluaran')->with('success', 'KategoriPengeluaran berhasil diperbarui');
     }
 
      public function destroyKategoriPengeluaran($id)
      {
          $kategoripengeluaran = KategoriPengeluaran::findOrFail($id);
          $kategoripengeluaran->delete();
  
          return redirect('kategoripengeluaran')->with('success', 'KategoriPengeluaran berhasil dihapus');
      }


}
