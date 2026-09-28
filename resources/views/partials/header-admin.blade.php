<nav class="navbar">
    <div class="logo">EDUSAFE</div>
    <div class="nav-links">
        <a href="{{ url('/admin') }}" class="{{ Request::is('admin') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ url('/data-pelajar') }}" class="{{ Request::is('data-pelajar') ? 'active' : '' }}">Data Pelajar</a>
        <a href="{{ url('/evaluasi') }}" class="{{ Request::is('evaluasi') ? 'active' : '' }}">Evaluasi</a>
        <a href="{{ url('/laporan') }}" class="{{ Request::is('laporan') ? 'active' : '' }}">Laporan</a>
    </div>
    <div class="nav-links">
        <span style="font-size: 13px; font-weight: bold; margin-right: 15px;">
            Admin Mode <span class="badge" style="background: var(--primary); color: white; border-radius: 50%; padding: 6px 8px;">AW</span>
        </span>
        <a href="{{ url('/login-admin') }}" style="color: #EF4444;">Keluar</a>
    </div>
</nav>