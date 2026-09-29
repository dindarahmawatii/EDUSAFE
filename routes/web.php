<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\siswacontroller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - EDUSAFE
|--------------------------------------------------------------------------
*/

// ------------------------------
// 1. Landing & Praktikum
// ------------------------------
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/schedule', [PageController::class, 'schedule_master'])->name('schedule');
Route::get('/materi-modul4', [PageController::class, 'materi'])->name('materi.modul4');


// ------------------------------
// 2. Authentication
// ------------------------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/login-admin', function () {
    return view('auth.login-admin');
})->name('login.admin');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
});

Route::post('/logout', [siswacontroller::class, 'logout'])->name('siswa.logout');


// ------------------------------
// 3. Modul Siswa (siswacontroller)
// ------------------------------
Route::get('/materi', [siswacontroller::class, 'materi'])->name('siswa.materi');
Route::get('/siswa/materi/{id}', [siswacontroller::class, 'bacaMateri'])->name('siswa.baca-materi');

Route::get('/kuis/{id?}', [siswacontroller::class, 'kuis'])->name('siswa.kuis');
Route::post('/kuis/submit', [siswacontroller::class, 'submitKuis'])->name('siswa.kuis.submit');

Route::get('/nilai', [siswacontroller::class, 'nilai'])->name('siswa.nilai');
Route::get('/evaluasi-siswa', [siswacontroller::class, 'evaluasiSiswa'])->name('siswa.evaluasi-siswa');
Route::get('/rekap', [siswacontroller::class, 'rekap'])->name('siswa.rekap');

// ------------------------------
// 4. Modul Admin
// ------------------------------
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/data-pelajar', function () {
    return view('admin.data-pelajar');
})->name('admin.data-pelajar');

Route::get('/evaluasi', function () {
    return view('admin.evaluasi');
})->name('admin.evaluasi');

Route::get('/laporan', function () {
    return view('admin.laporan');
})->name('admin.laporan');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/materi/store', [AdminController::class, 'storeMateri'])->name('materi.store');
});