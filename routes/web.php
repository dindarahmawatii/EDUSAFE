<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Praktikum Modul 4
Route::get('/schedule', [PageController::class, 'schedule_master']);
Route::get('/materi-modul4', [PageController::class, 'materi']);

// Landing
Route::get('/', function () {
    return view('login');
});

// Routing untuk halaman-halaman frontend milikmu
Route::get('/login', function () {
    return view('login');
});

// Tambahkan route register di sini agar tidak error 404
Route::get('/register', function () {
    return view('register');
});

Route::get('/materi', function () {
    return view('materi');
});

Route::get('/baca-materi', function () {
    return view('baca-materi');
});

Route::get('/kuis', function () {
    return view('kuis');
});

Route::get('/nilai', function () {
    return view('nilai');
});

Route::get('/evaluasi', function () {
    return view('evaluasi');
});

Route::get('/evaluasi-siswa', function () {
    return view('evaluasi-siswa');
});

Route::get('/rekap', function () {
    return view('rekap');
});

Route::get('/admin', function () {
    return view('admin');
<<<<<<< HEAD
});

// Auth
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/login-admin', function () {
    return view('auth.login-admin');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Siswa
Route::get('/materi', function () {
    return view('siswa.materi');
});

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