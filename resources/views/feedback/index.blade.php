@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark mb-2">Gracias Clinic</h1>
        <h2 class="h3 text-muted">Kelola Feedback</h2>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('feedback.index') }}">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           class="form-control border-start-0" 
                           placeholder="Cari nama..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('feedback.index') }}" id="filterForm">
                <select name="rating_filter" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Filter Bintang</option>
                    <option value="5" {{ request('rating_filter') == '5' ? 'selected' : '' }}>★★★★★ (5 Bintang)</option>
                    <option value="4" {{ request('rating_filter') == '4' ? 'selected' : '' }}>★★★★☆ (4 Bintang ke atas)</option>
                    <option value="3" {{ request('rating_filter') == '3' ? 'selected' : '' }}>★★★☆☆ (3 Bintang ke atas)</option>
                    <option value="2" {{ request('rating_filter') == '2' ? 'selected' : '' }}>★★☆☆☆ (2 Bintang ke atas)</option>
                    <option value="1" {{ request('rating_filter') == '1' ? 'selected' : '' }}>★☆☆☆☆ (1 Bintang ke atas)</option>
                </select>
                @if(request('rating_filter'))
                    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-outline-secondary mt-2">Clear Filter</a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Info Filter Aktif -->
    @if(request('search') || request('rating_filter'))
    <div class="alert alert-info mb-4">
        <strong>Filter Aktif:</strong>
        @if(request('search')) Pencarian: "{{ request('search') }}" @endif
        @if(request('search') && request('rating_filter')) | @endif
        @if(request('rating_filter')) Rating: {{ request('rating_filter') }} bintang ke atas @endif
        <a href="{{ route('feedback.index') }}" class="float-end">Tampilkan Semua</a>
    </div>
    @endif

    <!-- Feedback List Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Nama</th>
                            <th width="20%">Email</th>
                            <th width="15%">Layanan</th>
                            <th width="15%">Rating Rata-rata</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                            @php
                                $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + (($feedbacks->currentPage() - 1) * $feedbacks->perPage()) }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $feedback->name }}</div>
                                    @if($feedback->phone)
                                        <small class="text-muted">{{ $feedback->phone }}</small>
                                    @endif
                                </td>
                                <td>{{ $feedback->email }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $feedback->service_type ?? 'General' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="text-warning me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= round($avg) ? '' : '-empty' }} small"></i>
                                            @endfor
                                        </div>
                                        <span class="fw-semibold">{{ number_format($avg, 1) }}/5</span>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $feedback->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Button Detail -->
                                        <a href="{{ route('feedback.show', $feedback->id) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Detail Feedback">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Button Hapus -->
                                        <form action="{{ route('feedback.destroy', $feedback->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback dari {{ $feedback->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Feedback">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h4 class="text-muted">
                                            @if(request('search') || request('rating_filter'))
                                                Tidak ada feedback yang sesuai dengan filter
                                            @else
                                                Belum ada feedback
                                            @endif
                                        </h4>
                                        <p class="text-muted">
                                            @if(request('search') || request('rating_filter'))
                                                Coba ubah kata kunci pencarian atau filter rating
                                            @else
                                                Belum ada pengguna yang memberikan feedback.
                                            @endif
                                        </p>
                                        <a href="{{ route('feedback.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-2"></i>Tambah Feedback Pertama
                                        </a>
                                        @if(request('search') || request('rating_filter'))
                                            <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary mt-2">
                                                Tampilkan Semua Feedback
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination - Diperbaiki -->
            @if($feedbacks->hasPages())
                <div class="pagination-container">
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mb-2">
                        {{ $feedbacks->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .card {
        border-radius: 15px;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
    }
    
    .table td {
        vertical-align: middle;
        padding: 12px 8px;
    }
    
    .fa-star {
        color: #ffc107;
        font-size: 0.7rem;
    }
    
    .fa-star-empty {
        color: #dee2e6;
        font-size: 0.7rem;
    }
    
    .badge {
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .btn-group .btn {
        border-radius: 6px;
        margin: 0 2px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* 🔧 CSS UNTUK PAGINATION YANG LEBIH KONSISTEN */
    .pagination {
        font-size: 0.875rem;
        margin-bottom: 0;
    }
    
    .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .page-link:hover {
        color: #0d6efd;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    /* Menyamakan ukuran semua tombol pagination */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
</style>
@endsection