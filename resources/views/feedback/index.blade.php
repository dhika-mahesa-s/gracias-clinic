@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<!-- Modal Konfirmasi Toggle Visibility -->
<div id="toggleVisibilityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all scale-95 opacity-0" id="toggleModalContent">
        <div class="p-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full mb-4" id="modalIconContainer">
                <svg class="w-8 h-8" id="modalIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2" id="modalTitle">Ubah Visibilitas?</h3>
            <p class="text-center text-gray-600 mb-2" id="modalMessage">
                Apakah Anda yakin ingin mengubah visibilitas feedback ini?
            </p>
            <p class="text-center text-sm font-semibold mb-6" id="modalCustomerName"></p>
            <div class="flex gap-3">
                <button type="button" onclick="closeToggleModal()" 
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="confirmToggle()" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r text-white font-semibold rounded-xl hover:shadow-lg transition-all" id="confirmButton">
                    Ya, Ubah
                </button>
            </div>
        </div>
    </div>
</div>

<div class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-primary rounded-xl">
                    <i class="fa-solid fa-comments text-primary-foreground text-2xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-foreground">Kelola Feedback</h1>
            </div>
            <p class="text-muted-foreground ml-14">Manajemen feedback dan testimoni customer</p>
        </div>

        {{-- Filter & Search Section --}}
        <div class="bg-card rounded-2xl shadow-md border border-border p-6 mb-6 animate-slide-down">
            <form method="GET" action="{{ route('admin.feedback.index') }}" class="space-y-4">
                {{-- Search --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-muted-foreground"></i>
                    </div>
                    <input type="text" name="search" 
                           class="w-full pl-11 pr-20 py-3 border border-input rounded-xl focus:ring-2 focus:ring-ring focus:border-input transition-smooth bg-background text-foreground" 
                           placeholder="Cari nama customer..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-1.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-lg text-sm font-semibold transition-smooth hover-scale-sm active-press">
                        Cari
                    </button>
                </div>

                {{-- Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-foreground mb-2">Filter Rating</label>
                        <select name="rating_filter" class="w-full px-4 py-2.5 border border-input rounded-xl focus:ring-2 focus:ring-ring focus:border-input bg-background text-foreground font-medium transition-smooth">
                            <option value="">Semua Rating</option>
                            <option value="5" {{ request('rating_filter') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                            <option value="4" {{ request('rating_filter') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4+ Bintang)</option>
                            <option value="3" {{ request('rating_filter') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3+ Bintang)</option>
                            <option value="2" {{ request('rating_filter') == '2' ? 'selected' : '' }}>⭐⭐ (2+ Bintang)</option>
                            <option value="1" {{ request('rating_filter') == '1' ? 'selected' : '' }}>⭐ (1+ Bintang)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-foreground mb-2">Status Visibilitas</label>
                        <select name="visibility" class="w-full px-4 py-2.5 border border-input rounded-xl focus:ring-2 focus:ring-ring focus:border-input bg-background text-foreground font-medium transition-smooth">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>✓ Tampil di Homepage</option>
                            <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>✗ Disembunyikan</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl font-semibold transition-smooth hover-lift active-press">
                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.feedback.index') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary/80 text-secondary-foreground rounded-xl font-semibold transition-smooth hover-scale-sm active-press">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Feedback Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($feedbacks as $index => $feedback)
                @php
                    $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                    $stars = floor($avg);
                    $halfStar = ($avg - $stars) >= 0.5;
                    $delays = ['', 'delay-75', 'delay-100', 'delay-150', 'delay-200', 'delay-250'];
                    $delayClass = $delays[$index % 6] ?? '';
                @endphp

                <div class="bg-card rounded-2xl shadow-md hover:shadow-xl transition-smooth overflow-hidden border border-border hover-lift animate-slide-up {{ $delayClass }}">
                    {{-- Card Header --}}
                    <div class="p-6 bg-muted border-b border-border">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-full flex items-center justify-center text-primary-foreground font-bold text-lg shadow-lg">
                                    {{ substr($feedback->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-card-foreground">{{ $feedback->name }}</h3>
                                    <p class="text-xs text-muted-foreground">{{ $feedback->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $stars)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @elseif ($i == $stars + 1 && $halfStar)
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-card-foreground">{{ number_format($avg, 1) }}</span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-muted-foreground">Status Visibilitas:</span>
                            @if ($feedback->is_visible)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-eye"></i> Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-muted text-muted-foreground rounded-full text-xs font-semibold">
                                    <i class="fas fa-eye-slash"></i> Tersembunyi
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Actions --}}
                    <div class="p-4 bg-muted border-t border-border flex gap-2">
                        <a href="{{ route('admin.feedback.show', $feedback->id) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all duration-150 shadow-sm hover:shadow">
                            <i class="fas fa-info-circle"></i>
                            <span>Detail</span>
                        </a>

                        <button onclick="openToggleModal({{ $feedback->id }}, '{{ addslashes($feedback->name) }}', {{ $feedback->is_visible ? 'true' : 'false' }})"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-150 shadow-sm hover:shadow
                                {{ $feedback->is_visible ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                            <i class="fas {{ $feedback->is_visible ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            <span>{{ $feedback->is_visible ? 'Sembunyikan' : 'Tampilkan' }}</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-card rounded-2xl shadow-md border border-border p-16 text-center">
                    <i class="fas fa-comments text-6xl text-muted mb-4"></i>
                    <h3 class="text-xl font-semibold text-card-foreground mb-2">Belum Ada Feedback</h3>
                    <p class="text-muted-foreground">Belum ada feedback dari customer</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $feedbacks->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

{{-- ⚡ Modal & AJAX Toggle Script --}}
<script>
let currentFeedbackId = null;
let currentIsVisible = null;

// Open Toggle Modal
function openToggleModal(feedbackId, customerName, isVisible) {
    currentFeedbackId = feedbackId;
    currentIsVisible = isVisible;
    
    const modal = document.getElementById('toggleVisibilityModal');
    const modalContent = document.getElementById('toggleModalContent');
    const iconContainer = document.getElementById('modalIconContainer');
    const modalIcon = document.getElementById('modalIcon');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalCustomerName = document.getElementById('modalCustomerName');
    const confirmButton = document.getElementById('confirmButton');
    
    // Update modal content based on current visibility
    if (isVisible) {
        // Currently visible, will hide
        iconContainer.className = 'flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4';
        modalIcon.className = 'w-8 h-8 text-red-600';
        modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        modalTitle.textContent = 'Sembunyikan Feedback?';
        modalMessage.innerHTML = 'Feedback dari <strong class="text-red-600">' + customerName + '</strong> akan <strong class="text-red-600">disembunyikan</strong> dari homepage.';
        confirmButton.className = 'flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all';
        confirmButton.innerHTML = '<i class="fas fa-eye-slash mr-2"></i>Ya, Sembunyikan';
    } else {
        // Currently hidden, will show
        iconContainer.className = 'flex items-center justify-center w-16 h-16 mx-auto bg-green-100 rounded-full mb-4';
        modalIcon.className = 'w-8 h-8 text-green-600';
        modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        modalTitle.textContent = 'Tampilkan Feedback?';
        modalMessage.innerHTML = 'Feedback dari <strong class="text-green-600">' + customerName + '</strong> akan <strong class="text-green-600">ditampilkan</strong> di homepage.';
        confirmButton.className = 'flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all';
        confirmButton.innerHTML = '<i class="fas fa-eye mr-2"></i>Ya, Tampilkan';
    }
    
    modalCustomerName.textContent = '';
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Close Modal
function closeToggleModal() {
    const modal = document.getElementById('toggleVisibilityModal');
    const modalContent = document.getElementById('toggleModalContent');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        currentFeedbackId = null;
        currentIsVisible = null;
    }, 300);
}

// Confirm Toggle
async function confirmToggle() {
    if (!currentFeedbackId) return;
    
    try {
        const response = await fetch(`/admin/feedback/${currentFeedbackId}/toggle-visibility`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();
        if (data.success) {
            closeToggleModal();
            
            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl animate-slide-down flex items-center gap-3';
            notification.innerHTML = `
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">${data.message}</p>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
                location.reload();
            }, 2000);
        } else {
            alert('Gagal mengubah visibilitas.');
        }
    } catch (error) {
        console.error(error);
        alert('Terjadi kesalahan.');
    }
}

// Close modal when clicking outside
document.getElementById('toggleVisibilityModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeToggleModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeToggleModal();
    }
});
</script>
@endsection
