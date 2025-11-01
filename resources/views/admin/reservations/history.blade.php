@extends('layouts.dashboard')

@section('title', 'Manajemen Reservasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- HEADER DAN FILTER ADMIN --}}
    <div class="bg-card p-6 rounded-xl shadow-lg mb-8 border border-border">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl md:text-3xl font-semibold text-foreground">Manajemen Reservasi</h1>

            <a href="javascript:history.back()" class="text-muted-foreground hover:text-primary font-medium flex items-center space-x-1 p-2 rounded-lg bg-secondary hover:bg-accent text-sm">
                <span class="text-lg leading-none">&larr;</span>
                <span>Kembali</span>
            </a>
        </div>

        {{-- SEARCH BAR ADMIN --}}
        <form action="{{ route('admin.reservations.history') }}" method="GET" class="flex items-center bg-background rounded-lg p-3 border border-border">
            <i class="fa-solid fa-search text-muted-foreground mr-3"></i>
            <input type="text" name="search" class="flex-grow focus:outline-none focus:ring-0 border-none text-foreground bg-transparent text-sm" placeholder="Cari Pasien, Kode Booking, Treatment, atau Dokter..." value="{{ request('search') }}">
            <button type="submit" class="text-sm font-medium text-primary hover:text-primary/80 px-3 border-l border-border ml-3">
                Cari
            </button>
        </form>

        {{-- FILTER DROPDOWNS --}}
        <form id="filter-form-admin" action="{{ route('admin.reservations.history') }}" method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <div class="flex flex-wrap items-center space-x-2 mt-4 text-sm">
                <label for="status-filter-admin" class="text-muted-foreground font-medium">Filter:</label>
                <select name="status" id="status-filter-admin" onchange="document.getElementById('filter-form-admin').submit()" class="px-3 py-1.5 border border-border rounded-lg shadow-sm focus:ring-ring focus:border-primary bg-card text-foreground">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Mendatang (Confirmed)</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Selesai (Completed)</option>
                    <option value="cancel" {{ request('status')=='cancel'?'selected':'' }}>Dibatalkan (Cancel)</option>
                </select>
            </div>
        </form>

        {{-- Tombol Cetak Laporan --}}
        <div class="flex justify-end mt-4">
            <a href="{{ route('admin.reservations.print', request()->query()) }}" target="_blank"
                class="inline-flex items-center space-x-2 px-4 py-2 bg-primary text-primary-foreground rounded-lg shadow-md hover:bg-primary/80 transition font-medium text-sm">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
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

        <div class="bg-card p-5 rounded-xl shadow-lg border border-border">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">

                <div class="flex-grow">
                    <div class="text-xs font-medium text-muted-foreground mb-1">Pasien: {{ optional($r->user)->name ?? 'User Dihapus' }}</div>
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
                        Booking ID: {{ $r->booking_id ?? '-' }}
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="bg-card p-6 md:p-10 rounded-xl shadow-lg border border-border text-center">
            <h5 class="text-xl font-medium text-muted-foreground mb-4">Tidak ada reservasi ditemukan yang cocok dengan filter Anda.</h5>
        </div>
        @endforelse

        <div class="flex justify-center pt-4">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection