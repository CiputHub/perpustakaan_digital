<?php

use Illuminate\Support\Facades\Route;

// ================= CONTROLLER =================
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
use App\Http\Controllers\LaporanController;


/*
|--------------------------------------------------------------------------
| 🔥 FRONTEND (USER / ANGGOTA)
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');

// Buku
Route::get('/buku/{id}', [FrontendController::class, 'detail'])->name('detail');
Route::get('/semua-buku', [FrontendController::class, 'semuaBuku'])->name('semua.buku');

// Kategori
Route::get('/kategori/{id}', [FrontendController::class, 'kategoriBuku'])->name('kategori.buku');

// Auth Anggota
Route::get('/login_anggota', [LoginController::class, 'showLoginForm'])->name('login_anggota');
Route::post('/login_anggota', [LoginController::class, 'login'])->name('login.anggota.post');
Route::post('/logout_anggota', [LoginController::class, 'logout'])->name('logout_anggota');

Route::get('/register_anggota', [AuthAnggotaController::class, 'registerForm'])->name('register_anggota');
Route::post('/register_anggota', [AuthAnggotaController::class, 'register'])->name('register.anggota.post');

// Peminjaman (anggota)
Route::get('/pinjam/{id}', [PeminjamanController::class, 'create'])->name('pinjam.form');
Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('pinjam.store');

Route::middleware('auth:anggota')->group(function () {
    Route::get('/history', [PeminjamanController::class, 'history'])->name('history');
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::get('/peminjaman/{id}/form-kembali', [PeminjamanController::class, 'formKembali'])->name('peminjaman.formKembali');
});


/*
|--------------------------------------------------------------------------
| 🔥 BACKEND (ADMIN / PETUGAS / KEPALA)
|--------------------------------------------------------------------------
*/

// Login admin
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register kepala perpus
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// CRUD Buku
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('buku', BukuController::class);
});

// Kategori
Route::resource('kategori', KategoriController::class)->middleware('auth');

// Anggota
Route::resource('anggota', AnggotaController::class)->middleware('auth');

// Petugas (khusus kepala perpus)
Route::middleware(['auth', 'role:kepala_perpus'])->group(function () {
    Route::resource('petugas', PetugasController::class);
});

// Peminjaman (petugas & kepala)
Route::middleware(['auth', 'role:kepala_perpus,petugas'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

    Route::post('/peminjaman/{id}/acc', [PeminjamanController::class, 'acc'])->name('peminjaman.acc');
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
});

// Laporan
Route::middleware(['auth', 'role:kepala_perpus,petugas'])->group(function () {
    Route::resource('laporan', LaporanController::class);
});
