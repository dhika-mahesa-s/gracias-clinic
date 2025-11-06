@extends('layouts.app')

@section('title', 'Tentang Kami - Gracias Aesthetic Clinic')

@section('content')
<div class="relative min-h-screen bg-background overflow-hidden">

    {{-- Hero Section with Gradient Background --}}
    <section class="relative py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-primary/10 via-background to-primary/5 overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-primary/10 rounded-full blur-3xl animate-pulse-slow delay-200"></div>
        
        <div class="relative max-w-7xl mx-auto text-center animate-fade-in">
            <div class="inline-flex items-center justify-center p-3 bg-gradient-to-br from-primary to-primary/80 rounded-2xl shadow-lg mb-6 animate-bounce-slow">
                <i class="fa-solid fa-heart-pulse text-primary-foreground text-3xl"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-foreground mb-6 animate-slide-up delay-75">
                Tentang <span class="text-primary">Kami</span>
            </h1>
            <p class="text-lg sm:text-xl text-muted-foreground max-w-3xl mx-auto leading-relaxed animate-slide-up delay-100">
                Klinik kecantikan modern dengan pendekatan personal dan profesional untuk hasil optimal yang alami
            </p>
        </div>
    </section>

    {{-- Main Content Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-20">

        {{-- Profil Klinik Section --}}
        <section class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center animate-slide-up delay-150">
            {{-- Text Content --}}
            <div class="space-y-6 order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20 animate-scale-in delay-200">
                    <i class="fa-solid fa-building-columns text-primary"></i>
                    <span class="text-sm font-semibold text-primary">Profil Klinik</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-card-foreground">
                    Gracias Aesthetic Clinic
                </h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-primary to-primary/50 rounded-full"></div>
                <p class="text-base sm:text-lg text-muted-foreground leading-relaxed">
                    <strong class="text-foreground">Gracias Aesthetic Clinic</strong> adalah <span class="text-primary font-semibold">Klinik Pratama</span> yang berfokus pada <strong class="text-foreground">Aesthetic Medicine dan Anti Aging</strong> di Pekanbaru.
                </p>
                <p class="text-base sm:text-lg text-muted-foreground leading-relaxed">
                    Kami melayani dengan dokter <span class="text-primary font-semibold">bersertifikat internasional (USA)</span> serta menggunakan produk premium dari Korea dan Eropa dengan izin edar resmi, memastikan keamanan dan hasil optimal.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <div class="flex items-center gap-3 px-4 py-3 bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl border border-green-200 shadow-sm">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-certificate text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-semibold">Dokter Bersertifikat</p>
                            <p class="text-sm font-bold text-green-900">Internasional (USA)</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 px-4 py-3 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl border border-blue-200 shadow-sm">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-shield-halved text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 font-semibold">Produk Premium</p>
                            <p class="text-sm font-bold text-blue-900">Korea & Eropa</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Video Content --}}
            <div class="order-1 lg:order-2 animate-scale-in delay-250">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-card hover:shadow-3xl transition-smooth hover-lift group">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-smooth z-10"></div>
                    <video class="w-full h-[300px] sm:h-[400px] lg:h-[500px] object-cover" autoplay loop muted playsinline>
                        <source src="{{ asset('videos/profil-klinik.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung video tag.
                    </video>
                </div>
            </div>
        </section>

        {{-- Mengapa Gracias Klinik Section --}}
        <section class="bg-gradient-to-br from-card to-card/50 rounded-3xl shadow-xl border border-border p-8 sm:p-12 lg:p-16 animate-slide-up delay-100">
            <div class="max-w-4xl mx-auto text-center space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20">
                    <i class="fa-solid fa-star text-primary"></i>
                    <span class="text-sm font-semibold text-primary">Keunggulan Kami</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-card-foreground">
                    Mengapa <span class="text-primary">Gracias Klinik</span>?
                </h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-primary/50 rounded-full mx-auto"></div>
                
                <div class="space-y-6 pt-4">
                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-2xl p-6 border border-primary/10 hover:border-primary/30 transition-smooth hover-lift">
                        <p class="text-base sm:text-lg text-muted-foreground leading-relaxed">
                            Gracias Clinic berkomitmen memberikan <span class="text-primary font-semibold">layanan kecantikan terbaik</span> melalui teknologi modern, tenaga profesional berpengalaman, dan pendekatan yang berfokus pada kepuasan serta kenyamanan pasien.
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-2xl p-6 border border-primary/10 hover:border-primary/30 transition-smooth hover-lift">
                        <p class="text-base sm:text-lg text-muted-foreground leading-relaxed">
                            Setiap individu memiliki <span class="text-primary font-semibold">kebutuhan unik</span>. Karena itu, setiap perawatan dilakukan secara personal, terukur, dan aman untuk memberikan hasil yang alami dan optimal.
                        </p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-2xl p-6 border border-primary/10 hover:border-primary/30 transition-smooth hover-lift">
                        <div class="flex items-center justify-center gap-3 mb-3">
                            <i class="fa-solid fa-heart text-primary text-2xl"></i>
                        </div>
                        <p class="text-base sm:text-lg text-card-foreground font-semibold leading-relaxed">
                            "Kecantikan sejati lahir dari keseimbangan antara penampilan luar dan rasa percaya diri dalam diri."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Visi & Misi Section --}}
        <section class="grid md:grid-cols-2 gap-6 lg:gap-8 animate-slide-up delay-150">
            {{-- Visi --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/30 rounded-3xl shadow-lg border border-blue-200 p-8 lg:p-10 hover:shadow-xl transition-smooth hover-lift group">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-smooth">
                        <i class="fa-solid fa-eye text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-blue-900 mb-6 text-center">Visi</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-blue-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Menjadi klinik kecantikan profesional dan terpercaya</span>
                    </li>
                    <li class="flex items-start gap-3 text-blue-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Menjadi pilihan utama masyarakat dalam perawatan kulit</span>
                    </li>
                    <li class="flex items-start gap-3 text-blue-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Terus berinovasi menghadirkan perawatan terbaik</span>
                    </li>
                </ul>
            </div>

            {{-- Misi --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100/30 rounded-3xl shadow-lg border border-green-200 p-8 lg:p-10 hover:shadow-xl transition-smooth hover-lift group">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-smooth">
                        <i class="fa-solid fa-bullseye text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-green-900 mb-6 text-center">Misi</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 text-green-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Menyediakan pelayanan estetika berkualitas tinggi dengan teknologi terkini</span>
                    </li>
                    <li class="flex items-start gap-3 text-green-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Memberikan perawatan wajah dan tubuh sesuai kebutuhan individu</span>
                    </li>
                    <li class="flex items-start gap-3 text-green-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Menciptakan suasana klinik yang aman, nyaman, dan profesional</span>
                    </li>
                    <li class="flex items-start gap-3 text-green-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Mengembangkan staf kompeten dan berdedikasi tinggi</span>
                    </li>
                    <li class="flex items-start gap-3 text-green-800 bg-white/60 rounded-xl p-4 hover:bg-white/80 transition-smooth">
                        <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fa-solid fa-check text-white text-xs"></i>
                        </div>
                        <span class="text-sm sm:text-base leading-relaxed">Meningkatkan kesadaran masyarakat akan pentingnya perawatan kulit</span>
                    </li>
                </ul>
            </div>
        </section>

        {{-- Tim Dokter Section --}}
        <section class="bg-gradient-to-br from-card to-card/50 rounded-3xl shadow-xl border border-border p-8 sm:p-12 lg:p-16 animate-slide-up delay-100">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20 mb-6">
                    <i class="fa-solid fa-user-doctor text-primary"></i>
                    <span class="text-sm font-semibold text-primary">Tim Profesional</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-card-foreground mb-4">
                    Tim Dokter <span class="text-primary">Berpengalaman</span>
                </h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-primary/50 rounded-full mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
                {{-- Dokter 1 --}}
                <div class="bg-gradient-to-br from-background to-card rounded-2xl p-8 border border-border shadow-lg hover:shadow-2xl transition-smooth hover-lift group">
                    <div class="relative mb-6">
                        <div class="w-40 h-40 mx-auto rounded-2xl overflow-hidden shadow-xl ring-4 ring-primary/20 group-hover:ring-primary/40 transition-smooth">
                            <img src="{{ asset('images/dokter1.png') }}" alt="dr. Jessica Natasia"
                                class="w-full h-full object-cover group-hover:scale-110 transition-smooth">
                        </div>
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 px-4 py-1.5 bg-gradient-to-r from-primary to-primary/80 rounded-full shadow-lg">
                            <i class="fa-solid fa-star text-primary-foreground text-sm"></i>
                        </div>
                    </div>
                    <div class="text-center space-y-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-card-foreground">dr. Jessica Natasia</h3>
                        <p class="text-primary font-semibold">Spesialis Estetika Kulit</p>
                        <div class="w-16 h-1 bg-gradient-to-r from-primary to-primary/50 rounded-full mx-auto"></div>
                        <p class="text-sm text-muted-foreground leading-relaxed px-4">
                            Berpengalaman lebih dari <span class="text-primary font-semibold">8 tahun</span> dalam perawatan wajah dan rejuvenasi dengan pendekatan yang personal dan profesional
                        </p>
                    </div>
                </div>

                {{-- Dokter 2 --}}
                <div class="bg-gradient-to-br from-background to-card rounded-2xl p-8 border border-border shadow-lg hover:shadow-2xl transition-smooth hover-lift group">
                    <div class="relative mb-6">
                        <div class="w-40 h-40 mx-auto rounded-2xl overflow-hidden shadow-xl ring-4 ring-primary/20 group-hover:ring-primary/40 transition-smooth">
                            <img src="{{ asset('images/dokter2.png') }}" alt="dr. Stella Verinda"
                                class="w-full h-full object-cover group-hover:scale-110 transition-smooth">
                        </div>
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 px-4 py-1.5 bg-gradient-to-r from-primary to-primary/80 rounded-full shadow-lg">
                            <i class="fa-solid fa-star text-primary-foreground text-sm"></i>
                        </div>
                    </div>
                    <div class="text-center space-y-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-card-foreground">dr. Stella Verinda</h3>
                        <p class="text-primary font-semibold">Ahli Dermatologi & Laser</p>
                        <div class="w-16 h-1 bg-gradient-to-r from-primary to-primary/50 rounded-full mx-auto"></div>
                        <p class="text-sm text-muted-foreground leading-relaxed px-4">
                            Fokus pada <span class="text-primary font-semibold">terapi laser, anti-aging</span>, dan perawatan kulit berteknologi tinggi dengan hasil yang optimal dan aman
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Lokasi Section --}}
        <section class="bg-gradient-to-br from-card to-card/50 rounded-3xl shadow-xl border border-border p-8 sm:p-12 lg:p-16 animate-slide-up delay-150">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20 mb-6">
                    <i class="fa-solid fa-map-location-dot text-primary"></i>
                    <span class="text-sm font-semibold text-primary">Lokasi Klinik</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-card-foreground mb-4">
                    Kunjungi <span class="text-primary">Kami</span>
                </h2>
                <div class="w-24 h-1.5 bg-gradient-to-r from-primary to-primary/50 rounded-full mx-auto mb-6"></div>
                <p class="text-base sm:text-lg text-muted-foreground max-w-2xl mx-auto">
                    Temukan lokasi kami di Pekanbaru dan rasakan pengalaman perawatan kecantikan yang profesional
                </p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-card hover:shadow-3xl transition-smooth hover-lift">
                    <iframe class="w-full h-[350px] sm:h-[450px] lg:h-[500px] border-0" 
                        style="filter: grayscale(10%) contrast(105%) brightness(100%);"
                        loading="lazy" 
                        allowfullscreen
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.652185090712!2d101.43125147496471!3d0.5228696994720179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5add0acd6f7c5%3A0xc3d0c3d2f946c02e!2sGracias%20Aesthetic%20Clinic!5e0!3m2!1sen!2sid!4v1761886001566!5m2!1sen!2sid">
                    </iframe>
                </div>
                
                {{-- Contact Info Cards --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">
                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-xl p-5 border border-primary/20 hover:border-primary/40 transition-smooth hover-lift group">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-location-dot text-primary-foreground"></i>
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground font-semibold mb-1">Alamat</p>
                                <p class="text-sm font-bold text-foreground">Jl. Gardenia No.20, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-xl p-5 border border-primary/20 hover:border-primary/40 transition-smooth hover-lift group">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                <i class="fa-brands fa-whatsapp text-white"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-muted-foreground font-semibold mb-1">WhatsApp</p>
                                <p class="text-sm font-bold text-foreground mb-2">+62-8217-4973-339</p>
                                <a href="https://wa.me/6282174973339?text=Halo%20Gracias%20Aesthetic%20Clinic%2C%20saya%20ingin%20berkonsultasi" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-xs font-semibold rounded-lg shadow-sm hover:shadow-md transition-smooth hover-scale-sm active-press">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>Chat Sekarang</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-primary/5 to-transparent rounded-xl p-5 border border-primary/20 hover:border-primary/40 transition-smooth hover-lift group sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-smooth">
                                <i class="fa-solid fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground font-semibold mb-1">Jam Operasional</p>
                                <p class="text-sm font-bold text-foreground">09:00 - 20:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- Bottom Padding --}}
    <div class="h-16"></div>
</div>
@endsection
