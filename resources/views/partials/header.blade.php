<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - @yield('title', 'Sistem Edukasi Malware')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/materi') }}" class="{{ Request::is('materi*') ? 'active' : '' }}">Main menu</a>
            <a href="{{ url('/nilai') }}" class="{{ Request::is('nilai*') ? 'active' : '' }}">Nilai</a>
            <a href="{{ url('/evaluasi-siswa') }}" class="{{ Request::is('evaluasi-siswa*') ? 'active' : '' }}">Evaluasi</a>
            <a href="{{ url('/rekap') }}" class="{{ Request::is('rekap*') ? 'active' : '' }}">Rekap</a>
        </div>
    </nav>