<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EduQuiz - Platform Pembelajaran Online Malware')</title>
    
    <!-- Font Inter dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS BASE & COMPONENTS (Wajib Dimuat) -->
    <link rel="stylesheet" href="{{ asset('css/base/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/base/reset.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/navbar.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/components/buttons.css') }}?v={{ time() }}">
    
    <!-- CSS Khusus per Halaman -->
    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>