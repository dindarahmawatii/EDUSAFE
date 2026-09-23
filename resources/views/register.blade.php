<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDUSAFE- Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f8fafc] flex flex-col justify-between m-0 font-sans">

    <!-- ini navbarnya -->
    <header class="w-full px-12 py-6 flex justify-between items-center bg-transparent">
        <div class="text-blue-900 font-bold text-lg">EDUSAFE</div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-500">Sudah punya akun?</span>
            <a href="{{ url('/') }}" class="px-5 py-2 text-xs font-medium border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">Masuk</a>
        </div>
    </header>

    <!-- ini konten utamanya -->
    <main class="flex-grow flex justify-center items-center px-4 py-6">
        <div class="bg-white/80 backdrop-blur-md border border-blue-50 p-8 rounded-2xl shadow-sm w-[460px]">
            
            <h2 class="text-xl font-bold text-blue-950 mb-1">Buat Akun Baru</h2>
            <p class="text-xs text-gray-400 mb-6">Lengkapi data di bawah untuk memulai.</p>
            
            <form action="{{ url('/') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama lengkap" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" placeholder="contoh@email.com" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" placeholder="Ulangi password" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex items-center gap-2 mb-6 text-xs text-gray-600">
                    <input type="checkbox" id="syarat" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                    <label for="syarat">Saya setuju dengan Syarat & Ketentuan yang berlaku.</label>
                </div>

                <button type="submit" class="w-full bg-[#001d6c] text-white py-3 rounded-xl text-xs font-medium hover:bg-blue-900 transition flex items-center justify-center gap-2 shadow-md">
                    Daftar Sekarang &rarr;
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

</body>
</html>