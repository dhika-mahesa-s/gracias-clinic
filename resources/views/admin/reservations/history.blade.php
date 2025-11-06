@extends('layouts.dashboard')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-7xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2 flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-primary to-primary/80 rounded-xl shadow-lg">
                            <i class="fa-solid fa-clock-rotate-left text-primary-foreground text-2xl"></i>
                        </div>
                        Riwayat Reservasi
                    </h1>
                    <p class="text-muted-foreground ml-16 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-xs"></i>
                        Lihat semua riwayat reservasi customer
                    </p>
                </div>
                
                <a href="{{ route('admin.reservations.print', request()->query()) }}" target="_blank"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
                    <i class="fa-solid fa-print text-lg"></i>
                    <span>Cetak Laporan</span>
                </a>
            </div>
        </div>

        {{-- FILTER & SEARCH SECTION --}}
        <div class="bg-card rounded-2xl shadow-md border border-border p-6 mb-6 animate-slide-down">
            {{-- SEARCH BAR --}}
            <form action="{{ route('admin.reservations.history') }}" method="GET" class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-muted-foreground"></i>
                    </div>
                    <input type="text" name="search" 
                        class="w-full pl-11 pr-24 py-3 border border-input rounded-xl focus:ring-2 focus:ring-ring focus:border-input transition-smooth bg-background text-foreground" 
                        placeholder="Cari Kode Booking, Treatment, atau Dokter..." 
                        value="{{ request('search') }}">
                    <button type="submit" 
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-1.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg text-sm font-semibold transition-smooth hover-scale-sm active-press">
                        Cari
                    </button>
                </div>
            </form>

            {{-- FILTER DROPDOWNS --}}
            <form id="filter-form-admin" action="{{ route('admin.reservations.history') }}" method="GET">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <div class="flex flex-wrap items-center gap-3">
                    <label class="text-sm font-semibold text-foreground">Filter Status:</label>
                    <select name="status" id="status-filter-admin" onchange="document.getElementById('filter-form-admin').submit()" 
                        class="px-4 py-2 border border-input rounded-xl shadow-sm focus:ring-2 focus:ring-ring focus:border-input bg-background text-foreground font-medium transition-smooth">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Confirmed</option>
                        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- STATS CARDS --}}
        @php $stats = $stats ?? ['total' => 0, 'pending' => 0, 'upcoming' => 0, 'done' => 0, 'cancelled' => 0]; @endphp
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-gradient-to-br from-card to-card/80 rounded-xl shadow-md border border-border p-5 text-center hover:shadow-lg transition-smooth animate-scale-in delay-75 hover-lift group">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                    <i class="fa-solid fa-list-check text-primary-foreground text-lg"></i>
                </div>
                <div class="text-3xl font-bold text-card-foreground mb-1">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-xs text-muted-foreground font-semibold">Total Reservasi</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-xl shadow-md border border-yellow-200 p-5 text-center hover:shadow-lg transition-smooth animate-scale-in delay-100 hover-lift group">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                    <i class="fa-solid fa-clock text-white text-lg"></i>
                </div>
                <div class="text-3xl font-bold text-yellow-700 mb-1">{{ $stats['pending'] ?? 0 }}</div>
                <div class="text-xs text-yellow-600 font-semibold">Pending</div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl shadow-md border border-blue-200 p-5 text-center hover:shadow-lg transition-smooth animate-scale-in delay-150 hover-lift group">
                <div class="w-12 h-12 bg-blue-500 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                    <i class="fa-solid fa-check text-white text-lg"></i>
                </div>
                <div class="text-3xl font-bold text-blue-700 mb-1">{{ $stats['upcoming'] ?? 0 }}</div>
                <div class="text-xs text-blue-600 font-semibold">Confirmed</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl shadow-md border border-green-200 p-5 text-center hover:shadow-lg transition-smooth animate-scale-in delay-200 hover-lift group">
                <div class="w-12 h-12 bg-green-500 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                    <i class="fa-solid fa-circle-check text-white text-lg"></i>
                </div>
                <div class="text-3xl font-bold text-green-700 mb-1">{{ $stats['done'] ?? 0 }}</div>
                <div class="text-xs text-green-600 font-semibold">Completed</div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl shadow-md border border-red-200 p-5 text-center hover:shadow-lg transition-smooth animate-scale-in delay-250 hover-lift group">
                <div class="w-12 h-12 bg-red-500 rounded-xl mx-auto mb-3 flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                    <i class="fa-solid fa-times text-white text-lg"></i>
                </div>
                <div class="text-3xl font-bold text-red-700 mb-1">{{ $stats['cancelled'] ?? 0 }}</div>
                <div class="text-xs text-red-600 font-semibold">Cancelled</div>
            </div>
        </div>

        {{-- RESERVATION LIST --}}
        <div class="space-y-4">
            @forelse($reservations as $index => $r)
                @php
                    $delays = ['', 'delay-75', 'delay-100', 'delay-150'];
                    $delayClass = $delays[$index % 4] ?? '';
                @endphp
                <div class="bg-gradient-to-br from-card to-card/50 rounded-2xl shadow-lg hover:shadow-xl transition-smooth border border-border overflow-hidden animate-slide-up {{ $delayClass }} hover-lift group">
                    {{-- Header with Treatment Name and Status --}}
                    <div class="bg-gradient-to-r from-primary/10 to-primary/5 px-6 py-4 border-b border-border">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                    <i class="fa-solid fa-spa text-primary-foreground text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-card-foreground group-hover:text-primary transition-smooth">{{ optional($r->treatment)->name ?? '—' }}</h3>
                                    <p class="text-xs text-muted-foreground">
                                        <i class="fa-solid fa-hashtag mr-1"></i>
                                        <span class="font-semibold">{{ $r->booking_id ?? '-' }}</span>
                                    </p>
                                </div>
                            </div>
                            @php
                                $status = strtolower($r->status);
                                $statusConfig = [
                                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-300', 'icon' => 'fa-circle-check'],
                                    'confirmed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-300', 'icon' => 'fa-check'],
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-300', 'icon' => 'fa-clock'],
                                    'cancel' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-300', 'icon' => 'fa-times'],
                                ];
                                $config = $statusConfig[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'border' => 'border-gray-300', 'icon' => 'fa-question'];
                            @endphp
                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} shadow-sm">
                                <i class="fa-solid {{ $config['icon'] }}"></i>
                                {{ ucfirst($r->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Body with Details --}}
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl border border-blue-100 hover:border-blue-200 transition-smooth">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-calendar text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600 font-semibold mb-0.5">Tanggal</p>
                                    <p class="text-sm font-bold text-blue-900">{{ optional($r->tanggal)->format('d M Y') ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100 hover:border-purple-200 transition-smooth">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-clock text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-purple-600 font-semibold mb-0.5">Waktu</p>
                                    <p class="text-sm font-bold text-purple-900">{{ \Carbon\Carbon::parse($r->waktu)->format('H:i') ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-green-50 rounded-xl border border-green-100 hover:border-green-200 transition-smooth">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-user-doctor text-white"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600 font-semibold mb-0.5">Dokter</p>
                                    <p class="text-sm font-bold text-green-900">{{ optional($r->doctor)->name ?? 'Dr. -' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl border border-primary/20 hover:border-primary/30 transition-smooth">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-primary to-primary/80 rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-money-bill-wave text-primary-foreground"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-primary font-semibold mb-0.5">Harga</p>
                                    <p class="text-sm font-bold text-primary">Rp {{ number_format($r->harga ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-card rounded-2xl shadow-lg border border-border p-20 text-center animate-fade-in">
                    <div class="w-24 h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-inbox text-7xl text-muted-foreground"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-card-foreground mb-2">Tidak Ada Reservasi</h3>
                    <p class="text-muted-foreground text-lg">Tidak ada reservasi yang cocok dengan filter Anda.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($reservations->hasPages())
            <div class="mt-8 flex items-center justify-center animate-fade-in delay-200">
                <nav class="inline-flex items-center gap-2 bg-card rounded-xl shadow-md border border-border p-2">
                    {{-- Previous --}}
                    @if ($reservations->onFirstPage())
                        <span class="px-3 py-2 text-muted-foreground cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $reservations->previousPageUrl() }}"
                            class="px-3 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-smooth">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pages --}}
                    @for ($page = 1; $page <= $reservations->lastPage(); $page++)
                        @if ($page == $reservations->currentPage())
                            <span class="px-4 py-2 bg-primary text-primary-foreground font-semibold rounded-lg shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $reservations->url($page) }}"
                                class="px-4 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-smooth">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if ($reservations->hasMorePages())
                        <a href="{{ $reservations->nextPageUrl() }}"
                            class="px-3 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-smooth">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-3 py-2 text-muted-foreground cursor-not-allowed">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</div>
@endsection