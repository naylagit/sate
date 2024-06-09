<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\KategoriBahanBaku;
use App\Models\LaporanBahanBaku;

class BahanBakuController extends Controller
{
    public function kategoribahanbaku()
    {
        $page = 'kategoribahanbaku';
        $data = KategoriBahanBaku::get();
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
   
        ];

        return view('crud.list', compact('page', 'fields', 'data'));
    }
    public function createKategoriBahanBaku()
    {
        $page = 'kategoribahanbaku';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
   
        ];

        return view('crud.add', compact('page', 'fields'));
    }

    public function storeKategoriBahanBaku(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        KategoriBahanBaku::create($validated);

        return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function editKategoriBahanBaku($id)
    {
        $data = BahanBaku::findOrFail($id);
        $fields = [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama],
        ];

        return view('crud.edit', ['fields' => $fields, 'data' => $data, 'page' => 'kategoribahanbaku']);
    }

    public function updateKategoriBahanBaku(Request $request, $id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);



        $bahanbaku->update($validated);

        return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil diperbarui');
    }

     public function destroyKategoriBahanBaku($id)
     {
         $kategoribahanbaku = KategoriBahanBaku::findOrFail($id);
         $kategoribahanbaku->delete();
 
         return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil dihapus');
     }


     public function bahanbaku()
     {
         $page = 'kategoribahanbaku';
         $data = BahanBaku::get();
         $kategori = KategoriBahanBaku::get();

         dd($kategori);

         $fields = [
             ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
             ['type' => 'select', 'name' => 'kategori_bahan_baku', 'label' => 'Kategori Bahan Baku',  'options' => ['laki-laki', 'perempuan']],
             ['type' => 'number', 'name' => 'stok', 'label' => 'Stok'],
    
         ];
 
         return view('crud.list', compact('page', 'fields', 'data'));
     }
     public function createBahanBaku()
     {
         $page = 'kategoribahanbaku';
         $kategori = KategoriBahanBaku::get();

         $kd = [];

         foreach($kategori as $k){
            $kd[$k->id] = $k['nama'];
         }
        
         $fields = [
             ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
             ['type' => 'select', 'name' => 'kategori_bahan_baku_id', 'label' => 'Kategori Bahan Baku', 'options' => $kd],
             ['type' => 'text', 'name' => 'stok', 'label' => 'Stok'],
         ];
 
         return view('crud.add', compact('page', 'fields'));
     }
 
     public function storeBahanBaku(Request $request)
     {
         $validated = $request->validate([
             'nama' => 'required|string|max:255',
             'kategori_bahan_baku_id' => 'required|string|max:255',
             'stok' => 'required|string|max:255',
         ]);
         BahanBaku::create($validated);
 
         return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil ditambahkan');
     }
 
     public function editBahanBaku($id)
     {
         $data = BahanBaku::findOrFail($id);
         $fields = [
             ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama],
         ];
 
         return view('crud.edit', ['fields' => $fields, 'data' => $data, 'page' => 'kategoribahanbaku']);
     }
 
     public function updateBahanBaku(Request $request, $id)
     {
         $bahanbaku = BahanBaku::findOrFail($id);
 
         $validated = $request->validate([
             'nama' => 'required|string|max:255',
         ]);
 
 
 
         $bahanbaku->update($validated);
 
         return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil diperbarui');
     }
 
      public function destroyBahanBaku($id)
      {
          $kategoribahanbaku = BahanBaku::findOrFail($id);
          $kategoribahanbaku->delete();
  
          return redirect('kategoribahanbaku')->with('success', 'Karyawan berhasil dihapus');
      }

}
