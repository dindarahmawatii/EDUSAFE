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

        <!-- Header Judul -->
        <div style="margin-bottom: 24px;">
            <h2 style="font-size: 22px; color: #0F172A; font-weight: 800; margin-bottom: 6px;">Review Pembahasan Kuis</h2>
            <p style="color: #64748B; font-size: 14px; margin: 0;">Pilih modul materi di bawah ini untuk melihat detail soal, jawaban, dan pembahasan dari instruktur.</p>
        </div>

        <!-- Grid Container Card Materi -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            
            <!-- CARD 1: Malware Analysis Fundamentals (ID: 1) -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div>
                    <span style="background: #DDF0FF; color: #00288A; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Modul 01</span>
                    <h3 style="font-size: 16px; color: #0F172A; font-weight: 700; margin: 12px 0 8px 0; line-height: 1.4;">Malware Analysis Fundamentals</h3>
                    <p style="color: #64748B; font-size: 12px; margin: 0 0 16px 0;">Selesai dikerjakan pada 24 Okt 2026</p>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-top: 12px; border-top: 1px solid #F1F5F9;">
                        <span style="font-size: 12px; color: #64748B; font-weight: 600;">Skor Anda:</span>
                        <span style="font-size: 15px; font-weight: 800; color: #10B981;">90 / 100</span>
                    </div>
                    <a href="{{ route('siswa.review.detail', 1) }}" style="display: block; text-align: center; background: #00288A; color: #FFFFFF; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; transition: background 0.2s;">
                        Lihat Pembahasan →
                    </a>
                </div>
            </div>

            <!-- CARD 2: Phishing & Social Engineering (ID: 2) -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <div>
                    <span style="background: #FEF3C7; color: #D97706; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Modul 02</span>
                    <h3 style="font-size: 16px; color: #0F172A; font-weight: 700; margin: 12px 0 8px 0; line-height: 1.4;">Phishing & Social Engineering</h3>
                    <p style="color: #64748B; font-size: 12px; margin: 0 0 16px 0;">Selesai dikerjakan pada 26 Okt 2026</p>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-top: 12px; border-top: 1px solid #F1F5F9;">
                        <span style="font-size: 12px; color: #64748B; font-weight: 600;">Skor Anda:</span>
                        <span style="font-size: 15px; font-weight: 800; color: #10B981;">80 / 100</span>
                    </div>
                    <a href="{{ route('siswa.review.detail', 2) }}" style="display: block; text-align: center; background: #00288A; color: #FFFFFF; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; transition: background 0.2s;">
                        Lihat Pembahasan →
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection