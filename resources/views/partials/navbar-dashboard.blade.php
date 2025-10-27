<nav class="bg-white/90 backdrop-blur-md shadow-md fixed top-0 w-full z-10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO dan Nama Brand --}}
            <a class="flex items-center space-x-3" href="{{ url('/') }}">
                <img src="{{ asset('images/logo-gracias-clinic.png') }}" alt="Gracias Clinic Logo" class="h-20 w-auto">
                <span class="text-xl font-extrabold text-gray-800">Gracias Aesthetic Clinic</span>
            </a>

            {{-- TOMBOL NAVIGASI --}}
            <div class="hidden sm:ml-6 sm:flex sm:space-x-4 items-center">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="{{ url('/treatments') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Treatments</a>
                <a href="{{ route('reservations.history') }}" class="text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 text-sm font-medium">Riwayat Reservasi</a>
                <a href="{{ url('/faq') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">FAQ</a>

                {{-- AUTH BUTTONS --}}
                <div class="ml-4 flex items-center space-x-2">
                    @auth
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-sm font-medium">Logout</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 border border-gray-300 px-3 py-1.5 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-sm font-medium">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>