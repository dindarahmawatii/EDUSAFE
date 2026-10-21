@extends('layouts.siswa')

@section('title', 'Rekap Pembelajaran - EduQuiz')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/rekap.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="rekap-page-wrapper">
    <div class="rekap-container">
        
        <!-- Header -->
        <div class="rekap-header">
            <h1 class="rekap-main-title">Rekap Pembelajaran</h1>
            <p class="rekap-main-desc">
                Pantau perkembangan akademik Anda melalui riwayat aktivitas, waktu akses, dan status penyelesaian modul secara real-time.
            </p>
        </div>

        <!-- Top Stats Cards -->
        <div class="rekap-stats-grid">
            
            <!-- Card 1: Total Modul Selesai -->
            <div class="stat-card">
                <div class="stat-icon-square">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                </div>
                <span class="stat-card-label">TOTAL MODUL SELESAI</span>
                <div class="stat-card-value">{{ $totalSelesai ?? 0 }}</div>
                <div class="stat-card-trend">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    <span>+12% Bulan ini</span>
                </div>
            </div>

            <!-- Card 2: Waktu Belajar (Active Card) -->
            <div class="stat-card active-blue-card">
                <div class="stat-icon-square light-blue-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span class="stat-card-label">WAKTU BELAJAR</span>
                <div class="stat-card-value">42j 15m</div>
                <p class="stat-card-subtext">Rata-rata 1.5 jam per hari</p>
            </div>

            <!-- Card 3: Target Mingguan -->
            <div class="stat-card">
                <h3 class="target-title">Target Mingguan</h3>
                <div class="target-bar-bg">
                    <div class="target-bar-fill" style="width: 75%;"></div>
                </div>
                <div class="target-info-flex">
                    <span class="target-count">6 dari 8 Modul</span>
                    <strong class="target-percent">75%</strong>
                </div>
            </div>

        </div>

        <!-- Card Utama: Search, Filter, & Tabel -->
        <div class="rekap-table-card">
            
            <!-- Toolbar Atas -->
            <div class="rekap-toolbar">
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Cari modul atau materi...">
                </div>

                <div class="toolbar-actions">
                    <button class="btn-toolbar">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter
                    </button>
                    <button class="btn-toolbar">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Ekspor Rekap
                    </button>
                </div>
            </div>

            <!-- Tabel Rekap -->
            <div class="table-responsive">
                <table class="rekap-table">
                    <thead>
                        <tr>
                            <th>MATERI PEMBELAJARAN</th>
                            <th>KATEGORI</th>
                            <th>WAKTU AKSES TERAKHIR</th>
                            <th>DURASI SESI</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- Row 1 -->
                        <tr>
                            <td>
                                <div class="materi-cell">
                                    <div class="materi-icon-box dark-blue-icon">📘</div>
                                    <div>
                                        <strong class="materi-title-text">Pengenalan Malware Analysis</strong>
                                        <small class="materi-sub-text">Modul 1: Fondasi Keamanan</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-tag tag-cyber">Cybersecurity</span></td>
                            <td class="time-text">24 Okt 2026, 14:30</td>
                            <td class="duration-text">45 Menit</td>
                            <td><span class="status-pill pill-selesai">✔ Selesai</span></td>
                            <td class="action-cell">&bull;&bull;&bull;</td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>
                                <div class="materi-cell">
                                    <div class="materi-icon-box gray-icon">⚙️</div>
                                    <div>
                                        <strong class="materi-title-text">Reverse Engineering Dasar</strong>
                                        <small class="materi-sub-text">Modul 2: Analisis Statis</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-tag tag-forensics">Forensics</span></td>
                            <td class="time-text">23 Okt 2026, 09:15</td>
                            <td class="duration-text">1j 20m</td>
                            <td><span class="status-pill pill-berjalan">⏳ Berjalan</span></td>
                            <td class="action-cell">&bull;&bull;&bull;</td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td>
                                <div class="materi-cell">
                                    <div class="materi-icon-box light-gray-icon">📊</div>
                                    <div>
                                        <strong class="materi-title-text">Dynamic Analysis Lab</strong>
                                        <small class="materi-sub-text">Modul 3: Sandbox Environment</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-tag tag-lab">Lab Praktikum</span></td>
                            <td class="time-text">22 Okt 2026, 16:45</td>
                            <td class="duration-text">&ndash;</td>
                            <td><span class="status-pill pill-terkunci">🔒 Terkunci</span></td>
                            <td class="action-cell">&bull;&bull;&bull;</td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td>
                                <div class="materi-cell">
                                    <div class="materi-icon-box royal-blue-icon">🛡️</div>
                                    <div>
                                        <strong class="materi-title-text">Deteksi Ransomware</strong>
                                        <small class="materi-sub-text">Modul 4: Mitigasi Ancaman</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-tag tag-cyber">Cybersecurity</span></td>
                            <td class="time-text">21 Okt 2026, 11:20</td>
                            <td class="duration-text">55 Menit</td>
                            <td><span class="status-pill pill-selesai">✔ Selesai</span></td>
                            <td class="action-cell">&bull;&bull;&bull;</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Footer & Pagination -->
            <div class="table-footer flex-between">
                <span class="entries-info">Menampilkan 4 dari 24 entri</span>
                
                <div class="pagination">
                    <button class="page-nav">&lsaquo;</button>
                    <button class="page-num active">1</button>
                    <button class="page-num">2</button>
                    <button class="page-num">3</button>
                    <button class="page-nav">&rsaquo;</button>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection