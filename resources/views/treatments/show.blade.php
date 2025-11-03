@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-12 px-6 animate-fadeIn">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-[#F3F6FB] border border-[#D9E1EC] shadow-md rounded-3xl p-10 hover:shadow-lg transition-all duration-300 animate-fadeUp">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 border-b border-[#D9E1EC] pb-4">
                <h3 class="text-3xl font-extrabold text-[#27374D] tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-spa text-primary"></i>
                    {{ $treatment->name }}
                </h3>
                <a href="{{ route('treatments.index') }}"
                   class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>

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
                        $src = 'https://via.placeholder.com/400x250?text=No+Image';
                    }
                } else {
                    $src = 'https://via.placeholder.com/400x250?text=No+Image';
                }

                $formattedPrice = 'Rp ' . number_format($treatment->price, 0, ',', '.');
            @endphp

            <!-- Gambar Treatment -->
            <div class="relative flex justify-center mb-8">
                <div class="overflow-hidden rounded-3xl border border-[#D9E1EC] shadow-md group">
                    <img src="{{ $src }}" alt="{{ $treatment->name }}"
                         class="w-full max-w-md object-cover transform group-hover:scale-105 transition duration-500 ease-out">
                </div>
            </div>

            <!-- Detail Treatment -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-[#E2E8F0]/60 rounded-2xl p-5 border border-[#D9E1EC] hover:shadow-inner transition">
                        <p class="font-semibold text-[#27374D] flex items-center gap-2">
                            <i class="fa-solid fa-money-bill-wave text-green-600"></i> Harga:
                        </p>
                        <p class="text-[#27374D] font-bold text-2xl mt-1">{{ $formattedPrice }}</p>
                    </div>
                    <div class="bg-[#E2E8F0]/60 rounded-2xl p-5 border border-[#D9E1EC] hover:shadow-inner transition">
                        <p class="font-semibold text-[#27374D] flex items-center gap-2">
                            <i class="fa-regular fa-clock text-primary"></i> Durasi:
                        </p>
                        <p class="text-[#27374D] font-bold text-xl mt-1">{{ $treatment->duration }} menit</p>
                    </div>
                </div>

                <div class="bg-[#E2E8F0]/50 rounded-2xl p-6 border border-[#D9E1EC] mt-4">
                    <h4 class="text-xl font-semibold text-[#27374D] mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-primary"></i> Deskripsi
                    </h4>
                    <p class="text-[#526D82] leading-relaxed">{{ $treatment->description }}</p>
                </div>
            </div>

            <!-- Tombol Reservasi -->
            <div class="mt-10 text-center">
                @auth
                    <a href="{{ route('reservasi.index', ['treatment_id' => $treatment->id]) }}"
                       class="px-4 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 
                              transition-all duration-300 text-sm font-medium shadow-md">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Reservasi Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       onclick="event.preventDefault();
                                sessionStorage.setItem('intended', '{{ route('reservasi.index', ['treatment_id' => $treatment->id]) }}');
                                window.location.href='{{ route('login') }}';"
                       class="px-4 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 
                              transition-all duration-300 text-sm font-medium shadow-md">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Reservasi Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- Efek Animasi Halus --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(25px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn { animation: fadeIn 0.5s ease-out; }
.animate-fadeUp { animation: fadeUp 0.6s ease-out; }
</style>
@endsection
