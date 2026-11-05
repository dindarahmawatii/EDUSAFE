@extends('layouts.siswa')

@section('title', 'EDUSAFE - Ringkasan Nilai & Pencapaian')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/nilai.css') }}?v={{ time() }}">
@endpush

@section('content')
@php
    $materiVal = $materiSelesai ?? 12;
    $persenMateri = ($materiVal / 15) * 100;
    $rataNilaiVal = $rataRataNilai ?? 88.5;
@endphp

<div class="nilai-page-wrapper">
    <div class="nilai-container">
        
        <!-- Header Halaman -->
        <div class="nilai-header">
            <h1 class="nilai-main-title">Ringkasan Nilai & Pencapaian</h1>
            <p class="nilai-main-desc">Pantau kemajuan belajar Anda dan akses sertifikat resmi.</p>
        </div>

        <!-- Grid Top Cards -->
        <div class="top-cards-grid">
            
            <!-- Card Quiz Terakhir -->
            <div class="card-quiz-terakhir">
                <div class="quiz-info-left">
                    <span class="badge-quiz">Quiz Terakhir</span>
                    <h2 class="quiz-title">
                        {{ data_get($kuisTerakhir, 'nama_modul', 'Malware Analysis Fundamentals') }}
                    </h2>
                    <p class="quiz-date">Diselesaikan pada 24 Okt 2026</p>
                    
                    <!-- LINK SUDAH DIPERBAIKI KE ROUTE REVIEW -->
                    <a href="{{ route('siswa.review') }}" class="btn-review">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Review Jawaban
                    </a>
                </div>

                <div class="score-circle-wrapper">
                    <div class="score-circle">
                        <span class="score-number">{{ data_get($kuisTerakhir, 'skor', 90) }}</span>
                        <span class="score-label">Skor Akhir</span>
                    </div>
                </div>
            </div>

            <!-- Card Kemajuan Kursus -->
            <div class="card-kemajuan">
                <h3 class="kemajuan-title">Kemajuan Kursus</h3>
                
                <div class="progress-group">
                    <div class="progress-labels">
                        <span>Materi Selesai</span>
                        <strong>{{ $materiVal }}/15</strong>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="--w: {{ $persenMateri }}%;"></div>
                    </div>
                </div>

                <div class="progress-group" style="margin-top: 12px;">
                    <div class="progress-labels">
                        <span>Rata-rata Nilai</span>
                        <strong>{{ number_format($rataNilaiVal, 1) }}</strong>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="--w: {{ $rataNilaiVal }}%;"></div>
                    </div>
                </div>

                <p class="kemajuan-note" style="margin-top: 16px;">
                    "Tinggal {{ 15 - $materiVal }} modul lagi untuk mendapatkan sertifikat profesional!"
                </p>
            </div>

        </div>

        <!-- Section Detail Nilai per Modul -->
        <div class="detail-nilai-section">
            <div class="detail-header">
                <h2>Detail Nilai per Modul</h2>
                <div class="detail-actions">
                    <button class="btn-icon" title="Filter"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg></button>
                    <button class="btn-icon" title="Unduh Laporan"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></button>
                </div>
            </div>

            <!-- List Nilai Modul -->
            <div class="modul-nilai-list">
                
                <div class="modul-nilai-item">
                    <div class="item-left">
                        <div class="item-icon">⚙️</div>
                        <div>
                            <h4 class="item-modul-title">Pengantar Malware Analysis</h4>
                            <span class="item-modul-sub">Modul 1 • 12 Pertanyaan</span>
                        </div>
                    </div>
                    <div class="item-right">
                        <div class="score-info">
                            <span class="item-score">95/100</span>
                            <span class="item-status status-sangat-baik">Sangat Baik</span>
                        </div>
                        <a href="{{ route('siswa.review') }}" class="item-arrow" style="text-decoration:none;">&rsaquo;</a>
                    </div>
                </div>

                <div class="modul-nilai-item">
                    <div class="item-left">
                        <div class="item-icon">&lt;&gt;</div>
                        <div>
                            <h4 class="item-modul-title">Static Analysis Techniques</h4>
                            <span class="item-modul-sub">Modul 2 • 15 Pertanyaan</span>
                        </div>
                    </div>
                    <div class="item-right">
                        <div class="score-info">
                            <span class="item-score">82/100</span>
                            <span class="item-status status-lulus">Lulus</span>
                        </div>
                        <a href="{{ route('siswa.review') }}" class="item-arrow" style="text-decoration:none;">&rsaquo;</a>
                    </div>
                </div>

                <div class="modul-nilai-item">
                    <div class="item-left">
                        <div class="item-icon">📊</div>
                        <div>
                            <h4 class="item-modul-title">Behavioral Analysis</h4>
                            <span class="item-modul-sub">Modul 3 • 20 Pertanyaan</span>
                        </div>
                    </div>
                    <div class="item-right">
                        <div class="score-info">
                            <span class="item-score">90/100</span>
                            <span class="item-status status-sangat-baik">Sangat Baik</span>
                        </div>
                        <a href="{{ route('siswa.review') }}" class="item-arrow" style="text-decoration:none;">&rsaquo;</a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection