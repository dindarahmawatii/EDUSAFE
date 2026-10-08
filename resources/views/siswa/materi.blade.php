@extends('layouts.app')

@section('title', 'EDUSAFE - Materi Pembelajaran')

@section('content')
<div class="container">
    <div class="flex-between" style="margin-bottom: 30px;">
        <div>
            <h1 style="color: var(--primary); font-size: 28px; font-weight: 700;">Materi Pembelajaran Malware</h1>
            <p style="color: var(--text-muted); font-size: 14px; margin-top: 5px;">
                Pelajari berbagai ancaman siber dan cara melindunginya melalui kurikulum terstruktur.
            </p>
        </div>
        <div class="card" style="padding: 12px 20px; background: #EBF3FF; border: 1px solid #C6DBFF; text-align: center;">
            <span style="font-size: 11px; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Progres Belajar</span>
            <h3 style="color: var(--primary); margin-top: 2px; font-size: 18px;">65% Selesai</h3>
        </div>
    </div>

    <!-- Grid 3 Kolom Seragam & Simetris -->
    <div class="grid grid-3">
        @foreach($materiList as $materi)
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                <div>
                    <div class="badge" style="background: var(--secondary); color: var(--primary); margin-bottom: 15px;">
                        {{ $materi['modul'] }}
                    </div>
                    <h3 style="font-size: 18px; color: var(--text-dark); margin-bottom: 10px; font-weight: 700;">
                        {{ $materi['judul'] }}
                    </h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px;">
                        {{ $materi['deskripsi'] }}
                    </p>
                </div>

                <div class="flex-between" style="padding-top: 15px; border-top: 1px solid var(--border); margin-top: auto;">

                    <!-- Sesuaikan 'siswa.baca-materi' dengan nama route di web.php -->
                    <a href="{{ route('siswa.baca-materi', $materi['id']) }}" class="btn" style="padding: 8px 16px; font-size: 13px;">
                        Buka Materi &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection