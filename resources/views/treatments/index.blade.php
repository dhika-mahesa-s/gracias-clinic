@php 
    use Illuminate\Support\Facades\Storage; 
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] text-[#526D82] py-10 px-4">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-bold flex items-center gap-2 text-[#27374D] ">
        Treatment Kami
      </h2>
      <a href="{{ route('treatments.manage') }}" 
         class="px-5 py-2.5 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition shadow-sm font-medium">
        ← Kembali
      </a>
    </div>

    {{-- Grid Treatment --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
        <div class="bg-gray-100 border border-gray-300 rounded-2xl shadow-md p-6 hover:shadow-lg transition">
          <img src="{{ $img }}" alt="{{ $t->name }}" 
               class="w-full h-48 object-cover rounded-xl mb-4 border border-gray-300 shadow-sm">

          <h3 class="text-xl font-semibold text-[#27374D] mb-2">{{ $t->name }}</h3>
          <p class="text-sm text-[#526D82] mb-3">{{ \Illuminate\Support\Str::limit($t->description, 100) }}</p>
          <p class="text-lg font-bold text-[#27374D] mb-5">{{ $price }}</p>

          <div class="flex justify-center gap-3">
            <a href="{{ route('reservasi.index') }}" 
               class="px-4 py-2 rounded-lg text-white bg-primary hover:bg-primary/90 transition-all duration-300 text-sm font-medium shadow-md">
               🗓️ Reservasi
            </a>
            <a href="{{ route('treatments.show', $t) }}" 
               class="px-4 py-2 rounded-lg border border-[#526D82] text-[#526D82] text-sm font-medium hover:bg-[#526D82] hover:text-white transition shadow-sm">
               ℹ️ Selengkapnya
            </a>
          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>
@endsection
