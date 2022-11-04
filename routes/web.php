<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BentukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SanksiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriSiswaController;
use App\Models\Kategori;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', function () {
    return view('auth.login');
});
Route::get('/guru/login', function () {
    return view('auth.login-guru');
});

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('loginn', [AuthController::class, 'loginn'])->name('loginn');


Route::group(['middleware' => 'auth', 'ceklevel:admin, guru, siswa'], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('sanksi', [SanksiController::class, 'index'])->name('sanksi');
    // bentuk
    Route::get('bentuk1', [BentukController::class, 'index1'])->name('bentuk1');
    Route::get('bentuk', [BentukController::class, 'index'])->name('bentuk');
    Route::get('/detail_pelanggaran/{id}',  [BentukController::class, 'detail_pelanggaran']);
    
    Route::get('/pelanggaran/{id}',  [PelanggaranController::class, 'pelanggaran']);

});

Route::group(['middleware' => 'auth', 'ceklevel:admin, guru'], function(){
    // pelanggaran
    Route::get('data', [PelanggaranController::class, 'data'])->name('data');
    Route::post('/insertPelanggaran',[PelanggaranController::class, 'insertPelanggaran'] )->name('insertPelanggaran');
    Route::post('getPelanggaran',[PelanggaranController::class, 'getPelanggaran'])->name('getPelanggaran');
    Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran');
    Route::post('pelanggaran.store', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::post('pelanggaran.edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::post('pelanggaran.update', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    Route::post('pelanggaran.delete', [PelanggaranController::class, 'delete'])->name('pelanggaran.delete');
    // kelas
    Route::get('kelas', [KelasController::class, 'index'])->name('kelas');
    // kelas
    Route::get('isiKelas', [SiswaController::class, 'isi'])->name('isiKelas');
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa');
    
    Route::get('/detail_kelas/{id}',  [SiswaController::class, 'detail_kelas']);
});
    
Route::group(['middleware' => 'auth', 'ceklevel:admin'], function(){
    // kategori
    Route::post('kategori.store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('kategori.edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::post('kategori.update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::post('kategori.delete', [KategoriController::class, 'delete'])->name('kategori.delete');
    
    //bentuk
    Route::post('/insert',[BentukController::class, 'insert'] )->name('insert');
    Route::post('bentuk.store', [BentukController::class, 'store'])->name('bentuk.store');
    Route::post('bentuk.edit', [BentukController::class, 'edit'])->name('bentuk.edit');
    Route::post('bentuk.update', [BentukController::class, 'update'])->name('bentuk.update');
    Route::post('bentuk.delete', [BentukController::class, 'delete'])->name('bentuk.delete');
    //export excel bentuk
    Route::get('exportExcel', [BentukController::class, 'exportExcel'])->name('exportExcel');
    Route::post('importExcel', [BentukController::class, 'importExcel'])->name('importExcel');
    //sanksi
    Route::post('sanksi.store', [SanksiController::class, 'store'])->name('sanksi.store');
    Route::post('sanksi.edit', [SanksiController::class, 'edit'])->name('sanksi.edit');
    Route::post('sanksi.update', [SanksiController::class, 'update'])->name('sanksi.update');
    Route::post('sanksi.delete', [SanksiController::class, 'delete'])->name('sanksi.delete');
    // kelas
    Route::post('kelas.store', [KelasController::class, 'store'])->name('kelas.store');
    Route::post('kelas.edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::post('kelas.update', [KelasController::class, 'update'])->name('kelas.update');
    Route::post('kelas.delete', [KelasController::class, 'delete'])->name('kelas.delete');
    // kelas
    Route::post('/insertSiswa',[SiswaController::class, 'insertSiswa'] )->name('insertSiswa');
    Route::post('siswa.store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::post('siswa.edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('siswa.update', [SiswaController::class, 'update'])->name('siswa.update');
    Route::post('siswa.delete', [SiswaController::class, 'delete'])->name('siswa.delete');
    //export excel bentuk
    Route::get('exportExcel1', [SiswaController::class, 'exportExcel1'])->name('exportExcel1');
    Route::post('importExcel1', [SiswaController::class, 'importExcel1'])->name('importExcel1');

    // export pdf
    Route::get('exportPDF', [PelanggaranController::class, 'exportPDF'])->name('exportPDF');
    
    //Data Admin
    Route::get('admin', [UserController::class, 'index'])->name('admin');
    Route::post('admin.store', [UserController::class, 'store'])->name('admin.store');
    Route::post('admin.edit', [UserController::class, 'edit'])->name('admin.edit');
    Route::post('admin.update', [UserController::class, 'update'])->name('admin.update');
    
    
});

Route::group(['middleware' => 'auth:siswa'], function(){
    Route::get('homeSiswa', [KategoriSiswaController::class, 'indexSiswa'])->name('HomeSiswa');
    Route::get('kategoriSiswa', [KategoriSiswaController::class, 'index'])->name('kategoriSiswa');
    Route::get('bentukSiswa', [KategoriSiswaController::class, 'bentuk'])->name('bentukSiswa');
    Route::get('sanksiSiswa', [KategoriSiswaController::class, 'sanksi'])->name('sanksiSiswa');
    Route::get('detailPelanggaran', [KategoriSiswaController::class, 'detail'])->name('detailPelanggaran');

});

require __DIR__.'/auth.php';
