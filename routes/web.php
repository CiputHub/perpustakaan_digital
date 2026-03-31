<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AuthController;

Route::get('/dashboard', function () {
    return view('/dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/peminjaman', [PeminjamanController::class, 'index'])
    ->name('peminjaman.index');


Route::resource('/buku', BukuController::class);

Route::resource('/petugas', PetugasController::class);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
