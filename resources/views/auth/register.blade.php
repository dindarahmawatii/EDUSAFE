<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8fafc] flex flex-col justify-between m-0 font-sans">

    <!-- ini navbarnya -->
    <header class="w-full px-12 py-6 flex justify-between items-center bg-transparent">
        <div class="text-blue-900 font-bold text-lg">EDUSAFE</div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-500">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="px-5 py-2 text-xs font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">Masuk</a>
        </div>
    </header>

    <!-- ini konten utamanya -->
    <main class="flex-grow flex justify-center items-center px-4 py-6">
        <div class="bg-white/80 backdrop-blur-md border border-blue-50 p-8 rounded-2xl shadow-sm w-[460px]">
            
            <h2 class="text-xl font-bold text-blue-950 mb-1">Buat Akun Baru</h2>
            <p class="text-xs text-gray-400 mb-6">Lengkapi data di bawah untuk memulai.</p>

            {{-- Alert Box --}}
            <div id="alert-box" class="hidden mb-4 p-3 rounded-lg text-xs border leading-relaxed"></div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg text-xs bg-red-50 text-red-700 border border-red-200 leading-relaxed">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 leading-relaxed">
                    {{ session('success') }}
                </div>
            @endif
            
            <form id="register-form" action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <button type="submit" id="btn-submit" class="w-full bg-[#001d6c] text-white py-3 rounded-xl text-xs font-medium hover:bg-blue-900 transition flex items-center justify-center gap-2 shadow-md">
                    <span id="btn-text">Daftar Sekarang &rarr;</span>
                    <svg id="btn-spinner" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </main>

    <footer class="w-full px-12 py-6 border-t border-gray-200 flex justify-between items-center text-xs text-gray-500">
        <div>Edusafe</div>
        <div class="flex gap-6">
            <a href="#" class="hover:underline">EDUSAFE • Sistem Edukasi & Keamanan</a>
        </div>
    </footer>

    <script>
        const form        = document.getElementById('register-form');
        const nameInput   = document.getElementById('name');
        const emailInput  = document.getElementById('email');
        const passInput   = document.getElementById('password');
        const passConf    = document.getElementById('password_confirmation');
        const btnSubmit   = document.getElementById('btn-submit');
        const btnText     = document.getElementById('btn-text');
        const btnSpinner  = document.getElementById('btn-spinner');
        const alertBox    = document.getElementById('alert-box');

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

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            hideAlert();

            if (passInput.value.length < 8) {
                showAlert('Password minimal terdiri dari 8 karakter.', 'error');
                return;
            }

            if (passInput.value !== passConf.value) {
                showAlert('Konfirmasi password tidak cocok.', 'error');
                return;
            }

            btnSubmit.disabled = true;
            btnText.textContent = 'Mendaftar...';
            btnSpinner.classList.remove('hidden');

            try {
                const res = await fetch('{{ url("/api/register") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: nameInput.value,
                        email: emailInput.value,
                        password: passInput.value,
                        password_confirmation: passConf.value,
                    }),
                });

                const data = await res.json();

                if (res.ok) {
                    showAlert('Registrasi berhasil! Mengalihkan ke halaman login...', 'success');
                    setTimeout(function () {
                        window.location.href = '{{ route("login") }}';
                    }, 1000);
                } else if (res.status === 422) {
                    let errMsg = '';
                    if (data.errors) {
                        const errs = Object.values(data.errors).flat();
                        errMsg = '<ul class="list-disc list-inside">' + errs.map(e => `<li>${e}</li>`).join('') + '</ul>';
                    } else {
                        errMsg = data.message || 'Data tidak valid.';
                    }
                    showAlert(errMsg, 'error');
                } else {
                    showAlert(data.message || 'Terjadi kesalahan saat mendaftar.', 'error');
                }
            } catch (err) {
                // Fallback to standard form submit if fetch fails
                form.submit();
            } finally {
                btnSubmit.disabled = false;
                btnText.textContent = 'Daftar Sekarang →';
                btnSpinner.classList.add('hidden');
            }
        });
    </script>
</body>
</html>