<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen overflow-hidden m-0 p-0 font-sans">
   <div class="w-full h-full bg-gradient-to-tr from-[#2563eb] via-[#60a5fa] to-[#bfdbfe] flex flex-col justify-center items-center relative">
       <h1 class="text-white text-5xl font-bold tracking-wider mb-8 drop-shadow-md">EduSafe</h1>
        <div class="bg-white p-8 rounded-2xl shadow-xl w-[420px]">

            {{-- Kotak pesan error / lockout --}}
            <div id="alert-box" class="hidden mb-4 p-3 rounded-lg text-xs border leading-relaxed"></div>

            <form id="login-form">
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-xs font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Isi email"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-xs font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" placeholder="Isi password"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <button type="submit" id="btn-submit"
                    class="w-full bg-[#222222] text-white py-3 rounded-lg text-sm font-medium hover:bg-black transition mb-5 flex items-center justify-center gap-2">
                    <span id="btn-text">Sign In</span>
                    <svg id="btn-spinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </form>

            <div class="flex justify-between items-center text-xs">
                <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
                <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Buat Akun</a>
            </div>
        </div>

    </div>

    <script>
        const form       = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passInput  = document.getElementById('password');
        const btnSubmit  = document.getElementById('btn-submit');
        const btnText    = document.getElementById('btn-text');
        const btnSpinner = document.getElementById('btn-spinner');
        const alertBox   = document.getElementById('alert-box');

        let countdownTimer = null;

        /* ---- helper tampilkan pesan ---- */
        function showAlert(html, type) {
            alertBox.className = 'mb-4 p-3 rounded-lg text-xs border leading-relaxed';
            if (type === 'error')   alertBox.classList.add('bg-red-50',     'text-red-700',    'border-red-200');
            if (type === 'warning') alertBox.classList.add('bg-amber-50',   'text-amber-800',  'border-amber-200');
            if (type === 'success') alertBox.classList.add('bg-emerald-50', 'text-emerald-700','border-emerald-200');
            alertBox.innerHTML = html;
        }

        function hideAlert() {
            alertBox.className = 'hidden';
            alertBox.innerHTML = '';
        }

        function formatTime(secs) {
            const m = Math.floor(secs / 60);
            const s = secs % 60;
            return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        /* ---- aktifkan mode lockout ---- */
        function startLockout(lockoutUntil) {
            if (countdownTimer) clearInterval(countdownTimer);

            passInput.disabled    = true;
            passInput.value       = '';
            passInput.placeholder = 'Password terkunci';
            passInput.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-60');

            btnSubmit.disabled = true;
            btnSubmit.classList.add('bg-gray-400', 'cursor-not-allowed');
            btnSubmit.classList.remove('hover:bg-black');

            function tick() {
                const remaining = Math.max(0, Math.ceil((lockoutUntil - Date.now()) / 1000));

                if (remaining <= 0) {
                    clearInterval(countdownTimer);
                    localStorage.removeItem('edusafe_lockout_until');

                    passInput.disabled    = false;
                    passInput.placeholder = 'Isi password';
                    passInput.classList.remove('bg-gray-100', 'cursor-not-allowed', 'opacity-60');

                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    btnSubmit.classList.add('hover:bg-black');

                    showAlert('Waktu tunggu selesai. Silakan coba login kembali.', 'success');
                    return;
                }

                showAlert(
                    `<div class="font-semibold mb-1">🔒 Akun sementara dikunci</div>
                     Terlalu banyak percobaan login yang salah (5x).<br>
                     Coba lagi dalam: <span class="font-mono font-bold">${formatTime(remaining)}</span>`,
                    'error'
                );
            }

            tick();
            countdownTimer = setInterval(tick, 1000);
        }

        /* ---- cek sisa lockout saat halaman dimuat ---- */
        const stored = localStorage.getItem('edusafe_lockout_until');
        if (stored) {
            const until = parseInt(stored, 10);
            if (until > Date.now()) {
                startLockout(until);
            } else {
                localStorage.removeItem('edusafe_lockout_until');
            }
        }

        /* ---- submit form ---- */
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (passInput.disabled) return;

            hideAlert();
            btnSubmit.disabled      = true;
            btnText.textContent     = 'Memproses...';
            btnSpinner.classList.remove('hidden');

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
                    /* ✅ Login berhasil */
                    localStorage.removeItem('edusafe_lockout_until');
                    if (data.data && data.data.access_token) {
                        localStorage.setItem('auth_token', data.data.access_token);
                    }
                    showAlert('Login berhasil! Mengalihkan...', 'success');
                    setTimeout(function () {
                        window.location.href = '{{ url("/materi") }}';
                    }, 600);

                } else if (res.status === 429) {
                    /* 🔒 Terlalu banyak percobaan */
                    const retryAfter = data.retry_after !== undefined ? data.retry_after : 900;
                    const until      = Date.now() + retryAfter * 1000;
                    localStorage.setItem('edusafe_lockout_until', until);
                    startLockout(until);

                } else if (res.status === 401) {
                    /* ❌ Kredensial salah */
                    let msg = data.message || 'Email atau password salah.';
                    if (data.remaining_attempts !== undefined) {
                        msg += ' <span class="font-semibold">(Sisa: ' + data.remaining_attempts + 'x percobaan)</span>';
                    }
                    showAlert(msg, 'warning');
                    passInput.value = '';
                    passInput.focus();

                } else if (res.status === 422) {
                    /* ⚠️ Validasi gagal */
                    const firstError = data.errors
                        ? Object.values(data.errors)[0][0]
                        : null;
                    showAlert(firstError || data.message || 'Data tidak valid.', 'error');

                } else {
                    showAlert(data.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }

            } catch (err) {
                showAlert('Gagal terhubung ke server. Periksa koneksi internet Anda.', 'error');
            } finally {
                if (!passInput.disabled) {
                    btnSubmit.disabled  = false;
                }
                btnText.textContent = 'Sign In';
                btnSpinner.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
