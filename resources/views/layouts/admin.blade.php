<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EDUSAFE - Admin Panel')</title>
    
    <!-- CSS Base & Component -->
    <link rel="stylesheet" href="{{ asset('css/base/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/base/reset.css') }}?v={{ time() }}">
    
    <!-- CSS Admin Page & Layout -->
    <link rel="stylesheet" href="{{ asset('css/pages/admin/admin.css') }}?v={{ time() }}">
    
    @stack('styles')
</head>
<body>

    {{-- Header / Navbar Admin --}}
    @include('partials.navbar-admin')

    {{-- Main Content --}}
    <main class="admin-main-content">
        @yield('content')
    </main>

    {{-- Footer Admin --}}
    @include('partials.footer-admin')

    @stack('scripts')
</body>
</html>