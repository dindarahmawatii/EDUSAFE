<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Kelola Evaluasi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/admin') }}">Dashboard</a>
            <a href="{{ url('/evaluasi') }}" class="active">Evaluasi Performa</a>
        </div>
    </nav>

    <div class="container">
        <h1 style="color: var(--primary); margin-bottom: 10px;">Evaluasi Performa Pengguna</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;">Berikan penilaian dan umpan balik profesional untuk perkembangan akademik pengguna.</p>
        
        <div class="card" style="margin-bottom: 20px; display: flex; align-items: center; gap: 20px;">
            <div style="background: #EBF3FF; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">👤</div>
            <div style="flex: 1;">
                <h3 style="margin-bottom: 5px;">Rizky Pratama <span class="badge" style="background: var(--primary); color: white;">ACTIVE SCHOLAR</span></h3>
                <p style="font-size: 13px; color: var(--text-muted);">ID: <strong>EDU-2024-089</strong> | Modul: Malware Analysis Fundamentals</p>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 24px; font-weight: bold; color: var(--primary);">88%</span><br><span style="font-size: 12px; color: var(--text-muted);">RERATA KUIS</span>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="card" style="background: #F8FAFC;">
                <h3 style="margin-bottom: 15px;">📝 Catatan Instruktur & Rekomendasi</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 10px;">Berikan detail mendalam mengenai kelebihan dan area yang perlu difokuskan.</p>
                <textarea rows="6" style="width: 100%; padding: 15px; border: 1px solid var(--border); border-radius: 8px;" placeholder="Tuliskan evaluasi profesional Anda..."></textarea>
            </div>
            
            <div style="display: flex; flex-direction: column; justify-content: flex-end;">
                <div class="flex-between" style="gap: 15px;">
                    <a href="{{ url('/admin') }}" class="btn btn-outline" style="flex: 1; text-align: center;">Draf Evaluasi</a>
                    <a href="{{ url('/admin') }}" class="btn" style="flex: 1; text-align: center;">Simpan & Kirim Evaluasi</a>
                </div>
                <p style="font-size: 12px; text-align: center; color: var(--text-muted); margin-top: 15px;">Hasil evaluasi ini akan segera terlihat pada dasbor profil pengguna setelah dikirimkan secara resmi.</p>
            </div>
        </div>
    </div>
</body>
</html>