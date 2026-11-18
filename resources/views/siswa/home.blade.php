@extends('layouts.siswa')

@section('title', 'EduQuiz - Platform Pembelajaran Online Malware')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/home.css') }}?v={{ time() }}">
    <!-- Tambahkan CSS materi jika diperlukan styling-nya -->
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/materi.css') }}?v={{ time() }}">
@endpush

@section('content')
    <!-- 1. Hero Banner Full Screen / Full Biru -->
    <section class="hero-banner" style="min-height: calc(100vh - 100px); display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <h1 class="hero-title">EduSafe</h1>
        <p class="hero-subtitle">Platform Pembelajaran Online Malware</p>
        <div class="hero-actions">
            <!-- Tombol Materi diarahkan ke ID section di bawah -->
            <a href="#materi-section" class="btn btn-light">Materi</a>
            <a href="{{ route('siswa.kuis') }}" class="btn btn-dark">Kuis</a>
        </div>
    </section>

    <!-- 2. Section Materi yang Digabung Langsung ke Bawah -->
    <div id="materi-section" class="materi-page-wrapper" style="padding-top: 60px;">
        <div class="materi-container">
            
            <!-- Header & Progres Belajar -->
            <div class="materi-header-flex">
                <div class="materi-title-area">
                    <h1 class="materi-main-title">Materi Pembelajaran Malware</h1>
                    <p class="materi-main-desc">
                        Pelajari berbagai ancaman siber dan cara melindunginya melalui kurikulum terstruktur.
                    </p>
                </div>
            </div>

            <!-- Grid Modul dari file materi.blade.php kamu -->
            <div class="materi-grid">
                @forelse($materiList ?? [] as $index => $materi)
                    <div class="modul-card">
                        <div class="modul-thumb {{ ['preview-thumb', 'blue-gradient-thumb', 'dark-thumb', 'deep-blue-thumb', 'royal-blue-thumb', 'blue-gradient-thumb'][$index % 6] }}">
                            <span class="modul-badge">
                                Modul {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($index === 0)
                                <div class="thumb-mockup"><small>EduSafe</small></div>
                            @else
                                <div class="thumb-icon">{{ ['📘', '🐛', '🛡️', '📊', '🛡️', '🔐'][$index % 6] }}</div>
                            @endif
                        </div>
                        <div class="modul-content">
                            <h3 class="modul-title">{{ $materi->judul ?? $materi->namamateri ?? 'Materi tanpa judul' }}</h3>
                            <p class="modul-desc">{{ \Illuminate\Support\Str::limit($materi->deskripsi ?? $materi->konten ?? 'Deskripsi belum tersedia.', 180) }}</p>
                            <div class="modul-footer">
                                <span class="modul-time">⏱ {{ $materi->kategori ?? 'Materi pembelajaran' }}</span>
                                <a href="{{ route('siswa.baca-materi', $materi->id) }}" class="btn-buka">Buka Materi &rarr;</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Belum ada materi pembelajaran.</p>
                @endforelse

                <!-- Modul Terkunci -->
                <div class="modul-card locked-card">
                    <div class="modul-thumb locked-thumb"><div class="lock-icon">🔒</div></div>
                    <div class="modul-content">
                        <h3 class="modul-title locked-title">Studi Kasus Lanjutan</h3>
                        <p class="modul-desc locked-desc">Bedah tuntas serangan malware nyata. Segera hadir.</p>
                        <div class="modul-footer"><span class="btn-terkunci">Terkunci</span></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection