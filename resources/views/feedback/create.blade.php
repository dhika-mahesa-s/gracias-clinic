@extends('layouts.app')

@section('content')
<!-- Include Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

    /* ⭐ STAR RATING STYLE */
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

    /* Custom styles untuk efek glassmorphism yang sama */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Pastikan font Playfair Display digunakan */
    .playfair-font {
        font-family: 'Playfair Display', serif;
    }

    /* Style khusus untuk tombol agar pasti muncul */
    .submit-button {
        background-color: #434F5D !important;
        color: white !important;
        padding: 12px 32px !important;
        border-radius: 10px !important;
        font-weight: 500 !important;
        font-size: 16px !important;
        border: none !important;
        cursor: pointer !important;
        display: inline-block !important;
        text-align: center !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
    }

    .submit-button:hover {
        background-color: #374151 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
</style>

<div class="container mx-auto my-8 px-4 bg-[#E3EAF2]">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="playfair-font font-semibold text-2xl sm:text-3xl md:text-4xl text-gray-800 leading-tight">
            Better Care Starts<br>with Your Words
        </h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold">Terjadi kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Feedback Card -->
    <div class="glass-card rounded-2xl shadow-lg p-6 md:p-8 lg:p-12 max-w-4xl lg:max-w-6xl mx-auto transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            <!-- Data Diri -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label for="name" class="block font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama Anda" required>
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan email Anda" required>
                </div>

                <div>
                    <label for="phone" class="block font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nomor telepon Anda" pattern="[0-9]{11,}" minlength="11" maxlength="15">
                </div>

                <div>
                    <label for="service_type" class="block font-medium text-gray-700 mb-2">Jenis Layanan</label>
                    <input type="text" id="service_type" name="service_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Contoh: Perawatan wajah, terapi, dll">
                </div>
            </div>

            <hr class="my-6 md:my-8 border-gray-300">

            <!-- Penilaian -->
            <h5 class="text-center font-bold text-gray-700 text-2xl md:text-2xl mb-4 md:mb-6">Penilaian Anda (1–5 ⭐)</h5>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
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
                    <div>
                        <label class="block font-medium text-gray-700 mb-2 text-sm md:text-base">{{ $label }}</label>
                        <div class="flex items-center justify-start gap-2 flex-wrap rating-stars text-xl md:text-2xl text-gray-400 cursor-pointer" data-field="{{ $field }}">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="{{ $field }}" required>
                    </div>
                @endforeach
            </div>

            <!-- Pesan -->
            <div class="mt-6 md:mt-8">
                <label for="message" class="block font-medium text-gray-700 mb-2">Pesan / Saran</label>
                <textarea id="message" name="message" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>

            <!-- Tombol Submit - DIPERBAIKI DENGAN STYLE KHUSUS -->
            <div class="text-center mt-8 pt-6">
                <button type="submit" class="submit-button">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Feedback
                </button>
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