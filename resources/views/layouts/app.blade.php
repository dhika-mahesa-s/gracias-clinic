<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Gracias Clinic')</title>

    {{-- Pertahankan link Bootstrap Icons jika diperlukan untuk icon --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- WAJIB: INTEGRASI VITE UNTUK MEMUAT TAILWIND CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

{{-- Menggunakan kelas Tailwind untuk layout dasar --}}

<body class="font-sans min-h-screen flex flex-col pt-16 bg-gray-50"
    style="background: linear-gradient(135deg, #e2ebf0 0%, #f7f9fb 100%);">

    @include('partials.navbar-dashboard')

    <main class="flex-grow py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <footer class="text-center py-3 border-t mt-auto w-full bg-white/90">
        <small class="text-gray-600">© {{ date('Y') }} Gracias Aesthetic Clinic. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/reservations-history.js') }}"></script>
</body>

</html>