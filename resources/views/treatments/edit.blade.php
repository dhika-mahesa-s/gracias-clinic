@php 
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
<h3>Edit Treatment</h3>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data" class="mt-3">
  @csrf @method('PUT')

  <div class="mb-3">
    <label>Nama Treatment</label>
    <input type="text" name="name" value="{{ old('name', $treatment->name) }}" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" required>{{ old('description', $treatment->description) }}</textarea>
  </div>

  <div class="mb-3">
    <label>Harga (Rp)</label>
    <input type="number" name="price" value="{{ old('price', $treatment->price) }}" class="form-control" required min="0" step="1">
  </div>

  <div class="mb-3">
    <label>Durasi (menit)</label>
    <input type="number" name="duration" value="{{ old('duration', $treatment->duration) }}" class="form-control" required min="1" step="1">
  </div>

  <div class="mb-3">
    <label>Gambar</label>
    
    <div class="mb-2">
      @if($treatment->image)
        <img src="{{ Storage::url($treatment->image) }}" width="120" class="rounded">
      @endif
    </div>
    <input type="file" name="image" class="form-control" accept="image/*">
    <small class="text-light">Biarkan kosong jika tidak ingin mengganti gambar.</small>
  </div>

  <button class="btn btn-success">Simpan Perubahan</button>
  <a href="{{ route('treatments.manage') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
