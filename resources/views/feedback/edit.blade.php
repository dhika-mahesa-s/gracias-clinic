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
            <div class="card shadow-sm border-0 rounded-4">
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
                                       value="{{ old('name', $feedback->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $feedback->email) }}" required>
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
                                <select name="service_type" class="form-select @error('service_type') is-invalid @enderror">
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

                            @php
                                $fields = [
                                    'staff_rating' => 'Staf Klinik',
                                    'professional_rating' => 'Profesionalitas',
                                    'result_rating' => 'Hasil Perawatan',
                                    'return_rating' => 'Kembali Berobat',
                                    'overall_rating' => 'Kepuasan Keseluruhan'
                                ];
                            @endphp

                            @foreach ($fields as $name => $label)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">{{ $label }} <span class="text-danger">*</span></label>
                                    <select name="{{ $name }}" class="form-select @error($name) is-invalid @enderror" required>
                                        <option value="">Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old($name, $feedback->$name) == $i ? 'selected' : '' }}>
                                                {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error($name)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <!-- Message Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-comment me-2"></i>Pesan Tambahan
                                </h5>
                                <textarea name="message" 
                                          class="form-control @error('message') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Masukkan pesan atau komentar tambahan...">{{ old('message', $feedback->message) }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons (tanpa tombol Batal) -->
                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center gap-2">
                            <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-outline-secondary w-100 w-md-auto">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                            </a>

                            <button type="submit" class="btn btn-primary w-100 w-md-auto">
                                <i class="fas fa-save me-2"></i>Update Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Rating -->
            <div class="card mt-4 shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-semibold d-flex align-items-center">
                    <i class="fas fa-chart-bar me-2"></i> Ringkasan Rating Saat Ini
                </div>
                <div class="card-body text-center">
                    @php
                        $currentAvg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                    @endphp
                    <div class="row g-3">
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-primary">{{ $feedback->staff_rating }}/5</h5>
                            <p class="text-muted mb-0">Staf</p>
                        </div>
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-primary">{{ $feedback->professional_rating }}/5</h5>
                            <p class="text-muted mb-0">Profesional</p>
                        </div>
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-primary">{{ $feedback->result_rating }}/5</h5>
                            <p class="text-muted mb-0">Hasil</p>
                        </div>
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-primary">{{ $feedback->return_rating }}/5</h5>
                            <p class="text-muted mb-0">Kembali</p>
                        </div>
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-primary">{{ $feedback->overall_rating }}/5</h5>
                            <p class="text-muted mb-0">Keseluruhan</p>
                        </div>
                        <div class="col-6 col-md-2">
                            <h5 class="fw-bold text-success">{{ number_format($currentAvg, 1) }}/5</h5>
                            <p class="text-muted mb-0">Rata-rata</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
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

    @media (max-width: 576px) {
        .container {
            padding-left: 8px;
            padding-right: 8px;
        }

        .card-body {
            padding: 1rem 1.2rem;
        }

        h1.display-5 {
            font-size: 1.3rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
        }

        .card-body .row.text-center {
            justify-content: center;
        }

        .card-body .row.text-center > div {
            flex: 0 0 45%;
        }
    }
</style>

@endsection
git 