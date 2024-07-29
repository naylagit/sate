<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Meja;
use App\Models\KategoriMenu;
use App\Models\KategoriPengeluaran;
use App\Models\Menu;

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



Meja::create([
    'nama' => 'Meja 1',
    'status' => '1'
], 
);

Meja::create([
    'nama' => 'Meja 2',
    'status' => '1'
], 
);

Meja::create([
    'nama' => 'Meja 3',
    'status' => '1'
], 
);

Meja::create([
    'nama' => 'Meja 4',
    'status' => '1'
], 
);

Meja::create([
    'nama' => 'Meja 5',
    'status' => '1'
], 
);

KategoriMenu::create([
    'nama' => 'Makanan'
], 
);

KategoriMenu::create([
    'nama' => 'Minuman'
], 
);

KategoriMenu::create([
    'nama' => 'Cemilan'
], 
);

KategoriPengeluaran::create([
    'nama' => 'Bahan Baku'
], 
);

KategoriPengeluaran::create([
    'nama' => 'Listrik'
], 
);

KategoriPengeluaran::create([
    'nama' => 'Gaji'
], 
);

Menu::create([
    'nama' => 'Makanan 1',
    'kategori_id' => '1',
    'harga' => '15000',
    'status' => '1',
], 
);

Menu::create([
    'nama' => 'Makanan 2',
    'kategori_id' => '1',
    'harga' => '20000',
    'status' => '1',
], 
);

Menu::create([
    'nama' => 'Minuman 1',
    'kategori_id' => '2',
    'harga' => '5000',
    'status' => '1',
], 
);

Menu::create([
    'nama' => 'Minuman 2',
    'kategori_id' => '2',
    'harga' => '8000',
    'status' => '1',
], 
);

Menu::create([
    'nama' => 'Cemilan 1',
    'kategori_id' => '3',
    'harga' => '8000',
    'status' => '1',
], 
);


    }
}
