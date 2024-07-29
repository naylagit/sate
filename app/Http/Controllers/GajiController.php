<?php

namespace App\Http\Controllers;
 
use App\Exports\DataGajiExport;
use App\Exports\GajiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gaji;
use App\Models\Kehadiran;
use App\Models\Pinjaman;
use App\Models\Pengeluaran;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{
    public function gaji(Request $request)
    {
            $page = 'gaji'; 

            $id = Auth::user()->id;

            $gajiExist = Gaji::where('user_id', $id)->where('bulan', Carbon::now()->month)->first();

            if(!$gajiExist){

                $kehadiran = Kehadiran::where('user_id', $id)->where('status', 'hadir')->where('verifikasi', 'diverifikasi')->whereMonth('tanggal', Carbon::now()->month)->get();
                $total = count($kehadiran) * 50000;


                Gaji::create([
                    'user_id' => $id,
                    'bulan' => Carbon::now()->month,
                    'total' => $total,
                    'status' => 1,
                ]);

            } else {

                $kehadiran = Kehadiran::where('user_id', $id)->where('status', 'hadir')->where('verifikasi', 'diverifikasi')->whereMonth('tanggal', Carbon::now()->month)->get();
                $total = count($kehadiran) * 50000;

                $gajiExist->update([
                    'total' => $total
                ]);

            }


            $data = Gaji::where('user_id', $id)->with('user')->get()->map(function ($item) use ($id) {


                $item->user_name = $item->user->nama;

                $attendancesCount = Kehadiran::where('user_id', $id)
                    ->whereMonth('tanggal', $item->bulan)
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->where('status', 'hadir')
                    ->count();

                    $pinjaman = Pinjaman::where('user_id', $id)->where('bulan', $item->bulan)->where('status', 3)->get();
                    $item->pinjaman = $pinjaman->sum('total');
        
                $item->total_kehadiran = $attendancesCount;
                $item->bulan = Carbon::createFromDate(null, (int)$item->bulan, 1)->format('F');

                $item->total_gaji = $item->total - $item->pinjaman;
          
                return $item;
            });


            $fields = [
                ['type' => 'text', 'name' => 'bulan', 'label' => 'Bulan'],
                ['type' => 'text', 'name' => 'total_kehadiran', 'label' => 'Total Kehadiran'],
                ['type' => 'number', 'name' => 'total', 'label' => 'Gaji'],
                ['type' => 'number', 'name' => 'pinjaman', 'label' => 'Pinjaman'],
                ['type' => 'number', 'name' => 'total_gaji', 'label' => 'Total'],
                ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
            ];

    
            return view('crud.gaji.list', compact('page', 'fields', 'data', 'id'));

    }

    public function data(Request $request, $id = 'all', $month = 'all')
    {
            $page = 'gaji'; 

            if($id == 'all'){

                $users = User::whereIn('role', ['admin', 'karyawan'])->get();

                foreach($users as $user){
    
                    $gajiExist = Gaji::where('user_id', $user['id'])->where('bulan', Carbon::now()->month)->first();
    
                    if(!$gajiExist){
    
                        $kehadiran = Kehadiran::where('user_id', $user['id'])->where('status', 'hadir')->where('verifikasi', 'diverifikasi')->whereMonth('tanggal', Carbon::now()->month)->get();
                        $total = count($kehadiran) * 50000;
        
        
                        Gaji::create([
                            'user_id' => $user['id'],
                            'bulan' => Carbon::now()->month,
                            'total' => $total,
                            'status' => 1,
                        ]);
                    } else {

                        $kehadiran = Kehadiran::where('user_id',$user['id'] )->where('status', 'hadir')->where('verifikasi', 'diverifikasi')->whereMonth('tanggal', Carbon::now()->month)->get();
                        $total = count($kehadiran) * 50000;
        
                        $gajiExist->update([
                            'total' => $total
                        ]);

                    }
        
                }
    
                if ($month == 'all') {
                    $data = Gaji::with(['user' => function ($query) {
                        $query->whereIn('role', ['admin', 'karyawan']);
                    }])->get()->map(function ($item) {
                        if ($item->user) {
                            $item->user_name = $item->user->nama;
                            $item->total_kehadiran = Kehadiran::where('user_id', $item->user_id)->where('verifikasi','diverifikasi')->count();
                            $pinjaman = Pinjaman::where('user_id', $item->user_id)->where('bulan', $item->bulan)->where('status', 3)->get();
                            $item->pinjaman = $pinjaman->sum('total');
                            $item->total_gaji = $item->total - $item->pinjaman;
                            
                            return $item;
                        }
                    })->filter();
                } else {
                    $data = Gaji::with(['user' => function ($query) {
                        $query->whereIn('role', ['admin', 'karyawan']);
                    }])->where('bulan', $month)->get()->map(function ($item) use ($month) {
                        if ($item->user) {
                            $item->user_name = $item->user->nama;
                            $item->total_kehadiran = Kehadiran::where('user_id', $item->user_id)
                                                              ->whereMonth('tanggal', $month)->where('verifikasi','diverifikasi')
                                                              ->count();
                                                              $pinjaman = Pinjaman::where('user_id', $item->user_id)->where('bulan', $item->bulan)->where('status', 3)->get();
                                                              $item->pinjaman = $pinjaman->sum('total');
                                                              $item->total_gaji = $item->total - $item->pinjaman;
                            return $item;
                        }
                    })->filter();
                }
                
                $fields = [
                    ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama'],
                    ['type' => 'text', 'name' => 'total_kehadiran', 'label' => 'Total Kehadiran'],
                    ['type' => 'number', 'name' => 'total', 'label' => 'Gaji'],
                    ['type' => 'number', 'name' => 'pinjaman', 'label' => 'Pinjaman'],
                    ['type' => 'number', 'name' => 'total_gaji', 'label' => 'Total'],
                    ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
                ];
    
        
                return view('crud.gaji.data', compact('page', 'fields', 'data', 'month'));

            } else {


                $gajiExist = Gaji::where('user_id', $id)->where('bulan', Carbon::now()->month)->first();
    
                if(!$gajiExist){
    
                    $kehadiran = Kehadiran::where('user_id', $id)->whereMonth('tanggal', Carbon::now()->month)->get();
                    $total = count($kehadiran) * 50000;
    
    
                    Gaji::create([
                        'user_id' => $id,
                        'bulan' => Carbon::now()->month,
                        'total' => $total,
                        'status' => 1,
                    ]);
                }
    
    
                $data = Gaji::where('user_id', $id)->with('user')->get()->map(function ($item) use ($id) {


                    $item->user_name = $item->user->nama;
    
                    $attendancesCount = Kehadiran::where('user_id', $id)
                        ->whereMonth('tanggal', $item->bulan)
                        ->whereYear('tanggal', Carbon::now()->year)
                        ->where('status', 'hadir')
                        ->count();

                        $pinjaman = Pinjaman::where('user_id', $id)->where('bulan', $item->bulan)->where('status', 3)->get();
                        $item->pinjaman = $pinjaman->sum('total');
            
                    $item->total_kehadiran = $attendancesCount;
                    $item->bulan = Carbon::createFromDate(null, (int)$item->bulan, 1)->format('F');
                    $item->total_gaji = $item->total - $item->pinjaman;
            
                    return $item;
                });
    
                $fields = [
                    ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama'],
                    ['type' => 'text', 'name' => 'bulan', 'label' => 'Bulan'],
                    ['type' => 'text', 'name' => 'total_kehadiran', 'label' => 'Total Kehadiran'],
                    ['type' => 'number', 'name' => 'total', 'label' => 'Gaji'],
                    ['type' => 'number', 'name' => 'pinjaman', 'label' => 'Pinjaman'],
                    ['type' => 'number', 'name' => 'total_gaji', 'label' => 'Total'],
                    ['type' => 'text', 'name' => 'status', 'label' => 'Status'],
                ];
    
    
        
                return view('crud.gaji.dataById', compact('page', 'fields', 'data', 'id'));

            }



    }

    public function verifikasi($id)
    {
            $page = 'gaji';

            $data = Gaji::where('id', $id)->with('user')->first();

    if ($data) {
        // Get the user's name
        $data->user_name = $data->user->nama;

        $attendancesCount = Kehadiran::where('user_id', $data->user_id)
            ->whereMonth('tanggal', $data->bulan)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', 'hadir')
            ->count();

        $data->total_kehadiran = $attendancesCount;

        $data->bulan = Carbon::createFromDate(null, (int)$data->bulan, 1)->format('F');
    }


            $fields = [
                ['type' => 'text', 'name' => 'user_name', 'label' => 'Nama',  'value' => $data->user_name],
                ['type' => 'text', 'name' => 'bulan', 'label' => 'Bulan',  'value' => $data->bulan],
                ['type' => 'text', 'name' => 'total_kehadiran', 'label' => 'Total Kehadiran',  'value' => $data->total_kehadiran],
                ['type' => 'number', 'name' => 'total', 'label' => 'Gaji' ,  'value' => $data->total],
                ['type' => 'number', 'name' => 'total', 'label' => 'Total' ,  'value' => $data->total],
                ['type' => 'select', 'name' => 'status', 'label' => 'Status' , 'options' => ['1', '2' , '3'],  'value' => $data->status], 
            ];

        
            
            return view('crud.gaji.verifikasi', compact('id','page', 'fields', 'data'));

    }

    public function verifikasiStore(Request $request, $id)
    {
    
        $data = Gaji::with('user')->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:1,2,3',
        ]);

        if($validated['status'] == 3){

            Pengeluaran::create([
                'nominal' => $data['total'],
                'kategori_id' => 3,
                'keterangan' => 'Gaji-'.$data->user->nama
            ]);

        }

        $data->update($validated);

        return redirect('data/gaji/'.$data['user_id'])->with('success', 'Gaji berhasil diperbarui');
    }


    public function export($id = null)
    {
           $user = User::findOrFail($id);
           return Excel::download(new GajiExport( $id), 'Data Gaji-'.$user['nama'].'.xlsx');
    }

    public function exportData($month = null)
    {
           $dateObj = DateTime::createFromFormat('!m', $month);
           $monthName = $dateObj->format('F'); 
           return Excel::download(new DataGajiExport($month), 'Data Gaji-'.$monthName.'.xlsx');
    }


}
