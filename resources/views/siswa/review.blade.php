@extends('layouts.siswa')

@section('title', 'EDUSAFE - Pilih Pembahasan Kuis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/nilai.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="nilai-page-wrapper">
    <div class="nilai-container" style="max-width: 900px;">
        
        <!-- Tombol Kembali ke Ringkasan Nilai -->
        <div style="margin-bottom: 16px;">
            <a href="{{ route('siswa.nilai') }}" style="color: #00288A; font-weight: 700; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                ← Kembali ke Ringkasan Nilai
            </a>
        </div>

        @if (session('warning'))
            <div style="background: #FEF3C7; border: 1px solid #FCD34D; color: #92400E; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <span>⚠️</span>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Header Judul -->
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 22px; color: #0F172A; font-weight: 800; margin-bottom: 6px;">Review Pembahasan Kuis</h2>
            <p style="color: #64748B; font-size: 14px; margin: 0;">Pilih modul materi di bawah ini untuk melihat detail soal, jawaban, dan pembahasan dari instruktur.</p>
        </div>

        <!-- Grid Container Card Materi -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            
            @forelse($reviewModulList ?? [] as $item)
                <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <div>
                        <span style="background: {{ $item->badge_bg }}; color: {{ $item->badge_color }}; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            Modul {{ $item->nomor_modul }}
                        </span>
                        <h3 style="font-size: 16px; color: #0F172A; font-weight: 700; margin: 12px 0 8px 0; line-height: 1.4;">
                            {{ $item->judul }}
                        </h3>
                        <p style="color: #64748B; font-size: 12px; margin: 0 0 16px 0;">
                            @if($item->tanggal_selesai)
                                Selesai dikerjakan pada {{ $item->tanggal_selesai }}
                            @else
                                Belum dikerjakan
                            @endif
                        </p>
                    </div>
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-top: 12px; border-top: 1px solid #F1F5F9;">
                            <span style="font-size: 12px; color: #64748B; font-weight: 600;">Skor Anda:</span>
                            @if($item->skor !== null)
                                <span style="font-size: 15px; font-weight: 800; color: {{ $item->skor >= 70 ? '#10B981' : '#EF4444' }};">
                                    {{ $item->skor }} / 100
                                </span>
                            @else
                                <span style="font-size: 14px; font-weight: 700; color: #94A3B8;">- / 100</span>
                            @endif
                        </div>
                        <a href="{{ route('siswa.review.detail', $item->id) }}" style="display: block; text-align: center; background: #00288A; color: #FFFFFF; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; transition: background 0.2s;">
                            Lihat Pembahasan →
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 48px 24px; text-align: center; color: #64748B;">
                    <div style="font-size: 36px; margin-bottom: 12px;">📝</div>
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; color: #0F172A; font-weight: 700;">Belum Ada Kuis yang Selesai Dikerjakan</h3>
                    <p style="margin: 0 0 20px 0; font-size: 13px; color: #64748B;">Modul akan otomatis muncul di halaman review jawaban setelah Anda menyelesaikan kuisnya.</p>
                    <a href="{{ route('siswa.materi') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #00288A; color: #FFFFFF; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none;">
                        Menuju Halaman Materi & Kuis →
                    </a>
                </div>
            @endforelse

        </div>

    </div>
</div>
@endsection