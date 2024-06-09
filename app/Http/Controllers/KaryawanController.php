<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function karyawan()
    {
        $page = 'karyawan';
        $data = User::where('role','karyawan')->get();
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email'],
            ['type' => 'text', 'name' => 'tempat_lahir', 'label' => 'Tempat Lahir'],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir'],
            ['type' => 'select', 'name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'options' => ['laki-laki', 'perempuan']],
            ['type' => 'text', 'name' => 'alamat', 'label' => 'Alamat'],
            ['type' => 'text', 'name' => 'no_telp', 'label' => 'No Telepon'],
            ['type' => 'select', 'name' => 'status', 'label' => 'Status']
   
        ];

        return view('crud.list', compact('page', 'fields', 'data'));
    }
    public function createKaryawan()
    {
        $page = 'karyawan';
        $fields = [
            ['type' => 'text', 'name' => 'nama', 'label' => 'Nama'],
            ['type' => 'email', 'name' => 'email', 'label' => 'Email'],
            ['type' => 'password', 'name' => 'password', 'label' => 'Password'],
            ['type' => 'text', 'name' => 'tempat_lahir', 'label' => 'Tempat Lahir'],
            ['type' => 'date', 'name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir'],
            ['type' => 'select', 'name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'options' => ['laki-laki', 'perempuan']],
            ['type' => 'text', 'name' => 'alamat', 'label' => 'Alamat'],
            ['type' => 'text', 'name' => 'no_telp', 'label' => 'No Telepon']
        ];

        return view('crud.add', compact('page', 'fields'));
    }

    public function storeKaryawan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $validated['role'] = 'karyawan';
        $validated['status'] = 'aktif';

        User::create($validated);

        return redirect('karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function editKaryawan($id)
    {
        $data = User::findOrFail($id);
        $fields = [
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text', 'value' => $data->nama],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $data->email],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'value' => ''],
            ['name' => 'tempat_lahir', 'label' => 'Tempat Lahir', 'type' => 'text', 'value' => $data->tempat_lahir],
            ['name' => 'tanggal_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date', 'value' => $data->tanggal_lahir],
            ['name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'options' => ['laki-laki', 'perempuan'], 'value' => $data->jenis_kelamin],
            ['name' => 'alamat', 'label' => 'Alamat', 'type' => 'text', 'value' => $data->alamat],
            ['name' => 'no_telp', 'label' => 'No. Telepon', 'type' => 'text', 'value' => $data->no_telp],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'value' => $data->status, 'options' => ['aktif', 'non-aktif']],  
        ];

        return view('crud.edit', ['fields' => $fields, 'data' => $data, 'page' => 'karyawan']);
    }

    public function updateKaryawan(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);


        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$karyawan->id,
            'password' => 'nullable|string|min:8',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'status' => 'required|string|max:50',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }


        $karyawan->update($validated);

        return redirect('karyawan')->with('success', 'Karyawan berhasil diperbarui');
    }

     public function destroyKaryawan($id)
     {
         $karyawan = User::findOrFail($id);
         $karyawan->delete();
 
         return redirect('karyawan')->with('success', 'Karyawan berhasil dihapus');
     }





}
