@extends('layouts.app')

@section('title', 'EDUSAFE - Baca Materi')

@section('content')
<div class="container">
    <div class="card" style="max-width: 800px; margin: 0 auto; padding: 40px;">
        <div class="badge" style="background: var(--primary); color: white; margin-bottom: 15px;">{{ $materi['modul'] }}</div>
        <h1 style="color: var(--primary); margin-bottom: 10px;">{{ $materi['judul'] }}</h1>
        <p style="color: var(--text-muted); font-size: 14px; border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 20px;">
            Estimasi waktu baca: {{ $materi['estimasi'] }} | Kategori: {{ $materi['kategori'] }}
        </p>

        <div style="line-height: 1.8; color: var(--text-dark); margin-bottom: 40px;">
            @foreach($materi['isi'] as $bagian)
                <h3>{{ $bagian['subjudul'] }}</h3>
                <p style="margin-bottom: 15px;">
                    {{ $bagian['konten'] }}
                </p>
            @endforeach
        </div>

        <div class="flex-between" style="background: #EBF3FF; padding: 25px; border-radius: 12px; border: 1px solid #C6DBFF;">
            <div>
                <h3 style="margin-bottom: 5px; color: var(--primary);">Sudah paham materinya?</h3>
                <p style="font-size: 13px; color: var(--text-muted);">Uji pemahaman Anda dengan mengerjakan kuis evaluasi untuk modul ini.</p>
            </div>
            <a href="{{ route('siswa.kuis') }}" class="btn" style="background: #10B981; font-size: 16px; padding: 12px 24px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
                Kerjakan Kuis
            </a>
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('siswa.materi') }}" style="color: var(--text-muted); font-size: 14px; text-decoration: underline;">&larr; Kembali ke Daftar Materi</a>
        </div>
    </div>
</div>
@endsection