<nav class="navbar navbar-expand-lg navbar-light navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-gracias-clinic.png') }}" alt="Gracias Clinic Logo" class="nav-logo me-2">
            <span class="brand-text">Gracias Clinic</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navMain">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/treatments') }}">Treatments</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reservations.history') }}">Riwayat Reservasi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/faq') }}">FAQ</a></li>
            </ul>

            <div class="d-flex align-items-center">
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-logout">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-dark me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-dark">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>