@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Daftar Feedback Pengguna</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-3">+ Tambah Feedback</a>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Layanan</th>
                    <th>Staff</th>
                    <th>Profesionalitas</th>
                    <th>Hasil</th>
                    <th>Pengembalian</th>
                    <th>Keseluruhan</th>
                    <th>Rata-rata</th>
                    <th>Pesan</th>
                    <th>Dikirim Pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                    @php
                        $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td>{{ $feedback->service_type ?? '-' }}</td>

                        {{-- Rating per kategori --}}
                        <td>{{ $feedback->staff_rating }}</td>
                        <td>{{ $feedback->professional_rating }}</td>
                        <td>{{ $feedback->result_rating }}</td>
                        <td>{{ $feedback->return_rating }}</td>
                        <td>{{ $feedback->overall_rating }}</td>

                        {{-- Rata-rata --}}
                        <td><strong>{{ number_format($avg, 1) }}</strong></td>

                        <td>{{ $feedback->message ?? '-' }}</td>
                        <td>{{ $feedback->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">Belum ada feedback.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
