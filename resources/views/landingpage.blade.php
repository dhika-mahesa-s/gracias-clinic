@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-background text-foreground min-h-screen flex flex-col items-center justify-center text-center px-6 overflow-hidden">
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
        
        {{-- Kondisi tombol berdasarkan status login --}}
        <div class="flex justify-center gap-4">
            @guest
                {{-- Jika user belum login --}}
                <a href="{{ route('register') }}"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow hover:bg-gray-400 transition">
                    Reservasi Sekarang
                </a>

            @endguest

            @auth
                {{-- Jika user sudah login --}}
                <a href="{{ route('reservasi.index') }}"
                    class="bg-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow hover:bg-gray-400 transition">
                    Reservasi Sekarang
                </a>
            @endauth
        </div>
    </div>
</section>


            {{-- 💆‍♀️ Layanan Unggulan Kami --}}
            <section class="py-20 bg-gray-50 text-center">
                <div class="max-w-6xl mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-3">Layanan Unggulan Kami</h2>
                    <p class="text-gray-600 mb-12">Berbagai pilihan perawatan untuk kebutuhan kecantikan Anda</p>
        
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {{-- Facial Treatment --}}
                        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex justify-center mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/4359/4359906.png" alt="Facial" class="w-16 h-16">
                            </div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Facial Treatment</h3>
                            <p class="text-gray-500">Perawatan wajah profesional untuk kulit sehat bercahaya</p>
                        </div>
        
                        {{-- Skin Rejuvenation --}}
                        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex justify-center mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/4207/4207254.png" alt="Rejuvenation" class="w-16 h-16">
                            </div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Skin Rejuvenation</h3>
                            <p class="text-gray-500">Teknologi terkini untuk regenerasi kulit</p>
                        </div>
        
                        {{-- Aesthetic Injection --}}
                        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex justify-center mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/1116/1116453.png" alt="Injection" class="w-16 h-16">
                            </div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Aesthetic Injection</h3>
                            <p class="text-gray-500">Perawatan anti-aging dengan hasil natural</p>
                        </div>
        
                        {{-- Body Treatment --}}
                        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex justify-center mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Body Treatment" class="w-16 h-16">
                            </div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">Body Treatment</h3>
                            <p class="text-gray-500">Perawatan tubuh untuk tampil lebih percaya diri</p>
                        </div>
                    </div>
        
                    <div class="mt-10">
                        <a href="{{ route('treatments.index') }}" class="inline-flex items-center px-6 py-3 border border-[#526D82] text-[#526D82] rounded-lg hover:bg-gray-200 transition">
                            Lihat Semua Treatment
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </section>

     {{-- 💬 Testimoni Pelanggan --}}
     <section class="py-10 bg-gray-50 text-center">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-3">Kata Mereka</h2>
            <p class="text-gray-600 mb-12">Pengalaman pelanggan kami</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Testi 1 --}}
                <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                    <div class="flex justify-center mb-3 text-[#FFD700]">
                        <span>★★★★★</span>
                    </div>
                    <p class="text-gray-700 mb-3">"Pelayanan sangat profesional dan hasil treatment sangat memuaskan!"</p>
                    <p class="text-[#526D82] font-semibold">Rini Kusuma</p>
                </div>

                {{-- Testi 2 --}}
                <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                    <div class="flex justify-center mb-3 text-[#FFD700]">
                        <span>★★★★★</span>
                    </div>
                    <p class="text-gray-700 mb-3">"Tempat nyaman, dokter ramah, dan hasilnya langsung terlihat."</p>
                    <p class="text-[#526D82] font-semibold">Rini Kusuma</p>
                </div>

                {{-- Testi 3 --}}
                <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-2 transition-transform duration-300">
                    <div class="flex justify-center mb-3 text-[#FFD700]">
                        <span>★★★★★</span>
                    </div>
                    <p class="text-gray-700 mb-3">"Gracias Clinic adalah tempat terbaik untuk perawatan kecantikan."</p>
                    <p class="text-[#526D82] font-semibold">Rini Kusuma</p>
                </div>
            </div>

            <div class="mt-10">
                <a href="{{ route ('feedback.create') }}" class="inline-flex items-center px-6 py-3 border border-gray-800 text-gray-800 rounded-lg hover:bg-gray-800 hover:text-white transition">
                    Berikan Feedback Anda
                </a>
            </div>
        </div>
    </section>


@endsection
