<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Baca Materi</title>
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
        <div class="card" style="max-width: 800px; margin: 0 auto; padding: 40px;">
            <div class="badge" style="background: var(--primary); color: white; margin-bottom: 15px;">Modul 01</div>
            <h1 style="color: var(--primary); margin-bottom: 10px;">Pengenalan Malware Analysis</h1>
            <p style="color: var(--text-muted); font-size: 14px; border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 20px;">
                Estimasi waktu baca: 15 Menit | Kategori: Cybersecurity
            </p>

            <div style="line-height: 1.8; color: var(--text-dark); margin-bottom: 40px;">
                <h3>Apa itu Malware?</h3>
                <p style="margin-bottom: 15px;">
                    Malware (Malicious Software) adalah suatu perangkat lunak yang dirancang khusus dengan tujuan untuk merusak, menyusup, atau meretas sistem komputer, server, atau jaringan tanpa persetujuan dari pemiliknya. Dalam era digital saat ini, malware menjadi salah satu ancaman siber paling utama.
                </p>

                <h3>Mengapa Malware Berbahaya?</h3>
                <p style="margin-bottom: 15px;">
                    Malware dapat mencuri data sensitif pengguna (seperti kata sandi dan informasi perbankan), mengenkripsi file penting untuk meminta tebusan finansial (seperti Ransomware), atau secara diam-diam menggunakan sumber daya perangkat Anda untuk menyerang jaringan lain secara massal.
                </p>
            </div>

            <div class="flex-between" style="background: #EBF3FF; padding: 25px; border-radius: 12px; border: 1px solid #C6DBFF;">
                <div>
                    <h3 style="margin-bottom: 5px; color: var(--primary);">Sudah paham materinya?</h3>
                    <p style="font-size: 13px; color: var(--text-muted);">Uji pemahaman Anda dengan mengerjakan kuis evaluasi untuk modul ini.</p>
                </div>
                <a href="{{ url('/kuis') }}" class="btn" style="background: #10B981; font-size: 16px; padding: 12px 24px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);">
                    📝 Kerjakan Kuis
                </a>
            </div>

            <div style="margin-top: 30px;">
                <a href="{{ url('/materi') }}" style="color: var(--text-muted); font-size: 14px; text-decoration: underline;">&larr; Kembali ke Daftar Materi</a>
            </div>
        </div>
    </div>
</body>
</html>