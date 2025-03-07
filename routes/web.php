<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\barang\AdminBarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\pemasukkan\AdminPemasukkanController;
use App\Http\Controllers\pengeluaran\AdminPengeluaranController;
use App\Http\Controllers\transaksi\AdminTransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class,'login'])->name('login');
Route::post('/authenticate', [AuthController::class,'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    
    // Route prefix untuk Produsen

    Route::prefix('admin')->name('admin.')->middleware('CekUserLogin:1')->group(function () {
        Route::get('/dashborad', [DashboardController::class,'index'])->name('dashboard');
        // jb
        Route::get('/jenis-barang', [AdminBarangController::class,'jb'])->name('jb');
        Route::post('/store/jenis-barang', [AdminBarangController::class,'store_jb'])->name('store_jb');
        Route::put('/update/jenis-barang/{id}', [AdminBarangController::class,'update_jb'])->name('update_jb');
        Route::delete('/delete/jenis-barang/{id}', [AdminBarangController::class,'delete_jb'])->name('delete_jb');
        // barang
        Route::get('/barang', [AdminBarangController::class,'barang'])->name('barang');
        Route::post('/store/barang', [AdminBarangController::class,'store_barang'])->name('store_barang');
        Route::put('/update/barang/{id}', [AdminBarangController::class,'update_barang'])->name('update_barang');
        Route::delete('/delete/barang/{id}', [AdminBarangController::class,'delete_barang'])->name('delete_barang');
        Route::post('/import-barang', [AdminBarangController::class,'import'])->name('import.barang');
        Route::get('/print-barcode', [AdminBarangController::class,'printBarcode'])->name('barcode');
        // Transaksi
        Route::get('/daftar-transaksi', [AdminTransaksiController::class,'daftar_transaksi'])->name('daftar_transaksi');
        Route::delete('/delete-transaksi/{id}', [AdminTransaksiController::class,'delete_transaksi'])->name('delete_transaksi');
        Route::get('/transaksi', [AdminTransaksiController::class,'transaksi'])->name('transaksi');
        Route::post('/store-transaksi', [AdminTransaksiController::class,'store_transaksi'])->name('store_transaksi');
        Route::get('/cetak-nota/{id}', [AdminTransaksiController::class,'cetakNota'])->name('nota');

        // Scan
        Route::get('/scan', [AdminTransaksiController::class,'scan'])->name('scan');
        Route::get('/get-barang-by-barcode', [AdminTransaksiController::class, 'getBarangByBarcode'])->name('get_barang_by_barcode');

        // Pengeluaran
        Route::get('/pengeluaran', [AdminPengeluaranController::class,'pengeluaran'])->name('pengeluaran');
        Route::post('/store-pengeluaran', [AdminPengeluaranController::class,'store_pengeluaran'])->name('store_pengeluaran');
        Route::put('/update-pengeluaran/{id}', [AdminPengeluaranController::class,'update_pengeluaran'])->name('update_pengeluaran');
        Route::delete('/delete-pengeluaran/{id}', [AdminPengeluaranController::class,'delete_pengeluaran'])->name('delete_pengeluaran');

        // Pemasukkan
        Route::get('/pemasukkan', [AdminPemasukkanController::class,'pemasukkan'])->name('pemasukkan');
        Route::post('/store-pemasukkan', [AdminPemasukkanController::class,'store_pemasukkan'])->name('store_pemasukkan');
        Route::put('/update-pemasukkan/{id}', [AdminPemasukkanController::class,'update_pemasukkan'])->name('update_pemasukkan');
        Route::delete('/delete-pemasukkan/{id}', [AdminPemasukkanController::class,'delete_pemasukkan'])->name('delete_pemasukkan');
    });
    

    Route::prefix('pengawas')->name('pengawas.')->middleware('CekUserLogin:2')->group(function () {

    });

});