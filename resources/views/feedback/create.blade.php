@extends('layouts.app')

@section('content')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
    body {
        background: white;
        font-family: 'Inter', sans-serif;
    }

    .feedback-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .feedback-header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 2.3rem;
        color: #2b2b2b;
        line-height: 1.3;
    }

    .feedback-card {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 3rem;
        max-width: 1100px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .feedback-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.25);
    }

    @media (max-width: 992px) {
        .feedback-card {
            padding: 2rem;
            max-width: 95%;
        }

        .feedback-header h1 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .feedback-card {
            padding: 1.5rem;
            border-radius: 15px;
        }

        .feedback-header h1 {
            font-size: 1.6rem;
        }

        .btn {
            width: 100%;
        }
    }

    label {
        font-weight: 500;
        color: #333;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
    }

    textarea {
        resize: none;
        border-radius: 10px;
    }

    /* ⭐ STAR RATING STYLE */
    .rating-stars {
        display: flex;
        gap: 8px;
        cursor: pointer;
        font-size: 1.6rem;
        color: #ccc;
        transition: all 0.3s ease;
    }

    .rating-stars i {
        transition: all 0.15s ease;
    }

    .rating-stars i.active {
        color: #f5b301;
    }

    .rating-stars i.hovered {
        color: #f8c93b;
        transform: scale(1.15);
    }

    .btn-primary {
        background-color: #304ffe;
        border-color: #304ffe;
        border-radius: 10px;
        padding: 10px 25px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #1e40ff;
    }

    hr {
        border-top: 1px solid #e0e0e0;
    }

    /* 🧭 Responsivitas tambahan */
    @media (max-width: 768px) {
        label {
            font-size: 0.95rem;
        }

        .form-control {
            font-size: 0.95rem;
            padding: 8px 12px;
        }

        input::placeholder,
        textarea::placeholder {
            font-size: 0.9rem;
            white-space: normal;
        }

        .rating-stars {
            font-size: 1.4rem;
        }

        h5.text-center {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .feedback-card {
            padding: 1.2rem;
            border-radius: 10px;
        }

        .feedback-header h1 {
            font-size: 1.4rem;
        }

        .form-control,
        label {
            width: 100%;
        }

        input::placeholder,
        textarea::placeholder {
            font-size: 0.85rem;
        }

        .btn {
            width: 100%;
            font-size: 0.95rem;
        }

        .rating-stars {
            justify-content: space-between;
        }
    }
</style>

<div class="container my-5">
    <div class="feedback-header">
        <h1>Better Care Starts<br>with Your Words</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="feedback-card">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            <!-- 🧍 Data Diri -->
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                </div>

                <div class="col-12 col-md-6">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Masukkan nomor telepon Anda" pattern="[0-9]{11,}" minlength="11" maxlength="15">
                </div>

                <div class="col-12 col-md-6">
                    <label for="service_type">Jenis Layanan</label>
                    <input type="text" id="service_type" name="service_type" class="form-control" placeholder="Contoh: Perawatan wajah, terapi, dll">
                </div>
            </div>

            <hr class="my-4">

            <!-- 🌟 Penilaian -->
            <h5 class="mb-3 text-center fw-bold text-secondary">Penilaian Anda (1–5 ⭐)</h5>
            <div class="row g-4">
                @php
                    $ratings = [
                        'staff_rating' => 'Staf klinik tanggap terhadap kebutuhan saya.',
                        'professional_rating' => 'Dokter/terapis bersikap profesional selama perawatan.',
                        'result_rating' => 'Hasil perawatan sesuai dengan harapan saya.',
                        'return_rating' => 'Saya ingin kembali melakukan perawatan di klinik ini.',
                        'overall_rating' => 'Secara keseluruhan, saya puas dengan layanan klinik ini.'
                    ];
                @endphp

                @foreach ($ratings as $field => $label)
                    <div class="col-12 col-sm-6">
                        <label>{{ $label }}</label>
                        <div class="d-flex align-items-center justify-content-start rating-stars flex-wrap" data-field="{{ $field }}">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="{{ $field }}" required>
                    </div>
                @endforeach
            </div>

            <!-- 💬 Pesan -->
            <div class="mt-4">
                <label for="message">Pesan / Saran</label>
                <textarea id="message" name="message" class="form-control" rows="4" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>

            <!-- 📨 Tombol Submit -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 w-100 w-md-auto" style="background-color:#434F5D;border:none;">Kirim Feedback</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.rating-stars').forEach(starGroup => {
    const stars = starGroup.querySelectorAll('i');
    const input = starGroup.nextElementSibling;
    let currentValue = 0;

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            currentValue = index + 1;
            input.value = currentValue;
            updateStars();
        });

        star.addEventListener('mouseenter', () => updateStars(index + 1));
        star.addEventListener('mouseleave', () => updateStars());
    });

    function updateStars(tempValue = currentValue) {
        stars.forEach((s, i) => {
            s.classList.remove('active', 'hovered');
            if (i < tempValue) s.classList.add(tempValue === currentValue ? 'active' : 'hovered');
        });
    }
});
</script>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Terima Kasih Sudah Bersuara!',
    text: '{{ session("success") }}',
    confirmButtonColor: '#3b82f6',
    background: 'rgba(255, 255, 255, 0.9)',
    backdrop: `rgba(0,0,0,0.3)
        url("https://cdn.jsdelivr.net/gh/galanghm/assets/checkmark.gif")
        center top
        no-repeat`
}).then(() => {
    document.querySelector('form').reset();
    document.querySelectorAll('.fa-star').forEach(s => s.classList.remove('active', 'hovered'));
});
</script>
@endif
@endsection
