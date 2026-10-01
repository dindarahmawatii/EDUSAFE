<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Praktikum Modul 4
Route::get('/schedule', [PageController::class, 'schedule_master']);
Route::get('/materi-modul4', [PageController::class, 'materi']);

// Landing
Route::get('/', [AuthController::class, 'showLogin']);

// Auth Routes (Web)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/login-admin', function () {
    return view('auth.login-admin');
})->name('login.admin');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Siswa
Route::get('/materi', function () {
    return view('siswa.materi');
})->name('materi');

Route::get('/baca-materi', function () {
    return view('siswa.baca-materi');
});

Route::get('/kuis', function () {
    return view('siswa.kuis');
});

Route::get('/nilai', function () {
    return view('siswa.nilai');
});

Route::get('/evaluasi-siswa', function () {
    return view('siswa.evaluasi-siswa');
});

Route::get('/rekap', function () {
    return view('siswa.rekap');
});

// Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/data-pelajar', function () {
    return view('admin.data-pelajar');
});

Route::get('/evaluasi', function () {
    return view('admin.evaluasi');
});

Route::get('/laporan', function () {
    return view('admin.laporan');
});
