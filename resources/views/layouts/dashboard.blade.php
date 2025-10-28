<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Gracias Aesthetic Clinic')</title>

    {{-- ✅ Tailwind & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- ✅ Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="font-[Poppins] bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    @include('partials.navbar-dashboard')

    <div class="flex min-h-screen pt-16">
        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Konten Utama --}}
        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    {{-- Chart.js atau Script Tambahan --}}
    @yield('scripts')
</body>
</html>
