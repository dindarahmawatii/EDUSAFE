<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Login Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { 
            background: linear-gradient(to bottom right, #EBF3FF, #F4F7FE); 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE <span style="font-size: 12px; color: var(--primary); font-weight: normal;">| Control Center</span></div>
        <div class="nav-links">
            <a href="{{ url('/login') }}" class="btn btn-outline" style="padding: 6px 15px;">Portal Siswa</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card" style="width: 400px; background: #FFFFFF; border: none; padding: 35px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
            <h2 style="color: var(--primary); margin-bottom: 5px;">Admin Gateway</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 25px;">Otentikasi khusus admin EDUSAFE.</p>

            <form action="{{ url('/admin') }}" method="GET">
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Email Administrator</label>
                    <input type="email" name="username" placeholder="Masukan email" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 12px; font-weight: bold;">Masuk Dasbor Admin &rarr;</button>
            </form>
        </div>
    </div>
</body>
</html>