<nav class="fixed top-0 left-0 right-0 bg-primary text-primary-foreground shadow-sm border-b border-border z-50">
    <div class="flex items-center justify-between px-6 py-3">
        {{-- Logo --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center bg-white/80 rounded-full p-1 shadow-sm">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 object-contain">
            </div>
            <span class="font-semibold text-lg md:text-xl tracking-wide">Gracias Admin Dashboard</span>
        </div>

        {{-- Salam & Logout --}}
        <div class="flex items-center space-x-4 relative z-50">
            <span class="text-sm md:text-base">Halo, <b>{{ Auth::user()->name ?? 'Admin' }}</b></span>

            <button type="button" onclick="confirmLogout()"
                class="flex items-center gap-2 bg-secondary text-secondary-foreground px-4 py-2 rounded-lg hover:bg-secondary/90 transition-all shadow-sm">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
</nav>
{{-- Script SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah anda yakin untuk logout?',
            text: "Anda akan keluar dari akun ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            width: '400px',
            padding: '1rem'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
