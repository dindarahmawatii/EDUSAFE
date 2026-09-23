<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduQuiz - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen overflow-hidden m-0 p-0 font-sans">

   <div class="w-full h-full bg-gradient-to-tr from-[#2563eb] via-[#60a5fa] to-[#bfdbfe] flex flex-col justify-center items-center relative">
        
        <div class="absolute top-6 left-8 text-white/90 font-medium text-sm tracking-wide">Login</div>

       <h1 class="text-white text-5xl font-bold tracking-wider mb-8 drop-shadow-md">EduQuiz</h1>

        <div class="bg-white p-8 rounded-2xl shadow-xl w-[420px]">
            <form action="{{ url('/materi') }}" method="GET">
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-xs font-semibold mb-2">Email</label>
                    <input type="email" placeholder="Isi email" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 text-xs font-semibold mb-2">Password</label>
                    <input type="password" placeholder="Isi password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-[#222222] text-white py-3 rounded-lg text-sm font-medium hover:bg-black transition mb-5">
                    Sign In
                </button>
            </form>

            <div class="flex justify-between items-center text-xs">
                <a href="#" class="text-blue-600 hover:underline">Forgot password?</a>
                <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Buat Akun</a>
            </div>
        </div>

    </div>

</body>
</html>
