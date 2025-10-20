@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Reservasi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Kode</th>
                <th>Nama Pelanggan</th>
                <th>Treatment</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservations as $r)
            <tr>
                <td>{{ $r->reservation_code }}</td>
                <td>{{ $r->customer_name }}</td>
                <td>{{ $r->treatment->name }}</td>
                <td>{{ $r->doctor->name }}</td>
                <td>{{ $r->reservation_date }}</td>
                <td>{{ $r->reservation_time }}</td>
                <td>
                    @if($r->status === 'confirmed')
                        <span class="badge bg-success">Confirmed</span>
                    @elseif($r->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($r->status === 'completed')
                        <span class="badge bg-info text-dark">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
                <td>
                    @if($r->status === 'pending')
                        <form action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                        </form>
                    @else
                        <button class="btn btn-sm btn-secondary" disabled>Sudah</button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Belum ada data reservasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
