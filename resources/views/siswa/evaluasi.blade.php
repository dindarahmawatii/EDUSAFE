@extends('layouts.siswa')

@section('title', 'Evaluasi Performa - EduQuiz')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/evaluasi.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="evaluasi-page-wrapper">
    <div class="evaluasi-container">
        
        <!-- Header Halaman -->
        <div class="evaluasi-header">
            <h1 class="evaluasi-main-title">Evaluasi Performa Pengguna</h1>
            <p class="evaluasi-main-desc">Berikut adalah penilaian dan umpan balik profesional dari instruktur mengenai perkembangan akademik Anda.</p>
        </div>

        <!-- Top Profile & Summary Card -->
        <div class="eval-profile-card">
            <div class="profile-left">
                <div class="profile-avatar">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </div>
                <div>
                    <div class="profile-name-row">
                        <h3 class="profile-name">{{ Auth::user()?->name ?? 'Rizky Pratama' }}</h3>
                        <span class="badge-active">ACTIVE SCHOLAR</span>
                    </div>
                    <p class="profile-meta">ID: <strong>EDU-{{ str_pad((string)(Auth::id() ?? 1), 4, '0', STR_PAD_LEFT) }}</strong> &bull; Modul Saat Ini: <strong>Pengenalan Malware & Ancaman Siber</strong></p>
                </div>
            </div>

            <div class="profile-stats-right">
                <div class="stat-box">
                    <span class="stat-value">{{ $rerataKuis ?? 88 }}%</span>
                    <span class="stat-label">RERATA KUIS</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">{{ $materiSelesai ?? 0 }}/{{ $totalMateri ?? 6 }}</span>
                    <span class="stat-label">MODUL SELESAI</span>
                </div>
                <div class="stat-box">
                    <span class="stat-value">{{ $predikat ?? 'A' }}</span>
                    <span class="stat-label">PREDIKAT</span>
                </div>
            </div>
        </div>

        <!-- Middle Grid (Metrik Kompetensi & Statistik Terakhir) -->
        <div class="eval-grid-middle">
            
            <!-- Kolom Kiri: Metrik Kompetensi Slider -->
            <div class="eval-card metrik-card">
                <div class="metrik-header">
                    <span class="badge-sub">Metrik Kompetensi</span>
                    <div class="score-avg-badge">
                        <span>8.5</span>
                        <small>SKOR RATA-RATA</small>
                    </div>
                </div>
                <h3 class="metrik-title">Penilaian Teknis & Soft-skill</h3>

                <div class="slider-item">
                    <div class="slider-label"><span>Pemahaman Teknis</span><strong>8/10</strong></div>
                    <div class="slider-track"><div class="slider-fill" style="width: 80%;"></div><div class="slider-thumb" style="left: 80%;"></div></div>
                </div>

                <div class="slider-item">
                    <div class="slider-label"><span>Ketepatan Analisis</span><strong>9/10</strong></div>
                    <div class="slider-track"><div class="slider-fill" style="width: 90%;"></div><div class="slider-thumb" style="left: 90%;"></div></div>
                </div>

                <div class="slider-item">
                    <div class="slider-label"><span>Kecepatan Penyelesaian</span><strong>7/10</strong></div>
                    <div class="slider-track"><div class="slider-fill" style="width: 70%;"></div><div class="slider-thumb" style="left: 70%;"></div></div>
                </div>

                <div class="slider-item">
                    <div class="slider-label"><span>Kualitas Laporan</span><strong>10/10</strong></div>
                    <div class="slider-track"><div class="slider-fill" style="width: 100%;"></div><div class="slider-thumb" style="left: 100%;"></div></div>
                </div>
            </div>

            <!-- Kolom Kanan: Statistik Belajar Terakhir -->
            <div class="eval-card statistik-card">
                <h3 class="card-section-title">STATISTIK BELAJAR TERAKHIR</h3>
                
                <div class="stat-row-item">
                    <div class="stat-row-left">
                        <span class="stat-icon-box">📊</span>
                        <span>Kuis Modul 4</span>
                    </div>
                    <strong>95/100</strong>
                </div>

                <div class="stat-row-item">
                    <div class="stat-row-left">
                        <span class="stat-icon-box">⏱️</span>
                        <span>Waktu Belajar</span>
                    </div>
                    <strong>42 Jam</strong>
                </div>

                <div class="stat-row-item">
                    <div class="stat-row-left">
                        <span class="stat-icon-box">🎯</span>
                        <span>Penyelesaian</span>
                    </div>
                    <strong>85%</strong>
                </div>
            </div>

        </div>

        <!-- Bottom Grid (Rekomendasi Kompetensi & Catatan Instruktur) -->
        <div class="eval-grid-bottom">
            
            <!-- Rekomendasi Checklist -->
            <div class="eval-card rekomendasi-card">
                <h3 class="card-section-title flex-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    Rekomendasi Kompetensi
                </h3>

                <div class="check-item checked">
                    <span class="checkbox-icon">✔</span>
                    <span>Siap untuk sertifikasi tingkat lanjut</span>
                </div>
                <div class="check-item">
                    <span class="checkbox-icon uncheck"></span>
                    <span>Perlu pengayaan pada Reverse Engineering</span>
                </div>
                <div class="check-item checked">
                    <span class="checkbox-icon">✔</span>
                    <span>Sangat baik dalam penulisan dokumentasi</span>
                </div>
                <div class="check-item">
                    <span class="checkbox-icon uncheck"></span>
                    <span>Membutuhkan bimbingan manajemen waktu</span>
                </div>
            </div>

            <!-- Catatan Instruktur -->
            <div class="eval-card catatan-card">
                <h3 class="card-section-title flex-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Catatan Instruktur & Rekomendasi
                </h3>
                <p class="catatan-desc-label">Berikan detail mendalam mengenai kelebihan dan area yang perlu difokuskan.</p>
                
                <div class="catatan-box-view">
                    <p><em>"Pemahaman dasar mengenai Ransomware sangat baik. Secara keseluruhan, dokumentasi jawaban kuis sangat rapi dan mudah dipahami. Tetap pertahankan kualitas belajarnya!"</em></p>
                </div>
            </div>

        </div>

        <!-- Footer Info Note -->
        <div class="eval-footer-note">
            <p>Hasil evaluasi ini diperbarui secara berkala oleh tim akademik berdasarkan aktivitas kuis dan progres lab Anda.</p>
        </div>

    </div>
</div>
@endsection