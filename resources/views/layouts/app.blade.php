<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gracias Aesthetic Clinic')</title>

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
</body>
</html>
