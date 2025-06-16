<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController; 
use App\Http\Controllers\PelanggarController;
use App\Http\Controllers\DetailPelanggaranController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\PtkDashboardController;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// ========== RUTE UNTUK TAMU (BELUM LOGIN) ==========
Route::middleware('guest')->group(function () {
    Route::get('/register', [LoginRegisterController::class, 'storeRegister'])->name('register'); // menampilkan form
    Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store'); // proses simpan
    Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
});


// ========== RUTE UNTUK PENGGUNA YANG SUDAH LOGIN ==========
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

    // ====== RUTE UNTUK ADMIN SAJA ======
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Manajemen Siswa
        Route::resource('/siswa', SiswaController::class);

        // Manajemen Akun
        Route::prefix('/akun')->group(function () {
            Route::get('/', [LoginRegisterController::class, 'index'])->name('akun.index');
            Route::get('/create', [LoginRegisterController::class, 'create'])->name('akun.create');
            Route::post('/', [LoginRegisterController::class, 'storeAkun'])->name('akun.store');
            Route::get('/{user}/edit', [LoginRegisterController::class, 'edit'])->name('akun.edit');
            Route::put('/{user}', [LoginRegisterController::class, 'update'])->name('akun.update');
            Route::put('/updateEmail/{user}', [LoginRegisterController::class, 'updateEmail'])->name('akun.updateEmail');
            Route::put('/updatePassword/{user}', [LoginRegisterController::class, 'updatePassword'])->name('akun.updatePassword');
            Route::delete('/{user}', [LoginRegisterController::class, 'destroy'])->name('akun.destroy');
        });

        // Manajemen Pelanggaran
        Route::resource('/pelanggaran', PelanggaranController::class);
        Route::resource('/pelanggar', PelanggarController::class)->names(['store' => 'pelanggar.store'
        ]);
        

        Route::post('/pelanggar/storePelanggaran', [PelanggarController::class, 'storePelanggaran'])->name('pelanggar.storePelanggaran');
        Route::post('/pelanggar/statusTindak/{akun}', [PelanggarController::class, 'statusTindak'])->name('pelanggar.statusTindak');

        // Detail Pelanggaran
        Route::resource('detailPelanggar', DetailPelanggaranController::class);
    });

    // ====== RUTE UNTUK SISWA SAJA ======
   // Route::middleware('siswa')->prefix('siswa')->group(function () {
        //Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

        // Tambahkan route khusus siswa di sini
        // Contoh: Route::get('/profil', [SiswaProfileController::class, 'show'])->name('siswa.profile');
    });

    // ====== RUTE UNTUK PTK SAJA ======
    //Route::middleware('ptk')->prefix('ptk')->group(function () {
        //Route::get('/dashboard', [PtkDashboardController::class, 'index'])->name('ptk.dashboard');

        // Tambahkan route khusus PTK di sini
        // Contoh: Route::get('/laporan', [PtkReportController::class, 'index'])->name('ptk.laporan');
    

