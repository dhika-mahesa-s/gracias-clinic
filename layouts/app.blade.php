<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Gracias Clinic')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    @include('partials.navbar-dashboard')

    <main class="pt-4 mt-2">
        @yield('content')
    </main>

    <!-- Bootstrap JS (include at end so collapse works) -->
    <script src="{{ asset('js/reservations-history.js') }}"></script>
    @stack('scripts')
</body>

</html>