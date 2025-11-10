@extends('layouts.dashboard')

@section('title', 'Kelola Reservasi - Gracias Aesthetic Clinic')

@section('content')
<section class="min-h-screen bg-background py-8 px-3 sm:px-4 lg:px-6 mt-4">
    <div class="max-w-full mx-auto">

        {{-- Header Section --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2 flex items-center gap-3">
                            <div class="p-3 bg-gradient-to-br from-primary to-primary/80 rounded-xl shadow-lg">
                                <i class="fa-solid fa-calendar-check text-primary-foreground text-2xl"></i>
                            </div>
                            Kelola Reservasi
                        </h1>
                        <p class="text-muted-foreground ml-16 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-xs"></i>
                            Manajemen dan monitoring reservasi customer
                        </p>
                    </div>
                </div>
                
                {{-- Enhanced Quick Stats --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @php
                        $pending = $reservations->where('status', 'pending')->count();
                        $confirmed = $reservations->where('status', 'confirmed')->count();
                        $completed = $reservations->where('status', 'completed')->count();
                        $cancelled = $reservations->where('status', 'cancelled')->count();
                    @endphp
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-xl p-5 shadow-md border border-yellow-200 animate-scale-in delay-75 hover-lift transition-smooth group">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2.5 bg-yellow-500 rounded-lg shadow-sm group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-clock text-white text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-yellow-700 bg-yellow-200 px-2 py-1 rounded-full">Pending</span>
                        </div>
                        <div class="text-3xl font-bold text-yellow-700 mb-1">{{ $pending }}</div>
                        <div class="text-xs text-yellow-600 font-medium">Menunggu Konfirmasi</div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-5 shadow-md border border-blue-200 animate-scale-in delay-100 hover-lift transition-smooth group">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2.5 bg-blue-500 rounded-lg shadow-sm group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-check text-white text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Confirmed</span>
                        </div>
                        <div class="text-3xl font-bold text-blue-700 mb-1">{{ $confirmed }}</div>
                        <div class="text-xs text-blue-600 font-medium">Sudah Dikonfirmasi</div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-5 shadow-md border border-green-200 animate-scale-in delay-150 hover-lift transition-smooth group">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2.5 bg-green-500 rounded-lg shadow-sm group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-circle-check text-white text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Completed</span>
                        </div>
                        <div class="text-3xl font-bold text-green-700 mb-1">{{ $completed }}</div>
                        <div class="text-xs text-green-600 font-medium">Treatment Selesai</div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-5 shadow-md border border-red-200 animate-scale-in delay-200 hover-lift transition-smooth group">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2.5 bg-red-500 rounded-lg shadow-sm group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-times text-white text-lg"></i>
                            </div>
                            <span class="text-xs font-semibold text-red-700 bg-red-200 px-2 py-1 rounded-full">Cancelled</span>
                        </div>
                        <div class="text-3xl font-bold text-red-700 mb-1">{{ $cancelled }}</div>
                        <div class="text-xs text-red-600 font-medium">Dibatalkan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3 shadow-sm animate-slide-down">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @elseif(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 flex items-center gap-3 shadow-sm animate-slide-down">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-info text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-blue-800 font-medium">{{ session('info') }}</p>
                </div>
            </div>
        @elseif(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3 shadow-sm animate-slide-down">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-exclamation text-red-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Desktop Table View --}}
        <div class="hidden lg:block bg-card rounded-2xl shadow-lg border border-border overflow-hidden animate-slide-up delay-100">
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead class="bg-gradient-to-r from-primary/10 to-primary/5 border-b-2 border-primary/20">
                        <tr>
                            <th class="w-32 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-hashtag text-primary"></i>
                                    Kode
                                </div>
                            </th>
                            <th class="w-40 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user text-primary"></i>
                                    Customer
                                </div>
                            </th>
                            <th class="w-36 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-spa text-primary"></i>
                                    Treatment
                                </div>
                            </th>
                            <th class="w-32 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user-doctor text-primary"></i>
                                    Dokter
                                </div>
                            </th>
                            <th class="w-28 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days text-primary"></i>
                                    Jadwal
                                </div>
                            </th>
                            <th class="w-24 px-4 py-4 text-left text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-dot text-primary"></i>
                                    Status
                                </div>
                            </th>
                            <th class="w-32 px-4 py-4 text-center text-xs font-bold text-card-foreground uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-bolt text-primary"></i>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-card divide-y divide-border">
                        @forelse ($reservations as $r)
                            <tr class="hover:bg-primary/5 transition-smooth group">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-10 bg-primary rounded-full opacity-0 group-hover:opacity-100 transition-smooth"></div>
                                        <span class="text-sm font-bold text-primary">{{ $r->reservation_code }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/70 rounded-full flex items-center justify-center text-primary-foreground font-bold text-sm shadow-md">
                                            {{ strtoupper(substr($r->customer_name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-card-foreground group-hover:text-primary transition-smooth">{{ $r->customer_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-sm text-card-foreground font-medium" title="{{ $r->treatment->name }}">{{ Str::limit($r->treatment->name, 25) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-stethoscope text-primary text-xs"></i>
                                        <span class="text-sm font-medium text-card-foreground">{{ $r->doctor->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5 text-xs text-card-foreground">
                                            <i class="fa-solid fa-calendar text-primary text-xs"></i>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs text-muted-foreground">
                                            <i class="fa-solid fa-clock text-primary text-xs"></i>
                                            <span>{{ $r->reservation_time }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    @switch($r->status)
                                        @case('pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-300 shadow-sm">
                                                <i class="fa-solid fa-clock"></i>
                                                Pending
                                            </span>
                                        @break
                                        @case('confirmed')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300 shadow-sm">
                                                <i class="fa-solid fa-check"></i>
                                                Confirmed
                                            </span>
                                        @break
                                        @case('completed')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300 shadow-sm">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Completed
                                            </span>
                                        @break
                                        @case('cancelled')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-300 shadow-sm">
                                                <i class="fa-solid fa-times"></i>
                                                Cancelled
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($r->status === 'pending')
                                            <form id="confirm-form-{{ $r->id }}" action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" onclick="openModal('confirm', {{ $r->id }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-smooth hover-scale-sm active-press shadow-md hover:shadow-lg"
                                                    title="Konfirmasi">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                            <form id="cancel-form-{{ $r->id }}" action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-smooth hover-scale-sm active-press shadow-md hover:shadow-lg"
                                                    title="Batalkan">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </form>
                                        @elseif ($r->status === 'confirmed')
                                            <form id="done-form-{{ $r->id }}" action="{{ route('admin.reservasi.selesai', $r->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" onclick="openModal('done', {{ $r->id }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-smooth hover-scale-sm active-press shadow-md hover:shadow-lg"
                                                    title="Selesai">
                                                    <i class="fa-solid fa-check-double"></i>
                                                </button>
                                            </form>
                                            <form id="cancel-form-{{ $r->id }}" action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-smooth hover-scale-sm active-press shadow-md hover:shadow-lg"
                                                    title="Batalkan">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-muted-foreground italic px-4 py-2 bg-muted rounded-lg">Selesai</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-inbox text-5xl text-muted-foreground"></i>
                                        </div>
                                        <p class="text-lg font-semibold text-card-foreground mb-1">Belum Ada Reservasi</p>
                                        <p class="text-sm text-muted-foreground">Data reservasi akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="lg:hidden space-y-4">
            @forelse ($reservations as $r)
                <div class="bg-card rounded-xl shadow-md border border-border overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    {{-- Card Header --}}
                    <div class="p-4 bg-muted border-b border-border">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-muted-foreground">{{ $r->reservation_code }}</span>
                            @switch($r->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <i class="fa-solid fa-clock mr-1"></i> Pending
                                    </span>
                                @break
                                @case('confirmed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fa-solid fa-check mr-1"></i> Confirmed
                                    </span>
                                @break
                                @case('completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Completed
                                    </span>
                                @break
                                @case('cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                        <i class="fa-solid fa-times mr-1"></i> Cancelled
                                    </span>
                                @break
                            @endswitch
                        </div>
                        <h3 class="text-lg font-bold text-card-foreground">{{ $r->customer_name }}</h3>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-4 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-spa text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-muted-foreground mb-1">Treatment</p>
                                <p class="text-sm font-semibold text-card-foreground">{{ $r->treatment->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-user-doctor text-primary-foreground"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-muted-foreground mb-1">Dokter</p>
                                <p class="text-sm font-semibold text-card-foreground">{{ $r->doctor->name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-calendar text-primary mt-1"></i>
                                <div>
                                    <p class="text-xs text-muted-foreground mb-1">Tanggal</p>
                                    <p class="text-sm font-medium text-card-foreground">{{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-clock text-primary mt-1"></i>
                                <div>
                                    <p class="text-xs text-muted-foreground mb-1">Waktu</p>
                                    <p class="text-sm font-medium text-card-foreground">{{ $r->reservation_time }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Actions --}}
                    @if ($r->status === 'pending' || $r->status === 'confirmed')
                        <div class="p-4 bg-muted border-t border-border">
                            <div class="flex gap-2">
                                @if ($r->status === 'pending')
                                    <form id="confirm-form-{{ $r->id }}" action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="button" onclick="openModal('confirm', {{ $r->id }})"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-150 shadow-sm hover:shadow">
                                            <i class="fa-solid fa-check"></i> Konfirmasi
                                        </button>
                                    </form>
                                    <form id="cancel-form-{{ $r->id }}" action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all duration-150 shadow-sm hover:shadow">
                                            <i class="fa-solid fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @elseif ($r->status === 'confirmed')
                                    <form id="done-form-{{ $r->id }}" action="{{ route('admin.reservasi.selesai', $r->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="button" onclick="openModal('done', {{ $r->id }})"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-all duration-150 shadow-sm hover:shadow">
                                            <i class="fa-solid fa-check-double"></i> Selesai
                                        </button>
                                    </form>
                                    <form id="cancel-form-{{ $r->id }}" action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all duration-150 shadow-sm hover:shadow">
                                            <i class="fa-solid fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-card rounded-xl shadow-md border border-border p-12 text-center">
                    <i class="fa-solid fa-inbox text-6xl text-muted mb-4"></i>
                    <p class="text-muted-foreground font-medium">Belum ada data reservasi</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($reservations->hasPages())
            <div class="mt-8 flex items-center justify-center">
                <nav class="inline-flex items-center gap-2 bg-card rounded-xl shadow-md border border-border p-2">
                    {{-- Previous --}}
                    @if ($reservations->onFirstPage())
                        <span class="px-3 py-2 text-muted-foreground cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $reservations->previousPageUrl() }}"
                            class="px-3 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-colors">
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
                                class="px-4 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if ($reservations->hasMorePages())
                        <a href="{{ $reservations->nextPageUrl() }}"
                            class="px-3 py-2 text-foreground hover:bg-accent hover:text-accent-foreground rounded-lg transition-colors">
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

        {{-- Modern Confirmation Modal --}}
        <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm transition-all duration-300">
            <div class="bg-card rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
                <div class="p-6">
                    {{-- Modal Icon --}}
                    <div class="flex items-center justify-center mb-4">
                        <div id="modalIcon" class="w-16 h-16 rounded-full flex items-center justify-center"></div>
                    </div>

                    {{-- Modal Title --}}
                    <h3 id="modalTitle" class="text-2xl font-bold text-card-foreground text-center mb-3"></h3>

                    {{-- Modal Message --}}
                    <p id="modalMessage" class="text-muted-foreground text-center mb-6"></p>

                    {{-- Modal Actions --}}
                    <div class="flex gap-3">
                        <button id="cancelBtn"
                            class="flex-1 px-6 py-3 rounded-xl border-2 border-border text-foreground font-semibold hover:bg-accent transition-all duration-150">
                            Batal
                        </button>
                        <button id="confirmBtn"
                            class="flex-1 px-6 py-3 rounded-xl font-semibold text-white transition-all duration-150 shadow-lg hover:shadow-xl transform hover:scale-105">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Animations --}}
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }

    #confirmModal.flex #modalContent {
        animation: modalShow 0.3s ease-out forwards;
    }

    @keyframes modalShow {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

{{-- Scripts --}}
<script>
    let actionType = null;
    let actionId = null;

    function openModal(type, id) {
        actionType = type;
        actionId = id;

        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('modalContent');
        const title = document.getElementById('modalTitle');
        const message = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const modalIcon = document.getElementById('modalIcon');

        // Reset animation
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        // Configure modal based on action type
        if (type === 'cancel') {
            modalIcon.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-3xl text-red-600"></i>';
            modalIcon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-red-100';
            title.textContent = 'Batalkan Reservasi?';
            message.textContent = 'Tindakan ini akan membatalkan reservasi customer. Apakah Anda yakin?';
            confirmBtn.textContent = 'Ya, Batalkan';
            confirmBtn.className = 'flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 transition-all duration-150 shadow-lg hover:shadow-xl transform hover:scale-105';
        } else if (type === 'confirm') {
            modalIcon.innerHTML = '<i class="fa-solid fa-circle-check text-3xl text-blue-600"></i>';
            modalIcon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-blue-100';
            title.textContent = 'Konfirmasi Reservasi?';
            message.textContent = 'Reservasi akan dikonfirmasi dan customer akan menerima notifikasi.';
            confirmBtn.textContent = 'Ya, Konfirmasi';
            confirmBtn.className = 'flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-all duration-150 shadow-lg hover:shadow-xl transform hover:scale-105';
        } else if (type === 'done') {
            modalIcon.innerHTML = '<i class="fa-solid fa-check-double text-3xl text-green-600"></i>';
            modalIcon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-green-100';
            title.textContent = 'Tandai Selesai?';
            message.textContent = 'Treatment telah selesai dan reservasi akan ditandai sebagai completed.';
            confirmBtn.textContent = 'Ya, Selesai';
            confirmBtn.className = 'flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-green-600 hover:bg-green-700 transition-all duration-150 shadow-lg hover:shadow-xl transform hover:scale-105';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Trigger animation
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        const modalContent = document.getElementById('modalContent');

        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    document.getElementById('cancelBtn').addEventListener('click', closeModal);

    document.getElementById('confirmBtn').addEventListener('click', () => {
        if (!actionId || !actionType) return;

        let formId = '';
        if (actionType === 'cancel') formId = `cancel-form-${actionId}`;
        else if (actionType === 'confirm') formId = `confirm-form-${actionId}`;
        else if (actionType === 'done') formId = `done-form-${actionId}`;

        const form = document.getElementById(formId);
        if (form) {
            form.submit();
        }

        closeModal();
    });

    // Close modal when clicking outside
    document.getElementById('confirmModal').addEventListener('click', (e) => {
        if (e.target.id === 'confirmModal') {
            closeModal();
        }
    });
</script>
@endsection
