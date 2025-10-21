@extends('layouts.app')

@section('content')
<div class="card p-5">
  <div class="mb-4">
    <h3 class="mb-2 text-start">Treatment Kami</h3>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">← Kembali</a>
  </div>

  @php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $src = $treatment->image
      ? (Str::startsWith($treatment->image, ['http://','https://'])
          ? $treatment->image
          : Storage::url($treatment->image))
      : 'https://via.placeholder.com/200?text=No+Image';

    $formattedPrice = 'Rp. ' . number_format($treatment->price, 0, ',', '.');
  @endphp

  <img src="{{ $src }}" width="200" class="mb-4 rounded" alt="{{ $treatment->name }}">
  <h4>{{ $treatment->name }}</h4>
  <p><strong>Harga:</strong> {{ $formattedPrice }}</p>
  <p><strong>Durasi:</strong> {{ $treatment->duration }} menit</p>
  <p class="mt-3">{{ $treatment->description }}</p>

  <a href="{{ route('treatments.reservasi') }}" class="btn btn-primary mt-3">Reservasi Sekarang!</a>
</div>
@endsection
