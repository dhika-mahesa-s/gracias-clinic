@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-background py-12 px-4 sm:px-6 lg:px-8">
  <div class="container mx-auto max-w-7xl">

    {{-- Header Section --}}
    <div class="mb-12 text-center animate-fade-in">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-primary/80 rounded-2xl shadow-lg mb-4 animate-bounce-in">
        <i class="fa-solid fa-spa text-primary-foreground text-3xl"></i>
      </div>
      <h1 class="text-4xl sm:text-5xl font-bold text-foreground mb-3">
        Treatment Kami
      </h1>
      <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
        Pilih treatment terbaik untuk perawatan kecantikan dan kesehatan kulit Anda
      </p>
      <div class="mt-4 h-1 w-24 bg-gradient-to-r from-primary/50 via-primary to-primary/50 rounded-full mx-auto"></div>
    </div>

    {{-- Grid Treatment --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
      @foreach($treatments as $index => $t)
        @php
            $hasDiscount = $t->hasActiveDiscount();
            $originalPrice = $t->price;
            $discountedPrice = $hasDiscount ? $t->getDiscountedPrice() : $originalPrice;
            $price = 'Rp ' . number_format($discountedPrice, 0, ',', '.');

            if ($t->image) {
                // Jika URL eksternal (https://...)
                if (preg_match('#^https?://#', $t->image)) {
                    $img = $t->image;
                }
                // Jika file ada di storage/app/public/
                elseif (Storage::disk('public')->exists($t->image)) {
                    $img = asset('storage/' . $t->image);
                }
                // Jika file ada di public/images/
                elseif (file_exists(public_path($t->image))) {
                    $img = asset($t->image);
                }
                else {
                    $img = 'https://via.placeholder.com/400x300?text=No+Image';
                }
            } else {
                $img = 'https://via.placeholder.com/400x300?text=No+Image';
            }
            
            // Stagger delay for animation
            $delays = ['delay-75', 'delay-100', 'delay-150', 'delay-200', 'delay-250', 'delay-300'];
            $delayClass = $delays[$index % 6] ?? '';
        @endphp

        {{-- Treatment Card --}}
        <div class="bg-card rounded-2xl shadow-lg border border-border overflow-hidden hover:shadow-xl transition-smooth hover-lift group animate-slide-up {{ $delayClass }}">
          {{-- Image Container --}}
          <div class="relative overflow-hidden bg-muted h-56 sm:h-64">
            <img src="{{ $img }}" 
                 alt="{{ $t->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-smooth">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-smooth"></div>
            
            {{-- Price Badge with Discount --}}
            <div class="absolute top-4 right-4">
              @if($hasDiscount)
                {{-- Discount Badge --}}
                @php
                    $discount = $t->getActiveDiscount();
                @endphp
                <div class="mb-2">
                  <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                    <i class="fa-solid fa-tags mr-1"></i>
                    {{ $discount->type === 'percentage' ? $discount->value . '% OFF' : 'DISKON' }}
                  </div>
                </div>
                {{-- Price with Strikethrough --}}
                <div class="bg-white/95 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg">
                  <div class="text-xs text-gray-500 line-through">
                    Rp {{ number_format($originalPrice, 0, ',', '.') }}
                  </div>
                  <div class="font-bold text-lg text-primary">
                    {{ $price }}
                  </div>
                </div>
              @else
                {{-- Normal Price --}}
                <div class="bg-primary text-primary-foreground px-4 py-2 rounded-xl shadow-lg font-bold text-lg backdrop-blur-sm">
                  {{ $price }}
                </div>
              @endif
            </div>
          </div>

          {{-- Card Content --}}
          <div class="p-6">
            {{-- Treatment Name --}}
            <h3 class="text-xl font-bold text-card-foreground mb-3 flex items-center gap-2 group-hover:text-primary transition-smooth">
              <i class="fa-solid fa-wand-magic-sparkles text-primary"></i>
              {{ $t->name }}
            </h3>
            
            {{-- Description --}}
            <p class="text-sm text-muted-foreground mb-5 leading-relaxed line-clamp-3">
              {{ \Illuminate\Support\Str::limit($t->description, 120) }}
            </p>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3">
              @auth
                <a href="{{ route('reservasi.index',['treatment_id' => $t->id])}}"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-primary-foreground bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary font-semibold shadow-md hover:shadow-lg transition-smooth hover-scale-sm active-press">
                   <i class="fa-solid fa-calendar-check"></i>
                   <span>Reservasi</span>
                </a>
              @else
                <a href="{{ route('reservasi.index',['treatment_id' => $t->id]) }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-primary-foreground bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary font-semibold shadow-md hover:shadow-lg transition-smooth hover-scale-sm active-press">
                   <i class="fa-solid fa-calendar-check"></i>
                   <span>Reservasi</span>
                </a>
              @endauth

              <a href="{{ route('treatments.show', $t) }}" 
                 class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border-2 border-border text-card-foreground font-semibold hover:bg-primary hover:text-primary-foreground hover:border-primary shadow-sm hover:shadow-md transition-smooth hover-scale-sm active-press">
                 <i class="fa-solid fa-circle-info"></i>
                 <span>Detail</span>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Empty State --}}
    @if($treatments->isEmpty())
      <div class="text-center py-20 animate-fade-in">
        <div class="w-24 h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
          <i class="fa-solid fa-spa text-6xl text-muted-foreground"></i>
        </div>
        <h3 class="text-2xl font-bold text-foreground mb-2">Belum Ada Treatment</h3>
        <p class="text-muted-foreground text-lg">Treatment akan ditampilkan di sini</p>
      </div>
    @endif
  </div>
</section>
@endsection
