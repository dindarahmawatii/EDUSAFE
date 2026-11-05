<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduSafe</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Base, Components, & Halaman Auth -->
    <link rel="stylesheet" href="{{ asset('css/base/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/base/reset.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/forms.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/buttons.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/alerts.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/pages/auth/login.css') }}?v={{ time() }}">
</head>
<body class="auth-page">

    <main class="auth-wrap">
        <h1 class="auth-brand">EduSafe</h1>

        <div class="auth-card">
            {{-- Alert dari JavaScript --}}
            <div id="alert-box" class="alert" hidden></div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="login-form" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" id="btn-submit" class="btn btn-dark btn-block">
                    <span id="btn-text">Sign In</span>
                </button>
            </form>

            <div class="auth-links">
                <a href="{{ route('forgot-password') }}" class="link-forgot">Forgot password?</a>
                <a href="{{ route('register') }}" class="link-register">Buat Akun</a>
            </div>
        </div>
    </main>

    <script>
        const form       = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        const btnSubmit  = document.getElementById('btn-submit');
        const btnText    = document.getElementById('btn-text');
        const alertBox   = document.getElementById('alert-box');
        const BTN_LABEL  = 'Sign In';

        let countdownTimer = null;

        function showAlert(html, type) {
            alertBox.hidden = false;
            alertBox.className = 'alert alert-' + type;
            alertBox.innerHTML = html;
        }

        function hideAlert() {
            alertBox.hidden = true;
            alertBox.innerHTML = '';
        }

        function formatTime(secs) {
            const m = Math.floor(secs / 60);
            const s = secs % 60;
            return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function startLockout(lockoutUntil) {
            if (countdownTimer) clearInterval(countdownTimer);

            passInput.disabled    = true;
            passInput.value       = '';
            passInput.placeholder = 'Password terkunci';
            btnSubmit.disabled    = true;

            function tick() {
                const remaining = Math.max(0, Math.ceil((lockoutUntil - Date.now()) / 1000));

                if (remaining <= 0) {
                    clearInterval(countdownTimer);
                    localStorage.removeItem('edusafe_lockout_until');

                    passInput.disabled    = false;
                    passInput.placeholder = 'Masukkan password';
                    btnSubmit.disabled    = false;

                    showAlert('Waktu tunggu selesai. Silakan coba login kembali.', 'success');
                    return;
                }

                showAlert(
                    '<strong>Akun sementara dikunci</strong><br>' +
                    'Terlalu banyak percobaan login yang salah (5x).<br>' +
                    'Coba lagi dalam: <strong>' + formatTime(remaining) + '</strong>',
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
                const res = await fetch('{{ route("login.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email:    emailInput.value,
                        password: passInput.value,
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    localStorage.removeItem('edusafe_lockout_until');
                    showAlert('Login berhasil! Mengalihkan...', 'success');
                    
                    setTimeout(function () {
                        window.location.href = data.redirect;
                    }, 600);

                } else if (res.status === 429) {
                    const retryAfter = data.retry_after !== undefined ? data.retry_after : 900;
                    const until      = Date.now() + retryAfter * 1000;
                    localStorage.setItem('edusafe_lockout_until', until);
                    startLockout(until);

                } else if (res.status === 401) {
                    let msg = data.message || 'Email atau kata sandi salah.';
                    if (data.remaining_attempts !== undefined) {
                        msg += ' <strong>(Sisa: ' + data.remaining_attempts + 'x percobaan)</strong>';
                    }
                    showAlert(msg, 'warning');
                    passInput.value = '';
                    passInput.focus();

                } else if (res.status === 422) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
                    showAlert(firstError || data.message || 'Data tidak valid.', 'error');

                } else {
                    showAlert(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }

            } catch (err) {
                form.submit();
            } finally {
                if (!passInput.disabled) btnSubmit.disabled = false;
                btnText.textContent = BTN_LABEL;
            }
        });
    </script>
</body>
</html>