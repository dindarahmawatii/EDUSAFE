@extends('layouts.admin')

@section('title', 'EDUSAFE - Rekap Pembelajaran')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">
        
        <!-- Header Halaman -->
        <div style="margin-bottom: 25px;">
            <h1 class="admin-card-title" style="font-size: 24px; color: #00288A; margin-bottom: 6px;">Rekap Pembelajaran Sistem</h1>
            <p style="color: #64748B; font-size: 14px; margin: 0;">Tinjauan keseluruhan progres modul, total durasi belajar, dan pencapaian target mingguan.</p>
        </div>

        <!-- 3 Kartu Ringkasan Progres (Biru Muda Elegan) -->
        <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Total Modul Selesai</span>
                    <div class="stat-icon">📖</div>
                </div>
                <h2 class="stat-value" style="color: #00288A; font-size: 32px;">24 Modul</h2>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Waktu Belajar Kumulatif</span>
                    <div class="stat-icon">⏳</div>
                </div>
                <h2 class="stat-value" style="color: #00288A; font-size: 32px;">42j 15m</h2>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Target Mingguan</span>
                    <span class="stat-trend" style="color: #00288A;">75%</span>
                </div>
                <div style="background: #BFDBFE; height: 10px; border-radius: 6px; margin: 12px 0; overflow: hidden;">
                    <div style="background: #00288A; width: 75%; height: 100%; border-radius: 6px;"></div>
                </div>
                <div class="flex-between" style="font-size: 12px; color: #475569; font-weight: 600;">
                    <span>6 dari 8 Modul Selesai</span>
                    <span style="color: #00288A; font-weight: 800;">Hampir Selesai</span>
                </div>
            </div>
        </div>

        <!-- Tabel Detail Riwayat Rekap Pembelajaran -->
        <div class="admin-card">
            <div class="flex-between" style="margin-bottom: 20px;">
                <h3 class="admin-card-title">Riwayat Penyelesaian Modul Siswa</h3>
                <button class="btn-cancel" style="padding: 8px 16px; font-size: 13px;">📥 Cetak Laporan Rekap</button>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Modul Pembelajaran</th>
                            <th>Kategori</th>
                            <th>Durasi Rerata</th>
                            <th>Tingkat Penyelesaian</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Pengenalan Malware & Threats</strong></td>
                            <td>Cybersecurity Dasar</td>
                            <td>45 Menit</td>
                            <td><strong>100%</strong> (1,284 Siswa)</td>
                            <td><span class="badge-status-green">Selesai</span></td>
                        </tr>
                        <tr>
                            <td><strong>Anatomi Trojan & Worms</strong></td>
                            <td>Malware Analysis</td>
                            <td>60 Menit</td>
                            <td><strong>88%</strong> (1,120 Siswa)</td>
                            <td><span class="badge-status-blue">Berjalan</span></td>
                        </tr>
                        <tr>
                            <td><strong>Reverse Engineering Fundamentals</strong></td>
                            <td>Security Engineering</td>
                            <td>90 Menit</td>
                            <td><strong>45%</strong> (580 Siswa)</td>
                            <td><span class="badge-status-red" style="background: #FEF3C7; color: #92400E;">Materi Baru</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection