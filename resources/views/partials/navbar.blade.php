<nav x-data="{ open: false }"
    class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-white/30 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-20">
        <a href="{{ url('/') }}" class="flex items-center space-x-2 font-semibold text-gray-800 text-lg">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-14 h-14 md:w-16 md:h-16">
            <span>Gracias Aesthetic Clinic</span>
        </a>

        {{-- Desktop menu --}}
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="relative text-gray-700 font-medium hover:text-black">Home</a>
            <a href="{{ route('treatments.index') }}" class="relative text-gray-700 font-medium hover:text-black">Treatments</a>
            <a href="{{ route('reservasi.index') }}" class="relative text-gray-700 font-medium hover:text-black">Reservasi</a>

            {{-- Tampilkan hanya jika user sudah punya reservasi --}}
            @auth
                @if($hasReservation)
                    <a href="{{ route('reservations.history') }}" class="relative text-gray-700 font-medium hover:text-black">
                        Riwayat Reservasi
                    </a>
                @endif
            @endauth

            <a href="#" class="relative text-gray-700 font-medium hover:text-black">About Us</a>
            <a href="#" class="relative text-gray-700 font-medium hover:text-black">FAQ</a>

            @guest
                <a href="{{ route('login') }}" class="px-4 py-2 border border-gray-800 rounded-lg font-medium hover:bg-gray-900 hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-black transition">
                    Daftar Sekarang
                </a>
            @endguest

            @auth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    

    {{-- Mobile menu --}}
    <div x-show="open" x-transition class="md:hidden bg-white/90 backdrop-blur-md border-t border-gray-200">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ url('/') }}" class="block text-gray-700 font-medium hover:text-black">Home</a>
            <a href="{{ route('treatments.index') }}" class="block text-gray-700 font-medium hover:text-black">Treatments</a>
            <a href="{{ route('reservasi.index') }}" class="block text-gray-700 font-medium hover:text-black">Reservasi</a>
            <a href="#" class="block text-gray-700 font-medium hover:text-black">About Us</a>
            <a href="#" class="block text-gray-700 font-medium hover:text-black">FAQ</a>

            @guest
                <a href="{{ route('login') }}" class="block px-4 py-2 mt-2 border border-gray-800 rounded-lg text-center font-medium hover:bg-gray-900 hover:text-white transition">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 bg-gray-900 text-white rounded-lg text-center font-medium hover:bg-black transition">Daftar Sekarang</a>
            @endguest

            @auth
                @if($hasReservation)
                <a href="{{ route('reservations.history') }}" class="block text-gray-700 font-medium hover:text-black">Riwayat Reservasi</a>
                @endif
            @endauth

            
            @auth
                <form action="{{ route('logout') }}" method="POST" class="mt-2 text-center">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
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