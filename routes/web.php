<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthAnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

//SISTEM BACKEND
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::resource('kategori', KategoriController::class);

Route::get('/kategori/{id}', [FrontendController::class, 'kategoriBuku'])
    ->name('kategori.buku');

Route::get('/buku/{id}', [FrontendController::class, 'detail'])
    ->name('buku.detail');

Route::get('/semua-buku', [FrontendController::class, 'semuaBuku'])
    ->name('semua.buku');

// dashboard anggota pakai middleware
Route::prefix('anggota')
    ->middleware('auth:anggota')
    ->group(function(){
        Route::get('/dashboard', [DashboardController::class,'index'])->name('anggota.dashboard.index');
        // route anggota lain...
    });


Route::prefix('admin')->group(function () {
Route::resource('buku', BukuController::class);
});

    // FRONTEND DETAIL (taruh di atas)
Route::get('/buku/{id}', [FrontendController::class, 'detail'])
    ->name('detail');




Route::resource('/anggota', AnggotaController::class);

//SISTEM LOGIN

// hanya kepala perpus
Route::middleware(['auth','role:kepala_perpus'])->group(function () {
    Route::resource('petugas', PetugasController::class);
});

// petugas + kepala perpus
Route::middleware(['auth','role:kepala_perpus,petugas'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');
});

// petugas + kepala perpus
Route::middleware(['auth','role:kepala_perpus,petugas'])->group(function () {
    Route::get('/anggota', [AnggotaController::class, 'index'])
        ->name('anggota.index');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//SISTEM FRONTEND
Route::get('/frontend/view/index', [FrontendController::class, 'index'])
    ->name('frontend.index');

Route::get('/', [FrontendController::class, 'index']);

Route::get('/semua-buku', [FrontendController::class, 'semuaBuku'])
    ->name('semua.buku');


Route::get('/login_anggota', [LoginController::class,'showLoginForm'])->name('login_anggota');
Route::post('/login_anggota', [LoginController::class,'login'])->name('login.anggota.post');

Route::post('/logout_anggota', [LoginController::class,'logout'])->name('logout_anggota');

Route::get('/register_anggota', [AuthAnggotaController::class, 'registerForm'])->name('register_anggota');
Route::post('/register_anggota', [AuthAnggotaController::class, 'register'])
->name('register.anggota.post');




Route::get('/pinjam/{id}', [PeminjamanController::class, 'create'])->name('pinjam.form');
Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('pinjam.store');

Route::post('/peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');

Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
    ->name('peminjaman.kembalikan');

Route::get('/history', [PeminjamanController::class, 'history'])
    ->middleware('auth:anggota')
    ->name('history');

Route::get('/peminjaman/{id}/form-kembali', [PeminjamanController::class, 'formKembali'])
    ->name('peminjaman.formKembali');


    //LAPORAN PEMINJAMAN
   Route::middleware(['auth','role:kepala_perpus,petugas'])->group(function () {
    Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
});


