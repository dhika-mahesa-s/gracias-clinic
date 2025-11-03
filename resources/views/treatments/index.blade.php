@php 
    use Illuminate\Support\Facades\Storage; 
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4 animate-fadeIn">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-10">
      <h2 class="text-3xl font-bold flex items-center gap-3 text-[#27374D]">
        <i class="fa-solid fa-spa text-primary"></i>
        Treatment Kami
      </h2>
    </div>

    {{-- Grid Treatment --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($treatments as $t)
        @php
          $price = 'Rp ' . number_format($t->price, 0, ',', '.');

          if ($t->image) {
              if (preg_match('#^https?://#', $t->image)) {
                  $img = $t->image;
              } elseif (Storage::disk('public')->exists($t->image)) {
                  $img = Storage::url($t->image);
              } else {
                  $img = 'https://via.placeholder.com/300x200?text=No+Image';
              }
          } else {
              $img = 'https://via.placeholder.com/300x200?text=No+Image';
          }
        @endphp

        {{-- Card Treatment --}}
        <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-md p-6 
                    hover:shadow-lg hover:-translate-y-1 transition-all duration-300 animate-fadeUp">
          <div class="overflow-hidden rounded-xl mb-4">
            <img src="{{ $img }}" alt="{{ $t->name }}" 
                 class="w-full h-48 object-cover rounded-xl border border-[#D9E1EC] shadow-sm hover:scale-105 transition-transform duration-500">
          </div>

          <h3 class="text-xl font-semibold text-[#27374D] mb-2 flex items-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles text-primary"></i>
            {{ $t->name }}
          </h3>
          <p class="text-sm text-[#526D82] mb-3 leading-relaxed">
            {{ \Illuminate\Support\Str::limit($t->description, 100) }}
          </p>
          <p class="text-lg font-bold text-[#27374D] mb-5">
           {{ $price }}
          </p>

          <div class="flex justify-center gap-3">

    @auth
        {{-- ✅ Jika user sudah login, langsung buka halaman feedback --}}
        <a href="{{ route('reservasi.index',['treatment_id' => $t->id])}}"
            class="px-4 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 transition-all duration-300 text-sm font-medium shadow-md">
            Reservasi
        </a>
    @else
        {{-- 🚪 Jika belum login, arahkan ke login dan simpan halaman tujuan --}}
        <a href="{{ route('login') }}"
            onclick="event.preventDefault(); 
                     sessionStorage.setItem('intended', '{{ route('reservasi.index',['treatment_id' => $t->id])}}');
                     window.location.href='{{ route('login') }}';"
            class="px-4 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 transition-all duration-300 text-sm font-medium shadow-md">
            Reservasi
        </a>
    @endauth




            <a href="{{ route('treatments.show', $t) }}" 
               class="flex items-center gap-2 px-4 py-2 rounded-lg border border-[#526D82] 
                      text-[#526D82] text-sm font-medium hover:bg-[#526D82] hover:text-white transition-all duration-300 shadow-sm">
               <i class="fa-solid fa-circle-info"></i> Selengkapnya
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Efek Animasi Halus --}}
<style>
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeUp { from { opacity: 0; transform: translateY(25px); } to { opacity: 1; transform: translateY(0); } }
.animate-fadeIn { animation: fadeIn 0.5s ease-out; }
.animate-fadeUp { animation: fadeUp 0.6s ease-out; }
</style>
@endsection
