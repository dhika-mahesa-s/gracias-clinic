<nav x-data="{ open: false }"
    class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-20">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-2 font-semibold text-gray-800 text-lg">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14 md:w-16 md:h-16">
            <span>Gracias Aesthetic Clinic</span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}"
               class="relative px-3 py-1 rounded-md 
               {{ Request::is('/') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                Home
            </a>

            <a href="{{ route('treatments.index') }}"
               class="relative px-3 py-1 rounded-md 
               {{ Route::is('treatments.index') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                Treatments
            </a>

            <a href="{{ route('reservasi.index') }}"
               class="relative px-3 py-1 rounded-md 
               {{ Route::is('reservasi.index') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                Reservasi
            </a>

            @auth
                @if($hasReservation)
                    <a href="{{ route('reservations.history') }}"
                       class="relative px-3 py-1 rounded-md 
                       {{ Route::is('reservations.history') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                        Riwayat Reservasi
                    </a>
                @endif
            @endauth

            <a href="{{ route('about') }}"
               class="relative px-3 py-1 rounded-md 
               {{ Route::is('about') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                About Us
            </a>

            <a href="{{ route('customer.faq.index') }}"
               class="relative px-3 py-1 rounded-md 
               {{ Route::is('customer.faq.*') ? 'text-blue-600 font-semibold bg-blue-100' : 'text-gray-700 font-medium hover:text-black hover:bg-blue-50' }}">
                FAQ
            </a>

            {{-- Tombol Login/Register --}}
            @guest
                <a href="{{ route('login') }}"
                   class="px-4 py-2 border border-gray-800 rounded-lg font-medium hover:bg-gray-900 hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-black transition">
                    Daftar Sekarang
                </a>
            @endguest

            {{-- Tombol Logout --}}
            @auth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

        {{-- Tombol Menu Mobile --}}
        <button @click="open = !open" class="md:hidden focus:outline-none text-gray-700">
            <i :class="open ? 'fa-solid fa-xmark text-2xl' : 'fa-solid fa-bars text-2xl'"></i>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" x-transition class="md:hidden bg-white/90 backdrop-blur-md border-t border-gray-200">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ url('/') }}"
               class="block px-3 py-2 rounded-md 
               {{ Request::is('/') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                Home
            </a>

            <a href="{{ route('treatments.index') }}"
               class="block px-3 py-2 rounded-md 
               {{ Route::is('treatments.index') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                Treatments
            </a>

            <a href="{{ route('reservasi.index') }}"
               class="block px-3 py-2 rounded-md 
               {{ Route::is('reservasi.index') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                Reservasi
            </a>

            @auth
                @if($hasReservation)
                    <a href="{{ route('reservations.history') }}"
                       class="block px-3 py-2 rounded-md 
                       {{ Route::is('reservations.history') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                        Riwayat Reservasi
                    </a>
                @endif
            @endauth

            <a href="{{ route('about') }}"
               class="block px-3 py-2 rounded-md 
               {{ Route::is('about') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                About Us
            </a>

            <a href="{{ route('customer.faq.index') }}"
               class="block px-3 py-2 rounded-md 
               {{ Route::is('customer.faq.*') ? 'bg-blue-500 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                FAQ
            </a>

            @guest
                <a href="{{ route('login') }}"
                   class="block px-4 py-2 mt-2 border border-gray-800 rounded-lg text-center font-medium hover:bg-gray-900 hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="block px-4 py-2 bg-gray-900 text-white rounded-lg text-center font-medium hover:bg-black transition">
                    Daftar Sekarang
                </a>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="POST" class="mt-2 text-center">
                    @csrf
                    <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

{{-- ✅ SweetAlert Logout Notification --}}
@if(session('logout_success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Logout Berhasil!",
            text: "{{ session('logout_success') }}",
            icon: "success",
            confirmButtonText: "OK",
            confirmButtonColor: "#3085d6",
            timer: 2000,
            timerProgressBar: true
        });
    });
</script>
@endif
