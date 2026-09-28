<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - @yield('title', 'Sistem Edukasi Malware')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="flex-between" style="padding: 15px 30px; background: white; border-bottom: 1px solid var(--border);">
        <div class="logo">
            <a href="{{ route('siswa.materi') }}" style="font-weight: bold; font-size: 20px; color: var(--primary); text-decoration: none;">EDUSAFE</a>
    </div>

    <div class="nav-links" style="display: flex; align-items: center; gap: 20px;">
        <a href="{{ route('siswa.materi') }}" class="nav-link">Main menu</a>
        <a href="{{ route('siswa.nilai') }}" class="nav-link">Nilai</a>
        <a href="{{ route('siswa.evaluasi-siswa') }}" class="nav-link">Evaluasi</a>

        {{-- Form & Tombol Logout --}}
        <form action="{{ route('siswa.logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn" style="background: #ff2d2d; color: white; padding: 6px 14px; font-size: 13px; border: none; border-radius: 6px; cursor: pointer;">
                Logout
            </button>
        </form>
    </div>
</nav>