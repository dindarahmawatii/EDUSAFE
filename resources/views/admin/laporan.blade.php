@extends('layouts.admin')

@section('title', 'EDUSAFE - Laporan System')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">

        <!-- Card Pembungkus Utama -->
        <div class="admin-card">
            <div class="flex-between" style="margin-bottom: 20px;">
                <div>
                    <h2 class="admin-card-title" style="font-size: 22px; color: #00288A;">Laporan Rekapitulasi Edukasi</h2>
                    <p style="color: #64748B; font-size: 13px; margin-top: 4px;">Unduh dan tinjau performa statistik kegiatan kuis serta tingkat pemahaman siswa.</p>
                </div>
                <button class="btn-primary-admin" style="background: #10B981;">Ekspor Laporan (PDF/Excel)</button>
            </div>

            <!-- 3 Ringkasan Statistik -->
            <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
                <div class="stat-card">
                    <p class="stat-label">TINGKAT KELULUSAN KUIS</p>
                    <h3 class="stat-value" style="color: #00288A;">94.2%</h3>
                    <span class="stat-trend">+3.1% dibanding bulan lalu</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">MODUL PALING POPULER</p>
                    <h3 class="stat-value" style="font-size: 18px; color: #00288A;">Malware Analysis</h3>
                    <span class="stat-label">Total 420 penyelesaian</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">RERATA WAKTU PENYELESAIAN</p>
                    <h3 class="stat-value" style="color: #00288A;">18.5 Menit</h3>
                    <span class="stat-label">Per modul edukasi</span>
                </div>
            </div>

            <!-- Tabel Activity -->
            <h3 class="admin-card-title" style="margin-bottom: 16px;">Rekapitulasi Aktivitas Bulanan</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Siswa Aktif</th>
                            <th>Kuis Diselesaikan</th>
                            <th>Rata-rata Nilai</th>
                            <th>Status Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>September 2026</strong></td>
                            <td>1,284 Siswa</td>
                            <td>3,420 Kali</td>
                            <td><strong>78.5</strong></td>
                            <td><span class="badge-status-blue">Berjalan</span></td>
                        </tr>
                        <tr>
                            <td><strong>Agustus 2026</strong></td>
                            <td>1,150 Siswa</td>
                            <td>2,980 Kali</td>
                            <td><strong>80.2</strong></td>
                            <td><span class="badge-status-green">Selesai & Arsip</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection