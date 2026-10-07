<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Evaluasi Performa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/materi') }}">Main menu</a>
            <a href="{{ url('/nilai') }}">Nilai</a>
            <a href="{{ url('/evaluasi-siswa') }}" class="active">Evaluasi</a>
            <a href="{{ url('/rekap') }}">Rekap</a>
        </div>
    </nav>

    <div class="container">
        <h1 style="color: var(--primary); margin-bottom: 10px;">Hasil Evaluasi Performa Anda</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Berikut adalah penilaian dan umpan balik dari instruktur mengenai perkembangan akademik Anda.</p>
        
        <div class="card" style="margin-bottom: 20px; display: flex; align-items: center; gap: 20px;">
            <div style="background: #EBF3FF; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">👤</div>
            <div style="flex: 1;">
                <h3 style="margin-bottom: 5px;">Rizky Pratama (Anda) <span class="badge" style="background: var(--primary); color: white;">ACTIVE SCHOLAR</span></h3>
                <p style="font-size: 13px; color: var(--text-muted);">ID: <strong>EDU-2024-089</strong> | Modul Terakhir: Malware Analysis Fundamentals</p>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 24px; font-weight: bold; color: var(--primary);">88%</span><br><span style="font-size: 12px; color: var(--text-muted);">RERATA KUIS</span>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="card" style="background: #F8FAFC;">
                <h3 style="margin-bottom: 20px; color: var(--primary);">Metrik Kompetensi</h3>
                
                <div style="margin-bottom: 15px;">
                    <div class="flex-between" style="font-size: 13px; margin-bottom: 5px;"><span>Pemahaman Teknis</span><strong>8/10</strong></div>
                    <div style="background: #E2E8F0; height: 8px; border-radius: 4px;"><div style="background: var(--primary); width: 80%; height: 100%; border-radius: 4px;"></div></div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div class="flex-between" style="font-size: 13px; margin-bottom: 5px;"><span>Ketepatan Analisis</span><strong>9/10</strong></div>
                    <div style="background: #E2E8F0; height: 8px; border-radius: 4px;"><div style="background: var(--primary); width: 90%; height: 100%; border-radius: 4px;"></div></div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div class="flex-between" style="font-size: 13px; margin-bottom: 5px;"><span>Kualitas Laporan</span><strong>10/10</strong></div>
                    <div style="background: #E2E8F0; height: 8px; border-radius: 4px;"><div style="background: var(--primary); width: 100%; height: 100%; border-radius: 4px;"></div></div>
                </div>
            </div>
            
            <div class="card" style="background: #F0FDF4; border: 1px solid #BBF7D0;">
                <h3 style="margin-bottom: 15px; color: #166534;">💬 Catatan & Rekomendasi Instruktur</h3>
                <p style="font-size: 14px; line-height: 1.6; color: #14532D; margin-bottom: 20px;">
                    <em>"Pemahaman dasar mengenai Ransomware sangat baik. Secara keseluruhan, dokumentasi jawaban kuis sangat rapi dan mudah dipahami. Tetap pertahankan kualitas belajarnya!"</em>
                </p>
                <div style="background: white; padding: 10px; border-radius: 6px; font-size: 13px; border: 1px solid #BBF7D0; color: #166534;">
                    <strong>✔️ Rekomendasi Khusus:</strong> Siap untuk sertifikasi tingkat lanjut.
                </div>
            </div>
        </div>
    </div>
</body>
</html>