@extends('layouts.app')

@section('title', 'EDUSAFE - Nilai & Pencapaian')

@section('content')
@php
    $materiVal = $materiSelesai ?? 12;
    $persenMateri = ($materiVal / 15) * 100;
    $rataNilaiVal = $rataRataNilai ?? 88.5;
@endphp

<div class="container" style="padding: 30px 0;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: var(--text-dark); margin-bottom: 5px;">Ringkasan Nilai & Pencapaian</h1>
        <p style="color: var(--text-muted);">Pantau kemajuan belajar Anda dan akses hasil evaluasi kuis.</p>
    </div>
    
    <div class="grid grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Card Kuis Terakhir -->
        <div class="card" style="background: #EBF3FF; border: none; padding: 25px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div class="badge" style="background: #C6DBFF; color: var(--primary); padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; margin-bottom: 10px;">Quiz Terakhir</div>
                <h3 style="margin-bottom: 5px; color: var(--primary);">
                    {{ isset($kuisTerakhir) && $kuisTerakhir ? $kuisTerakhir->nama_modul : 'Malware Analysis Fundamentals' }}
                </h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                    Diselesaikan dengan baik
                </p>
                <a href="{{ route('siswa.rekap') }}" class="btn" style="background: var(--primary); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 13px;">Review Jawaban</a>
            </div>
            
            <!-- Lingkaran Skor -->
            <div style="width: 100px; height: 100px; border-radius: 50%; border: 8px solid var(--primary); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; color: var(--primary); background: white;">
                {{ isset($kuisTerakhir) && $kuisTerakhir ? $kuisTerakhir->skor : 90 }}
            </div>
        </div>

        <!-- Card Kemajuan Kursus -->
        <div class="card" style="background: #EBF3FF; border: none; padding: 25px; border-radius: 12px;">
            <h3 style="margin-bottom: 15px; color: var(--text-dark);">Kemajuan Kursus</h3>
            
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                <span>Materi Selesai</span>
                <span style="font-weight: bold;">{{ $materiVal }}/15</span>
            </div>
            <div style="background: #C6DBFF; height: 8px; border-radius: 4px; margin-bottom: 15px; overflow: hidden;">
                <div style="background: var(--primary); width: {{ $persenMateri }}%; height: 100%; border-radius: 4px;"></div>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 5px;">
                <span>Rata-rata Nilai</span>
                <span style="font-weight: bold;">{{ number_format($rataNilaiVal, 1) }}</span>
            </div>
            <div style="background: #C6DBFF; height: 8px; border-radius: 4px; overflow: hidden;">
                <div style="background: var(--primary); width: {{ $rataNilaiVal }}%; height: 100%; border-radius: 4px;"></div>
            </div>
        </div>

    </div>
</div>
@endsection