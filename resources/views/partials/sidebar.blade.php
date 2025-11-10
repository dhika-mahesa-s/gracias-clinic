<aside class="w-64 bg-sidebar shadow-xl border-r border-sidebar-border hidden lg:block animate-slide-right">
    {{-- Sidebar Header --}}
    <div class="p-6 border-b border-sidebar-border bg-sidebar-accent mt-8">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary rounded-xl shadow-lg">
                <i class="fa-solid fa-hospital text-primary-foreground text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-sidebar-foreground">Admin Panel</h2>
                <p class="text-xs text-sidebar-foreground/70">Gracias Clinic</p>
            </div>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="p-4">
        <ul class="space-y-2">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('admin.dashboard') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('admin.dashboard') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-chart-line {{ Route::is('admin.dashboard') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                </a>
            </li>

            {{-- Kelola Reservasi --}}
            <li>
                <a href="{{ route('reservasi.admin') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('reservasi.admin') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('reservasi.admin') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-calendar-check {{ Route::is('reservasi.admin') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola Reservasi</span>
                </a>
            </li>

            {{-- Riwayat Reservasi --}}
            <li>
                <a href="{{ route('admin.reservations.history') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('admin.reservations.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('admin.reservations.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-clock-rotate-left {{ Route::is('admin.reservations.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Riwayat Reservasi</span>
                </a>
            </li>

            {{-- Kelola Treatment --}}
            <li>
                <a href="{{ route('treatments.manage') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('treatments.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('treatments.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-spa {{ Route::is('treatments.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola Treatment</span>
                </a>
            </li>

            {{-- Kelola Diskon --}}
            <li>
                <a href="{{ route('admin.discounts.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('admin.discounts.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('admin.discounts.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-tags {{ Route::is('admin.discounts.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola Diskon</span>
                </a>
            </li>

            {{-- Kelola Jadwal --}}
            <li>
                <a href="{{ route('schedules.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('schedules.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('schedules.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-regular fa-calendar-days {{ Route::is('schedules.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola Jadwal</span>
                </a>
            </li>

            {{-- Kelola FAQ --}}
            <li>
                <a href="{{ route('admin.faq.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('admin.faq.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('admin.faq.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-circle-question {{ Route::is('admin.faq.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola FAQ</span>
                </a>
            </li>

            {{-- Kelola Feedback --}}
            <li>
                <a href="{{ route('admin.feedback.index') }}"
                   class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-smooth hover-scale-sm active-press
                   {{ Route::is('admin.feedback.*') ? 'bg-primary text-primary-foreground shadow-lg' : 'hover:bg-sidebar-accent text-sidebar-foreground' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-smooth
                        {{ Route::is('admin.feedback.*') ? 'bg-primary-foreground/20' : 'bg-sidebar-accent group-hover:bg-primary/10' }}">
                        <i class="fa-solid fa-comments {{ Route::is('admin.feedback.*') ? 'text-primary-foreground' : 'text-sidebar-foreground/70 group-hover:text-primary' }}"></i>
                    </div>
                    <span class="font-semibold">Kelola Feedback</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
