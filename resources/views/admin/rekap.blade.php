@extends('layouts.admin')

@section('title', 'EDUSAFE - Rekap Pembelajaran')

@section('content')
<div class="admin-page-wrapper">
    <div class="admin-container">
        
        <!-- Header Halaman -->
        <div style="margin-bottom: 25px;">
            <h1 class="admin-card-title" style="font-size: 24px; color: #00288A; margin-bottom: 6px;">Rekap Pembelajaran Sistem</h1>
            <p style="color: #64748B; font-size: 14px; margin: 0;">Tinjauan keseluruhan progres modul, total durasi belajar, dan pencapaian target mingguan seluruh siswa.</p>
        </div>

        <!-- 3 Kartu Ringkasan Progres -->
        <div class="admin-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Total Modul Selesai</span>
                    <div class="stat-icon">📖</div>
                </div>
                <h2 class="stat-value" style="color: #00288A; font-size: 32px;">{{ $totalModulSelesai }} Modul</h2>
                <p style="margin: 6px 0 0 0; font-size: 12px; color: #64748B;">
                    Dari total <strong>{{ $totalModul }}</strong> modul di sistem
                </p>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Waktu Belajar Kumulatif</span>
                    <div class="stat-icon">⏳</div>
                </div>
                <h2 class="stat-value" style="color: #00288A; font-size: 32px;">{{ $waktuBelajarFormatted }}</h2>
                <p style="margin: 6px 0 0 0; font-size: 12px; color: #64748B;">
                    Akumulasi durasi belajar seluruh siswa
                </p>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-label" style="text-transform: uppercase; font-size: 11px;">Target Mingguan</span>
                    <span class="stat-trend" style="color: #00288A;">{{ $persenTarget }}%</span>
                </div>
                <div style="background: #BFDBFE; height: 10px; border-radius: 6px; margin: 12px 0; overflow: hidden;">
                    <div style="background: #00288A; width: {{ $persenTarget }}%; height: 100%; border-radius: 6px; transition: width 0.3s ease;"></div>
                </div>
                <div class="flex-between" style="font-size: 12px; color: #475569; font-weight: 600;">
                    <span>{{ $capaianMingguan }} dari {{ $targetMingguan }} Modul Selesai</span>
                    <span style="color: #00288A; font-weight: 800;">{{ $statusTarget }}</span>
                </div>
            </div>
        </div>

        <!-- Tabel 1: Ringkasan Tingkat Penyelesaian per Modul -->
        <div class="admin-card" style="margin-bottom: 28px;">
            <div class="flex-between" style="margin-bottom: 20px;">
                <div>
                    <h3 class="admin-card-title">Tingkat Penyelesaian per Modul</h3>
                    <p style="color: #64748B; font-size: 13px; margin: 4px 0 0 0;">Persentase penyelesaian modul materi oleh mahasiswa/siswa terdaftar.</p>
                </div>
                <button class="btn-cancel" style="padding: 8px 16px; font-size: 13px;" onclick="window.print()">📥 Cetak Rekap</button>
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
                        @forelse($rekapModul as $item)
                            <tr>
                                <td><strong>{{ $item->judul }}</strong></td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->durasi }}</td>
                                <td>
                                    <strong>{{ $item->persen }}%</strong>
                                    <span style="color: #64748B; font-size: 12px;">({{ $item->selesai_count }} dari {{ $item->total_siswa }} Siswa)</span>
                                </td>
                                <td>
                                    <span class="{{ $item->status_class }}">{{ $item->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="table-empty">Belum ada modul pembelajaran di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Riwayat Penyelesaian Modul Semua Siswa -->
        <div class="admin-card">
            <div class="flex-between" style="margin-bottom: 20px;">
                <div>
                    <h3 class="admin-card-title">Riwayat Penyelesaian Modul Semua Siswa</h3>
                    <p style="color: #64748B; font-size: 13px; margin: 4px 0 0 0;">Log aktivitas aktual seluruh siswa yang telah menyelesaikan modul beserta hasil kuisnya.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Modul Pembelajaran</th>
                            <th>Kategori</th>
                            <th>Waktu Selesai</th>
                            <th>Nilai Kuis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatSiswa as $r)
                            <tr>
                                <td>
                                    <strong>{{ $r->user_name }}</strong>
                                    <div style="font-size: 12px; color: #64748B;">{{ $r->user_email }}</div>
                                </td>
                                <td><strong>{{ $r->modul }}</strong></td>
                                <td>{{ $r->kategori }}</td>
                                <td>{{ $r->tanggal_selesai }}</td>
                                <td>
                                    @if($r->nilai !== null)
                                        <strong style="color: #00288A;">{{ $r->nilai }}/100</strong>
                                    @else
                                        <span style="color: #94A3B8;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status_kuis === 'LULUS')
                                        <span class="badge-status-green">Lulus Kuis</span>
                                    @elseif($r->status_kuis === 'TIDAK LULUS')
                                        <span class="badge-status-red">Remedial</span>
                                    @else
                                        <span class="badge-status-blue">Materi Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="table-empty">Belum ada catatan riwayat penyelesaian modul oleh siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection