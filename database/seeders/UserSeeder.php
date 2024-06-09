<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('owner123'), 
            'tempat_lahir' => 'New York',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => '123 Main St, New York, NY',
            'no_telp' => '1234567890',
            'role' => 'owner',
            'status' => 'aktif',
        ], 
    );

    User::create([
        'nama' => 'admin1',
        'email' => 'admin1@gmail.com',
        'password' => Hash::make('admin123'), 
        'tempat_lahir' => 'New York',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'laki-laki',
        'alamat' => '123 Main St, New York, NY',
        'no_telp' => '1234567890',
        'role' => 'admin',
        'status' => 'aktif',
    ], 
);

User::create([
    'nama' => 'karyawan1',
    'email' => 'karyawan1@gmail.com',
    'password' => Hash::make('karyawan123'), 
    'tempat_lahir' => 'New York',
    'tanggal_lahir' => '1990-01-01',
    'jenis_kelamin' => 'laki-laki',
    'alamat' => '123 Main St, New York, NY',
    'no_telp' => '1234567890',
    'role' => 'karyawan',
    'status' => 'aktif',
], 
);

User::create([
    'nama' => 'karyawan2',
    'email' => 'karyawan2@gmail.com',
    'password' => Hash::make('karyawan123'), 
    'tempat_lahir' => 'New York',
    'tanggal_lahir' => '1990-01-01',
    'jenis_kelamin' => 'perempuan',
    'alamat' => '123 Main St, New York, NY',
    'no_telp' => '1234567890',
    'role' => 'karyawan',
    'status' => 'aktif',
], 
);

User::create([
    'nama' => 'karyawan3',
    'email' => 'karyawan3@gmail.com',
    'password' => Hash::make('karyawan123'), 
    'tempat_lahir' => 'New York',
    'tanggal_lahir' => '1990-01-01',
    'jenis_kelamin' => 'perempuan',
    'alamat' => '123 Main St, New York, NY',
    'no_telp' => '1234567890',
    'role' => 'karyawan',
    'status' => 'aktif',
], 
);
    }
}
