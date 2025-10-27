@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="px-4 py-8">

    {{-- HEADER DAN FILTER --}}
    <div class="mb-6">
        <div class="flex items-center space-x-4 mb-4">
            {{-- Tombol Kembali - Sederhana --}}
            <a href="javascript:history.back()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                <span class="mr-1 text-xl leading-none">&larr;</span>
                <span>Kembali</span>
            </a>
            <h1 class="text-3xl font-semibold text-gray-800">Riwayat Reservasi</h1>
        </div>

        {{-- SEARCH BAR --}}
        <form action="{{ route('reservations.history') }}" method="GET" class="flex items-center bg-white rounded-xl shadow-sm p-3 border border-gray-200">
            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" class="flex-grow focus:outline-none text-gray-700" placeholder="Cari by ID, treatment, atau dokter..." value="{{ request('search') }}">
            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-800 px-3 border-l border-gray-200 ml-3">
                Filter
            </button>
        </form>

        {{-- FILTER DROPDOWNS --}}
        <div class="flex flex-wrap space-x-2 mt-4 text-sm">
            <select name="status" class="px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Status</option>
                <option value="Dikonfirmasi" {{ request('status')=='Dikonfirmasi'?'selected':'' }}>Dikonfirmasi</option>
                <option value="Selesai" {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                <option value="Dibatalkan" {{ request('status')=='Dibatalkan'?'selected':'' }}>Dibatalkan</option>
            </select>
            <select class="px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm">
                <option>Semua Tanggal</option>
            </select>
            <select class="px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm">
                <option>Semua Dokter</option>
            </select>
            <select class="px-3 py-1.5 border border-gray-300 rounded-lg shadow-sm">
                <option>Semua Treatment</option>
            </select>
        </div>
    </div>

    {{-- STATS CARDS --}}
    @php $stats = $stats ?? ['total' => 0, 'done' => 0, 'upcoming' => 0, 'cancelled' => 0]; @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</h3><small class="text-gray-500">Total Reservasi</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-green-500">{{ $stats['done'] }}</h3><small class="text-gray-500">Selesai</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-blue-500">{{ $stats['upcoming'] }}</h3><small class="text-gray-500">Mendatang</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-center">
            <h3 class="text-3xl font-bold text-red-500">{{ $stats['cancelled'] }}</h3><small class="text-gray-500">Dibatalkan</small>
        </div>
    </div>

    {{-- MAIN RESERVATION LIST --}}
    <div class="space-y-4">
        @if(isset($reservations) && $reservations->count() > 0)
        @foreach($reservations as $r)

        {{-- Item Card --}}
        <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-100">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">

                <div class="flex-grow">
                    <div class="flex items-center mb-3">
                        <h5 class="text-xl font-bold mr-3">{{ optional($r->treatment)->name ?? '—' }}</h5>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                            {{ $r->status }}
                        </span>
                    </div>

                    {{-- Detail Row --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-600 mb-4">
                        <div class="flex items-center space-x-2"><span>{{ optional($r->tanggal)->format('d M Y') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><span>{{ \Carbon\Carbon::parse($r->waktu)->format('H:i') ?? '-' }}</span></div>
                        <div class="flex items-center space-x-2"><span>{{ optional($r->doctor)->name ?? 'Dr. -' }}</span></div>
                        <div class="font-bold text-gray-800">Rp {{ number_format($r->harga ?? 0, 0, ',', '.') }}</div>
                    </div>

                    <div class="text-xs text-gray-400 mb-4">
                        Booking ID: {{ $r->booking_id ?? '-' }} • Dibuat: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }}
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex space-x-3">
                        <button class="flex items-center space-x-1 px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-lg shadow-sm hover:bg-indigo-50 text-sm font-medium" data-id="{{ $r->id}}" onclick="openReservationDetail(this.dataset.id)">
                            <span>Detail</span>
                        </button>

                        @if(in_array($r->status, ['Pending','Dikonfirmasi']) && auth()->check() && auth()->id() == $r->user_id)
                        <form action="{{ route('reservations.cancel', $r) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan reservasi ini?')">
                            @csrf
                            <button class="flex items-center space-x-1 px-4 py-2 bg-red-500 text-white rounded-lg shadow-sm hover:bg-red-600 text-sm font-medium">
                                <span>Batal</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex justify-center pt-4">
            {{ $reservations->links('vendor.pagination.tailwind') }}
        </div>

        @else
        <div class="bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-100 text-center">
            <h5 class="text-xl font-medium text-gray-700 mb-4">Belum ada riwayat reservasi</h5>
        </div>
        @endif
    </div>
</div>

@include('partials.detail-modal')
<script src="{{ asset('js/reservations-history.js') }}"></script>
@endsection