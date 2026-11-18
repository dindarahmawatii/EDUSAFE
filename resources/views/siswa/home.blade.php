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
            @forelse($materiList ?? [] as $materi)
                <a href="{{ route('siswa.baca-materi', $materi->id) }}" class="materi-card">
                    <div>
                        <h3 class="materi-card-title">{{ $materi->judul }}</h3>
                        <p class="materi-card-question">{{ $materi->kategori }}</p>
                        <p class="materi-card-snippet">{{ \Illuminate\Support\Str::limit($materi->deskripsi, 110) }}</p>
                    </div>
                </a>
            @empty
                <p>Belum ada materi.</p>
            @endforelse
        </div>
    </div>
@endsection