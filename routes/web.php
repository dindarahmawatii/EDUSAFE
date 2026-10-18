<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - EDUSAFE
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PINTU MASUK UTAMA
// ==========================================
Route::redirect('/', '/login');


// ==========================================
// 2. MODUL AUTENTIKASI (Guest Only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login')->name('login.post');

        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register', 'register')->name('register.post');
    });

    Route::view('/lupa-password', 'auth.lupa-password')->name('forgot-password');
});


// ==========================================
// 3. MODUL SETELAH LOGIN (Authenticated Only)
// ==========================================
Route::middleware('auth')->group(function () {

    // Proses Keluar Akun
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Beranda Utama Siswa
    Route::view('/beranda', 'siswa.home')->name('home');

    // ------------------------------------------
    // A. SUB-MODUL SISWA
    // ------------------------------------------
    Route::prefix('siswa')->name('siswa.')->controller(SiswaController::class)->group(function () {
        Route::get('/materi', 'materi')->name('materi');
        Route::get('/materi/{id}', 'bacaMateri')->name('baca-materi');

        Route::get('/kuis/{id?}', 'kuis')->name('kuis');
        Route::post('/kuis/submit', 'submitKuis')->name('kuis.submit');

        Route::get('/nilai', 'nilai')->name('nilai');
        Route::get('/evaluasi', 'evaluasiSiswa')->name('evaluasi-siswa');
        Route::get('/rekap', 'rekap')->name('rekap');
    });

    // ------------------------------------------
    // B. SUB-MODUL ADMIN
    // ------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');
        Route::view('/data-pelajar', 'admin.data-pelajar')->name('data-pelajar');
        Route::view('/evaluasi', 'admin.evaluasi')->name('evaluasi');
        Route::view('/laporan', 'admin.laporan')->name('laporan');
        Route::view('/rekap', 'admin.rekap')->name('rekap');

        Route::post('/materi/store', [AdminController::class, 'storeMateri'])->name('materi.store');
    });

});