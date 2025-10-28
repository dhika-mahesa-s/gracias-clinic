@extends('layouts.app')

@section('title', 'Manajemen Reservasi')

@section('content')
{{-- HERO/HEADER SECTION (ADMIN LOOK) --}}
<div class="px-4 py-6 sm:px-6 lg:px-8 bg-indigo-700 text-white border-b border-gray-900">
    <div class="flex items-center space-x-2 mb-4">
        <h1 class="text-2xl font-semibold">Manajemen Reservasi</h1>
    </div>

    {{-- SEARCH & FILTER ADMIN (Bisa filter Customer) --}}
    <form action="{{ route('admin.reservations.history') }}" method="GET" class="flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-3">
        {{-- Search Input (Mencari User Name, Doctor Name, Treatment) --}}
        <div class="relative flex-grow">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" class="w-full pl-10 pr-4 py-2 border border-indigo-400 bg-indigo-600 text-white rounded-lg focus:ring-white focus:border-white text-sm placeholder-indigo-200" placeholder="Cari Pasien, Dokter, atau Treatment..." value="{{ request('search') }}">
        </div>

        {{-- Dropdowns --}}
        <select name="status" class="px-4 py-2 border border-indigo-400 bg-indigo-600 text-white rounded-lg shadow-sm text-sm focus:ring-white focus:border-white">
            <option value="">Semua Status</option>
            <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
            <option value="Dikonfirmasi" {{ request('status')=='Dikonfirmasi'?'selected':'' }}>Dikonfirmasi</option>
            <option value="Selesai" {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
            <option value="Dibatalkan" {{ request('status')=='Dibatalkan'?'selected':'' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-white text-indigo-700 rounded-lg shadow-md hover:bg-gray-100 text-sm font-semibold">
            Filter
        </button>
    </form>
</div>

{{-- STATS CARDS --}}
@php $stats = $stats ?? ['total' => 0, 'done' => 0, 'upcoming' => 0, 'cancelled' => 0]; @endphp
<div class="container mx-auto px-4 mt-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-100 text-center">
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3><small class="text-gray-500">Total Reservasi</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-100 text-center">
            <h3 class="text-2xl font-bold text-green-500">{{ $stats['done'] }}</h3><small class="text-gray-500">Selesai</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-100 text-center">
            <h3 class="text-2xl font-bold text-blue-500">{{ $stats['upcoming'] }}</h3><small class="text-gray-500">Mendatang</small>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md border border-gray-100 text-center">
            <h3 class="text-2xl font-bold text-red-500">{{ $stats['cancelled'] }}</h3><small class="text-gray-500">Dibatalkan</small>
        </div>
    </div>

    {{-- MAIN RESERVATION LIST (Dengan Nama Pasien & Tombol Admin) --}}
    <div class="space-y-4">
        @if(isset($reservations) && $reservations->count() > 0)
        @foreach($reservations as $r)

        {{-- Item Card --}}
        <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-100">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">

                {{-- Kiri (Detail) --}}
                <div class="flex-grow">
                    <div class="text-xs font-medium text-gray-500 mb-1">Pasien: {{ optional($r->user)->name ?? 'User Dihapus' }}</div>
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
                        Booking ID: {{ $r->booking_id ?? '-' }}
                    </div>

                    {{-- Tombol Aksi Admin --}}
                    <div class="flex space-x-3">
                        <button class="flex items-center space-x-1 px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-lg shadow-sm hover:bg-indigo-50 text-sm font-medium" data-id="{{ $r->id}}" onclick="openReservationDetail(this.dataset.id)">
                            <span>Detail</span>
                        </button>

                        @if($r->status == 'Pending')
                        <form action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi reservasi ini?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg text-sm hover:bg-yellow-600 font-medium">Konfirmasi</button>
                        </form>
                        @elseif($r->status == 'Dikonfirmasi')
                        {{-- Tombol Selesai (Pastikan route 'admin.reservasi.selesai' ada) --}}
                        <form action="{{ route('reservations.cancel', $r) }}" method="POST" class="inline" onsubmit="return confirm('Tandai sebagai selesai?')"> {{-- GANTI ROUTE INI JIKA ADA RUTE SELESAI --}}
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600 font-medium">Selesai</button>
                        </form>
                        @endif

                        @if(!in_array($r->status, ['Selesai', 'Dibatalkan']))
                        <form action="{{ route('reservations.cancel', $r) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan reservasi ini?')">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 font-medium">Batalkan</button>
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
            <h5 class="text-xl font-medium text-gray-700 mb-4">Tidak ada reservasi ditemukan.</h5>
        </div>
        @endif
    </div>
</div>

@include('partials.detail-modal')
<script src="{{ asset('js/reservations-history.js') }}"></script>
@endsection