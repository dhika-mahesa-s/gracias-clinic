@extends('layouts.app')

@section('content')

<!-- 🌟 SECTION: FEEDBACK FORM -->
<div class="py-16 bg-gradient-to-br from-blue-50 via-gray-100 to-gray-200">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                Better Care Starts<br>
                <span class="text-blue-600">with Your Words</span>
            </h1>
        </div>

        <!-- Alert Error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8 shadow">
                <strong class="block mb-2">Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white/80 backdrop-blur-lg border border-gray-200 shadow-2xl rounded-2xl max-w-5xl mx-auto p-8 md:p-12">
            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Data Diri -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" readonly
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="email" class="block font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" readonly
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                <hr class="my-8 border-gray-300">

                <!-- Penilaian -->
                <div>
                    <h5 class="text-center font-semibold text-gray-700 text-2xl mb-8">
                        Penilaian Anda (1–5 ⭐)
                    </h5>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $ratings = [
                                'staff_rating' => 'Staf klinik tanggap terhadap kebutuhan saya.',
                                'professional_rating' => 'Dokter/terapis bersikap profesional selama perawatan.',
                                'result_rating' => 'Hasil perawatan sesuai harapan saya.',
                                'return_rating' => 'Saya ingin kembali melakukan perawatan di klinik ini.',
                                'overall_rating' => 'Secara keseluruhan, saya puas dengan layanan klinik ini.'
                            ];
                        @endphp

                        @foreach ($ratings as $field => $label)
                            <div>
                                <label class="block font-medium text-gray-700 mb-2">{{ $label }}</label>
                                <div class="flex items-center gap-2 rating-stars text-xl text-gray-400" data-field="{{ $field }}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="{{ $field }}" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pesan -->
                <div>
                    <label for="message" class="block font-medium text-gray-700 mb-2">Pesan / Saran</label>
                    <textarea id="message" name="message" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Ceritakan pengalaman Anda..."></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-gray-800 text-white font-medium px-8 py-3 rounded-lg hover:bg-gray-900 transform hover:-translate-y-1 transition-all shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ⭐ JS Rating -->
<script>
document.querySelectorAll('.rating-stars').forEach(group => {
    const stars = group.querySelectorAll('i');
    const input = group.nextElementSibling;
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
            s.classList.remove('text-yellow-400', 'scale-110');
            if (i < tempValue) s.classList.add('text-yellow-400', 'scale-110');
        });
    }
});
</script>

<!-- ✅ SweetAlert Success -->
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Terima Kasih Sudah Bersuara!',
    text: '{{ session("success") }}',
    confirmButtonColor: '#3b82f6',
    background: '#fff',
    backdrop: `rgba(0,0,0,0.3)
        url("https://cdn.jsdelivr.net/gh/galanghm/assets/checkmark.gif")
        center top no-repeat`
}).then(() => {
    document.querySelector('form').reset();
    document.querySelectorAll('.fa-star').forEach(s => s.classList.remove('text-yellow-400', 'scale-110'));
});
</script>
@endif
@endsection
