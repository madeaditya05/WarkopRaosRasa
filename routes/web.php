<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MenuMakananController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\UserController;

// Halaman awal
Route::get('/', function () {
    return view('login'); // bisa ganti jadi redirect()->route('login');
});

// Halaman test (opsional)
Route::get('/test', function () {
    echo 'test';
});

// === ROUTE AUTH (TIDAK PERLU LOGIN) ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === ROUTE PROTECTED (HANYA BISA DIAKSES SETELAH LOGIN) ===
Route::middleware(['auth'])->group(function () {
    
    // Halaman dashboard sesuai user_group
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/customer/home', function () {
        return view('customer.home');
    });

    // Route CRUD Supplier
    Route::resource('supplier', SupplierController::class);
    Route::get('/supplier/destroy/{id}', [SupplierController::class, 'destroy']);

    // Route CRUD Menu Makanan
    Route::resource('menu_makanan', MenuMakananController::class);
    Route::get('/menu_makanan/destroy/{id}', [MenuMakananController::class, 'destroy']);

    // Route CRUD Karyawan
    Route::resource('karyawan', KaryawanController::class);
    Route::get('/karyawan/destroy/{id}', [KaryawanController::class, 'destroy']);

    // Route CRUD Pelanggan
    Route::resource('pelanggan', PelangganController::class);
    Route::get('/pelanggan/destroy/{id}', [PelangganController::class, 'destroy']);

    // Route CRUD Bahan Baku
    Route::resource('bahanbaku', BahanBakuController::class);
    Route::get('/bahanbaku/destroy/{id}', [BahanBakuController::class, 'destroy']);

    // Route CRUD User
    Route::resource('user', UserController::class);
    Route::get('/user/destroy/{id}', [UserController::class, 'destroy']);
});