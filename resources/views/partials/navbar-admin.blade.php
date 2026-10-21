<header class="admin-header">
    <div class="admin-nav-container">
        <!-- Logo Brand -->
        <a href="{{ route('admin.dashboard') }}" class="admin-brand">
            EduQuiz <span class="admin-badge-mode">Admin Panel</span>
        </a>

        <!-- Menu Navigasi Utama -->
        <nav class="admin-nav-links">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.data-pelajar') }}" class="{{ request()->routeIs('admin.data-pelajar') ? 'active' : '' }}">Mahasiswa</a>
            <a href="{{ route('admin.evaluasi') }}" class="{{ request()->routeIs('admin.evaluasi') ? 'active' : '' }}">Evaluasi</a>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">Laporan</a>
            <a href="{{ route('admin.rekap') }}" class="{{ request()->routeIs('admin.rekap') ? 'active' : '' }}">Rekap</a>
        </nav>

        <!-- Profil Admin & Logout -->
        <div class="admin-user-area">
            <span class="admin-mode-label">Admin Mode</span>
            <div class="admin-avatar">AW</div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" class="btn-logout-admin">Keluar</button>
            </form>
        </div>
    </div>
</header>