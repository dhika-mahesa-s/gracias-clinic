<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Panel</title>

    <!-- Tambahkan CSS Bootstrap / Tailwind / CSS kustom kamu -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100">

    {{-- Header --}}
    @include('Admin.layout.header')

    <div class="flex">
        {{-- Sidebar --}}
        @include('Admin.layout.sidebar')

        {{-- Konten Utama --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    @include('Admin.layout.footer')

    <!-- Tambahkan JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
