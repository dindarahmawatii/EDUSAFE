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
            </div>

            <!-- 3 Ringkasan Statistik -->
            <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
                <div class="stat-card">
                    <p class="stat-label">TINGKAT KELULUSAN KUIS</p>
                    <h3 class="stat-value" style="color: #00288A;">{{ $tingkatKelulusan }}%</h3>
                    <span class="stat-trend">{{ $kelulusanSubtext }}</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">MODUL PALING POPULER</p>
                    <h3 class="stat-value" style="font-size: 18px; color: #00288A;">{{ $modulPopulerNama }}</h3>
                    <span class="stat-label">{{ $modulPopulerSubtext }}</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">RERATA WAKTU PENYELESAIAN</p>
                    <h3 class="stat-value" style="color: #00288A;">{{ $rerataWaktu }}</h3>
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
                            <th>Total Siswa</th>
                            <th>Kuis Diselesaikan</th>
                            <th>Rata-rata Nilai</th>
                            <th>Status Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapBulanan as $item)
                            <tr>
                                <td><strong>{{ $item->nama_bulan }}</strong></td>
                                <td>{{ $item->total_user }} Siswa</td>
                                <td>{{ $item->total_kuis }} Kali</td>
                                <td><strong>{{ $item->rerata_nilai !== null ? $item->rerata_nilai : '-' }}</strong></td>
                                <td><span class="{{ $item->status_class }}">{{ $item->status_label }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #64748B; padding: 24px;">
                                    Belum ada data aktivitas bulanan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection