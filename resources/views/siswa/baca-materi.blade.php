@extends('layouts.app')

@section('title', 'EDUSAFE - Baca Materi')

@section('content')
<div class="container">
    <div class="card" style="max-width: 900px; margin: 0 auto; padding: 40px;">
        <div class="badge" style="background: var(--primary); color: white; margin-bottom: 15px;">
            {{ $materi['modul'] ?? 'Modul' }}
        </div>
        
        <h1 style="color: var(--primary); margin-bottom: 10px;">
            {{ $materi['judul'] ?? 'Judul Materi' }}
        </h1>
        
        <p style="color: var(--text-muted); font-size: 14px; border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 25px;">
            Estimasi waktu baca: {{ $materi['estimasi'] ?? '-' }} | Kategori: {{ $materi['kategori'] ?? '-' }}
        </p>

        <!-- Tampilan Konten Teks -->
        <div style="line-height: 1.8; color: var(--text-dark); margin-bottom: 30px;">
            @if(isset($materi['isi']) && is_array($materi['isi']))
                @foreach($materi['isi'] as $bagian)
                    <h3 style="margin-top: 20px; color: var(--text-dark);">{{ $bagian['subjudul'] ?? '' }}</h3>
                    <p style="margin-bottom: 15px;">{{ $bagian['konten'] ?? '' }}</p>
                @endforeach
            @elseif(isset($materi['isi_teks']))
                <p style="margin-bottom: 15px;">{{ $materi['isi_teks'] }}</p>
            @else
                <p style="color: var(--text-muted); font-style: italic;">Ringkasan materi belum tersedia.</p>
            @endif
        </div>

        <!-- Placeholder PDF Reader untuk Admin / Backend -->
        <div style="margin-bottom: 40px; background: #F8FAFC; border: 1px solid var(--border); border-radius: 8px; padding: 20px;">
            <div class="flex-between" style="margin-bottom: 15px;">
                <h4 style="margin: 0; color: var(--primary);">📄 Dokumen Modul Pembelajaran (PDF)</h4>
                @if(!empty($materi['file_pdf']))
                    <a href="{{ asset('uploads/pdf/' . $materi['file_pdf']) }}" target="_blank" class="btn-outline" style="font-size: 12px; padding: 6px 12px;">
                        Download PDF
                    </a>
                @endif
            </div>

            @if(!empty($materi['file_pdf']) && file_exists(public_path('uploads/pdf/' . $materi['file_pdf'])))
                <iframe 
                    src="{{ asset('uploads/pdf/' . $materi['file_pdf']) }}#toolbar=0" 
                    width="100%" 
                    height="600px" 
                    style="border: 1px solid var(--border); border-radius: 6px;">
                </iframe>
            @else
                <div style="text-align: center; padding: 40px; border: 2px dashed #CBD5E1; border-radius: 6px; background: #FFFFFF;">
                    <p style="color: var(--text-muted); margin: 0; font-size: 14px;">
                        📌 Dokumen PDF belum diunggah oleh Admin untuk modul ini.
                    </p>
                </div>
            @endif
        </div>

        <!-- Banner Ajak Mengerjakan Kuis -->
        <div class="flex-between" style="background: #EBF3FF; padding: 25px; border-radius: 12px; border: 1px solid #C6DBFF; flex-wrap: wrap; gap: 15px;">
            <div>
                <h3 style="margin-bottom: 5px; color: var(--primary);">Sudah paham materinya?</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Uji pemahaman Anda dengan mengerjakan kuis evaluasi untuk modul ini.</p>
            </div>
            <a href="{{ route('siswa.kuis', $materi['id'] ?? 1) }}" class="btn" style="background: #10B981; font-size: 15px; padding: 12px 24px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
                Kerjakan Kuis
            </a>
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('siswa.materi') }}" style="color: var(--text-muted); font-size: 14px; text-decoration: underline;">&larr; Kembali ke Daftar Materi</a>
        </div>
    </div>
</div>
@endsection