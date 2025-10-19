@extends('Admin.layout.master')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Reservasi</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Tanggal Reservasi</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data dari controller --}}
            @foreach($reservasi as $r)
            <tr>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>{{ $r->layanan }}</td>
                <td>{{ $r->status }}</td>
                <td>
                    <a href="{{ route('admin.reservasi.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.reservasi.destroy', $r->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
