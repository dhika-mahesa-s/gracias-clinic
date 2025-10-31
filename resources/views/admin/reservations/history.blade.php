@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="px-4 py-8">

    {{-- HEADER DAN FILTER --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8 border border-gray-100">
        <div class="flex items-center space-x-3 mb-4">
            <a href="javascript:history.back()" class="text-gray-700 hover:text-indigo-600 font-medium flex items-center space-x-1 p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">
                <span class="text-lg leading-none">&larr;</span>
                <span>Kembali</span>
            </a>
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">Riwayat Reservasi</h1>
        </div>

        {{-- SEARCH BAR --}}
        <form action="{{ route('reservations.history') }}" method="GET" class="flex items-center bg-gray-50 rounded-lg p-3 border border-gray-200">
            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" class="flex-grow focus:outline-none text-gray-700 bg-transparent text-sm" placeholder="Cari Kode Booking, Treatment, atau Dokter..." value="{{ request('search') }}">
            <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 px-3 border-l border-gray-300 ml-3">
                Cari
            </button>
        </form>

        {{-- FILTER DROPDOWNS --}}
        <form id="filter-form" action="{{ route('reservations.history') }}" method="GET">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <div class="flex flex-wrap items-center space-x-2 mt-4 text-sm">
                <label for="status-filter" class="text-gray-600 font-medium">Filter:</label>
                <select name="status" id="status-filter" onchange="document.getElementById('filter-form').submit()" class="px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>Mendatang (Confirmed)</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status')=='dibatalkan'?'selected':'' }}>Dibatalkan</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Tombol Cetak Laporan --}}
        <div class="flex justify-end mt-4">
            <a href="{{ route('admin.reservations.print', request()->query()) }}" target="_blank"
                class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition font-medium text-sm">
                <i class="bi bi-printer"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>
    
    {{-- STATS CARDS --}}
    @php $stats = $stats ?? ['total' => 0, 'pending' => 0, 'upcoming' => 0, 'done' => 0, 'cancelled' => 0]; @endphp
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</h3><small class="text-gray-500">Total Reservasi</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] ?? 0 }}</h3><small class="text-gray-500">Pending</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-blue-500">{{ $stats['upcoming'] ?? 0 }}</h3><small class="text-gray-500">Mendatang</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-green-500">{{ $stats['done'] ?? 0 }}</h3><small class="text-gray-500">Selesai</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-red-500">{{ $stats['cancelled'] ?? 0 }}</h3><small class="text-gray-500">Dibatalkan</small>
        </div>
    </div>

    {{-- MAIN RESERVATION LIST --}}
    <div class="space-y-4">
        @forelse($reservations as $r)

        <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-100">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                <div class="flex-grow">
                    <div class="flex items-center mb-3">
                        <h5 class="text-xl font-bold mr-3">{{ optional($r->treatment)->name ?? '—' }}</h5>
                        @php
                        $status = strtolower($r->status);
                        $statusClass = ['completed' => 'bg-green-100 text-green-700','confirmed' => 'bg-indigo-100 text-indigo-700','pending' => 'bg-yellow-100 text-yellow-700','dibatalkan' => 'bg-red-100 text-red-700',][$status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ ucfirst($r->status) }}</span>
                    </div>

                    {{-- Detail Row --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-600 mb-4">
                        <div class="flex items-center space-x-2"><i class="bi bi-calendar text-gray-400"></i><span>{{ optional($r->tanggal)->format('d M Y') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><i class="bi bi-clock text-gray-400"></i><span>{{ \Carbon\Carbon::parse($r->waktu)->format('H:i') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><i class="bi bi-person text-gray-400"></i><span>{{ optional($r->doctor)->name ?? 'Dr. -' }}</span></div>
                        <div class="font-bold text-gray-800">Rp {{ number_format($r->harga ?? 0, 0, ',', '.') }}</div>
                    </div>

                    <div class="text-xs text-gray-400 mb-4">
                        Booking ID: {{ $r->booking_id ?? '-' }} • Dibuat: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-100 text-center">
            <h5 class="text-xl font-medium text-gray-700 mb-4">Belum ada riwayat reservasi yang cocok dengan filter Anda.</h5>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="flex justify-center pt-4">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

@endsection