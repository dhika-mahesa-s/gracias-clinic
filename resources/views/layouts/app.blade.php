<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Gracias Aesthetic Clinic')</title>

    {{-- ✅ Meta tags untuk PWA --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-tap-highlight" content="no">

    {{-- ✅ Preconnect untuk external resources --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://unpkg.com">

    {{-- ✅ Critical CSS - Vite (load first) --}}
    @vite('resources/css/app.css')

    {{-- ✅ Fonts - async with font-display swap --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    {{-- ✅ Font Awesome - defer loading --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          crossorigin="anonymous"
          referrerpolicy="no-referrer"
          media="print"
          onload="this.media='all'">

    {{-- ✅ Alpine.js x-cloak fix --}}
    <style>[x-cloak] { display: none !important; }</style>

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

    {{-- ✅ Vite JS (Alpine already included) --}}
    @vite('resources/js/app.js')

    {{-- ✅ Defer non-critical scripts --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js" defer></script>

    {{-- ✅ SweetAlert2 - defer --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    {{-- ✅ Initialize AOS after DOM ready --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 600, once: true });
            }
        });
    </script>

    {{-- ✅ Flash Messages with SweetAlert2 --}}
    @if (session('success'))
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#2563eb',
                });
            }
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
