@extends('layouts.admin')

@section('title', 'EDUSAFE - Laporan System')

@section('content')
<div class="container">
    <div class="flex-between" style="margin-bottom: 25px;">
        <div>
            <h1 style="color: var(--primary); margin-bottom: 5px;">Laporan Rekapitulasi Edukasi</h1>
            <p style="color: var(--text-muted);">Unduh dan tinjau performa statistik kegiatan kuis serta tingkat pemahaman siswa.</p>
        </div>
        <button class="btn" style="background: #10B981;">📥 Ekspor Laporan (PDF/Excel)</button>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-3" style="gap: 20px; margin-bottom: 30px;">
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">TINGKAT KELULUSAN KUIS</p>
            <h2 style="font-size: 32px; color: var(--primary); margin: 10px 0;">94.2%</h2>
            <span style="font-size: 12px; color: #10B981; font-weight: bold;">+3.1% dibanding bulan lalu</span>
        </div>
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">MODUL PALING POPULER</p>
            <h3 style="color: var(--primary); margin: 10px 0;">Malware Analysis Fundamentals</h3>
            <span style="font-size: 12px; color: var(--text-muted);">Total 420 penyelesaian</span>
        </div>
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">RERATA WAKTU PENYELESAIAN</p>
            <h2 style="font-size: 32px; color: var(--primary); margin: 10px 0;">18.5 Menit</h2>
            <span style="font-size: 12px; color: var(--text-muted);">Per modul edukasi</span>
        </div>
    </div>

    <!-- Tabel Ringkasan Rekap Laporan Bulanan -->
    <div class="card">
        <h3 style="margin-bottom: 20px;">Rekapitulasi Aktivitas Bulanan</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border); color: var(--text-muted); text-align: left;">
                    <th style="padding: 15px;">Bulan</th>
                    <th style="padding: 15px;">Siswa Aktif</th>
                    <th style="padding: 15px;">Kuis Diselesaikan</th>
                    <th style="padding: 15px;">Rata-rata Nilai</th>
                    <th style="padding: 15px;">Status Laporan</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 15px;"><strong>September 2026</strong></td>
                    <td style="padding: 15px;">1,284 Siswa</td>
                    <td style="padding: 15px;">3,420 Kali</td>
                    <td style="padding: 15px; font-weight: bold;">78.5</td>
                    <td style="padding: 15px;"><span class="badge" style="background: #DBEAFE; color: #1E40AF;">Berjalan</span></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 15px;"><strong>Agustus 2026</strong></td>
                    <td style="padding: 15px;">1,150 Siswa</td>
                    <td style="padding: 15px;">2,980 Kali</td>
                    <td style="padding: 15px; font-weight: bold;">80.2</td>
                    <td style="padding: 15px;"><span class="badge" style="background: #D1FAE5; color: #065F46;">Selesai & Arsip</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection