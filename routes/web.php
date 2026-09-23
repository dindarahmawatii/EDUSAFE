<?php

use Illuminate\Support\Facades\Route;

// Saat buka 127.0.0.1:8000 langsung tampilkan halaman login
Route::get('/', function () {
    return view('welcome');
});

// Routing untuk halaman-halaman frontend milikmu
Route::get('/login', function () {
    return view('login');
});

Route::get('/login-admin', function () {
    return view('login-admin');
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
});

Route::get('/data-pelajar', function () {
    return view('data-pelajar');
});

Route::get('/laporan', function () {
    return view('laporan');
});