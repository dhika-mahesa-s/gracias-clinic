@extends('layouts.app')

@section('content')
<div class="card p-5">

  {{-- Header kiri + tombol kembali --}}
  <div class="mb-4 d-flex justify-content-between align-items-center">
    <h3 class="mb-0 text-start">Treatment Kami</h3>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
  </div>

  @php use Illuminate\Support\Facades\Storage; @endphp

  <div class="row g-4">
    @foreach($treatments as $t)
      @php
        // Format harga Rp. 200.000
        $price = 'Rp. ' . number_format($t->price, 0, ',', '.');

        // Tentukan path gambar
        if ($t->image) {
            if (preg_match('#^https?://#', $t->image)) {
                // Jika full URL
                $img = $t->image;
            } elseif (Storage::disk('public')->exists($t->image)) {
                // Jika file ada di storage/app/public/treatments
                $img = Storage::url($t->image); // → /storage/treatments/nama-file.jpg
            } else {
                // Jika file tidak ditemukan
                $img = 'https://via.placeholder.com/100?text=No+Image';
            }
        } else {
            // Jika belum upload gambar
            $img = 'https://via.placeholder.com/100?text=No+Image';
        }
      @endphp

      <div class="col-12 col-md-4">
        <div class="card p-3 text-center">
          {{-- Gambar treatment --}}
          <img src="{{ $img }}" alt="{{ $t->name }}" width="100" height="100" class="mx-auto mb-3 rounded object-fit-cover">

          <h5 class="mb-1">{{ $t->name }}</h5>
          <p class="mb-2">{{ \Illuminate\Support\Str::limit($t->description, 100) }}</p>
          <p class="fw-bold mb-3">{{ $price }}</p>

          <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-sm">Reservasi Sekarang</a>
            <a href="{{ route('treatments.show', $t) }}" class="btn btn-secondary btn-sm">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
