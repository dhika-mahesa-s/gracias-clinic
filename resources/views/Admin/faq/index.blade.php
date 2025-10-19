@extends('Admin.layout.master')

@section('title', 'Kelola FAQ')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pertanyaan Umum</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faq as $f)
            <tr>
                <td>{{ $f->pertanyaan }}</td>
                <td>{{ $f->jawaban }}</td>
                <td>
                    <a href="{{ route('admin.faq.edit', $f->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.faq.destroy', $f->id) }}" method="POST" class="d-inline">
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
