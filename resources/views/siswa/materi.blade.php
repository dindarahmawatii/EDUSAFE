@extends('layouts.siswa')

@section('title', 'Materi Pembelajaran Malware - EduQuiz')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/materi.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="materi-page-wrapper">
    <div class="materi-container">
        
        <!-- Header & Progres Belajar -->
        <div class="materi-header-flex">
            <div class="materi-title-area">
                <h1 class="materi-main-title">Materi Pembelajaran Malware</h1>
                <p class="materi-main-desc">
                    Pelajari berbagai ancaman siber dan cara melindunginya melalui kurikulum terstruktur yang dirancang untuk membekali Anda dengan pengetahuan keamanan terkini.
                </p>
            </div>
            
            <div class="progres-card">
                <div class="progres-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                </div>
                <div class="progres-info">
                    <span class="progres-text">Progres Belajar</span>
                    <h3 class="progres-percentage">65% Selesai</h3>
                </div>
            </div>
        </div>

        <!-- Grid 3 Kolom Modul -->
        <div class="materi-grid">

            <!-- Modul 01 -->
            <div class="modul-card">
                <div class="modul-thumb preview-thumb">
                    <span class="modul-badge">Modul 01</span>
                    <div class="thumb-mockup">
                        <small>EduQuiz</small>
                    </div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title">Pengenalan Malware</h3>
                    <p class="modul-desc">Memahami dasar-dasar perangkat lunak berbahaya, sejarah perkembangannya, dan mengapa malware menjadi ancaman utama di era digital.</p>
                    <div class="modul-footer">
                        <span class="modul-time">⏱ 15 Menit</span>
                        <a href="{{ route('siswa.baca-materi', 1) }}" class="btn-buka">Buka Materi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Modul 02 -->
            <div class="modul-card">
                <div class="modul-thumb blue-gradient-thumb">
                    <span class="modul-badge">Modul 02</span>
                    <div class="thumb-icon">🐛</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title">Jenis-jenis Malware</h3>
                    <p class="modul-desc">Identifikasi perbedaan antara Virus, Worm, Trojan, Ransomware, dan Spyware serta cara kerja unik masing-masing ancaman.</p>
                    <div class="modul-footer">
                        <span class="modul-time">⏱ 25 Menit</span>
                        <a href="{{ route('siswa.baca-materi', 2) }}" class="btn-buka">Buka Materi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Modul 03 -->
            <div class="modul-card">
                <div class="modul-thumb dark-thumb">
                    <span class="modul-badge">Modul 03</span>
                    <div class="thumb-icon">🛡️</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title">Mekanisme Infeksi</h3>
                    <p class="modul-desc">Mempelajari jalur distribusi malware melalui email phishing, unduhan berbahaya, dan kerentanan sistem operasi.</p>
                    <div class="modul-footer">
                        <span class="modul-time">⏱ 20 Menit</span>
                        <a href="{{ route('siswa.baca-materi', 3) }}" class="btn-buka">Buka Materi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Modul 04 -->
            <div class="modul-card">
                <div class="modul-thumb deep-blue-thumb">
                    <span class="modul-badge">Modul 04</span>
                    <div class="thumb-icon">📊</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title">Analisis Malware Dasar</h3>
                    <p class="modul-desc">Teknik dasar untuk mengamati perilaku file mencurigakan dalam lingkungan sandbox yang aman tanpa membahayakan sistem.</p>
                    <div class="modul-footer">
                        <span class="modul-time">⏱ 30 Menit</span>
                        <a href="{{ route('siswa.baca-materi', 4) }}" class="btn-buka">Buka Materi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Modul 05 -->
            <div class="modul-card">
                <div class="modul-thumb royal-blue-thumb">
                    <span class="modul-badge">Modul 05</span>
                    <div class="thumb-icon">🛡️</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title">Pencegahan & Mitigasi</h3>
                    <p class="modul-desc">Strategi pertahanan berlapis, penggunaan perangkat lunak antivirus, dan praktik keamanan terbaik untuk individu dan organisasi.</p>
                    <div class="modul-footer">
                        <span class="modul-time">⏱ 18 Menit</span>
                        <a href="{{ route('siswa.baca-materi', 5) }}" class="btn-buka">Buka Materi &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Modul Terkunci -->
            <div class="modul-card locked-card">
                <div class="modul-thumb locked-thumb">
                    <div class="lock-icon">🔒</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title locked-title">Studi Kasus Lanjutan</h3>
                    <p class="modul-desc locked-desc">Bedah tuntas serangan malware nyata yang terjadi di industri teknologi dalam 5 tahun terakhir. Segera hadir.</p>
                    <div class="modul-footer">
                        <span class="btn-terkunci">Terkunci</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tombol Bottom Dropdown -->
        <div class="materi-bottom-action">
            <button class="btn-lihat-semua">Lihat Semua Materi &or;</button>
        </div>

    </div>
</div>
@endsection