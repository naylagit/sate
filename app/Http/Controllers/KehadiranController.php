<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\KehadiranExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    // public function kehadiran()
    // {
    //     $page = 'kehadiran';
    //     $data = Kehadiran::with('user')->orderBy('tanggal')->get()->map(function ($item) {
    //         $item->nama = $item->user->nama;
    //         return $item;
    //     });

    //     $fields = [
    //         ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'], // Add this line
    //         ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
    //         ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
    //         ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
    //         ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
    //     ];

    //     return view('crud.list', compact('page', 'fields', 'data'));
    // }


    public function kehadiran(Request $request, $month = null)
    {
        $page = 'kehadiran';

        if(Auth::user()->role == 'owner'){
            $data = User::with(['todaysKehadiran'])->whereIn('role', ['admin', 'karyawan'])->get()->map(function ($item) use ($month) {
                $item->todays_kehadiran_status = $item->todaysKehadiran ? $item->todaysKehadiran->status : false;
                $item->verifikasi = $item->todaysKehadiran ? $item->todaysKehadiran->verifikasi : null;

                $query = Kehadiran::where('user_id', $item->id)
                ->whereYear('tanggal', Carbon::now()->year);

                if ($month) {
                    $query->whereMonth('tanggal', $month);
                } else {
                    $query->whereMonth('tanggal', Carbon::now()->month);
                }

                $attendances = $query->get();

                

    $item->monthly_attendance = $attendances->count();

                return $item;
            });

            $fields = [
                ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
                ['type' => 'text', 'name' => 'role', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'todays_kehadiran_status', 'label' => 'Kehadiran Hari Ini'],
                ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Status'],
                ['type' => 'text', 'name' => 'monthly_attendance', 'label' => 'Total Kehadiran'],
            ];

            return view('kehadiran.list', compact('page', 'fields', 'data'));

        } elseif(Auth::user()->role == 'admin'){
            $data = User::with(['todaysKehadiran'])->where('role', 'karyawan')->get()->map(function ($item) {
                $item->todays_kehadiran_status = $item->todaysKehadiran ? $item->todaysKehadiran->status : false;
                $item->verifikasi = $item->todaysKehadiran ? $item->todaysKehadiran->verifikasi : null;
                return $item;
            });

            $fields = [
                ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
                ['type' => 'text', 'name' => 'role', 'label' => 'Role'],
                ['type' => 'select', 'name' => 'todays_kehadiran_status', 'label' => 'Kehadiran Hari Ini'],
                ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Status'],
            ];

            return view('kehadiran.list', compact('page', 'fields', 'data'));
        }
        
        
        // else {
        //     $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id', Auth::user()->id )->get()->map(function ($item) {
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

    public function getKehadiranById($id){

        $page = 'kehadiran'; 

        $data = Kehadiran::with('user')->orderBy('tanggal','DESC')->where('user_id',$id )->get()->map(function ($item) {
            $item->nama = $item->user->nama;
            return $item;
        });

        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'time', 'name' => 'waktu', 'label' => 'Waktu'],
            ['type' => 'date', 'name' => 'tanggal', 'label' => 'Tanggal'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir']],
            ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi']],
            ['type' => 'foto', 'name' => 'foto', 'label' => 'Foto'],
        ];


        return view('crud.list', compact('page', 'fields', 'data'));
    }

    public function createKehadiran()
    {
        $page = 'kehadiran';
        $fields = [
            ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir'],],
            ['type' => 'file', 'name' => 'foto', 'label' => 'Foto'],
        ];

        return view('crud.add', compact('page', 'fields'));
    }

    public function storeKehadiran(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:hadir,izin,tidak hadir',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validate image file
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['verifikasi'] = 'belum diverifikasi';

        $validated['tanggal'] = Carbon::now()->toDateString(); 
        $validated['waktu'] = Carbon::now()->toTimeString(); 

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Auth::user()->nama . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/fotos', $filename);
            $validated['foto'] = $filename; // Store the filename in the database
        }
    

        Kehadiran::create($validated);

        return redirect('kehadiran/'. Auth::user()->id)->with('success', 'Admin berhasil ditambahkan');
    }

    public function editKehadiran($id)
    {

        if(Auth::user()->role == 'owner'){

            $page = 'kehadiran';
            $data = Kehadiran::findOrFail($id);
    
            $fields = [
                ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir'],'value' => $data->status],
                ['type' => 'file', 'name' => 'foto', 'label' => 'Foto', 'value' => $data->foto],
                ['type' => 'select', 'name' => 'verifikasi', 'label' => 'Verifikasi', 'options' => ['diverifikasi', 'belum diverifikasi'],'value' => $data->verifikasi],
            ];
    
            return view('crud.edit', compact('page', 'fields', 'data'));

        } else {

            $page = 'kehadiran';
            $data = Kehadiran::findOrFail($id);
    
            $fields = [
                ['type' => 'select', 'name' => 'status', 'label' => 'Status', 'options' => ['hadir', 'izin', 'tidak hadir'],'value' => $data->status],
                ['type' => 'file', 'name' => 'foto', 'label' => 'Foto', 'value' => $data->foto],
            ];
    
            return view('crud.edit', compact('page', 'fields', 'data'));

        }
       
    }

    public function updateKehadiran(Request $request, $id)
    {
    
        $data = Kehadiran::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:hadir,izin,tidak hadir',
            'verifikasi' => 'nullable|string|in:diverifikasi,belum diverifikasi',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Auth::user()->nama . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/fotos', $filename);
            $validated['foto'] = $filename; 
        }

        if (!$request->filled('verifikasi')) {
            $validated['verifikasi'] = 'belum diverifikasi';
        } 

    
        $data->update($validated);

        return redirect('kehadiran/'. Auth::user()->id)->with('success', 'Kehadiran berhasil diperbarui');
    }


     public function destroyKehadiran($id)
     {
         $kehadiran = Kehadiran::findOrFail($id);
         $kehadiran->delete();
 
         return redirect('kehadiran/'. Auth::user()->id)->with('success', 'Kehadiran berhasil dihapus');
     }

     public function exportList($month = null)
     {

        //  $kehadiran = Kehadiran::findOrFail($id);
        //  $kehadiran->delete();
 
        //  return redirect('kehadiran/'. Auth::user()->id)->with('success', 'Kehadiran berhasil dihapus');

        return Excel::download(new KehadiranExport($month), 'kehadiran.xlsx');
     }





}
