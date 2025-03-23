<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    //return view('welcome');
    return view('login');

});

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//Made
use App\Http\Controllers\SupplierController;
Route::resource('supplier', SupplierController::class);
Route::get('/supplier/destroy/{id}', [SupplierController::class, 'destroy']);

//Bos saka
use App\Http\Controllers\MenuMakananController;
Route::resource('menu_makanan', MenuMakananController::class);
Route::get('/menu_makanan/destroy/{id}', [MenuMakananController::class, 'destroy']);