<nav class="navbar">
    <a href="{{ route('admin.dashboard') }}" class="brand">EduQuiz <span style="font-size:12px; color:var(--text-muted);">(Admin Panel)</span></a>

    <div class="nav-right">
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.data-pelajar') }}" class="{{ request()->routeIs('admin.data-pelajar') ? 'active' : '' }}">Data Pelajar</a></li>
            <li><a href="{{ route('admin.evaluasi') }}" class="{{ request()->routeIs('admin.evaluasi') ? 'active' : '' }}">Evaluasi</a></li>
            <li><a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">Laporan</a></li>
            <li><a href="{{ route('admin.rekap') }}" class="{{ request()->routeIs('admin.rekap') ? 'active' : '' }}">Rekap</a></li>
        </ul>

        <div class="nav-auth">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">Logout Admin</button>
            </form>
        </div>
    </div>
</nav>s