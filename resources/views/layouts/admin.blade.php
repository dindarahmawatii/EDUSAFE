<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EDUSAFE - Admin Panel')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh; margin: 0;">

    {{-- Header Khusus Admin --}}
    @include('partials.header-admin')

    {{-- Isi Konten Halaman Admin --}}
    <main style="flex: 1;">
        @yield('content')
    </main>

    {{-- Footer Khusus Admin --}}
    @include('partials.footer-admin')

</body>
</html>