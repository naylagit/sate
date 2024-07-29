<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventori;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class InventoriController extends Controller
{
    public function inventori()
    {

        $data = Inventori::get();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Inventori'],
            ['type' => 'number', 'name' => 'jumlah', 'label' => 'Jumlah'],
        ];

        return view('crud.inventori.list', compact('fields', 'data'));
    }
    public function createInventori()
    {
        $title = 'Inventori';
        $page = 'inventori';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'number', 'name' => 'jumlah', 'label' => 'Jumlah'],
        ];

        return view('crud.inventori.add', compact('fields', 'page', 'title'));
    }

    public function storeInventori(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_menus',
            'jumlah' => 'required|string|max:255',
        ]);
        Inventori::create($validated);

        return redirect('inventori')->with('success', 'Inventori berhasil ditambahkan');
    }

    public function editInventori($id)
    {
        $title = 'Inventori';
        $page = 'inventori';

        $data = Inventori::findOrFail($id);
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Inventori', 'value' => $data->nama],
            ['type' => 'number', 'name' => 'jumlah', 'label' => 'Jumlah', 'value' => $data->jumlah],
        ];

        return view('crud.inventori.edit',  compact('fields', 'page', 'title', 'data'));
    }

    public function updateInventori(Request $request, $id)
    {
        $inventori = Inventori::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_menus',
            'jumlah' => 'required|string|max:255',
        ]);

        $inventori->update($validated);

        return redirect('inventori')->with('success', 'Inventori berhasil diperbarui');
    }

    public function destroyInventori($id)
    {
        $inventori = Inventori::findOrFail($id);
        $inventori->delete();

        return redirect('inventori')->with('success', 'Inventori berhasil dihapus');
    }
}
