@extends('layouts.siswa')

@section('title', 'EDUSAFE - Baca ' . ($materi->judul ?? $materi['judul'] ?? 'Materi'))

@section('content')
<div class="container">
    <div class="card" style="max-width: 900px; margin: 0 auto; padding: 40px;">
        
        <!-- Top Breadcrumb & Badge -->
        <div class="flex-between" style="margin-bottom: 15px; align-items: center;">
            <div class="badge" style="background: var(--primary); color: white;">
                {{ $materi->kategori ?? $materi['kategori'] ?? 'Modul Pembelajaran' }}
            </div>
        </div>
        
        <!-- Judul Utama Materi -->
        <h1 style="color: var(--primary); margin-bottom: 15px; font-size: 28px; line-height: 1.3;">
            {{ $materi->judul ?? $materi['judul'] ?? 'Judul Materi' }}
        </h1>
        
        <!-- Meta Info (Durasi/Estimasi Waktu Dihapus) -->
        <p style="color: var(--text-muted); font-size: 13px; border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 25px;">
            Kategori: <strong>{{ $materi->kategori ?? $materi['kategori'] ?? '-' }}</strong> | 
            Status: <span style="color: #10B981; font-weight: bold;">Tersedia</span>
        </p>

        <!-- Tampilan Deskripsi / Ringkasan Materi -->
        <div style="line-height: 1.8; color: var(--text-dark); margin-bottom: 30px; font-size: 15px;">
            @if(!empty($materi->deskripsi ?? $materi['deskripsi'] ?? null))
                <div style="background: #FAFAFA; padding: 20px; border-left: 4px solid var(--primary); border-radius: 4px; margin-bottom: 20px;">
                    <h4 style="margin-top: 0; margin-bottom: 8px; color: var(--primary);">Ringkasan Modul:</h4>
                    <p style="margin: 0; color: #334155;">{{ $materi->deskripsi ?? $materi['deskripsi'] }}</p>
                </div>
            @elseif(isset($materi['isi']) && is_array($materi['isi']))
                @foreach($materi['isi'] as $bagian)
                    <h3 style="margin-top: 20px; color: var(--text-dark);">{{ $bagian['subjudul'] ?? '' }}</h3>
                    <p style="margin-bottom: 15px;">{{ $bagian['konten'] ?? '' }}</p>
                @endforeach
            @elseif(isset($materi['isi_teks']))
                <p style="margin-bottom: 15px;">{{ $materi['isi_teks'] }}</p>
            @else
                <p style="color: var(--text-muted); font-style: italic;">Ringkasan deskripsi materi belum tersedia.</p>
            @endif
        </div>

        <!-- Section PDF Reader & Download -->
        @php
            $filePdf = $materi->file_pdf ?? $materi['file_pdf'] ?? null;
            $pdfExist = $filePdf && file_exists(public_path('uploads/pdf/' . $filePdf));
        @endphp

        <div style="margin-bottom: 40px; background: #F8FAFC; border: 1px solid var(--border); border-radius: 10px; padding: 20px;">
            <div class="flex-between" style="margin-bottom: 15px; align-items: center; flex-wrap: wrap; gap: 10px;">
                <h4 style="margin: 0; color: var(--primary); display: flex; align-items: center; gap: 8px;">
                    <span>📄</span> Dokumen Modul Pembelajaran (PDF)
                </h4>
                
                @if($pdfExist)
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ asset('uploads/pdf/' . $filePdf) }}" target="_blank" class="btn-outline" style="font-size: 12px; padding: 6px 12px;">
                            👁️ Buka Tab Baru
                        </a>
                        <a href="{{ asset('uploads/pdf/' . $filePdf) }}" download class="btn" style="font-size: 12px; padding: 6px 12px;">
                            📥 Unduh PDF
                        </a>
                    </div>
                @endif
            </div>

            @if($pdfExist)
                <div style="position: relative; width: 100%; border-radius: 6px; overflow: hidden; border: 1px solid var(--border);">
                    <iframe 
                        src="{{ asset('uploads/pdf/' . $filePdf) }}#toolbar=0" 
                        width="100%" 
                        height="600px" 
                        style="border: none; display: block;">
                    </iframe>
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px; border: 2px dashed #CBD5E1; border-radius: 8px; background: #FFFFFF;">
                    <span style="font-size: 32px; display: block; margin-bottom: 10px;">📁</span>
                    <h5 style="margin: 0 0 5px 0; color: var(--text-dark); font-size: 15px;">Dokumen PDF Belum Tersedia</h5>
                    <p style="color: var(--text-muted); margin: 0; font-size: 13px;">
                        Admin belum mengunggah berkas PDF untuk modul ini.
                    </p>
                </div>
            @endif
        </div>

        <!-- Banner Ajak Mengerjakan Kuis -->
        <div class="flex-between" style="background: #EBF3FF; padding: 25px; border-radius: 12px; border: 1px solid #C6DBFF; flex-wrap: wrap; gap: 15px; align-items: center;">
            <div>
                <h3 style="margin: 0 0 5px 0; color: var(--primary);">Sudah paham materinya?</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Uji pemahaman Anda dengan mengerjakan kuis evaluasi untuk modul ini.</p>
            </div>
            <a href="{{ route('siswa.kuis', $materi->id ?? $materi['id'] ?? 1) }}" class="btn" style="background: #10B981; font-size: 14px; padding: 12px 24px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); text-decoration: none;">
                Kerjakan Kuis &rarr;
            </a>
        </div>

        <!-- Link Navigasi Bawah -->
        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ route('siswa.materi') }}" style="color: var(--text-muted); font-size: 14px; text-decoration: underline;">
                &larr; Kembali ke Daftar Materi
            </a>
        </div>

    </div>
</div>
@endsection