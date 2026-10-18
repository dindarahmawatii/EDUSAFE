@extends('layouts.siswa')

@section('title', 'EduQuiz - Platform Pembelajaran Online Malware')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/home.css') }}?v={{ time() }}">
@endpush

@section('content')
    <!-- Hero Banner -->
    <section class="hero-banner">
        <h1 class="hero-title">EduQuiz</h1>
        <p class="hero-subtitle">Platform Pembelajaran Online Malware</p>
        <div class="hero-actions">
            <a href="{{ route('siswa.materi') }}" class="btn btn-light">Materi</a>
            <a href="{{ route('siswa.kuis') }}" class="btn btn-dark">Kuis</a>
        </div>
    </section>

    <!-- Content / Grid Card Materi -->
    <div class="materi-section">
        <div class="materi-header">
            <h2>Materi</h2>
            <p>Tentang bahayanya Sebuah Malware</p>
        </div>

        <div class="materi-grid">
            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Pengenalan Malware</h3>
                    <p class="materi-card-question">Apa itu Malware?</p>
                    <p class="materi-card-snippet">Malware merupakan perangkat lunak berbahaya yang dirancang untuk merusak atau mengakses sistem...</p>
                </div>
            </a>

            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Jenis-Jenis Malware</h3>
                    <p class="materi-card-question">Apa saja jenis Malware?</p>
                    <p class="materi-card-snippet">Malware memiliki berbagai tipe seperti Virus, Trojan, Ransomware, Worm, dan Spyware...</p>
                </div>
            </a>

            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Cara Mengatasi Malware</h3>
                    <p class="materi-card-question">Bagaimana cara mengatasinya?</p>
                    <p class="materi-card-snippet">Malware bisa diatasi dengan pemindaian Antivirus, isolasi jaringan, dan pembersihan file infeksi...</p>
                </div>
            </a>

            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Upaya Pencegahan</h3>
                    <p class="materi-card-question">Bagaimana upaya pencegahannya?</p>
                    <p class="materi-card-snippet">Malware dapat dicegah dengan mengabaikan email mencurigakan dan selalu mengupdate sistem operasi...</p>
                </div>
            </a>

            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Sejarah Malware</h3>
                    <p class="materi-card-question">Kapan Malware pertama kali ada?</p>
                    <p class="materi-card-snippet">Malware ada sejak berkembangnya eksperimen program mandiri seperti Creeper virus di era ARPANET...</p>
                </div>
            </a>

            <a href="{{ route('siswa.materi') }}" class="materi-card">
                <div>
                    <h3 class="materi-card-title">Cara Kerja Malware</h3>
                    <p class="materi-card-question">Bagaimana cara kerjanya?</p>
                    <p class="materi-card-snippet">Malware memiliki teknik eksploitasi, penyusupan latar belakang, hingga enkripsi data secara paksa...</p>
                </div>
            </a>
        </div>
    </div>
@endsection