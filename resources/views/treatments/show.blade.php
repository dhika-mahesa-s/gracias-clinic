@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-background py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto max-w-5xl">
        
        {{-- Back Button --}}
        <div class="mb-6 animate-fade-in">
            <a href="{{ route('treatments.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-border text-foreground hover:bg-primary hover:text-primary-foreground hover:border-primary font-semibold shadow-sm hover:shadow-md transition-smooth hover-scale-sm active-press">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-card border border-border shadow-xl rounded-3xl overflow-hidden animate-scale-in">
            @php
                // 🔧 Logika pemilihan sumber gambar (fleksibel)
                if ($treatment->image) {
                    if (Str::startsWith($treatment->image, ['http://', 'https://'])) {
                        // Gambar dari URL eksternal
                        $src = $treatment->image;
                    } elseif (Storage::disk('public')->exists($treatment->image)) {
                        // Gambar tersimpan di storage/app/public/
                        $src = asset('storage/' . $treatment->image);
                    } elseif (file_exists(public_path($treatment->image))) {
                        // Gambar di public/images/
                        $src = asset($treatment->image);
                    } else {
                        // Tidak ditemukan, tampilkan placeholder
                        $src = 'https://via.placeholder.com/800x500?text=No+Image';
                    }
                } else {
                    $src = 'https://via.placeholder.com/800x500?text=No+Image';
                }

                $hasDiscount = $treatment->hasActiveDiscount();
                $originalPrice = $treatment->price;
                $discountedPrice = $hasDiscount ? $treatment->getDiscountedPrice() : $originalPrice;
                $formattedPrice = 'Rp ' . number_format($discountedPrice, 0, ',', '.');
                $formattedOriginalPrice = 'Rp ' . number_format($originalPrice, 0, ',', '.');
            @endphp

            {{-- Hero Image Section --}}
            <div class="relative overflow-hidden bg-muted h-64 sm:h-80 lg:h-96">
                <img src="{{ $src }}" 
                     alt="{{ $treatment->name }}"
                     class="w-full h-full object-cover hover-scale">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                
                {{-- Discount Badge on Image --}}
                @if($hasDiscount)
                    @php
                        $discount = $treatment->getActiveDiscount();
                    @endphp
                    <div class="absolute top-6 right-6 animate-bounce">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-2xl shadow-2xl">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-tags text-xl"></i>
                                <div>
                                    <div class="text-xs font-medium">DISKON SPESIAL</div>
                                    <div class="text-2xl font-bold">
                                        {{ $discount->type === 'percentage' ? $discount->value . '%' : 'Rp ' . number_format($discount->value, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Title Overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-10">
                    <div class="flex items-center gap-3 mb-3 animate-slide-right delay-75">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-spa text-primary-foreground text-xl"></i>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                            {{ $treatment->name }}
                        </h1>
                    </div>
                </div>
            </div>

            {{-- Content Section --}}
            <div class="p-6 sm:p-8 lg:p-10">
                {{-- Quick Info Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8 animate-slide-up delay-100">
                    {{-- Price Card --}}
                    <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-2xl p-6 border-2 border-green-200 shadow-md hover:shadow-lg transition-smooth hover-lift group">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-money-bill-wave text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-green-700 mb-1">Harga Treatment</p>
                                @if($hasDiscount)
                                    <div class="flex items-center gap-2">
                                        <p class="text-2xl sm:text-3xl font-bold text-green-900">{{ $formattedPrice }}</p>
                                        <span class="text-xs bg-red-500 text-white px-2 py-1 rounded-full font-bold">HEMAT!</span>
                                    </div>
                                    <p class="text-sm text-green-700 line-through mt-1">{{ $formattedOriginalPrice }}</p>
                                @else
                                    <p class="text-2xl sm:text-3xl font-bold text-green-900">{{ $formattedPrice }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Duration Card --}}
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl p-6 border-2 border-blue-200 shadow-md hover:shadow-lg transition-smooth hover-lift group">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                <i class="fa-regular fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-blue-700 mb-1">Durasi Treatment</p>
                                <p class="text-2xl sm:text-3xl font-bold text-blue-900">{{ $treatment->duration }} <span class="text-lg">menit</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 sm:p-8 border border-primary/20 mb-8 animate-slide-up delay-150">
                    <h2 class="text-2xl font-bold text-foreground mb-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-circle-info text-primary-foreground"></i>
                        </div>
                        Deskripsi Treatment
                    </h2>
                    <div class="prose prose-lg max-w-none">
                        <p class="text-muted-foreground leading-relaxed text-base sm:text-lg">
                            {{ $treatment->description }}
                        </p>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="flex justify-center animate-bounce-in delay-200">
                    @auth
                        <a href="{{ route('reservasi.index', ['treatment_id' => $treatment->id]) }}"
                           class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl text-primary-foreground bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary font-bold text-lg shadow-lg hover:shadow-xl transition-smooth hover-lift active-press">
                            <i class="fa-solid fa-calendar-check text-xl"></i>
                            <span>Reservasi Sekarang</span>
                        </a>
                    @else
                        {{-- Belum login - middleware auth akan handle redirect otomatis --}}
                        <a href="{{ route('reservasi.index', ['treatment_id' => $treatment->id]) }}"
                           class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl text-primary-foreground bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary font-bold text-lg shadow-lg hover:shadow-xl transition-smooth hover-lift active-press">
                            <i class="fa-solid fa-calendar-check text-xl"></i>
                            <span>Reservasi Sekarang</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
