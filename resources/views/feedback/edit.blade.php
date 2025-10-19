@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-dark mb-2">Edit Feedback</h1>
                <p class="text-muted">Perbarui data feedback dari pengguna</p>
            </div>

            <!-- Edit Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Pengguna -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>Informasi Pengguna
                                </h5>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $feedback->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $feedback->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="tel" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $feedback->phone) }}" 
                                       placeholder="Opsional"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Layanan</label>
                                <select name="service_type" class="form-control @error('service_type') is-invalid @enderror">
                                    <option value="">Pilih Layanan</option>
                                    <option value="Facial" {{ old('service_type', $feedback->service_type) == 'Facial' ? 'selected' : '' }}>Facial</option>
                                    <option value="Injection" {{ old('service_type', $feedback->service_type) == 'Injection' ? 'selected' : '' }}>Injection</option>
                                    <option value="Laser" {{ old('service_type', $feedback->service_type) == 'Laser' ? 'selected' : '' }}>Laser Treatment</option>
                                    <option value="Konsultasi" {{ old('service_type', $feedback->service_type) == 'Konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                                    <option value="Lainnya" {{ old('service_type', $feedback->service_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-star me-2"></i>Rating & Penilaian
                                </h5>
                            </div>
                            
                            <!-- Staff Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Staf Klinik <span class="text-danger">*</span></label>
                                <select name="staff_rating" class="form-control @error('staff_rating') is-invalid @enderror" required>
                                    <option value="">Pilih Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('staff_rating', $feedback->staff_rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-muted">Staf klinik tanggap terhadap kebutuhan saya</small>
                                @error('staff_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Professional Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Profesionalitas <span class="text-danger">*</span></label>
                                <select name="professional_rating" class="form-control @error('professional_rating') is-invalid @enderror" required>
                                    <option value="">Pilih Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('professional_rating', $feedback->professional_rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-muted">Dokter/terapis bersikap professional</small>
                                @error('professional_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Result Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Hasil Perawatan <span class="text-danger">*</span></label>
                                <select name="result_rating" class="form-control @error('result_rating') is-invalid @enderror" required>
                                    <option value="">Pilih Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('result_rating', $feedback->result_rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-muted">Hasil perawatan sesuai harapan</small>
                                @error('result_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Return Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kembali Berobat <span class="text-danger">*</span></label>
                                <select name="return_rating" class="form-control @error('return_rating') is-invalid @enderror" required>
                                    <option value="">Pilih Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('return_rating', $feedback->return_rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-muted">Saya ingin kembali melakukan perawatan</small>
                                @error('return_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Overall Rating -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Kepuasan Keseluruhan <span class="text-danger">*</span></label>
                                <select name="overall_rating" class="form-control @error('overall_rating') is-invalid @enderror" required>
                                    <option value="">Pilih Rating</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('overall_rating', $feedback->overall_rating) == $i ? 'selected' : '' }}>
                                            {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                        </option>
                                    @endfor
                                </select>
                                <small class="text-muted">Secara keseluruhan, saya puas dengan layanan</small>
                                @error('overall_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Message Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-comment me-2"></i>Pesan Tambahan
                                </h5>
                                <label class="form-label fw-semibold">Pesan/Komentar</label>
                                <textarea name="message" 
                                          class="form-control @error('message') is-invalid @enderror" 
                                          rows="4" 
                                          placeholder="Masukkan pesan atau komentar tambahan...">{{ old('message', $feedback->message) }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                                    </a>
                                    <div>
                                        <a href="{{ route('feedback.index') }}" class="btn btn-light me-2">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Feedback
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Rating Summary -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ringkasan Rating Saat Ini</h6>
                </div>
                <div class="card-body">
                    @php
                        $currentAvg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                    @endphp
                    <div class="row text-center">
                        <div class="col-md-2 mb-3">
                            <div class="text-primary fw-bold fs-5">{{ $feedback->staff_rating }}/5</div>
                            <small class="text-muted">Staf</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-primary fw-bold fs-5">{{ $feedback->professional_rating }}/5</div>
                            <small class="text-muted">Profesional</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-primary fw-bold fs-5">{{ $feedback->result_rating }}/5</div>
                            <small class="text-muted">Hasil</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-primary fw-bold fs-5">{{ $feedback->return_rating }}/5</div>
                            <small class="text-muted">Kembali</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-primary fw-bold fs-5">{{ $feedback->overall_rating }}/5</div>
                            <small class="text-muted">Keseluruhan</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-success fw-bold fs-5">{{ number_format($currentAvg, 1) }}/5</div>
                            <small class="text-muted">Rata-rata</small>
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
    
    .form-control, .form-select {
        border-radius: 10px;
    }
    
    .btn {
        border-radius: 10px;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
</style>
@endsection