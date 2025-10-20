@extends('layouts.app')

@section('content')
<h3>Daftar Treatment</h3>

<a href="{{ route('treatments.create') }}" class="btn btn-primary me-2">+ Tambahkan Treatment</a>
<a href="{{ route('treatments.index') }}" class="btn btn-secondary">Lihat Halaman Treatment</a>

@if(session('success'))
  <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<table class="table table-striped mt-3 bg-light text-dark">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Harga</th>
      <th>Durasi</th>
      <th>Deskripsi</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($treatments as $t)
    <tr>
      <td>{{ $t->id }}</td>
      <td>{{ $t->name }}</td>
      <td>Rp {{ number_format($t->price,0,',','.') }}</td>
      <td>{{ $t->duration }} menit</td>
      <td>{{ Str::limit($t->description, 60) }}</td>
      <td>
        
        @if($t->image)
          <img src="{{ Storage::url($t->image) }}" alt="img" width="60">
        @else
          <span>-</span>
        @endif
      </td>
      <td class="d-flex gap-2">
        <a href="{{ route('treatments.edit', $t) }}" class="btn btn-success btn-sm">Edit</a>
        <form action="{{ route('treatments.destroy', $t) }}" method="POST" onsubmit="return confirm('Hapus treatment ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
