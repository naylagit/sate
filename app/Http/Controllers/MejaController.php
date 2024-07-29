<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pengelolaan;
use App\Exports\BahanBakuExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class MejaController extends Controller
{
     public function meja()
     {

         $data = Meja::get();

         $fields = [
             ['type' => 'text', 'name' => 'nama', 'label' => 'Nomor Meja'],
             ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
         ];
 
         return view('crud.meja.list', compact('fields', 'data'));
     }
     public function createMeja()
     {
        $title = 'Meja';
        $page = 'meja';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nomor Meja'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status'],
        ];
 
         return view('crud.meja.add', compact('fields','page', 'title'));
     }
 
     public function storeMeja(Request $request)
     {
         $validated = $request->validate([
             'nama' => 'required|string|max:255|unique:mejas',
             'status' => 'required|string|max:255',
         ]);
         Meja::create($validated);
 
         return redirect('meja')->with('success', 'Meja berhasil ditambahkan');
     }
 
     public function editMeja($id)
     {
        $title = 'Meja';
        $page = 'meja';

         $data = Meja::findOrFail($id);
         $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nomor Meja', 'value' => $data->nama],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'value' => $data->status],
        ];
 
         return view('crud.meja.edit',  compact('fields','page', 'title','data'));
     }

     public function updateMeja(Request $request, $id)
     {
         $meja = Meja::findOrFail($id);
 
         $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|string|max:255',
         ]);
 
         $meja->update($validated);
 
         return redirect('meja')->with('success', 'Meja berhasil diperbarui');
     }
 
      public function destroyMeja($id)
      {
          $meja = Meja::findOrFail($id);
          $meja->delete();
  
          return redirect('meja')->with('success', 'Meja berhasil dihapus');
      }

}
