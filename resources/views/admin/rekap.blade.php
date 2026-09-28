@extends('layouts.admin')

@section('title', 'EDUSAFE - Rekap Pembelajaran')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 30px;">Rekap Pembelajaran</h1>
    
    <div class="grid grid-3" style="gap: 20px; margin-bottom: 30px;">
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">TOTAL MODUL SELESAI</p>
            <h2 style="font-size: 36px; color: var(--primary);">24</h2>
        </div>
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">WAKTU BELAJAR</p>
            <h2 style="font-size: 36px; color: var(--primary);">42j 15m</h2>
        </div>
        <div class="card" style="background: #EBF3FF;">
            <p style="font-size: 12px; font-weight: bold; color: var(--text-muted);">TARGET MINGGUAN</p>
            <div style="background: #C6DBFF; height: 10px; border-radius: 5px; margin: 10px 0;">
                <div style="background: var(--primary); width: 75%; height: 100%; border-radius: 5px;"></div>
            </div>
            <div class="flex-between" style="font-size: 13px;">
                <span>6 dari 8 Modul</span>
                <span style="font-weight:bold; color:var(--primary);">75%</span>
            </div>
        </div>
    </div>
</div>
@endsection