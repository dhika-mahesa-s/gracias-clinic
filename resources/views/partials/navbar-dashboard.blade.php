
    {{-- 🌟 Navbar Dashboard Admin --}}
    <nav class="fixed top-0 left-0 right-0 bg-primary text-primary-foreground shadow-sm border-b border-border z-50">
    <div class="flex items-center justify-between px-6 py-3">
        {{-- Kiri: Logo dan Nama --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center bg-white/80 rounded-full p-1 shadow-sm">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 object-contain">
            </div>
            <span class="font-semibold text-lg md:text-xl tracking-wide">Gracias Admin Dashboard</span>
        </div>

        {{-- Kanan: Salam dan Tombol Logout --}}
        <div class="flex items-center space-x-4">
            <span class="text-sm md:text-base">Halo, <b>Admin</b></span>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-2 bg-secondary text-secondary-foreground px-4 py-2 rounded-lg hover:bg-secondary/90 transition-all shadow-sm">
               <i class="fa-solid fa-right-from-bracket"></i>
               <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>

