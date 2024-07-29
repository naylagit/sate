<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Pengelolaan;
use App\Models\Pengeluaran;
use App\Exports\BahanBakuExport;
use App\Exports\LaporanBahanBakuExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use DateTime;

class BahanBakuController extends Controller
{
    public function bahanbaku()
    {

        $data = BahanBaku::get();

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'text', 'name' => 'updated_at', 'label' => 'Terakhir diperbarui'],
            ['type' => 'number', 'name' => 'stok', 'label' => 'Stok (kg)'],
        ];

        return view('crud.bahan_baku.list', compact('fields', 'data'));
    }
    public function createBahanBaku()
    {
        $title = 'Bahan Baku';
        $page = 'bahanbaku';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            //  ['type' => 'number', 'name' => 'stok', 'label' => 'Stok (kg)'],
        ];

        return view('crud.bahan_baku.add', compact('fields', 'page', 'title'));
    }

    public function storeBahanBaku(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:bahan_bakus,nama',
            //  'stok' => 'required|string|max:255',
        ]);
        $validated['stok'] = 0;
        BahanBaku::create($validated);

        return redirect('bahanbaku')->with('success', 'Bahan Baku berhasil ditambahkan');
    }

    public function editBahanBaku($id)
    {
        $title = 'Bahan Baku';
        $page = 'bahanbaku';

        $data = BahanBaku::findOrFail($id);
        $fields = [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama],
        ];

        return view('crud.bahan_baku.edit',  compact('fields', 'page', 'title', 'data'));
    }

    public function kelolaBahanBaku($id, $tipe)
    {
        $title = 'Kelola Bahan Baku';
        $page = 'bahanbaku/kelola';

        $data = BahanBaku::findOrFail($id);
        if ($tipe == 'masuk') {
            $fields = [
                ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama, 'readonly' => 'true'],
                ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'select', 'value' => $tipe, 'readonly' => 'true'],
                ['name' => 'jumlah', 'label' => 'Jumlah (Kg)', 'type' => 'number'],
                ['name' => 'stok', 'label' => 'Stok terkini', 'type' => 'number', 'value' => $data->stok, 'readonly' => 'true'],
                ['name' => 'harga', 'label' => 'Harga', 'type' => 'number',],
                ['name' => 'supplier', 'label' => 'Kontak Supplier', 'type' => 'text', 'optional' => 'true'],
            ];
        } else {
            $fields = [
                ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama, 'readonly' => 'true'],
                ['name' => 'kategori', 'label' => 'Kategori', 'type' => 'select', 'value' => $tipe, 'readonly' => 'true'],
                ['name' => 'jumlah', 'label' => 'Jumlah (Kg)', 'type' => 'number'],
                ['name' => 'stok', 'label' => 'Stok terkini', 'type' => 'number', 'value' => $data->stok, 'readonly' => 'true'],
            ];
        };


        return view('crud.bahan_baku.kelola_add',  compact('fields', 'page', 'title', 'data', 'id', 'tipe'));
    }

    public function updateBahanBaku(Request $request, $id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $bahanbaku->update($validated);

        return redirect('bahanbaku')->with('success', 'Bahan Baku berhasil diperbarui');
    }

    public function destroyBahanBaku($id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);
        $bahanbaku->delete();

        return redirect('bahanbaku')->with('success', 'Bahan Baku berhasil dihapus');
    }

    public function exportBahanBaku()
    {
        return Excel::download(new BahanBakuExport, 'Bahan Baku-' . Carbon::now()->toDateString() . '.xlsx');
    }


    public function laporanBahanbaku($month = 'all')
    {
        if ($month == 'all') {

            $data = Pengelolaan::with('bahanbaku')->orderBy('created_at', 'desc')->get()->map(function ($pengelolaan) {
                if ($pengelolaan->bahanbaku) {
                    $pengelolaan->nama_bahanbaku = $pengelolaan->bahanbaku->nama;
                }
                return $pengelolaan;
            });
        } else {


            $data = Pengelolaan::with('bahanbaku')->whereMonth('updated_at', $month)->get()->map(function ($pengelolaan) {
                if ($pengelolaan->bahanbaku) {
                    $pengelolaan->nama_bahanbaku = $pengelolaan->bahanbaku->nama;
                }
                return $pengelolaan;
            });
        }


        $fields = [
            ['type' => 'text', 'name' => 'nama_bahanbaku', 'label' => 'Nama Bahan Baku'],
            ['type' => 'text', 'name' => 'kategori', 'label' => 'Kategori'],
            ['type' => 'text', 'name' => 'updated_at', 'label' => 'Di Inputkan Pada'],
            ['type' => 'number', 'name' => 'jumlah', 'label' => 'Jumlah (kg)'],
            ['type' => 'text', 'name' => 'supplier', 'label' => 'No Supplier'],
        ];

        return view('crud.bahan_baku.kelola_list', compact('fields', 'data', 'month'));
    }

    public function storeKelolaBahanBaku(Request $request, $id)
    {

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|string|max:255',
            'harga' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
        ]);

        $validated['bahan_id'] = $id;

        $bahanbaku = BahanBaku::findOrFail($id);

        if ($validated['kategori'] == 'masuk') {
            $bahanbaku['stok'] += $validated['jumlah'];
            Pengelolaan::create($validated);
            $pengeluaran['nominal'] = $validated['harga'];
            $pengeluaran['supplier'] = $validated['supplier'];
            $pengeluaran['kategori_id'] = 1;
            $pengeluaran['keterangan'] = 'bahanbaku-' . $validated['nama'];
            Pengeluaran::create($pengeluaran);
        } elseif ($validated['kategori'] == 'keluar') {
            $bahanbaku['stok'] -= $validated['jumlah'];
            Pengelolaan::create($validated);
        } else {
            $bahanbaku['stok'] -= $validated['jumlah'];
            Pengelolaan::create($validated);
        }

        $bahanbaku->save();

        return redirect('bahanbaku')->with('success', 'Data Pengelolaan berhasil ditambahkan');
    }
    public function exportLaporanBahanBaku($month)
    {

        if ($month == 'all') {


            $monthName = 'all';
        } else {

            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
        }

        return Excel::download(new LaporanBahanBakuExport($month), 'Laporan Bahan Baku-' . $monthName . '.xlsx');
    }
}
