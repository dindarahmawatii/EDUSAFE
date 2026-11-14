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
                    <span>{{ $totalSelesai ?? 0 }} dari {{ $totalModul ?? 0 }} Modul ({{ $persenSelesai ?? 0 }}%)</span>
                </div>
            </div>

            <!-- Card 2: Waktu Belajar (Active Card) -->
            <div class="stat-card active-blue-card">
                <div class="stat-icon-square light-blue-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <span class="stat-card-label">WAKTU BELAJAR</span>
                <div class="stat-card-value">{{ $waktuBelajarFormatted ?? '0j 0m' }}</div>
                <p class="stat-card-subtext">Akumulasi durasi belajar modul & kuis Anda</p>
            </div>

            <!-- Card 3: Target Mingguan -->
            <div class="stat-card">
                <h3 class="target-title">Target Mingguan</h3>
                <div class="target-bar-bg">
                    <div class="target-bar-fill" style="width: {{ $persenTarget ?? 0 }}%;"></div>
                </div>
                <div class="target-info-flex">
                    <span class="target-count">{{ $capaianMingguan ?? 0 }} dari {{ $targetMingguan ?? 8 }} Modul</span>
                    <strong class="target-percent">{{ $persenTarget ?? 0 }}%</strong>
                </div>
            </div>

        </div>

        <!-- Card Utama: Search, Filter, & Tabel -->
        <div class="rekap-table-card">
            
            <!-- Toolbar Atas -->
            <div class="rekap-toolbar">
                <div class="search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="rekapSearch" placeholder="Cari modul atau materi...">
                </div>

                <div class="toolbar-actions">
                    <button class="btn-toolbar" onclick="window.print()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Ekspor Rekap
                    </button>
                </div>
            </div>

            <!-- Tabel Rekap -->
            <div class="table-responsive">
                <table class="rekap-table" id="rekapTable">
                    <thead>
                        <tr>
                            <th>MATERI PEMBELAJARAN</th>
                            <th>KATEGORI</th>
                            <th>WAKTU AKSES TERAKHIR</th>
                            <th>DURASI SESI</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarRekap ?? [] as $item)
                            <tr class="rekap-row">
                                <td>
                                    <div class="materi-cell">
                                        <div class="materi-icon-box {{ $item->icon_box }}">{{ $item->icon_emoji }}</div>
                                        <div>
                                            <strong class="materi-title-text">{{ $item->judul }}</strong>
                                            <small class="materi-sub-text">{{ $item->sub_text }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="category-tag {{ $item->tag_class }}">{{ $item->kategori }}</span></td>
                                <td class="time-text">{{ $item->waktu_akses }}</td>
                                <td class="duration-text">{{ $item->durasi }}</td>
                                <td>
                                    <span class="status-pill {{ $item->status_class }}">{{ $item->status }}</span>
                                    @if($item->nilai_kuis !== null)
                                        <div style="font-size: 11px; color: #00288A; font-weight: 700; margin-top: 4px;">Skor Kuis: {{ $item->nilai_kuis }}/100</div>
                                    @endif
                                </td>
                                <td class="action-cell">
                                    <a href="{{ route('siswa.baca-materi', $item->id) }}" class="btn-toolbar" style="padding: 6px 12px; font-size: 12px; text-decoration: none; display: inline-flex;">
                                        Pelajari &rsaquo;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #64748B; padding: 36px 16px;">
                                    Belum ada modul pembelajaran yang tersedia di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="table-footer flex-between">
                <span class="entries-info" id="entriesInfo">Menampilkan {{ count($daftarRekap ?? []) }} dari {{ $totalModul ?? 0 }} modul</span>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('rekapSearch');
        const rows = document.querySelectorAll('.rekap-row');
        const entriesInfo = document.getElementById('entriesInfo');
        const total = rows.length;

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(function (row) {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (entriesInfo) {
                    entriesInfo.textContent = 'Menampilkan ' + visibleCount + ' dari ' + total + ' modul';
                }
            });
        }
    });
</script>
@endpush