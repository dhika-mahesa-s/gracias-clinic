@extends('layouts.app')

@section('content')
<h3>Tambah Treatment</h3>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('treatments.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
  @csrf

  <div class="mb-3">
    <label>Nama Treatment</label>
    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
  </div>

  <div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
  </div>

  <div class="mb-3">
    <label>Harga (Rp)</label>
    <input type="number" name="price" value="{{ old('price') }}" class="form-control" required min="0" step="1">
  </div>

  <div class="mb-3">
    <label>Durasi (menit)</label>
    <input type="number" name="duration" value="{{ old('duration', 60) }}" class="form-control" required min="1" step="1">
  </div>

  <div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="image" class="form-control" accept="image/*" required>
  </div>

  <button class="btn btn-primary">Tambah</button>
  <a href="{{ route('treatments.manage') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
