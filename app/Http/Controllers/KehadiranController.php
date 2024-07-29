<?php

namespace App\Http\Controllers;

use App\Exports\DataKehadiranExport;
use App\Models\User;
use App\Models\Kehadiran;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\KehadiranExport;
use App\Exports\KehadiranUserExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

use Illuminate\Http\Request;

class KehadiranController extends Controller
{


    public function kehadiran(Request $request, $month = 'all')
    {
        $page = 'kehadiran';
        $id = Auth::user()->id;

        if ($month == 'all') {
            $data = Kehadiran::with('user')->orderBy('tanggal', 'DESC')->where('user_id', $id)->get()->map(function ($item) {
                $item->nama = $item->user->nama;
                return $item;
            });
        } else {
            $data = Kehadiran::with('user')->orderBy('tanggal', 'DESC')->where('user_id', $id)->whereMonth('tanggal', $month)->get()->map(function ($item) {
                $item->nama = $item->user->nama;
                return $item;
            });
        }

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
            ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
            ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
            ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
        ];


        return view('crud.kehadiran.list', compact('page', 'fields', 'data', 'id', 'month'));
    }

    public function createKehadiran()
    {
        $page = 'kehadiran';
        $fields = [
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir'],],
            ['type' => 'file', 'name' => 'foto', 'label' => 'Foto (Opsional)'],
        ];

        return view('crud.kehadiran.add', compact('page', 'fields'));
    }

    public function storeKehadiran(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:hadir,izin,tidak hadir',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['verifikasi'] = 'belum diverifikasi';

        $validated['tanggal'] = Carbon::now()->toDateString();
        $validated['waktu'] = Carbon::now()->toTimeString();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Auth::user()->nama . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/fotos', $filename);
            $validated['foto'] = $filename;
        }

        Kehadiran::create($validated);

        return redirect('kehadiran')->with('success', 'Kehadiran berhasil ditambahkan');
    }

    public function data($id = 'all', $month = 'all')
    {
        $page = 'kehadiran';

        if ($id == 'all') {
            if (Auth::user()->role == 'owner') {
                $role = ['admin', 'karyawan'];
            } else {
                $role = ['karyawan'];
            }

            $data = User::with(['todaysKehadiran'])->whereIn('role', $role)->get()->map(function ($item) use ($month) {
                $item->todays_kehadiran_status = $item->todaysKehadiran ? $item->todaysKehadiran->status : false;
                $item->verifikasi = $item->todaysKehadiran ? $item->todaysKehadiran->verifikasi : null;

                if ($month != 'all') {
                    $item->hadir = Kehadiran::where('user_id', $item->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','hadir')->whereMonth('tanggal', $month)->get()->count();
                    $item->izin = Kehadiran::where('user_id', $item->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','izin')->whereMonth('tanggal', $month)->get()->count();
                    $item->tidak_hadir = Kehadiran::where('user_id', $item->id)
                    ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi' )->where('status','tidak hadir')->whereMonth('tanggal', $month)->get()->count();
                } else {
                    $item->hadir = Kehadiran::where('user_id', $item->id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'hadir')->get()->count();
                    $item->izin = Kehadiran::where('user_id', $item->id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'izin')->get()->count();
                    $item->tidak_hadir = Kehadiran::where('user_id', $item->id)
                        ->whereYear('tanggal', Carbon::now()->year)->where('verifikasi', 'diverifikasi')->where('status', 'tidak hadir')->get()->count();
                }
                return $item;
            });
            $fields = [
                ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
                ['type' => 'text', 'name' => 'role', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'todays_kehadiran_status', 'label' => 'Kehadiran Hari Ini'],
                ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Status'],
                ['type' => 'text', 'name' => 'hadir', 'label' => 'Hadir'],
                ['type' => 'text', 'name' => 'izin', 'label' => 'Izin'],
                ['type' => 'text', 'name' => 'tidak_hadir', 'label' => 'Tidak Hadir'],
            ];

            return view('crud.kehadiran.data', compact('page', 'fields', 'data', 'month'));
        } else {

            $page = 'kehadiran';

            if ($month == 'all') {
                $data = Kehadiran::with('user')->orderBy('tanggal', 'DESC')->where('user_id', $id)->get()->map(function ($item) {
                    $item->nama = $item->user->nama;
                    return $item;
                });
            } else {
                $data = Kehadiran::with('user')->orderBy('tanggal', 'DESC')->where('user_id', $id)->whereMonth('tanggal', $month)->get()->map(function ($item) {
                    $item->nama = $item->user->nama;
                    return $item;
                });
            }

            $fields = [
                ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
                ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
                ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
                ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
                ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
                ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
            ];


            return view('crud.kehadiran.list', compact('page', 'fields', 'data', 'id', 'month'));
        }
    }

    public function verifikasi($id)
    {
        $page = 'kehadiran';
        $data = Kehadiran::findOrFail($id);
        $user = User::findOrFail($data['user_id']);

        $data['nama'] = $user['nama'];
        $data['role'] = $user['role'];

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama',  'value' => $data->nama],
            ['type' => 'text', 'name' => 'role', 'label' => 'Role',  'value' => $data->role],
            ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu',  'value' => $data->waktu],
            ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal',  'value' => $data->tanggal],
            ['type' => 'text', 'name' => 'status', 'label' => 'Status',  'value' => $data->status],
            ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi'],  'value' => $data->verifikasi],

        ];

        return view('crud.kehadiran.verifikasi', compact('id', 'page', 'fields', 'data', 'user'));
    }

    public function verifikasiStore(Request $request, $id)
    {

        $data = Kehadiran::findOrFail($id);

        $validated = $request->validate([
            'verifikasi' => 'required|string|in:diverifikasi,belum diverifikasi',
        ]);

        $data->update($validated);

        return redirect('data/kehadiran/' . $data['user_id'])->with('success', 'Kehadiran berhasil diperbarui');
    }



    public function export($month = null, $id = null)
    {
        $user = User::findOrFail($id);

        if ($month == 'all') {
            $monthName = 'all';
        } else {
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F');
        }

        return Excel::download(new KehadiranExport($month, $id), 'Kehadiran-' . $user['nama'] . '-' . $monthName . '.xlsx');
    }

    public function exportData($month = null)
    {
        $dateObj = DateTime::createFromFormat('!m', $month);
        $monthName = $dateObj->format('F');
        return Excel::download(new DataKehadiranExport($month), 'Data Kehadiran-' . $monthName . '.xlsx');
    }






















    // public function kehadiranUser($month = 'all'){

    //     $page = 'kehadiran'; 

    //     $id = Auth::user()->id;


    //     if($month == 'all'){

    //         $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$id )->get()->map(function ($item) {
    //             $item->nama = $item->user->nama;
    //             return $item;
    //         });

    //     } else {

    //         $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$id )->whereMonth('tanggal', $month)->get()->map(function ($item) {
    //             $item->nama = $item->user->nama;
    //             return $item;
    //         });

    //     }
    //         $fields = [
    //             ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
    //             ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
    //             ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
    //             ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
    //             ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
    //             ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
    //         ];

    //         return view('crud.kehadiran.listById', compact('page', 'fields', 'data', 'id', 'month'));
    // }

    // public function kehadiranUserExport($month = 'all'){

    //     if($month == 'all'){
    //         $monthName = 'all'; 
    //     } else {

    //         $dateObj = DateTime::createFromFormat('!m', $month);
    //         $monthName = $dateObj->format('F');    
    //     }

    //     $id = Auth::user()->id;
    //     $user = User::findOrFail($id);

    //     return Excel::download(new KehadiranUserExport($month, $id), 'Laporan Kehadiran -'.$user['nama'].'-'.$monthName.'.xlsx');
    // }



    // public function getKehadiranByUserId($id){

    //     $page = 'kehadiran'; 

    //     $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$id )->get()->map(function ($item) {
    //         $item->nama = $item->user->nama;
    //         return $item;
    //     });

    //     $fields = [
    //         ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
    //         ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
    //         ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
    //         ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
    //         ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
    //         ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
    //     ];


    //     return view('crud.kehadiran.list', compact('page', 'fields', 'data'));
    // }

    // public function getKehadiran(){

    //     $page = 'kehadiran'; 

    //     $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',Auth::user()->id )->get()->map(function ($item) {
    //         $item->nama = $item->user->nama;
    //         return $item;
    //     });

    //     $fields = [
    //         ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
    //         ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
    //         ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
    //         ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
    //         ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
    //         ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
    //     ];


    //     return view('crud.list', compact('page', 'fields', 'data'));
    // }


















}
