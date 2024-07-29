<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\KategoriPengeluaranController;
use App\Http\Controllers\inventoriController;
use App\Models\Pesanan;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('karyawan', [KaryawanController::class, 'karyawan'])->middleware('auth');
Route::get('karyawan/create', [KaryawanController::class, 'createKaryawan'])->middleware('auth');
Route::post('karyawan', [KaryawanController::class, 'storeKaryawan'])->middleware('auth');
Route::get('karyawan/{id}/edit', [KaryawanController::class, 'editKaryawan'])->middleware('auth');
Route::put('karyawan/{id}', [KaryawanController::class, 'updateKaryawan'])->middleware('auth');
Route::delete('karyawan/{id}', [KaryawanController::class, 'destroyKaryawan'])->middleware('auth');


Route::get('admin', [AdminController::class, 'admin'])->middleware('auth');
Route::get('admin/create', [AdminController::class, 'createAdmin'])->middleware('auth');
Route::post('admin', [AdminController::class, 'storeAdmin'])->middleware('auth');
Route::get('admin/{id}/edit', [AdminController::class, 'editAdmin'])->middleware('auth');
Route::put('admin/{id}', [AdminController::class, 'updateAdmin'])->middleware('auth');
Route::delete('admin/{id}', [AdminController::class, 'destroyAdmin'])->middleware('auth');



// Crud data karyawan/admin
Route::get('kehadiran/{month?}', [KehadiranController::class, 'kehadiran'])->middleware('auth');
Route::get('create/kehadiran', [KehadiranController::class, 'createKehadiran'])->middleware('auth');
Route::post('kehadiran', [KehadiranController::class, 'storeKehadiran'])->middleware('auth');

// Verifikasi kehadiran
Route::get('data/kehadiran/{id?}/{month?}', [KehadiranController::class, 'data'])->middleware('auth');
Route::get('verifikasi/kehadiran/{id?}', [KehadiranController::class, 'verifikasi'])->middleware('auth');
Route::put('verifikasi/kehadiran/{id?}', [KehadiranController::class, 'verifikasiStore'])->middleware('auth');

// export data kehadiran
Route::get('export/kehadiran/{month?}/{id?}', [KehadiranController::class, 'export'])->middleware('auth');
Route::get('export/data/kehadiran/{month?}', [KehadiranController::class, 'exportData'])->middleware('auth');
 
// Crud Gaji karyawan/admin
Route::get('gaji/', [GajiController::class, 'gaji'])->middleware('auth');

// Verifikasi Gaji Karyawan
Route::get('data/gaji/{id?}/{month?}', [GajiController::class, 'data'])->middleware('auth');
Route::get('verifikasi/gaji/{id?}', [GajiController::class, 'verifikasi'])->middleware('auth');
Route::put('verifikasi/gaji/{id?}', [GajiController::class, 'verifikasiStore'])->middleware('auth');

// export data gaji 
Route::get('export/gaji/{id?}', [GajiController::class, 'export'])->middleware('auth');
Route::get('export/data/gaji/{month?}', [GajiController::class, 'exportData'])->middleware('auth');


// Crud Pinjaman karyawan/admin
Route::get('pinjaman/{month?}', [PinjamanController::class, 'pinjaman'])->middleware('auth');
Route::get('create/pinjaman', [PinjamanController::class, 'createPinjaman'])->middleware('auth');
Route::post('pinjaman', [PinjamanController::class, 'storePinjaman'])->middleware('auth');

// Verifikasi Pinjaman Karyawan
Route::get('data/pinjaman/{id?}/{month?}', [PinjamanController::class, 'data'])->middleware('auth');
Route::get('verifikasi/pinjaman/{id?}', [PinjamanController::class, 'verifikasi'])->middleware('auth');
Route::put('verifikasi/pinjaman/{id?}', [PinjamanController::class, 'verifikasiStore'])->middleware('auth');

// export data Pinjaman 
Route::get('export/pinjaman/{id?}', [PinjamanController::class, 'export'])->middleware('auth');
Route::get('export/data/pinjaman/{month?}', [PinjamanController::class, 'exportData'])->middleware('auth');


// Menu
Route::get('menu', [MenuController::class, 'menu'])->middleware('auth');
Route::get('menu/create', [MenuController::class, 'createMenu'])->middleware('auth');
Route::post('menu', [MenuController::class, 'storeMenu'])->middleware('auth');
Route::get('menu/{id}/edit', [MenuController::class, 'editMenu'])->middleware('auth');
Route::put('menu/{id}', [MenuController::class, 'updateMenu'])->middleware('auth');
Route::delete('menu/{id}', [MenuController::class, 'destroyMenu'])->middleware('auth');

// Meja
Route::get('meja', [MejaController::class, 'meja'])->middleware('auth');
Route::get('meja/create', [MejaController::class, 'createMeja'])->middleware('auth');
Route::post('meja', [MejaController::class, 'storeMeja'])->middleware('auth');
Route::get('meja/{id}/edit', [MejaController::class, 'editMeja'])->middleware('auth');
Route::put('meja/{id}', [MejaController::class, 'updateMeja'])->middleware('auth');
Route::delete('meja/{id}', [MejaController::class, 'destroyMeja'])->middleware('auth');


//Pesanan
Route::get('/', [PesananController::class, 'dashboard'])->middleware('auth');
Route::get('pesanan', [PesananController::class, 'pesanan'])->middleware('auth');
Route::get('penjualan', [PesananController::class, 'penjualan'])->middleware('auth');
Route::get('pesanan/create', [PesananController::class, 'createPesanan'])->middleware('auth');
Route::post('pesanan', [PesananController::class, 'storePesanan'])->middleware('auth');
Route::get('pesanan/{id}/edit', [PesananController::class, 'editPesanan'])->middleware('auth');
Route::get('pesanan/{id}/editpending', [PesananController::class, 'editPesananPending'])->middleware('auth');
Route::put('pesanan/{id}', [PesananController::class, 'updatePesanan'])->middleware('auth');
Route::delete('pesanan/{id}', [PesananController::class, 'destroyPesanan'])->middleware('auth');
Route::get('penjualan/export', [PesananController::class, 'exportPenjualan'])->middleware('auth');
Route::get('keuntungan/export', [PesananController::class, 'export'])->middleware('auth');

//Pengeluaran
Route::get('pengeluaran', [PengeluaranController::class, 'pengeluaran'])->middleware('auth');
Route::get('pengeluaran/create', [PengeluaranController::class, 'createPengeluaran'])->middleware('auth');
Route::post('pengeluaran', [PengeluaranController::class, 'storePengeluaran'])->middleware('auth');
Route::get('pengeluaran/{id}/edit', [PengeluaranController::class, 'editPengeluaran'])->middleware('auth');
Route::put('pengeluaran/{id}', [PengeluaranController::class, 'updatePengeluaran'])->middleware('auth');
Route::delete('pengeluaran/{id}', [PengeluaranController::class, 'destroyPengeluaran'])->middleware('auth');
Route::get('pengeluaran/export', [PengeluaranController::class, 'export'])->middleware('auth');


//Pemasukan
Route::get('pemasukan', [PemasukanController::class, 'pemasukan'])->middleware('auth');
Route::get('pemasukan/export', [PemasukanController::class, 'export'])->middleware('auth');


// Kategori Menu
Route::get('kategorimenu', [KategoriMenuController::class, 'kategorimenu'])->middleware('auth');
Route::get('kategorimenu/create', [KategoriMenuController::class, 'createKategoriMenu'])->middleware('auth');
Route::post('kategorimenu', [KategoriMenuController::class, 'storeKategoriMenu'])->middleware('auth');
Route::get('kategorimenu/{id}/edit', [KategoriMenuController::class, 'editKategoriMenu'])->middleware('auth');
Route::put('kategorimenu/{id}', [KategoriMenuController::class, 'updateKategoriMenu'])->middleware('auth');
Route::delete('kategorimenu/{id}', [KategoriMenuController::class, 'destroyKategoriMenu'])->middleware('auth');


// Kategori Pengeluaran
Route::get('kategoripengeluaran', [KategoriPengeluaranController::class, 'kategoripengeluaran'])->middleware('auth');
Route::get('kategoripengeluaran/create', [KategoriPengeluaranController::class, 'createKategoriPengeluaran'])->middleware('auth');
Route::post('kategoripengeluaran', [KategoriPengeluaranController::class, 'storeKategoriPengeluaran'])->middleware('auth');
Route::get('kategoripengeluaran/{id}/edit', [KategoriPengeluaranController::class, 'editKategoriPengeluaran'])->middleware('auth');
Route::put('kategoripengeluaran/{id}', [KategoriPengeluaranController::class, 'updateKategoriPengeluaran'])->middleware('auth');
Route::delete('kategoripengeluaran/{id}', [KategoriPengeluaranController::class, 'destroyKategoriPengeluaran'])->middleware('auth');


// Inventori
Route::get('inventori', [InventoriController::class, 'inventori'])->middleware('auth');
Route::get('inventori/create', [InventoriController::class, 'createInventori'])->middleware('auth');
Route::post('inventori', [InventoriController::class, 'storeInventori'])->middleware('auth');
Route::get('inventori/{id}/edit', [InventoriController::class, 'editInventori'])->middleware('auth');
Route::put('inventori/{id}', [InventoriController::class, 'updateInventori'])->middleware('auth');
Route::delete('inventori/{id}', [InventoriController::class, 'destroyInventori'])->middleware('auth');


Route::get('karyawan', [KaryawanController::class, 'karyawan'])->middleware('auth');
Route::get('karyawan/create', [KaryawanController::class, 'createKaryawan'])->middleware('auth');
Route::post('karyawan', [KaryawanController::class, 'storeKaryawan'])->middleware('auth');
Route::get('karyawan/{id}/edit', [KaryawanController::class, 'editKaryawan'])->middleware('auth');
Route::put('karyawan/{id}', [KaryawanController::class, 'updateKaryawan'])->middleware('auth');
Route::delete('karyawan/{id}', [KaryawanController::class, 'destroyKaryawan'])->middleware('auth');

Route::get('bahanbaku', [BahanBakuController::class, 'bahanbaku'])->middleware('auth');
Route::get('bahanbaku/create', [BahanBakuController::class, 'createBahanbaku'])->middleware('auth');
Route::post('bahanbaku', [BahanBakuController::class, 'storeBahanbaku'])->middleware('auth');
Route::get('bahanbaku/{id}/edit', [BahanBakuController::class, 'editBahanbaku'])->middleware('auth');
Route::put('bahanbaku/{id}', [BahanBakuController::class, 'updateBahanbaku'])->middleware('auth');
Route::delete('bahanbaku/{id}', [BahanBakuController::class, 'destroyBahanbaku'])->middleware('auth');
Route::get('bahanbaku/kelola/{id}/{tipe}', [BahanBakuController::class, 'kelolaBahanbaku'])->middleware('auth');
Route::post('bahanbaku/kelola/{id}', [BahanBakuController::class, 'storeKelolaBahanbaku'])->middleware('auth');
Route::get('bahanbaku/laporan/{month?}', [BahanBakuController::class, 'laporanBahanbaku'])->middleware('auth');
Route::get('bahanbaku/export', [BahanBakuController::class, 'exportBahanbaku'])->middleware('auth');
Route::get('bahanbaku/export/laporan/{month}', [BahanBakuController::class, 'exportLaporanBahanbaku'])->middleware('auth');


Route::get('export/kehadiran/list/{month?}', [KehadiranController::class, 'exportList'])->middleware('auth');

Route::get('/list', function () {
    return view('crud.list');
})->middleware('auth');

