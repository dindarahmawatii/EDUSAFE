<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Login Siswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { 
            background: linear-gradient(to bottom right, #EBF3FF, #F4F7FE); 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <span style="font-size: 13px; color: var(--text-muted); margin-right: 10px;">Belum punya akun?</span>
            <a href="{{ url('/register') }}" class="btn btn-outline" style="padding: 6px 15px;">Daftar Siswa</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card" style="width: 400px; background: #FFFFFF; border: none; padding: 35px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
            <div class="badge" style="background: #EBF3FF; color: var(--primary); margin-bottom: 15px; display: inline-block;">Portal Pelajar</div>
            <h2 style="color: var(--primary); margin-bottom: 5px;">Selamat Datang! 👋</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 25px;">Masuk untuk melanjutkan pembelajaran malware awareness.</p>

            <form action="{{ url('/materi') }}" method="GET">
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Email Siswa</label>
                    <input type="text" name="username" placeholder="Masukkan email siswa" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <div class="flex-between" style="margin-bottom: 25px; font-size: 13px;">
                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" id="remember"> Ingat Saya
                    </label>
                    <a href="#" style="color: var(--primary); text-decoration: none;">Lupa Password?</a>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 12px; font-weight: bold;">Masuk Pembelajaran &rarr;</button>
            </form>

            <div style="margin-top: 25px; text-align: center; border-top: 1px solid var(--border); padding-top: 15px;">
                <a href="{{ url('/login-admin') }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none;">Login sebagai <strong>Admin / Instruktur</strong>?</a>
            </div>
        </div>
    </div>
</body>
</html>