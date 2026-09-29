<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Lupa Password</title>
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
            <span style="font-size: 13px; color: var(--text-muted); margin-right: 10px;">Ingat password Anda?</span>
            <a href="{{ url('/login') }}" class="btn btn-outline" style="padding: 6px 15px;">Masuk</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card" style="width: 400px; background: #FFFFFF; border: none; padding: 35px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
            <div class="badge" style="background: #EBF3FF; color: var(--primary); margin-bottom: 15px; display: inline-block;">Pemulihan Akun</div>
            <h2 style="color: var(--primary); margin-bottom: 5px;">Lupa Password?</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 25px;">Masukkan email terdaftar Anda. Kami akan mengirimkan instruksi/link untuk mereset password.</p>

            {{-- Pesan Sukses (Dikirim dari Backend jika email berhasil dikirim) --}}
            @if (session('status'))
                <div style="background: #D1FAE5; color: #065F46; padding: 10px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pesan Error Validasi --}}
            @if ($errors->has('email'))
                <div style="background: #FEE2E2; color: #991B1B; padding: 10px 12px; border-radius: 6px; font-size: 13px; margin-bottom: 20px;">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form action="{{ url('/lupa-password') }}" method="POST">
                @csrf
                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh: siswa@edusafe.id" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required autofocus>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 12px; font-weight: bold; margin-bottom: 15px;">Kirim Link Reset Password &rarr;</button>

                <div style="text-align: center;">
                    <a href="{{ url('/login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">&larr; Kembali ke Halaman Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>