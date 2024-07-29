<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\KategoriMenu;
use App\Models\Pengelolaan;
use App\Exports\BahanBakuExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class KategoriMenuController extends Controller
{
     public function kategorimenu()
     {

         $data = KategoriMenu::get();

         $fields = [
             ['type' => 'text', 'name' => 'id', 'label' => 'Id Kategori'],
             ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
         ];
 
         return view('crud.kategorimenu.list', compact('fields', 'data'));
     }
     public function createKategoriMenu()
     {
        $title = 'KategoriMenu';
        $page = 'kategorimenu';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
        ];
 
         return view('crud.kategorimenu.add', compact('fields','page', 'title'));
     }
 
     public function storeKategoriMenu(Request $request)
     {
         $validated = $request->validate([
             'nama' => 'required|string|max:255|unique:kategori_menus',
         ]);
         KategoriMenu::create($validated);
 
         return redirect('kategorimenu')->with('success', 'KategoriMenu berhasil ditambahkan');
     }
 
     public function editKategoriMenu($id)
     {
        $title = 'KategoriMenu';
        $page = 'kategorimenu';

         $data = KategoriMenu::findOrFail($id);
         $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama', 'value' => $data->nama],
        ];
 
         return view('crud.kategorimenu.edit',  compact('fields','page', 'title','data'));
     }

     public function updateKategoriMenu(Request $request, $id)
     {
         $kategorimenu = KategoriMenu::findOrFail($id);
 
         $validated = $request->validate([
            'nama' => 'required|string|max:255'
         ]);
 
         $kategorimenu->update($validated);
 
         return redirect('kategorimenu')->with('success', 'KategoriMenu berhasil diperbarui');
     }
 
      public function destroyKategoriMenu($id)
      {
          $kategorimenu = KategoriMenu::findOrFail($id);
          $kategorimenu->delete();
  
          return redirect('kategorimenu')->with('success', 'KategoriMenu berhasil dihapus');
      }

}
