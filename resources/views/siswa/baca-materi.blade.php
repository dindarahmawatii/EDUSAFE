@extends('layouts.siswa')

@section('title', 'EDUSAFE - Baca ' . ($materi->judul ?? $materi['judul'] ?? 'Materi'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/siswa/materi.css') }}?v={{ time() }}">
@endpush

@section('content')
<div class="materi-page-wrapper" style="padding: 40px 20px 80px;">
    <div class="materi-container" style="max-width: 900px; margin: 0 auto;">
        
        <!-- Tombol Kembali -->
        <div style="margin-bottom: 20px;">
            <a href="{{ route('siswa.materi') }}" style="color: var(--primary, #00288A); font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                &larr; Kembali ke Daftar Materi
            </a>
        </div>

        <div class="card" style="background: #FFFFFF; border: 1px solid #D9DEE8; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            
            <!-- Badge Kategori -->
            <div style="margin-bottom: 15px;">
                <span class="badge-modul" style="background: #DBEAFE; color: #1E40AF; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 800; text-transform: uppercase;">
                    {{ $materi->kategori ?? $materi['kategori'] ?? 'Modul Pembelajaran' }}
                </span>
            </div>
            
            <!-- Judul Materi -->
            <h1 style="color: #0F172A; margin-bottom: 16px; font-size: 28px; font-weight: 800; line-height: 1.3;">
                {{ $materi->judul ?? $materi['judul'] ?? 'Judul Materi' }}
            </h1>
            
            <!-- Meta Info -->
            <p style="color: #64748B; font-size: 13px; border-bottom: 1px solid #E2E8F0; padding-bottom: 16px; margin-bottom: 28px; display: flex; align-items: center; gap: 10px;">
                <span>Kategori: <strong>{{ $materi->kategori ?? $materi['kategori'] ?? '-' }}</strong></span>
                <span>&bull;</span>
                <span>Status: <span style="color: #10B981; font-weight: 800;">Tersedia & Aktif</span></span>
            </p>

            <!-- Ringkasan Singkat -->
            @if(!empty($materi->deskripsi ?? $materi['deskripsi'] ?? null))
                <div style="background: #F0F6FF; border: 1px solid #BFDBFE; padding: 20px 24px; border-left: 5px solid #2563EB; border-radius: 8px; margin-bottom: 28px;">
                    <h4 style="margin: 0 0 8px 0; color: #1E3A8A; font-size: 15px; font-weight: 800;">Ringkasan Modul:</h4>
                    <p style="margin: 0; color: #334155; font-size: 14px; line-height: 1.6;">{{ $materi->deskripsi ?? $materi['deskripsi'] }}</p>
                </div>
            @endif

            <!-- KOTAK UTAMA ISI MATERI (Input dari Admin) -->
            <div style="margin-bottom: 40px;">
                <h3 style="font-size: 16px; font-weight: 800; color: #0F172A; margin-bottom: 14px;">Isi Materi Pembelajaran</h3>
                
                <div style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 12px; padding: 30px; color: #1E293B; font-size: 15px; line-height: 1.8;">
                    @php
                        $isiKonten = $materi->konten ?? $materi->isi_teks ?? $materi['konten'] ?? $materi['isi_teks'] ?? null;
                    @endphp

                    @if(!empty($isiKonten))
                        <div class="materi-body-content">
                            {!! nl2br(e($isiKonten)) !!}
                        </div>
                    @else
                        <p style="color: #64748B; font-style: italic; margin: 0;">Konten materi lengkap belum diinput oleh admin.</p>
                    @endif
                </div>
            </div>

            <!-- Banner Ajak Mengerjakan Kuis -->
            <div style="background: #DDF0FF; padding: 24px 28px; border-radius: 12px; border: 1px solid #BFDBFE; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h3 style="margin: 0 0 4px 0; color: #0F172A; font-size: 18px; font-weight: 800;">Sudah paham materinya?</h3>
                    <p style="font-size: 13px; color: #475569; margin: 0;">Uji pemahaman Anda dengan mengerjakan kuis evaluasi untuk modul ini.</p>
                </div>
                <a href="{{ route('siswa.kuis', $materi->id ?? $materi['id'] ?? 1) }}" class="btn" style="background: #00288A; color: #FFFFFF; font-size: 13px; font-weight: 800; padding: 12px 24px; border-radius: 8px; text-decoration: none; transition: background 0.2s ease;">
                    Kerjakan Kuis &rarr;
                </a>
            </div>

        </div>

    </div>
</div>
@endsection