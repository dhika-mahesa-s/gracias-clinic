{{-- ========================================
     NAVBAR - Modern Glass Morphism Design
======================================== --}}
<nav x-data="{ open: false, scrolled: false }" 
     x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
     :class="scrolled ? 'bg-white/95 shadow-lg' : 'bg-white/80 shadow-sm'"
     class="fixed top-0 left-0 w-full z-50 backdrop-blur-md transition-smooth animate-slide-down">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            {{-- Logo & Brand --}}
            <a href="{{ url('/') }}" 
               class="group flex items-center gap-3 transition-smooth hover-scale-sm active-press">
                <div class="relative">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Gracias Clinic Logo" 
                         class="w-12 h-12 md:w-14 md:h-14 rounded-xl shadow-md group-hover:shadow-lg transition-smooth">
                    <div class="absolute inset-0 bg-primary/10 rounded-xl opacity-0 group-hover:opacity-100 transition-smooth"></div>
                </div>
                <div class="hidden sm:block">
                    <span class="block text-lg md:text-xl font-bold text-foreground group-hover:text-primary transition-smooth">
                        Gracias Aesthetic Clinic
                    </span>
                    <span class="block text-xs text-muted-foreground">
                        Your Beauty, Our Priority
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation Menu --}}
            <div class="hidden lg:flex items-center gap-2">
                {{-- Home --}}
                <a href="{{ url('/') }}"
                   class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                   {{ Request::is('/') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                    <span class="relative z-10">Home</span>
                    @if(Request::is('/'))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                    @endif
                </a>

                {{-- Treatments --}}
                <a href="{{ route('treatments.index') }}"
                   class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                   {{ Route::is('treatments.*') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                    <span class="relative z-10">Treatments</span>
                    @if(Route::is('treatments.*'))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                    @endif
                </a>

                {{-- Reservasi --}}
                <a href="{{ route('reservasi.index') }}"
                   class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                   {{ Route::is('reservasi.*') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                    <span class="relative z-10">Reservasi</span>
                    @if(Route::is('reservasi.*'))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                    @endif
                </a>

                {{-- Riwayat Reservasi (Only for logged in users with reservations) --}}
                @auth
                    @if ($hasReservation)
                        <a href="{{ route('reservations.history') }}"
                           class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                           {{ Route::is('reservations.*') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                            <span class="relative z-10">Riwayat</span>
                            @if(Route::is('reservations.*'))
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                            @endif
                        </a>
                    @endif
                @endauth

                {{-- About Us --}}
                <a href="{{ route('about') }}"
                   class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                   {{ Route::is('about') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                    <span class="relative z-10">About</span>
                    @if(Route::is('about'))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                    @endif
                </a>

                {{-- FAQ --}}
                <a href="{{ route('customer.faq.index') }}"
                   class="group relative px-4 py-2 rounded-xl font-medium transition-smooth hover-scale-sm active-press
                   {{ Route::is('customer.faq.*') ? 'text-primary bg-primary/10' : 'text-foreground hover:text-primary hover:bg-primary/5' }}">
                    <span class="relative z-10">FAQ</span>
                    @if(Route::is('customer.faq.*'))
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full"></div>
                    @endif
                </a>

                {{-- Divider --}}
                <div class="w-px h-8 bg-border mx-2"></div>

                {{-- Auth Buttons --}}
                @guest
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-primary to-blue-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover-lift active-press transition-smooth">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Login</span>
                    </a>
                @endguest

                @auth
                    {{-- User Menu Dropdown --}}
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center gap-3 px-4 py-2 rounded-xl bg-primary/10 border border-primary/20 hover:bg-primary/15 transition-smooth active-press">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-foreground max-w-[100px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-muted-foreground transition-transform" 
                                 :class="userMenuOpen ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="userMenuOpen"
                             x-transition:enter="transition-smooth"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition-smooth-fast"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             @click.away="userMenuOpen = false"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-border overflow-hidden">
                            <div class="p-4 border-b border-border bg-gradient-to-r from-primary/5 to-blue-500/5">
                                <p class="text-sm font-semibold text-foreground">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-muted-foreground truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-smooth">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span class="font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile Menu Toggle --}}
            <button @click="open = !open" 
                    class="lg:hidden p-2 rounded-xl hover:bg-primary/10 transition-smooth active-press">
                <svg class="w-6 h-6 text-foreground" 
                     :class="open ? 'hidden' : 'block'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg class="w-6 h-6 text-foreground"
                     :class="open ? 'block' : 'hidden'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" 
         x-transition:enter="transition-smooth" 
         x-transition:enter-start="opacity-0 -translate-y-4" 
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition-smooth-fast" 
         x-transition:leave-start="opacity-100 translate-y-0" 
         x-transition:leave-end="opacity-0 -translate-y-4"
         @click.away="open = false"
         class="lg:hidden bg-white/95 backdrop-blur-md border-t border-border shadow-lg">
        
        <div class="px-4 py-6 space-y-2">
            {{-- Mobile Menu Items --}}
            <a href="{{ url('/') }}"
               @click="open = false"
               class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
               {{ Request::is('/') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"/>
                        <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"/>
                    </svg>
                    <span>Home</span>
                </div>
            </a>

            <a href="{{ route('treatments.index') }}"
               @click="open = false"
               class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
               {{ Route::is('treatments.*') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                    <span>Treatments</span>
                </div>
            </a>

            <a href="{{ route('reservasi.index') }}"
               @click="open = false"
               class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
               {{ Route::is('reservasi.*') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd"/>
                    </svg>
                    <span>Reservasi</span>
                </div>
            </a>

            @auth
                @if ($hasReservation)
                    <a href="{{ route('reservations.history') }}"
                       @click="open = false"
                       class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
                       {{ Route::is('reservations.*') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd"/>
                            </svg>
                            <span>Riwayat Reservasi</span>
                        </div>
                    </a>
                @endif
            @endauth

            <a href="{{ route('about') }}"
               @click="open = false"
               class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
               {{ Route::is('about') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                    </svg>
                    <span>About Us</span>
                </div>
            </a>

            <a href="{{ route('customer.faq.index') }}"
               @click="open = false"
               class="block px-4 py-3 rounded-xl font-medium transition-smooth active-press
               {{ Route::is('customer.faq.*') ? 'bg-primary text-white' : 'text-foreground hover:bg-primary/5 hover:text-primary' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                    </svg>
                    <span>FAQ</span>
                </div>
            </a>

            {{-- Mobile Auth Section --}}
            <div class="pt-4 border-t border-border">
                @guest
                    <a href="{{ route('login') }}"
                       @click="open = false"
                       class="block w-full px-4 py-3 bg-gradient-to-r from-primary to-blue-600 text-white font-semibold text-center rounded-xl shadow-md hover:shadow-lg active-press transition-smooth">
                        Login
                    </a>
                @endguest

                @auth
                    <div class="px-4 py-3 bg-gradient-to-r from-primary/5 to-blue-500/5 rounded-xl mb-3">
                        <p class="text-sm font-semibold text-foreground">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-muted-foreground truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmLogout()"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 active-press transition-smooth">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ✅ SweetAlert Logout Notification --}}
@if (session('logout_success'))
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

{{-- ✅ SweetAlert Logout Confirmation --}}
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
            width: '400px', // Ukuran lebih kecil
            padding: '1rem'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the logout form
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
