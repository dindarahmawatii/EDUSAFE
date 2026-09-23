<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { 
            background: #0F172A; 
        }
    </style>
</head>
<body>
    <nav class="navbar" style="background: #1E293B; border-bottom: 1px solid #334155;">
        <div class="logo" style="color: #FFFFFF;">EDUSAFE <span style="font-size: 12px; color: #38BDF8; font-weight: normal;">| Control Center</span></div>
        <div class="nav-links">
            <a href="{{ url('/login') }}" class="btn btn-outline" style="color: #94A3B8; border-color: #475569;">Portal Siswa</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card" style="width: 400px; background: #1E293B; color: #F8FAFC; border: 1px solid #334155; padding: 35px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); border-radius: 12px;">
            <div class="badge" style="background: #334155; color: #38BDF8; margin-bottom: 15px; display: inline-block;">Restricted Area</div>
            <h2 style="color: #FFFFFF; margin-bottom: 5px;">Admin Gateway 🛡️</h2>
            <p style="font-size: 13px; color: #94A3B8; margin-bottom: 25px;">Otentikasi khusus pengelola dan instruktur EDUSAFE.</p>

            <form action="{{ url('/admin') }}" method="GET">
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; color: #CBD5E1;">Email Administrator</label>
                    <input type="text" name="username" placeholder="Masukkan ID Administrator" style="width: 100%; padding: 10px; background: #0F172A; border: 1px solid #475569; color: white; border-radius: 6px;" required>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; color: #CBD5E1;">Password</label>
                    <input type="password" name="password" placeholder="Masukkan kata sandi admin" style="width: 100%; padding: 10px; background: #0F172A; border: 1px solid #475569; color: white; border-radius: 6px;" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 12px; background: #2563EB; font-weight: bold;">Masuk Dasbor Admin &rarr;</button>
            </form>

            <div style="margin-top: 25px; text-align: center; border-top: 1px solid #334155; padding-top: 15px;">
                <a href="{{ url('/login') }}" style="font-size: 12px; color: #94A3B8; text-decoration: none;">&larr; Kembali ke halaman Login Siswa</a>
            </div>
        </div>
    </div>
</body>
</html>