<?php

namespace App\Http\Controllers;

use App\Exports\DataGajiExport;
use App\Exports\GajiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gaji;
use App\Models\Pinjaman;
use App\Models\Kehadiran;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
 
class PinjamanController extends Controller
{
    public function pinjaman(Request $request, $month = 'all')
    {
            $page = 'pinjaman'; 

            $id = Auth::user()->id;

            if($month == 'all'){
                $data = Pinjaman::where('user_id', $id)->with('user')->get()->map(function ($item) use ($id) {
                   
                    $item->bulan = Carbon::createFromDate(null, (int)$item->bulan, 1)->format('F');
              
                    return $item;
                });
            }else {
                $data = Pinjaman::where('user_id', $id)->with('user')->where('bulan', $month)->get()->map(function ($item) use ($id) {
                  
                    $item->bulan = Carbon::createFromDate(null, (int)$item->bulan, 1)->format('F');

                    return $item;
                });
            }

          

        
        
            $fields = [
                ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
                ['type' => 'number', 'name' => 'total', 'label' => 'total'],
                ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
            ];

    
            return view('crud.pinjaman.list', compact('page', 'fields', 'data', 'id', 'month'));

    }

    public function data(Request $request, $id = 'all', $month = 'all')
    {
            $page = 'pinjaman'; 

            if($id == 'all'){
    
                if ($month == 'all') {
                    $data = Pinjaman::with(['user' => function ($query) {
                        $query->whereIn('role', ['admin', 'karyawan']);
                    }])->get()->map(function ($item) {
                        if ($item->user) {
                            $item->user_name = $item->user->nama;
                            return $item;
                        }
                    })->filter();
                } else {
                    $data = Pinjaman::with(['user' => function ($query) {
                        $query->whereIn('role', ['admin', 'karyawan']);
                    }])->where('bulan', $month)->get()->map(function ($item) use ($month) {
                        if ($item->user) {
                            $item->user_name = $item->user->nama;

                            return $item;
                        }
                    })->filter();
                }
                
                $fields = [
                    ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama'],
                    ['type' => 'text', 'name' => 'tanggal', 'label' => 'Tanggal'],
                    ['type' => 'text', 'name' => 'total', 'label' => 'Ajuan Pinjaman'],
                    ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
                ];
    
        
                return view('crud.pinjaman.data', compact('page', 'fields', 'data', 'month'));

            } else {

                $data = Pinjaman::where('user_id', $id)->with('user')->get()->map(function ($item) use ($id) {
                    $item->user_name = $item->user->nama;
    
                    $item->bulan = Carbon::createFromDate(null, (int)$item->bulan, 1)->format('F');
            
                    return $item;
                });
    
                $fields = [
                    ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama'],
                    ['type' => 'text', 'name' => 'tanggal', 'label' => 'Tanggal'],
                    ['type' => 'text', 'name' => 'total', 'label' => 'Ajuan Pinjaman'],
                    ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
                ];
    
    
        
                return view('crud.pinjaman.dataById', compact('page', 'fields', 'data', 'id'));

            }



    }

    public function createPinjaman()
    {
        $page = 'pinjaman';
        $data = Gaji::select('total')->where('user_id', Auth::user()->id)->where('bulan', Carbon::now()->month)->first();

        $fields = [
            ['type' => 'number', 'name' => 'total', 'label' => 'Nominal'],
            ['type' => 'text', 'name' => 'gaji', 'label' => 'Total Gaji'],
            ['type' => 'text', 'name' => 'keterangan', 'label' => 'Keterangan'],
        ];

        return view('crud.pinjaman.add', compact('page', 'fields', 'data'));
    }

    public function storePinjaman(Request $request)
    {
        $validated = $request->validate([
            'total' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['tanggal'] =  Carbon::now()->toDateString(); 
        $validated['bulan'] =  Carbon::now()->month; 
        $validated['status'] = 1;

        Pinjaman::create($validated);

        return redirect('pinjaman')->with('success', 'Pinjaman berhasil ditambahkan');
    }

    public function verifikasi($id)
    {
            $page = 'pinjaman';

            $data = Pinjaman::where('id', $id)->with('user')->first();

    if ($data) {
        $data->user_name = $data->user->nama;

        $gaji = Gaji::select('total')->where('user_id', $data['user_id'])->where('bulan', Carbon::now()->month)->first();

        $data->gaji = $gaji['total'];

        $data->bulan = Carbon::createFromDate(null, (int)$data->bulan, 1)->format('F');
    }
 

    $fields = [
        ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama',  'value' => $data->user_name],
        ['type' => 'text', 'name' => 'total', 'label' => 'Nominal',  'value' => $data->total],
        ['type' => 'text', 'name' => 'total', 'label' => 'Gaji' ,  'value' => $data->gaji],
        ['type' => 'text', 'name' => 'keterangan', 'label' => 'Total' ,  'value' => $data->keterangan],
        ['type' => 'select', 'name' => 'status', 'label' => 'Status' , 'options' => ['1', '2' , '3'],  'value' => $data->status], 
    ];
            return view('crud.pinjaman.verifikasi', compact('id','page', 'fields', 'data'));

    }

    public function verifikasiStore(Request $request, $id)
    {
    
        $data = Pinjaman::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:1,2,3',
        ]);

        $data->update($validated);
        return redirect('data/pinjaman/'.$data['user_id'])->with('success', 'Verifikasi berhasil diperbarui');
    }

}
