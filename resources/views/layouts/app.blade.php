<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Gracias Clinic')</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer">

    {{-- ✅ Swiper.js (CSS) --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

</head>

{{-- Menggunakan kelas Tailwind untuk layout dasar --}}

<body class="font-sans min-h-screen flex flex-col pt-16 bg-gray-50"
    style="background: linear-gradient(135deg, #e2ebf0 0%, #f7f9fb 100%);">

    {{-- 🌟 Navbar --}}
    @include('partials.navbar')

    {{-- 📄 Konten Utama --}}
    <main class="flex-grow py-8">
        <div class="container mx-auto px-0">
            @yield('content')
        </div>
    </main>

    {{-- 🌙 Footer --}}
    @include('partials.footer')

    {{-- ✅ Swiper.js (JS) --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{-- ✅ Stack untuk script halaman tertentu --}}
    @stack('scripts')
    
</body>

</html>