<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Menu;
use App\Models\Pengelolaan;
use App\Models\KategoriMenu;
use App\Exports\BahanBakuExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class MenuController extends Controller
{
    public function menu()
    {

        $data = Menu::get();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu'],
            ['type' => 'text', 'name' => 'kategori', 'label' => 'Kategori Menu'],
            ['type' => 'number', 'name' => 'harga', 'label' => 'Harga Menu'],
            ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
        ];

        return view('crud.menu.list', compact('fields', 'data'));
    }
    public function createMenu()
    {
        $title = 'Menu';
        $page = 'menu';

        $kategoriMenus = KategoriMenu::all();
        $kategoriOptions = $kategoriMenus->pluck('nama', 'id')->toArray();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu'],
            ['type' => 'select', 'name' => 'kategori_id', 'label' => 'Kategori Menu', 'options' => $kategoriOptions],
            ['type' => 'number', 'name' => 'harga', 'label' => 'Harga Menu'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['1' => 'Tersedia', '0' => 'Tidak Tersedia']],
        ];

        return view('crud.menu.add', compact('fields', 'page', 'title'));
    }
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_menus,id',
            'harga' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);

        Menu::create($validated);

        return redirect('menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function editMenu($id)
    {
        $title = 'Menu';
        $page = 'menu';

        $menu = Menu::findOrFail($id);
        $kategoriMenus = KategoriMenu::all();
        $kategoriOptions = $kategoriMenus->pluck('nama', 'id')->toArray();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama Menu', 'value' => $menu->nama],
            ['type' => 'select', 'name' => 'kategori_id', 'label' => 'Kategori Menu', 'value' => $menu->kategori_id, 'options' => $kategoriOptions],
            ['type' => 'number', 'name' => 'harga', 'label' => 'Harga Menu', 'value' => $menu->harga],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'value' => $menu->status, 'options' => ['1' => 'Tersedia', '0' => 'Tidak Tersedia']],
        ];

        return view('crud.menu.edit', compact('fields', 'page', 'title', 'menu'));
    }
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_menus,id',
            'harga' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);

        $menu->update($validated);

        return redirect('menu')->with('success', 'Menu berhasil diperbarui');
    }

    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect('menu')->with('success', 'Menu berhasil dihapus');
    }
}
