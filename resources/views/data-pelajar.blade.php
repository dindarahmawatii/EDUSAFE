<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Data Pelajar</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <a href="{{ url('/admin') }}">Dashboard</a>
            <a href="{{ url('/data-pelajar') }}" class="active">Data Pelajar</a>
            <a href="{{ url('/evaluasi') }}">Evaluasi</a>
            <a href="{{ url('/laporan') }}">Laporan</a>
        </div>
        <div class="nav-links">
            <span style="font-size: 13px; font-weight: bold; margin-right: 15px;">
                Admin Mode <span class="badge" style="background: var(--primary); color: white; border-radius: 50%; padding: 6px 8px;">AW</span>
            </span>
            <a href="{{ url('/login-admin') }}" style="color: #EF4444;">Keluar</a>
        </div>
    </nav>

    <div class="container">
        <div class="flex-between" style="margin-bottom: 25px;">
            <div>
                <h1 style="color: var(--primary); margin-bottom: 5px;">Manajemen Data Pelajar</h1>
                <p style="color: var(--text-muted);">Kelola informasi akun, progres modul, dan status keaktifan siswa EDUSAFE.</p>
            </div>
            <button class="btn">+ Tambah Pelajar Baru</button>
        </div>

        <!-- Tabel Ringkasan Pelajar -->
        <div class="card">
            <div class="flex-between" style="margin-bottom: 20px; gap: 15px;">
                <input type="text" placeholder="🔍 Cari nama atau NISN/Email..." style="padding: 10px 15px; border: 1px solid var(--border); border-radius: 6px; width: 300px;">
                <div>
                    <select style="padding: 10px; border: 1px solid var(--border); border-radius: 6px; color: var(--text-muted);">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border); color: var(--text-muted); text-align: left;">
                            <th style="padding: 15px;">Pelajar</th>
                            <th style="padding: 15px;">ID / Email</th>
                            <th style="padding: 15px;">Modul Selesai</th>
                            <th style="padding: 15px;">Rerata Nilai</th>
                            <th style="padding: 15px;">Status</th>
                            <th style="padding: 15px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 15px; display: flex; align-items: center; gap: 10px;">
                                <div style="background: #EBF3FF; color: var(--primary); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">RP</div>
                                <strong>Rizky Pratama</strong>
                            </td>
                            <td style="padding: 15px; color: var(--text-muted);">EDU-2024-089<br><small>rizky@gmail.com</small></td>
                            <td style="padding: 15px;">12 / 15 Modul</td>
                            <td style="padding: 15px; font-weight: bold; color: var(--primary);">88%</td>
                            <td style="padding: 15px;"><span class="badge" style="background: #D1FAE5; color: #065F46;">Aktif</span></td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ url('/evaluasi') }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 12px;">Evaluasi</a>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 15px; display: flex; align-items: center; gap: 10px;">
                                <div style="background: #EBF3FF; color: var(--primary); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">JD</div>
                                <strong>Jane Doe</strong>
                            </td>
                            <td style="padding: 15px; color: var(--text-muted);">EDU-2024-090<br><small>jane.doe@gmail.com</small></td>
                            <td style="padding: 15px;">5 / 15 Modul</td>
                            <td style="padding: 15px; font-weight: bold; color: var(--primary);">75%</td>
                            <td style="padding: 15px;"><span class="badge" style="background: #D1FAE5; color: #065F46;">Aktif</span></td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ url('/evaluasi') }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 12px;">Evaluasi</a>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 15px; display: flex; align-items: center; gap: 10px;">
                                <div style="background: #EBF3FF; color: var(--primary); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">AS</div>
                                <strong>Andi Saputra</strong>
                            </td>
                            <td style="padding: 15px; color: var(--text-muted);">EDU-2024-091<br><small>andi@gmail.com</small></td>
                            <td style="padding: 15px;">8 / 15 Modul</td>
                            <td style="padding: 15px; font-weight: bold; color: var(--primary);">82%</td>
                            <td style="padding: 15px;"><span class="badge" style="background: #FEF3C7; color: #92400E;">Inaktif 3 Hari</span></td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ url('/evaluasi') }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 12px;">Evaluasi</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>