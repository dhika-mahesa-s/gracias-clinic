@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] text-[#526D82] py-12 px-6">
    <div class="container mx-auto max-w-3xl">
        <div class="bg-white/70 backdrop-blur-md border border-gray-200 shadow-xl rounded-3xl p-10 transition hover:shadow-2xl hover:scale-[1.01] duration-300">

            <!-- Header -->
            <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                <h3 class="text-3xl font-extrabold text-[#27374D] tracking-tight">
                    {{ $treatment->name }}
                </h3>
                <a href="{{ route('treatments.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white font-medium transition-all duration-300 shadow-sm hover:shadow-md">
                    ← Kembali
                </a>
            </div>

            @php
                use Illuminate\Support\Str;
                use Illuminate\Support\Facades\Storage;

                $src = $treatment->image
                    ? (Str::startsWith($treatment->image, ['http://','https://'])
                        ? $treatment->image
                        : Storage::url($treatment->image))
                    : 'https://via.placeholder.com/400x250?text=No+Image';

                $formattedPrice = 'Rp ' . number_format($treatment->price, 0, ',', '.');
            @endphp

            <!-- Gambar Treatment -->
            <div class="relative flex justify-center mb-8">
                <div class="overflow-hidden rounded-3xl border border-gray-200 shadow-md group">
                    <img src="{{ $src }}" alt="{{ $treatment->name }}" 
                         class="w-full max-w-md object-cover transform group-hover:scale-105 transition duration-500 ease-out">
                </div>
            </div>

            <!-- Detail Treatment -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-[#E2E8F0]/60 rounded-2xl p-5 border border-gray-200 hover:shadow-inner transition">
                        <p class="font-semibold text-[#27374D]">Harga:</p>
                        <p class="text-[#27374D] font-bold text-2xl mt-1">{{ $formattedPrice }}</p>
                    </div>
                    <div class="bg-[#E2E8F0]/60 rounded-2xl p-5 border border-gray-200 hover:shadow-inner transition">
                        <p class="font-semibold text-[#27374D]">Durasi:</p>
                        <p class="text-[#27374D] font-bold text-xl mt-1">{{ $treatment->duration }} menit</p>
                    </div>
                </div>

                <div class="bg-[#E2E8F0]/50 rounded-2xl p-6 border border-gray-200 mt-4">
                    <h4 class="text-xl font-semibold text-[#27374D] mb-2">Deskripsi</h4>
                    <p class="text-[#526D82] leading-relaxed">{{ $treatment->description }}</p>
                </div>
            </div>

            <!-- Tombol Reservasi -->
            <div class="mt-10 text-center">
                <a href="{{ route('reservasi.index', ['treatment_id' => $treatment->id] )}}" 
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white font-semibold rounded-2xl shadow-md hover:bg-primary/90 hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Reservasi Sekarang
                </a>
            </div>

        </div>
    </div>
</section>
@endsection
