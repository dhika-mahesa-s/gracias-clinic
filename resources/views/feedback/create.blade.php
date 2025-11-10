@extends('layouts.app')

@section('content')
    <!-- 🌟 FEEDBACK FORM SECTION -->
    <div class="min-h-screen py-12 bg-background">
        <div class="container mx-auto px-4 lg:px-8">
            
            <!-- Header Section -->
            <div class="text-center mb-12 animate-fade-in">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-2xl mb-6 shadow-lg hover-lift">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-foreground mb-4 animate-slide-up">
                    Better Care Starts
                </h1>
                <p class="text-3xl md:text-4xl font-bold text-primary animate-slide-up delay-75">
                    with Your Words
                </p>
                <p class="text-muted-foreground mt-4 max-w-2xl mx-auto animate-slide-up delay-100">
                    Pendapat Anda sangat berarti bagi kami untuk terus meningkatkan kualitas layanan
                </p>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="max-w-4xl mx-auto mb-8 animate-slide-down">
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-6 shadow-lg">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-semibold text-red-800 mb-2">Terjadi Kesalahan:</h3>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-card rounded-3xl shadow-2xl border border-border overflow-hidden animate-scale-in">
                    
                    <!-- Form Header -->
                    <div class="bg-primary p-8 text-primary-foreground">
                        <div class="flex items-center gap-4 animate-slide-right">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold mb-1">Form Feedback</h2>
                                <p class="text-primary-foreground/80 text-sm">Bagikan pengalaman Anda dengan kami</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <form action="{{ route('feedback.store') }}" method="POST" class="p-8 space-y-8">
                        @csrf

                        <!-- Data Pengguna Section -->
                        <div class="animate-slide-up delay-75">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-foreground">Informasi Anda</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-foreground mb-2">Nama</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ $user->name }}" 
                                        readonly
                                        class="w-full px-4 py-3.5 rounded-xl border-2 border-border bg-muted text-muted-foreground cursor-not-allowed"
                                    >
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-foreground mb-2">Email</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ $user->email }}" 
                                        readonly
                                        class="w-full px-4 py-3.5 rounded-xl border-2 border-border bg-muted text-muted-foreground cursor-not-allowed"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Pilih Reservasi Section -->
                        <div class="animate-slide-up delay-100">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-foreground">Pilih Reservasi</h3>
                            </div>

                            <label for="reservation_id" class="block text-sm font-medium text-foreground mb-2">
                                Pilih Reservasi yang Ingin Diberi Feedback
                            </label>
                            <div class="relative">
                                <select 
                                    name="reservation_id" 
                                    id="reservation_id"
                                    required
                                    class="w-full px-4 py-3.5 rounded-xl border-2 border-border bg-card text-foreground focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:border-border/80 appearance-none"
                                >
                                    @if ($reservations->isEmpty())
                                        <option value="" disabled selected>
                                            Anda belum pernah melakukan reservasi atau reservasi anda belum selesai dilakukan
                                        </option>
                                    @else
                                        <option value="" disabled selected>-- Pilih Reservasi --</option>
                                        @foreach ($reservations as $r)
                                            <option value="{{ $r->id }}">
                                                {{ $r->treatment->name }} dengan {{ $r->doctor->name }} pada {{ \Carbon\Carbon::parse($r->reservation_date)->format('d-m-Y') }} : ({{ $r->reservation_time }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t-2 border-border"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-4 bg-card text-sm font-medium text-muted-foreground">Rating & Review</span>
                            </div>
                        </div>

                        <!-- Penilaian Section -->
                        <div class="animate-slide-up delay-150">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-foreground">Penilaian Anda (1–5 ⭐)</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-6">
                                @php
                                    $ratings = [
                                        'staff_rating' => [
                                            'label' => 'Staf klinik tanggap terhadap kebutuhan saya.',
                                            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                                        ],
                                        'professional_rating' => [
                                            'label' => 'Dokter/terapis bersikap profesional selama perawatan.',
                                            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                                        ],
                                        'result_rating' => [
                                            'label' => 'Hasil perawatan sesuai harapan saya.',
                                            'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                                        ],
                                        'return_rating' => [
                                            'label' => 'Saya ingin kembali melakukan perawatan di klinik ini.',
                                            'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                                        ],
                                        'overall_rating' => [
                                            'label' => 'Secara keseluruhan, saya puas dengan layanan klinik ini.',
                                            'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'
                                        ],
                                    ];
                                @endphp

                                @foreach ($ratings as $field => $data)
                                    <div class="p-5 bg-muted/30 rounded-xl border-2 border-border hover:border-primary/30 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-start gap-4">
                                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <label class="block font-medium text-foreground mb-3">{{ $data['label'] }}</label>
                                                <div class="flex items-center gap-2 rating-stars text-3xl" data-field="{{ $field }}">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star cursor-pointer text-border hover:scale-125 transition-all duration-200" data-value="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="{{ $field }}" required>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pesan Section -->
                        <div class="animate-slide-up delay-200">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-foreground">Pesan / Saran</h3>
                            </div>
                            
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5"
                                class="w-full px-4 py-3.5 rounded-xl border-2 border-border bg-card text-foreground focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:border-border/80 resize-none"
                                placeholder="Ceritakan pengalaman Anda di Gracias Clinic... (opsional)"
                            ></textarea>
                            <p class="text-sm text-muted-foreground mt-2">Maksimal 1000 karakter</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 animate-slide-up delay-250">
                            <button 
                                type="submit" 
                                class="w-full bg-primary text-primary-foreground py-4 rounded-xl font-semibold text-lg hover-lift hover:shadow-2xl active-press transition-smooth-fast flex items-center justify-center gap-3 group"
                            >
                                <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span>Kirim Feedback</span>
                            </button>
                        </div>

                        <!-- Back Link -->
                        <div class="text-center animate-fade-in delay-300">
                            <a href="{{ route('landingpage') }}" class="text-sm text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-1 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Card -->
                <div class="mt-8 p-6 bg-primary/5 rounded-2xl border-2 border-primary/20 animate-fade-in delay-300">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-foreground mb-2">Mengapa Feedback Anda Penting?</h4>
                            <p class="text-sm text-muted-foreground leading-relaxed">
                                Setiap masukan dari Anda membantu kami untuk terus berinovasi dan memberikan layanan terbaik. 
                                Feedback Anda akan kami review dan gunakan untuk meningkatkan pengalaman pelanggan di masa mendatang.
                            </p>
                        </div>
                    </div>
                </div>
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
                
                star.addEventListener('mouseenter', () => {
                    updateStars(index + 1);
                });
                
                group.addEventListener('mouseleave', () => {
                    updateStars();
                });
            });

            function updateStars(tempValue = currentValue) {
                stars.forEach((s, i) => {
                    s.classList.remove('text-yellow-400', 'scale-125');
                    s.classList.add('text-border');
                    
                    if (i < tempValue) {
                        s.classList.remove('text-border');
                        s.classList.add('text-yellow-400', 'scale-125');
                    }
                });
            }
        });
    </script>

    <!-- ✅ SweetAlert Success -->
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Terima Kasih Sudah Bersuara!',
                html: '<p class="text-gray-600">{{ session('success') }}</p>',
                confirmButtonText: 'Kembali ke Beranda',
                confirmButtonColor: 'oklch(0.4815 0.1178 263.3758)',
                showCancelButton: true,
                cancelButtonText: 'Tutup',
                cancelButtonColor: '#6b7280',
                background: '#fff',
                backdrop: `rgba(72, 101, 185, 0.2)`,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('landingpage') }}";
                } else {
                    // Reset form
                    document.querySelector('form').reset();
                    document.querySelectorAll('.fa-star').forEach(s => {
                        s.classList.remove('text-yellow-400', 'scale-125');
                        s.classList.add('text-border');
                    });
                    document.querySelectorAll('input[type="hidden"]').forEach(input => {
                        input.value = '';
                    });
                }
            });
        </script>
    @endif
@endsection