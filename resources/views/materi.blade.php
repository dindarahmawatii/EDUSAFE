<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Materi Pembelajaran</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/materi') }}" class="active">Main menu</a>
            <a href="{{ url('/nilai') }}">Nilai</a>
            <a href="{{ url('/evaluasi-siswa') }}">Evaluasi</a>
            <a href="{{ url('/rekap') }}">Rekap</a>
        </div>
    </nav>

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
            <div class="card" style="background: #EBF3FF; border: none;">
                <div class="badge" style="background: white; color: var(--primary); margin-bottom: 15px;">Modul 01</div>
                <h3 style="margin-bottom: 10px;">Pengenalan Malware</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">Memahami dasar-dasar perangkat lunak berbahaya, sejarah perkembangannya, dan ancaman digital.</p>
                <div class="flex-between">
                    <span style="font-size: 12px; color: var(--text-muted);">🕒 15 Menit</span>
                    <a href="{{ url('/baca-materi') }}" class="btn">Buka Materi &rarr;</a>
                </div>
            </div>
            
            <div class="card" style="background: var(--primary); color: white;">
                <div class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 15px;">Modul 02</div>
                <h3 style="margin-bottom: 10px;">Jenis-jenis Malware</h3>
                <p style="font-size: 13px; color: #D1E0FF; margin-bottom: 20px;">Identifikasi perbedaan antara Virus, Worm, Trojan, Ransomware, dan Spyware.</p>
                <div class="flex-between">
                    <span style="font-size: 12px; color: #D1E0FF;">🕒 25 Menit</span>
                    <a href="{{ url('/baca-materi') }}" class="btn" style="background: white; color: var(--primary);">Buka Materi &rarr;</a>
                </div>
            </div>

            <div class="card" style="background: #1E293B; color: white;">
                <div class="badge" style="background: rgba(255,255,255,0.2); color: white; margin-bottom: 15px;">Modul 03</div>
                <h3 style="margin-bottom: 10px;">Mekanisme Infeksi</h3>
                <p style="font-size: 13px; color: #94A3B8; margin-bottom: 20px;">Mempelajari jalur distribusi malware melalui email phishing dan kerentanan operasi.</p>
                <div class="flex-between">
                    <span style="font-size: 12px; color: #94A3B8;">🕒 20 Menit</span>
                    <a href="{{ url('/baca-materi') }}" class="btn">Buka Materi &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>