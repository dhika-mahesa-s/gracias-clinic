<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Gracias Aesthetic Clinic')</title>

    {{-- ✅ Meta tag untuk membuka di browser eksternal --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    {{-- ✅ Meta tag untuk Edge browser --}}
    <meta name="msapplication-tap-highlight" content="no">

    {{-- ✅ Tailwind + Alpine (via Vite) --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- ✅ Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- ✅ Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer">

    {{-- ✅ Swiper.js (CSS) --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    {{-- ✅ Alpine.js x-cloak fix --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>

</head>

<body x-data="{ dark: false }" :class="{ 'dark': dark }" 
      class="font-[Poppins] overflow-x-hidden bg-background text-foreground transition-colors duration-300">

    {{-- 🌟 Navbar --}}
    @include('partials.navbar')

    {{-- 📄 Konten Utama --}}
    <main class="pt-20">
        @yield('content')
    </main>

    {{-- 🌙 Footer --}}
    @include('partials.footer')

    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => AOS.init({ duration: 600, once: true }), 100);
        });
    </script>

@vite('resources/js/app.js')

{{-- ✅ SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ✅ Flash Message (SweetAlert2) --}}
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2563eb', // Tailwind blue-600
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626', // Tailwind red-600
        });
    });
</script>
@endif

</body>
</html>
