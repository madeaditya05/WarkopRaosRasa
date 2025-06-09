<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MenuMakananController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiPembelianBahanBakuController;
use App\Http\Controllers\DetailTransaksiPembelianBahanBakuController;
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\MidtransController;

use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\TransaksiOfflineController;

use App\Http\Controllers\KeranjangController;

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

    // login customer
Route::get('/depan', [App\Http\Controllers\Controller::class, 'daftarbarang']);

Route::get('/dashboard', [MenuMakananController::class, 'customerView'])->name('dashboard');


Route::get('/pahe', [MenuMakananController::class, 'showPahe'])->name('showPahe');
Route::get('/indomie', [MenuMakananController::class, 'showIndomie'])->name('showIndomie');
Route::get('/kornet', [MenuMakananController::class, 'showKornet'])->name('showKornet');
Route::get('/nasi', [MenuMakananController::class, 'showNasi'])->name('showNasi');
Route::get('/omlet', [MenuMakananController::class, 'showOmlet'])->name('showOmlet');
Route::get('/orakarik', [MenuMakananController::class, 'showOrakarik'])->name('showOrakarik');
Route::get('/sarden', [MenuMakananController::class, 'showSarden'])->name('showSarden');
Route::get('/telur', [MenuMakananController::class, 'showTelur'])->name('showTelur');
Route::get('/minuman', [MenuMakananController::class, 'showMinuman'])->name('showMinuman');

Route::get('/search', [MenuMakananController::class, 'showSearch'])->name('showSearch');

Route::get('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
Route::get('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');


Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    //arannnnntzy
Route::resource('penjualan', PenjualanController::class);
Route::resource('TransaksiOffline', TransaksiOfflineController::class);
Route::get('transaksi-offline/export/pdf', [TransaksiOfflineController::class, 'exportPdf'])
      ->name('TransaksiOffline.exportPdf');

      Route::resource('TransaksiOffline', TransaksiOfflineController::class);
     Route::get('/TransaksiOffline/{id}', [TransaksiOfflineController::class, 'destroy'])->name('TransaksiOffline.destroy');





});

//GIBETTTT
// Pembelian bahan baku
Route::get('/transaksi', [TransaksiPembelianBahanBakuController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi/{id}/bayar', [TransaksiPembelianBahanBakuController::class, 'bayar'])->name('transaksi.bayar');

Route::get('/pembelian/create', [PembelianBahanBakuController::class, 'create'])->name('pembelian.create');
Route::post('/pembelian/store', [PembelianBahanBakuController::class, 'store'])->name('pembelian.store');

Route::get('/transaksi/{id}/detail', [DetailTransaksiPembelianBahanBakuController::class, 'show'])->name('transaksi.detail');
// Transaksinya
Route::get('/transaksi/{id}/edit', [TransaksiPembelianBahanBakuController::class, 'edit'])->name('transaksi.edit');
Route::put('/transaksi/{id}', [TransaksiPembelianBahanBakuController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiPembelianBahanBakuController::class, 'destroy'])->name('transaksi.destroy');
//bahan baku
Route::get('/bahan-baku/{id}', function($id) {
    return App\Models\BahanBaku::find($id);
});
//print
Route::get('/pembelian/{id}/export/pdf', [PembelianBahanBakuController::class, 'exportPDF'])->name('pembelian.export.pdf');
Route::get('/pembelian/{id}/export/excel', [PembelianBahanBakuController::class, 'exportExcel'])->name('pembelian.export.excel');
//pdf bahan baku
Route::get('/transaksi/export', [PembelianBahanBakuController::class, 'exportIndexPDF'])->name('transaksi.export.pdf');



