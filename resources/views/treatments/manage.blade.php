@php 
    use Illuminate\Support\Facades\Storage; 
@endphp

@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-7xl mx-auto">

        {{-- Header Section --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2 flex items-center gap-3">
                        <div class="p-2 bg-primary rounded-xl">
                            <i class="fa-solid fa-spa text-primary-foreground text-2xl"></i>
                        </div>
                        Kelola Treatment
                    </h1>
                    <p class="text-muted-foreground ml-14">Manajemen treatment dan layanan klinik</p>
                </div>
                <a href="{{ route('treatments.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Treatment</span>
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3 shadow-sm animate-slide-down">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Treatment Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($treatments as $index => $t)
                @php
                    if ($t->image) {
                        if (preg_match('#^https?://#', $t->image)) {
                            $imagePath = $t->image;
                        } elseif (Storage::disk('public')->exists($t->image)) {
                            $imagePath = asset('storage/' . $t->image);
                        } elseif (file_exists(public_path('images/' . $t->image))) {
                            $imagePath = asset('images/' . $t->image);
                        } elseif (Str::startsWith($t->image, ['storage/', 'images/'])) {
                            $imagePath = asset($t->image);
                        } else {
                            $imagePath = 'https://via.placeholder.com/400x300?text=No+Image';
                        }
                    } else {
                        $imagePath = 'https://via.placeholder.com/400x300?text=No+Image';
                    }
                    
                    $delayClass = match($index % 3) {
                        0 => '',
                        1 => 'delay-100',
                        2 => 'delay-200',
                    };
                @endphp

                <div class="group bg-card rounded-2xl shadow-md hover:shadow-2xl overflow-hidden border border-border hover-lift transition-smooth animate-slide-up {{ $delayClass }}">
                    {{-- Image Section --}}
                    <div class="relative h-48 overflow-hidden bg-muted">
                        <img src="{{ $imagePath }}" 
                             alt="{{ $t->name }}" 
                             class="w-full h-full object-cover transition-smooth group-hover:scale-110">
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-smooth"></div>
                        
                        {{-- ID Badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-3 py-1 bg-card/90 backdrop-blur-sm rounded-full text-xs font-semibold text-card-foreground">
                                #{{ $t->id }}
                            </span>
                        </div>

                        {{-- Discount Badge (if active) --}}
                        @if($t->hasActiveDiscount())
                            @php
                                $discount = $t->getActiveDiscount();
                            @endphp
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full text-xs font-bold shadow-lg animate-pulse">
                                    <i class="fa-solid fa-tags"></i>
                                    {{ $discount->type === 'percentage' ? $discount->value . '%' : 'DISKON' }}
                                </span>
                            </div>
                            <div class="absolute bottom-3 right-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/90 backdrop-blur-sm rounded-full text-xs font-semibold text-primary-foreground">
                                    <i class="fa-solid fa-clock"></i> {{ $t->duration }} menit
                                </span>
                            </div>
                        @else
                            {{-- Duration Badge --}}
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/90 backdrop-blur-sm rounded-full text-xs font-semibold text-primary-foreground">
                                    <i class="fa-solid fa-clock"></i> {{ $t->duration }} menit
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Content Section --}}
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-card-foreground mb-2 group-hover:text-primary transition-smooth">
                            {{ $t->name }}
                        </h3>

                        <p class="text-muted-foreground text-sm mb-4 line-clamp-2">
                            {{ $t->description }}
                        </p>

                        {{-- Price with Discount Info --}}
                        <div class="mb-4 pb-4 border-b border-border">
                            @if($t->hasActiveDiscount())
                                @php
                                    $discount = $t->getActiveDiscount();
                                @endphp
                                <div class="space-y-1">
                                    {{-- Discount Badge --}}
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full font-semibold">
                                            <i class="fa-solid fa-tag"></i> {{ $discount->name }}
                                        </span>
                                    </div>
                                    {{-- Discounted Price --}}
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl font-bold text-primary">
                                            Rp {{ number_format($t->getDiscountedPrice(), 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded font-semibold">
                                            HEMAT
                                        </span>
                                    </div>
                                    {{-- Original Price --}}
                                    <div class="text-sm text-muted-foreground line-through">
                                        Rp {{ number_format($t->price, 0, ',', '.') }}
                                    </div>
                                    {{-- Discount Period --}}
                                    <div class="text-xs text-muted-foreground mt-1">
                                        <i class="fa-solid fa-calendar-alt"></i>
                                        s/d {{ $discount->end_date->format('d M Y') }}
                                    </div>
                                </div>
                            @else
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-primary">
                                        Rp {{ number_format($t->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <a href="{{ route('treatments.edit', $t) }}"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-smooth shadow-sm hover:shadow hover-scale-sm active-press">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('treatments.destroy', $t) }}" method="POST" class="flex-1" 
                                  onsubmit="return confirm('Hapus treatment {{ $t->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-smooth shadow-sm hover:shadow hover-scale-sm active-press">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty State --}}
        @if($treatments->isEmpty())
            <div class="bg-card rounded-2xl shadow-md border border-border p-16 text-center animate-fade-in">
                <i class="fa-solid fa-spa text-6xl text-muted mb-4"></i>
                <h3 class="text-xl font-semibold text-card-foreground mb-2">Belum Ada Treatment</h3>
                <p class="text-muted-foreground mb-6">Mulai tambahkan treatment dan layanan klinik Anda</p>
                <a href="{{ route('treatments.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl font-semibold hover-lift active-press">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Treatment Pertama</span>
                </a>
            </div>
        @endif
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
