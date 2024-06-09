<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\BahanBakuController;


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

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


Route::get('kehadiran/list/{month?}', [KehadiranController::class, 'kehadiran'])->middleware('auth');
Route::get('kehadiran/create', [KehadiranController::class, 'createKehadiran'])->middleware('auth');
Route::post('kehadiran', [KehadiranController::class, 'storeKehadiran'])->middleware('auth');
Route::get('kehadiran/{id}', [KehadiranController::class, 'getKehadiranById'])->middleware('auth');
Route::get('kehadiran/{id}/edit', [KehadiranController::class, 'editKehadiran'])->middleware('auth');
Route::put('kehadiran/{id}', [KehadiranController::class, 'updateKehadiran'])->middleware('auth');
Route::delete('kehadiran/{id}', [KehadiranController::class, 'destroyKehadiran'])->middleware('auth');


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

Route::get('kategoribahanbaku', [BahanBakuController::class, 'kategoribahanbaku'])->middleware('auth');
Route::get('kategoribahanbaku/create', [BahanBakuController::class, 'createKategoriBahanBaku'])->middleware('auth');
Route::post('kategoribahanbaku', [BahanBakuController::class, 'storeKategoriBahanBaku'])->middleware('auth');
Route::get('kategoribahanbaku/{id}/edit', [BahanBakuController::class, 'editKategoriBahanBaku'])->middleware('auth');
Route::put('kategoribahanbaku/{id}', [BahanBakuController::class, 'updateKategoriBahanBaku'])->middleware('auth');
Route::delete('kategoribahanbaku/{id}', [BahanBakuController::class, 'destroyKategoriBahanBaku'])->middleware('auth');


Route::get('bahanbaku', [BahanBakuController::class, 'bahanbaku'])->middleware('auth');
Route::get('bahanbaku/create', [BahanBakuController::class, 'createBahanBaku'])->middleware('auth');
Route::post('bahanbaku', [BahanBakuController::class, 'storeBahanBaku'])->middleware('auth');
Route::get('bahanbaku/{id}/edit', [BahanBakuController::class, 'editBahanBaku'])->middleware('auth');
Route::put('bahanbaku/{id}', [BahanBakuController::class, 'updateBahanBaku'])->middleware('auth');
Route::delete('bahanbaku/{id}', [BahanBakuController::class, 'destroyBahanBaku'])->middleware('auth');



Route::get('export/kehadiran/list/{month?}', [KehadiranController::class, 'exportList'])->middleware('auth');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/list', function () {
    return view('crud.list');
})->middleware('auth');

