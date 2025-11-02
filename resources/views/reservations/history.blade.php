@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="px-4 py-8 max-w-7xl mx-auto">

    {{-- HEADER DAN FILTER --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-border">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl md:text-3xl font-semibold text-foreground">Riwayat Reservasi</h1>

            <a href="javascript:history.back()" class="text-muted-foreground hover:text-primary font-medium flex items-center space-x-1 p-2 rounded-lg bg-secondary hover:bg-accent text-sm">
                <span class="text-lg leading-none">&larr;</span>
                <span>Kembali</span>
            </a>
        </div>

        {{-- SEARCH BAR --}}
        <form action="{{ route('reservations.history') }}" method="GET" class="flex items-center bg-background rounded-lg p-3 border border-border">
            <i class="fa-solid fa-search text-muted-foreground mr-3"></i>
            <input type="text" name="search" class="flex-grow focus:outline-none focus:ring-0 border-none text-foreground bg-transparent text-sm" placeholder="Cari Kode Booking, Treatment, atau Dokter..." value="{{ request('search') }}">
            <button type="submit" class="text-sm font-medium text-primary hover:text-primary/80 px-3 border-l border-border ml-3">
                Cari
            </button>
        </form>

        {{-- FILTER DROPDOWNS --}}
        <form id="filter-form" action="{{ route('reservations.history') }}" method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <div class="flex flex-wrap items-center space-x-2 mt-4 text-sm">
                <label for="status-filter" class="text-muted-foreground font-medium">Filter:</label>
                <select name="status" id="status-filter" onchange="document.getElementById('filter-form').submit()" class="px-3 py-1.5 border border-border rounded-lg shadow-sm focus:ring-ring focus:border-primary bg-white text-foreground">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Mendatang (Confirmed)</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Selesai (Completed)</option>
                    <option value="cancel" {{ request('status')=='cancel'?'selected':'' }}>Dibatalkan</option>
                </select>
            </div>
        </form>
    </div>

    {{-- STATS CARDS --}}
    @php $stats = $stats ?? ['total' => 0, 'pending' => 0, 'upcoming' => 0, 'done' => 0, 'cancelled' => 0]; @endphp
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-card p-4 rounded-xl shadow-md border border-border text-center">
            <h3 class="text-3xl font-bold text-foreground">{{ $stats['total'] ?? 0 }}</h3><small class="text-muted-foreground">Total Reservasi</small>
        </div>
        <div class="bg-card p-4 rounded-xl shadow-md border border-border text-center">
            <h3 class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] ?? 0 }}</h3><small class="text-muted-foreground">Pending</small>
        </div>
        <div class="bg-card p-4 rounded-xl shadow-md border border-border text-center">
            <h3 class="text-3xl font-bold text-blue-500">{{ $stats['upcoming'] ?? 0 }}</h3><small class="text-muted-foreground">Mendatang</small>
        </div>
        <div class="bg-card p-4 rounded-xl shadow-md border border-border text-center">
            <h3 class="text-3xl font-bold text-green-500">{{ $stats['done'] ?? 0 }}</h3><small class="text-muted-foreground">Selesai</small>
        </div>
        <div class="bg-card p-4 rounded-xl shadow-md border border-border text-center">
            <h3 class="text-3xl font-bold text-red-500">{{ $stats['cancelled'] ?? 0 }}</h3><small class="text-muted-foreground">Dibatalkan</small>
        </div>
    </div>

    {{-- MAIN RESERVATION LIST --}}
    <div class="space-y-4">
        @forelse($reservations as $r)

        <div class="bg-white p-5 rounded-xl shadow-lg border border-border">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                <div class="flex-grow">
                    <div class="flex items-center mb-3">
                        <h5 class="text-xl font-bold mr-3 text-card-foreground">{{ optional($r->treatment)->name ?? '—' }}</h5>
                        @php
                        $status = strtolower($r->status);
                        $statusClass = ['completed' => 'bg-green-100 text-green-700','confirmed' => 'bg-indigo-100 text-indigo-700','pending' => 'bg-yellow-100 text-yellow-700','cancel' => 'bg-red-100 text-red-700',][$status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($r->status) }}</span>
                    </div>

                    {{-- Detail Row (FIX: Menggunakan Grid) --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-muted-foreground mb-4">
                        <div class="flex items-center space-x-2"><i class="fa-solid fa-calendar text-gray-400"></i><span>{{ optional($r->tanggal)->format('d M Y') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><i class="fa-solid fa-clock text-gray-400"></i><span>{{ \Carbon\Carbon::parse($r->waktu)->format('H:i') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><i class="fa-solid fa-user-doctor text-gray-400"></i><span>{{ optional($r->doctor)->name ?? 'Dr. -' }}</span></div>
                        <div class="font-bold text-foreground">Rp {{ number_format($r->harga ?? 0, 0, ',', '.') }}</div>
                    </div>

                    <div class="text-xs text-gray-400 mb-4">
                        Booking ID: {{ $r->booking_id ?? '-' }} • Dibuat: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }}
                    </div>

                    {{-- TOMBOL CETAK RESI --}}
                    <div class="flex justify-end space-x-3 mt-3"> <a href="{{ route('reservasi.cetak', $r->reservation_code) }}" target="_blank"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 shadow-md hover:shadow-lg hover:from-green-600 hover:to-green-700 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                            <i class="fa-solid fa-file-pdf"></i> Download Resi (PDF)
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="bg-card p-6 md:p-10 rounded-xl shadow-lg border border-border text-center">
            <h5 class="text-xl font-medium text-muted-foreground mb-4">Belum ada riwayat reservasi yang cocok dengan filter Anda.</h5>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="flex justify-center pt-4">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection