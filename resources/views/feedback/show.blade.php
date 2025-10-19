@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold text-dark mb-1">Detail Feedback</h1>
            <p class="text-muted mb-0">Informasi lengkap feedback dari pengguna</p>
        </div>
        <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Feedback Detail Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-user me-2"></i>Informasi Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                            <p class="fs-6">{{ $feedback->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Email</label>
                            <p class="fs-6">{{ $feedback->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Nomor Telepon</label>
                            <p class="fs-6">{{ $feedback->phone ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Layanan</label>
                            <p class="fs-6">
                                @if($feedback->service_type)
                                    <span class="badge bg-info text-dark">{{ $feedback->service_type }}</span>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold text-muted">Tanggal Submit</label>
                            <p class="fs-6">{{ $feedback->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating Details Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-star me-2"></i>Rating & Penilaian
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                    @endphp
                    
                    <div class="mb-4 text-center">
                        <h4 class="text-primary">Rating Rata-rata</h4>
                        <div class="display-4 fw-bold text-primary mb-2">{{ number_format($avg, 1) }}/5</div>
                        <div class="text-warning mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($avg) ? '' : '-empty' }} fa-2x"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="rating-items">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <h6 class="mb-1">Staf klinik tanggap terhadap kebutuhan saya</h6>
                                <small class="text-muted">Responsivitas staf</small>
                            </div>
                            <div class="text-end">
                                <div class="text-warning mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->staff_rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $feedback->staff_rating }}/5</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <h6 class="mb-1">Dokter/terapis bersikap professional</h6>
                                <small class="text-muted">Profesionalitas tenaga medis</small>
                            </div>
                            <div class="text-end">
                                <div class="text-warning mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->professional_rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $feedback->professional_rating }}/5</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <h6 class="mb-1">Hasil perawatan sesuai harapan</h6>
                                <small class="text-muted">Kepuasan hasil treatment</small>
                            </div>
                            <div class="text-end">
                                <div class="text-warning mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->result_rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $feedback->result_rating }}/5</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <h6 class="mb-1">Keinginan untuk kembali berobat</h6>
                                <small class="text-muted">Loyalitas pengguna</small>
                            </div>
                            <div class="text-end">
                                <div class="text-warning mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->return_rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $feedback->return_rating }}/5</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <div>
                                <h6 class="mb-1">Kepuasan keseluruhan layanan</h6>
                                <small class="text-muted">Total experience</small>
                            </div>
                            <div class="text-end">
                                <div class="text-warning mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $feedback->overall_rating ? '' : '-empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $feedback->overall_rating }}/5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Message Card -->
            @if($feedback->message)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-comment me-2"></i>Pesan Tambahan
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $feedback->message }}</p>
                </div>
            </div>
            @endif

            <!-- Action Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-cog me-2"></i>Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Feedback
                        </a>
                        <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus feedback dari {{ $feedback->name }}?')">
                                <i class="fas fa-trash me-2"></i>Hapus Feedback
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-chart-bar me-2"></i>Ringkasan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-primary fw-bold fs-4">{{ $feedback->staff_rating }}</div>
                            <small class="text-muted">Rating Staf</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-primary fw-bold fs-4">{{ $feedback->professional_rating }}</div>
                            <small class="text-muted">Profesionalitas</small>
                        </div>
                        <div class="col-6">
                            <div class="text-primary fw-bold fs-4">{{ $feedback->result_rating }}</div>
                            <small class="text-muted">Hasil</small>
                        </div>
                        <div class="col-6">
                            <div class="text-primary fw-bold fs-4">{{ $feedback->return_rating }}</div>
                            <small class="text-muted">Kembali</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .card {
        border-radius: 15px;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .fa-star {
        color: #ffc107;
    }
    
    .fa-star-empty {
        color: #dee2e6;
    }
    
    .rating-items .bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
    }
    
    .badge {
        border-radius: 8px;
        font-weight: 500;
    }
    
    .btn {
        border-radius: 10px;
    }
</style>
@endsection