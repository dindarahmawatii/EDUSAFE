<nav class="navbar">
    <a href="{{ route('home') }}" class="brand">EduQuiz</a>

    <div class="nav-right">
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Main menu</a></li>
            <li><a href="{{ route('siswa.nilai') }}" class="{{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">Nilai</a></li>
            <li><a href="{{ route('siswa.evaluasi-siswa') }}" class="{{ request()->routeIs('siswa.evaluasi-siswa') ? 'active' : '' }}">Evaluasi</a></li>
            <li><a href="{{ route('siswa.rekap') }}" class="{{ request()->routeIs('siswa.rekap') ? 'active' : '' }}">Rekap</a></li>
        </ul>

        <div class="nav-auth" style="display: flex; align-items: center; gap: 10px;">
            <!-- Tombol Masuk & Daftar Sesuai Mockup DPPL -->
            <a href="{{ route('login') }}" class="btn btn-sky">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-blue">Daftar</a>

            <!-- Tombol Logout Kecil Khusus Test -->
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout-test" title="Logout untuk testing">
                    🚪 Logout Test
                </button>
            </form>
        </div>
    </div>
</nav>