@extends('layouts.app')


@section('content')
    <!-- Hero Section -->
    <section
        class="relative bg-background text-foreground min-h-screen flex flex-col items-center justify-center text-center px-6 overflow-hidden">
        <!-- Gambar background -->
        <div class="absolute inset-0 bg-cover bg-center z-0"
            style="background-image: url('{{ asset('images/hd-bg.jpg') }}');">
        </div>

        <!-- Overlay abu-abu transparan -->
        <div class="absolute inset-0 bg-gray-700/60 z-10"></div>

        <!-- Konten -->
        <div class="relative z-20">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">
                Your Beauty, Our Priority
            </h1>
            <p class="text-gray-100 max-w-2xl mx-auto mb-8">
                — Wujudkan kecantikan impian Anda bersama kami —
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('reservasi.index') }}"
                    class="border border-gray text-white px-6 py-3 rounded-lg hover:bg-primary/90 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    Reservasi Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Mengapa Memilih Kami -->
    <section class="py-20 bg-background text-card-foreground">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold text-primary mb-6">Mengapa Memilih Gracias Clinic?</h2>
            <p class="text-muted-foreground max-w-2xl mx-auto mb-12">
                Kami berkomitmen memberikan pelayanan terbaik dengan standar internasional untuk kepuasan dan keamanan Anda.
            </p>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-card rounded-xl shadow-md p-6 border border-border hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" class="mx-auto w-16 h-16 mb-4"
                        alt="">
                    <h4 class="font-semibold text-primary mb-2">Dokter Berpengalaman</h4>
                    <p class="text-muted-foreground text-sm">Tim dokter ahli dengan pengalaman lebih dari 10 tahun di bidang
                        kecantikan.</p>
                </div>

                <div
                    class="bg-card rounded-xl shadow-md p-6 border border-border hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/4403/4403497.png" class="mx-auto w-16 h-16 mb-4"
                        alt="">
                    <h4 class="font-semibold text-primary mb-2">Fasilitas Modern</h4>
                    <p class="text-muted-foreground text-sm">Peralatan medis terkini dan teknologi canggih untuk hasil
                        optimal.</p>
                </div>

                <div
                    class="bg-card rounded-xl shadow-md p-6 border border-border hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/860/860916.png" class="mx-auto w-16 h-16 mb-4"
                        alt="">
                    <h4 class="font-semibold text-primary mb-2">Treatment Berkualitas</h4>
                    <p class="text-muted-foreground text-sm">Prosedur aman, teruji klinis, dan mengikuti standar
                        internasional.</p>
                </div>

                <div
                    class="bg-card rounded-xl shadow-md p-6 border border-border hover:-translate-y-2 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" class="mx-auto w-16 h-16 mb-4"
                        alt="">
                    <h4 class="font-semibold text-primary mb-2">Reservasi Mudah</h4>
                    <p class="text-muted-foreground text-sm">Sistem booking online yang mudah dan fleksibel sesuai jadwal
                        Anda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 💆‍♀️ Layanan Unggulan Kami --}}
    <section class="py-20 bg-card text-center">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-3 text-foreground">Layanan Unggulan Kami</h2>
            <p class="text-muted-foreground mb-12">Berbagai pilihan perawatan untuk kebutuhan kecantikan Anda</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Facial Treatment --}}
                <div
                    class="bg-background p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                    <div class="flex justify-center mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/4359/4359906.png" alt="Facial" class="w-16 h-16">
                    </div>
                    <h3 class="font-semibold text-lg text-card-foreground mb-2">Facial Treatment</h3>
                    <p class="text-muted-foreground">Perawatan wajah profesional untuk kulit sehat bercahaya</p>
                </div>

                {{-- Skin Rejuvenation --}}
                <div
                    class="bg-background p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                    <div class="flex justify-center mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/4207/4207254.png" alt="Rejuvenation"
                            class="w-16 h-16">
                    </div>
                    <h3 class="font-semibold text-lg text-card-foreground mb-2">Skin Rejuvenation</h3>
                    <p class="text-muted-foreground">Teknologi terkini untuk regenerasi kulit</p>
                </div>

                {{-- Aesthetic Injection --}}
                <div
                    class="bg-background p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                    <div class="flex justify-center mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/1116/1116453.png" alt="Injection"
                            class="w-16 h-16">
                    </div>
                    <h3 class="font-semibold text-lg text-card-foreground mb-2">Aesthetic Injection</h3>
                    <p class="text-muted-foreground">Perawatan anti-aging dengan hasil natural</p>
                </div>

                {{-- Body Treatment --}}
                <div
                    class="bg-background p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                    <div class="flex justify-center mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Body Treatment"
                            class="w-16 h-16">
                    </div>
                    <h3 class="font-semibold text-lg text-card-foreground mb-2">Body Treatment</h3>
                    <p class="text-muted-foreground">Perawatan tubuh untuk tampil lebih percaya diri</p>
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route('treatments.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-[#526D82] text-[#526D82] rounded-lg hover:bg-gray-400 hover:text-white transition duration-300">
                    Lihat Semua Treatment
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- 💬 Testimoni Pelanggan --}}
    <section class="py-20 bg-background text-center">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-3 text-foreground">Kata Mereka</h2>
            <p class="text-muted-foreground mb-12">Pengalaman pelanggan kami</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if ($featuredFeedbacks->isNotEmpty())
                    @foreach ($featuredFeedbacks as $feedback)
                        @php
                            // Hitung rata-rata rating yang lebih akurat
                            $ratings = [
                                $feedback->staff_rating,
                                $feedback->professional_rating,
                                $feedback->result_rating,
                                $feedback->return_rating,
                                $feedback->overall_rating,
                            ];
                            $validRatings = array_filter($ratings, function ($rating) {
                                return !is_null($rating) && $rating > 0;
                            });
                            $avg =
                                count($validRatings) > 0
                                    ? array_sum($validRatings) / count($validRatings)
                                    : $feedback->overall_rating;
                        @endphp

                        <div
                            class="bg-card p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                            <div class="flex justify-center mb-3 text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($avg) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-card-foreground mb-3 italic line-clamp-4">
                                "{{ $feedback->message ?: 'Pelayanan sangat memuaskan!' }}"
                            </p>

                            <p class="text-primary font-semibold">{{ $feedback->name ?: 'Pelanggan' }}</p>
                            <p class="text-sm text-muted-foreground mt-1">
                                {{ $feedback->created_at->format('M Y') }} •
                                Rating: {{ number_format($avg, 1) }}/5
                            </p>
                            @if ($feedback->service_type)
                                <p class="text-xs text-muted-foreground mt-1">{{ $feedback->service_type }}</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    {{-- Tampilan fallback ketika belum ada feedback yang dipilih admin --}}
                    <div
                        class="bg-card p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                        <div class="flex justify-center mb-3 text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                        <p class="text-card-foreground mb-3">"Pelayanan sangat profesional dan hasil treatment sangat
                            memuaskan!"</p>
                        <p class="text-primary font-semibold">Rini Kusuma</p>
                        <p class="text-sm text-muted-foreground mt-1">Facial Treatment</p>
                    </div>

                    <div
                        class="bg-card p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                        <div class="flex justify-center mb-3 text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                        <p class="text-card-foreground mb-3">"Tempat nyaman, dokter ramah, dan hasilnya langsung terlihat."
                        </p>
                        <p class="text-primary font-semibold">Sari Dewi</p>
                        <p class="text-sm text-muted-foreground mt-1">Skin Rejuvenation</p>
                    </div>

                    <div
                        class="bg-card p-8 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-2 transition-all duration-300 border border-border">
                        <div class="flex justify-center mb-3 text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                        <p class="text-card-foreground mb-3">"Gracias Clinic adalah tempat terbaik untuk perawatan
                            kecantikan."</p>
                        <p class="text-primary font-semibold">Maya Sari</p>
                        <p class="text-sm text-muted-foreground mt-1">Aesthetic Injection</p>
                    </div>
                @endif
            </div>

            <div class="mt-10">
    @auth
        {{-- ✅ Jika user sudah login, langsung buka halaman feedback --}}
        <a href="{{ route('feedback.create') }}"
            class="inline-flex items-center px-6 py-3 border border-gray-800 text-gray-800 rounded-lg hover:bg-gray-600 hover:text-white transition duration-300">
            Berikan Feedback Anda
        </a>
    @else
        {{-- 🚪 Jika belum login, arahkan ke login dan simpan halaman tujuan --}}
        <a href="{{ route('login') }}"
            onclick="event.preventDefault(); 
                     sessionStorage.setItem('intended', '{{ route('feedback.create') }}');
                     window.location.href='{{ route('login') }}';"
            class="inline-flex items-center px-6 py-3 border border-gray-800 text-gray-800 rounded-lg hover:bg-gray-600 hover:text-white transition duration-300">
            Berikan Feedback Anda
        </a>
    @endauth
</div>

        </div>
    </section>

@endsection

@section('styles')
    <style>
        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
