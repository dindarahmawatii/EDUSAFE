@extends('layouts.siswa')

@section('title', 'EDUSAFE - Kuis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/kuis.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="quiz-wrap">
    <div class="quiz-container">
        
        <!-- Bar Progress & Timer Atas -->
        <div class="quiz-top-bar">
            <div>
               <div class="quiz-progress-label"><span>Progress Belajar : Malware Fundamentals</span><strong>7 / 10 Soal</strong></div>
               <div class="quiz-progress-track"><div class="quiz-progress-fill"></div></div>
            </div>
            <div class="quiz-timer-box">
                ⏱️ 14:52
            </div>
        </div>

        <!-- Grid Utama (Soal & Sidebar Navigasi) -->
        <div class="quiz-main-grid">
            
            <!-- Kolom Kiri: Soal & Opsi -->
            <div class="quiz-question-card">
                <span class="q-badge">PERTANYAAN 7</span>
                <h2 class="q-title">Manakah dari berikut ini yang paling akurat mendeskripsikan "Ransomware" dalam konteks keamanan siber?</h2>
                
                <div class="options-stack">
                    <label class="opt-card">
                        <input type="radio" name="q7"> 
                        <span>Program yang mereplikasi diri secara otomatis melalui jaringan tanpa interaksi pengguna.</span>
                    </label>
                    <label class="opt-card active">
                        <input type="radio" name="q7" checked> 
                        <span style="font-weight: 700;">Malware yang mengenkripsi file pengguna dan menuntut pembayaran untuk mendapatkan kunci dekripsi.</span>
                    </label>
                    <label class="opt-card">
                        <input type="radio" name="q7"> 
                        <span>Software iklan yang menampilkan pop-up terus menerus untuk menghasilkan pendapatan bagi pembuatnya.</span>
                    </label>
                    <label class="opt-card">
                        <input type="radio" name="q7"> 
                        <span>Alat yang digunakan administrator sistem untuk memantau aktivitas jaringan secara legal.</span>
                    </label>
                </div>

                <div class="quiz-card-footer">
                    <a href="#" class="btn-prev">&larr; Sebelumnya</a>
                    <div class="quiz-action-right">
                        <button class="btn-ragu">Ragu-ragu</button>
                        <a href="{{ route('siswa.nilai') }}" class="btn-next">Simpan & Lanjut</a>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Sidebar Navigasi -->
            <div class="quiz-sidebar">
                <h3 class="sidebar-title">Navigasi Soal</h3>
                
                <div class="num-grid">
                    <div class="num-box done">1</div>
                    <div class="num-box done">2</div>
                    <div class="num-box done">3</div>
                    <div class="num-box done">4</div>
                    <div class="num-box done">5</div>
                    <div class="num-box done">6</div>
                    <div class="num-box current">7</div>
                    <div class="num-box">8</div>
                    <div class="num-box">9</div>
                    <div class="num-box">10</div>
                </div>

                <div class="status-legend">
                    <span><i class="dot blue"></i> Terjawab (6)</span>
                    <span><i class="dot gray"></i> Belum (3)</span>
                </div>

                <a href="{{ route('siswa.nilai') }}" class="btn-submit-quiz">Selesaikan Kumpulan</a>

                <div class="sidebar-banner">
                    <small>Modul: Malware Terkini</small>
                </div>
            </div>

        </div>

        <!-- Dua Card Bawah (Tips Ujian & Materi Terkait) -->
        <div class="quiz-bottom-grid">
            <div class="info-card">
                <div class="info-title">💡 Tips Ujian</div>
                <p>Fokus pada kata kunci seperti "enkripsi" dan "pembayaran" untuk mengidentifikasi kategori Ransomware.</p>
            </div>
            <div class="info-card">
                <div class="info-title">📖 Materi Terkait</div>
                <p>Lihat kembali Modul 3: Evolusi Ancaman Digital untuk detail lebih lanjut.</p>
            </div>
        </div>

    </div>
</div>
@endsection