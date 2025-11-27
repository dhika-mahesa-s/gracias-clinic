{{-- 
    Treatment Card Component
    Props: $treatment (Treatment model dengan eager loaded discounts)
--}}

<div class="treatment-card relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    
    {{-- Treatment Image --}}
    <div class="treatment-image relative h-48 overflow-hidden">
        @if($treatment->image)
            <img src="{{ asset('storage/' . $treatment->image) }}" 
                 alt="{{ $treatment->name }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                <span class="text-white text-2xl font-bold">{{ substr($treatment->name, 0, 1) }}</span>
            </div>
        @endif
        
        {{-- Discount Badge (jika ada diskon aktif) --}}
        @if($treatment->hasActiveDiscount())
            <div class="absolute top-3 right-3 bg-gradient-to-r from-pink-500 to-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg animate-pulse">
                -{{ $treatment->getDiscountPercentage() }}%
            </div>
        @endif
    </div>
    
    {{-- Treatment Info --}}
    <div class="p-5">
        {{-- Treatment Name --}}
        <h3 class="text-xl font-bold text-gray-800 mb-2">
            {{ $treatment->name }}
        </h3>
        
        {{-- Treatment Description --}}
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
            {{ Str::limit($treatment->description, 100) }}
        </p>
        
        {{-- Duration --}}
        <div class="flex items-center text-gray-500 text-sm mb-4">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $treatment->duration }} menit</span>
        </div>
        
        {{-- Price Section --}}
        <div class="mb-4">
            @if($treatment->hasActiveDiscount())
                {{-- Dengan Diskon --}}
                <div class="flex flex-col gap-1">
                    {{-- Original Price (strikethrough) --}}
                    <span class="text-gray-400 text-sm line-through">
                        {{ $treatment->getFormattedPrice() }}
                    </span>
                    
                    {{-- Discounted Price --}}
                    <div class="flex items-baseline gap-2">
                        <span class="text-2xl font-bold text-pink-600">
                            {{ $treatment->getFormattedDiscountedPrice() }}
                        </span>
                    </div>
                    
                    {{-- Save Amount --}}
                    <span class="text-xs text-green-600 font-medium">
                        💰 Hemat Rp {{ number_format($treatment->getDiscountAmount(), 0, ',', '.') }}
                    </span>
                    
                    {{-- Discount Info --}}
                    @php $discount = $treatment->getActiveDiscount(); @endphp
                    @if($discount)
                        <div class="mt-2 bg-pink-50 border border-pink-200 rounded px-2 py-1">
                            <p class="text-xs text-pink-700 font-medium">
                                🎉 {{ $discount->name }}
                            </p>
                            <p class="text-xs text-gray-600">
                                Berlaku s/d {{ $discount->end_date->format('d M Y H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            @else
                {{-- Normal Price (tanpa diskon) --}}
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-800">
                        {{ $treatment->getFormattedPrice() }}
                    </span>
                </div>
            @endif
        </div>
        
        {{-- CTA Button --}}
        <a href="{{ route('reservations.create', ['treatment_id' => $treatment->id]) }}" 
           class="block w-full text-center bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
            @if($treatment->hasActiveDiscount())
                🎁 Book dengan Diskon
            @else
                📅 Book Sekarang
            @endif
        </a>
    </div>
</div>
