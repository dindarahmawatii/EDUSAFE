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
                    <svg width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                </div>
                <div class="progres-info">
                    <span class="progres-text">Progres Belajar</span>
                    <h3 class="progres-percentage">65% Selesai</h3>
                </div>
            </div>
        </div>

        <!-- Grid 3 Kolom Modul -->
        <div class="materi-grid">

            @forelse($materiList as $index => $materi)

                <div class="modul-card">
                    <div class="modul-thumb {{ [
                        'preview-thumb',
                        'blue-gradient-thumb',
                        'dark-thumb',
                        'deep-blue-thumb',
                        'royal-blue-thumb',
                        'blue-gradient-thumb'
                    ][$index % 6] }}">

                        <span class="modul-badge">
                            Modul {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                        </span>

                        @if($index === 0)
                            <div class="thumb-mockup">
                                <small>EduQuiz</small>
                            </div>
                        @else
                            <div class="thumb-icon">
                                {{ ['📘', '🐛', '🛡️', '📊', '🛡️', '🔐'][$index % 6] }}
                            </div>
                        @endif
                    </div>

                    <div class="modul-content">
                        <h3 class="modul-title">
                            {{ $materi->judul ?? $materi->namamateri ?? 'Materi tanpa judul' }}
                        </h3>

                        <p class="modul-desc">
                            {{ \Illuminate\Support\Str::limit(
                                $materi->deskripsi ?? $materi->konten ?? 'Deskripsi materi belum tersedia.',
                                180
                            ) }}
                        </p>

                        <div class="modul-footer">
                            <span class="modul-time">
                                ⏱ {{ $materi->kategori ?? 'Materi pembelajaran' }}
                            </span>

                            <a href="{{ route('siswa.baca-materi', $materi->id) }}"
                               class="btn-buka">
                                Buka Materi &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <p>Belum ada materi pembelajaran.</p>
            @endforelse

            <!-- Modul Terkunci: desain asli dipertahankan -->
            <div class="modul-card locked-card">
                <div class="modul-thumb locked-thumb">
                    <div class="lock-icon">🔒</div>
                </div>
                <div class="modul-content">
                    <h3 class="modul-title locked-title">Studi Kasus Lanjutan</h3>
                    <p class="modul-desc locked-desc">
                        Bedah tuntas serangan malware nyata yang terjadi di industri teknologi dalam 5 tahun terakhir. Segera hadir.
                    </p>
                    <div class="modul-footer">
                        <span class="btn-terkunci">Terkunci</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tombol asli dipertahankan -->
        <div class="materi-bottom-action">
            <button class="btn-lihat-semua">Lihat Semua Materi &or;</button>
        </div>

    </div>
</div>
@endsection