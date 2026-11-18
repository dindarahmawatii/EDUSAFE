<nav class="navbar">
    <a href="{{ route('home') }}" class="brand">EduSafe</a>

    <div class="nav-right">
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Main menu</a></li>
            <li><a href="{{ route('siswa.nilai') }}" class="{{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">Nilai</a></li>
            <li><a href="{{ route('siswa.evaluasi-siswa') }}" class="{{ request()->routeIs('siswa.evaluasi-siswa') ? 'active' : '' }}">Evaluasi</a></li>
            <li><a href="{{ route('siswa.rekap') }}" class="{{ request()->routeIs('siswa.rekap') ? 'active' : '' }}">Rekap</a></li>
        </ul>

        <div class="nav-auth" style="display: flex; align-items: center; gap: 10px;">
            <!-- Tombol Logout Utama (Menggantikan Masuk/Daftar & Logout Test) -->
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: #00288A; color: #FFFFFF; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: background 0.2s;">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </div>
</nav>