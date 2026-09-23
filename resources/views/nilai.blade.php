<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Nilai</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/materi') }}">Main menu</a>
            <a href="{{ url('/nilai') }}" class="active">Nilai</a>
            <a href="{{ url('/evaluasi-siswa') }}">Evaluasi</a>
            <a href="{{ url('/rekap') }}">Rekap</a>
        </div>
    </nav>

    <div class="container">
        <h1 style="color: var(--text-dark); margin-bottom: 5px;">Ringkasan Nilai & Pencapaian</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Pantau kemajuan belajar Anda dan akses sertifikat resmi.</p>
        
        <div class="grid grid-2" style="margin-bottom: 30px;">
            <div class="card flex-between" style="background: #EBF3FF; border: none;">
                <div>
                    <div class="badge" style="background: #C6DBFF; color: var(--primary); margin-bottom: 10px;">Quiz Terakhir</div>
                    <h3 style="margin-bottom: 5px; color: var(--primary);">Malware Analysis Fundamentals</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">Diselesaikan pada 24 Okt 2024</p>
                    <a href="{{ url('/rekap') }}" class="btn">Review Jawaban</a>
                </div>
                <div style="width: 100px; height: 100px; border-radius: 50%; border: 8px solid var(--primary); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; color: var(--primary);">90</div>
            </div>
            <div class="card" style="background: #EBF3FF; border: none;">
                <h3 style="margin-bottom: 15px;">Kemajuan Kursus</h3>
                <div class="flex-between" style="font-size: 13px; margin-bottom: 5px;"><span>Materi Selesai</span><span>12/15</span></div>
                <div style="background: #C6DBFF; height: 8px; border-radius: 4px; margin-bottom: 15px;"><div style="background: var(--primary); width: 80%; height: 100%; border-radius: 4px;"></div></div>
                <div class="flex-between" style="font-size: 13px; margin-bottom: 5px;"><span>Rata-rata Nilai</span><span>88.5</span></div>
                <div style="background: #C6DBFF; height: 8px; border-radius: 4px;"><div style="background: var(--primary); width: 88%; height: 100%; border-radius: 4px;"></div></div>
            </div>
        </div>
    </div>
</body>
</html>