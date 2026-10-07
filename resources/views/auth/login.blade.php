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
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 15px;
            line-height: 1.5;
            border: 1px solid transparent;
        }
        .alert-error {
            background-color: #FEF2F2;
            color: #B91C1C;
            border-color: #FECACA;
        }
        .alert-warning {
            background-color: #FFFBEB;
            color: #92400E;
            border-color: #FDE68A;
        }
        .alert-success {
            background-color: #ECFDF5;
            color: #047857;
            border-color: #A7F3D0;
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">EDUSAFE</div>
        <div class="nav-links">
            <span style="font-size: 13px; color: var(--text-muted); margin-right: 10px;">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="btn btn-outline" style="padding: 6px 15px;">Daftar Siswa</a>
        </div>
    </nav>

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
        <div class="card" style="width: 400px; background: #FFFFFF; border: none; padding: 35px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
            <div class="badge" style="background: #EBF3FF; color: var(--primary); margin-bottom: 15px; display: inline-block;">Portal Pelajar</div>
            <h2 style="color: var(--primary); margin-bottom: 5px;">Selamat Datang!</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 25px;">Masuk untuk melanjutkan pembelajaran malware awareness.</p>

            {{-- Alert Box --}}
            <div id="alert-box" style="display: none;" class="alert"></div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="login-form" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;" required>
                </div>

                <div class="flex-between" style="margin-bottom: 25px; font-size: 13px;">
                    <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <input type="checkbox" id="remember" name="remember" value="1"> Ingat Saya
                    </label>
                    <a href="{{ url('/lupa-password') }}" style="color: var(--primary); text-decoration: none;">Lupa Password?</a>
                </div>

                <button type="submit" id="btn-submit" class="btn" style="width: 100%; padding: 12px; font-weight: bold;">
                    <span id="btn-text">Masuk Pembelajaran &rarr;</span>
                </button>
            </form>

            <div style="margin-top: 25px; text-align: center; border-top: 1px solid var(--border); padding-top: 15px;">
                <a href="{{ url('/login-admin') }}" style="font-size: 12px; color: var(--text-muted); text-decoration: none;">Login sebagai <strong>Admin / Instruktur</strong>?</a>
            </div>
        </div>
    </div>

    <script>
        const form       = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        const btnSubmit  = document.getElementById('btn-submit');
        const btnText    = document.getElementById('btn-text');
        const alertBox   = document.getElementById('alert-box');

        let countdownTimer = null;

        function showAlert(html, type) {
            alertBox.style.display = 'block';
            alertBox.className = 'alert';
            if (type === 'error')   alertBox.classList.add('alert-error');
            if (type === 'warning') alertBox.classList.add('alert-warning');
            if (type === 'success') alertBox.classList.add('alert-success');
            alertBox.innerHTML = html;
        }

        function hideAlert() {
            alertBox.style.display = 'none';
            alertBox.innerHTML = '';
        }

        function formatTime(secs) {
            const m = Math.floor(secs / 60);
            const s = secs % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        function startLockout(lockoutUntil) {
            if (countdownTimer) clearInterval(countdownTimer);

            passInput.disabled    = true;
            passInput.value       = '';
            passInput.placeholder = 'Password terkunci';
            passInput.style.backgroundColor = '#f1f5f9';
            passInput.style.cursor = 'not-allowed';

            btnSubmit.disabled = true;

            function tick() {
                const remaining = Math.max(0, Math.ceil((lockoutUntil - Date.now()) / 1000));

                if (remaining <= 0) {
                    clearInterval(countdownTimer);
                    localStorage.removeItem('edusafe_lockout_until');

                    passInput.disabled    = false;
                    passInput.placeholder = 'Masukkan password';
                    passInput.style.backgroundColor = '';
                    passInput.style.cursor = '';

                    btnSubmit.disabled = false;

                    showAlert('Waktu tunggu selesai. Silakan coba login kembali.', 'success');
                    return;
                }

                showAlert(
                    `<strong>🔒 Akun sementara dikunci</strong><br>
                     Terlalu banyak percobaan login yang salah (5x).<br>
                     Coba lagi dalam: <span style="font-family: monospace; font-weight: bold;">${formatTime(remaining)}</span>`,
                    'error'
                );
            }

            tick();
            countdownTimer = setInterval(tick, 1000);
        }

        const stored = localStorage.getItem('edusafe_lockout_until');
        if (stored) {
            const until = parseInt(stored, 10);
            if (until > Date.now()) {
                startLockout(until);
            } else {
                localStorage.removeItem('edusafe_lockout_until');
            }
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (passInput.disabled) return;

            hideAlert();
            btnSubmit.disabled  = true;
            btnText.textContent = 'Memproses...';

            try {
                const res = await fetch('{{ url("/api/login") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        email:    emailInput.value,
                        password: passInput.value,
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    localStorage.removeItem('edusafe_lockout_until');
                    if (data.data && data.data.access_token) {
                        localStorage.setItem('auth_token', data.data.access_token);
                    }
                    showAlert('Login berhasil! Mengalihkan ke materi...', 'success');
                    setTimeout(function () {
                        window.location.href = '{{ url("/materi") }}';
                    }, 600);

                } else if (res.status === 429) {
                    const retryAfter = data.retry_after !== undefined ? data.retry_after : 60;
                    const until      = Date.now() + retryAfter * 1000;
                    localStorage.setItem('edusafe_lockout_until', until);
                    startLockout(until);

                } else if (res.status === 401) {
                    let msg = data.message || 'Email atau password salah.';
                    if (data.remaining_attempts !== undefined) {
                        msg += ' <strong>(Sisa: ' + data.remaining_attempts + 'x percobaan)</strong>';
                    }
                    showAlert(msg, 'warning');
                    passInput.value = '';
                    passInput.focus();

                } else if (res.status === 422) {
                    const firstError = data.errors
                        ? Object.values(data.errors)[0][0]
                        : null;
                    showAlert(firstError || data.message || 'Data tidak valid.', 'error');

                } else {
                    showAlert(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }

            } catch (err) {
                // Fallback to regular POST submit
                form.submit();
            } finally {
                if (!passInput.disabled) {
                    btnSubmit.disabled  = false;
                }
                btnText.textContent = 'Masuk Pembelajaran →';
            }
        });
    </script>
</body>
</html>