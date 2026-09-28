@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

@section('content')
<div class="container">
    <div class="flex-between" style="margin-bottom: 30px;">
        <div>
            <h1 style="color: var(--primary); margin-bottom: 10px;">Materi Pembelajaran Malware</h1>
            <p style="color: var(--text-muted); max-width: 600px;">Pelajari berbagai ancaman siber dan cara melindunginya melalui kurikulum terstruktur.</p>
        </div>
        <div class="card" style="padding: 10px 20px; background: #EBF3FF;">
            <span style="font-size: 12px; font-weight: bold; color: var(--primary);">Progres Belajar</span>
            <div style="font-size: 18px; font-weight: bold;">65% Selesai</div>
        </div>
    </div>
    
    <div class="grid grid-3">
        @foreach($materiList as $materi)
            @if($materi['id'] == 1)
                {{-- Modul 01 --}}
                <div class="card" style="background: #EBF3FF; border: none;">
                    <div class="badge" style="background: white; color: var(--primary); margin-bottom: 15px;">{{ $materi['modul'] }}</div>
                    <h3 style="margin-bottom: 10px;">{{ $materi['judul'] }}</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">{{ $materi['deskripsi'] }}</p>
                    <div class="flex-between">
                        <span style="font-size: 12px; color: var(--text-muted);">🕒 {{ $materi['durasi'] }}</span>
                        <a href="{{ route('siswa.baca-materi', $materi['id']) }}" class="btn">Buka Materi &rarr;</a>
                    </div>
                </div>
            @elseif($materi['id'] == 2)
                {{-- Modul 02 --}}
                <div class="card" style="background: var(--primary); color: white;">
                    <div class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 15px;">{{ $materi['modul'] }}</div>
                    <h3 style="margin-bottom: 10px;">{{ $materi['judul'] }}</h3>
                    <p style="font-size: 13px; color: #D1E0FF; margin-bottom: 20px;">{{ $materi['deskripsi'] }}</p>
                    <div class="flex-between">
                        <span style="font-size: 12px; color: #D1E0FF;">🕒 {{ $materi['durasi'] }}</span>
                        <a href="{{ route('siswa.baca-materi', $materi['id']) }}" class="btn" style="background: white; color: var(--primary);">Buka Materi &rarr;</a>
                    </div>
                </div>
            @else
                {{-- Modul 03 --}}
                <div class="card" style="background: #1E293B; color: white;">
                    <div class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 15px;">{{ $materi['modul'] }}</div>
                    <h3 style="margin-bottom: 10px;">{{ $materi['judul'] }}</h3>
                    <p style="font-size: 13px; color: #94A3B8; margin-bottom: 20px;">{{ $materi['deskripsi'] }}</p>
                    <div class="flex-between">
                        <span style="font-size: 12px; color: #94A3B8;">🕒 {{ $materi['durasi'] }}</span>
                        <a href="{{ route('siswa.baca-materi', $materi['id']) }}" class="btn">Buka Materi &rarr;</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection