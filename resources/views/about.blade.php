@extends('layouts.app')

@section('content')
<div class="relative min-h-screen py-16 px-6 overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0 bg-cover bg-center bg-[url('{{ asset('images/about-us2.jpg') }}')] z-0"></div>


    {{-- Overlay putih transparan --}}
    <div class="absolute inset-0 bg-white bg-opacity-05 z-0"></div>

    {{-- Konten utama --}}
    <div class="relative z-10">
        <div class="max-w-5xl mx-auto text-center mb-12">
            <h1 class="text-4xl font-bold text-primary mb-4">About Us</h1>
        </div>

        {{-- Section Profil --}}
        <div class="max-w-5xl mx-auto rounded-2xl shadow-md overflow-hidden mb-12 relative group"
                data-aos="fade-up"
                data-aos-duration="1200"
                data-aos-once="true">

            {{-- 🎥 Video background --}}
            <video 
                autoplay 
                loop 
                muted 
                playsinline 
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <source src="{{ asset('videos/profil-klinik.mp4') }}" type="video/mp4">
                Browser Anda tidak mendukung pemutaran video.
            </video>

            {{-- 🌫️ Overlay transparan untuk kontras teks --}}
            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition duration-500"></div>

            {{-- 📝 Konten teks di atas video --}}
            <div class="relative z-10 p-8 sm:p-12 text-center md:text-left flex flex-col justify-center items-center md:items-start min-h-[65vh]">
                <h2 
                    class="text-3xl md:text-4xl font-bold text-white mb-4 drop-shadow-md"
                    data-aos="fade-down"
                    data-aos-delay="200">
                    Mengapa Memilih Gracias?
                </h2>

                <p 
                    class="text-gray-100 text-base md:text-lg leading-relaxed max-w-2xl"
                    data-aos="fade-up"
                    data-aos-delay="400">

                    Gracias Aesthetic Clinic merupakan Klinik Pratama dengan pelayanan khusus di bidang 
                    Aesthetic Medicine dan Anti Aging di Pekanbaru. Dilayani oleh dokter yang berpengalaman 
                    di bidang Aesthetic Medicine dengan sertifikasi Internasional (USA) serta menggunakan 
                    produk dari Korea hingga Eropa yang memiliki izin edar resmi — memastikan setiap 
                    perawatan aman dan profesional.
                </p>
            </div>
        </div>


        {{-- Section Visi & Misi --}}
        <div class="relative py-20 bg-white/60 backdrop-blur-md">
            <div class="max-w-5xl mx-auto text-center">
                {{-- Judul --}}
                <h2 class="text-4xl font-bold text-primary mb-12 fade-in-up">Visi & Misi</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- Visi --}}
                    <div
                        class="p-8 rounded-2xl bg-white/80 shadow-lg backdrop-blur-sm fade-in-up transition duration-700 hover:shadow-xl">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Visi</h3>
                        <ul class="text-gray-700 space-y-3 text-justify leading-relaxed">
                            <li>Menjadi klinik kecantikan yang memberikan solusi terbaik untuk perawatan kulit dan penampilan secara profesional.</li>
                            <li>Menjadi klinik kecantikan yang dipercaya dan menjadi pilihan utama masyarakat.</li>
                            <li>Menjadi klinik kecantikan yang inovatif dan selalu menghadirkan perawatan terbaru.</li>
                        </ul>
                    </div>

                    {{-- Misi --}}
                    <div
                        class="p-8 rounded-2xl bg-white/80 shadow-lg backdrop-blur-sm fade-in-up transition duration-700 hover:shadow-xl">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Misi</h3>
                        <ul class="text-gray-700 space-y-3 text-justify leading-relaxed">
                            <li>Memberikan pelayanan estetika berkualitas tinggi dengan menggunakan teknologi terkini dan produk terbaik.</li>
                            <li>Menyediakan berbagai macam perawatan wajah dan tubuh yang lengkap dan disesuaikan dengan kebutuhan setiap individu.</li>
                            <li>Menciptakan lingkungan yang nyaman, aman, dan profesional bagi pelanggan.</li>
                            <li>Mengembangkan staf yang kompeten dan berdedikasi tinggi dalam memberikan pelayanan.</li>
                            <li>Meningkatkan kesadaran masyarakat tentang pentingnya perawatan kulit dan penampilan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Tim --}}
        <div class="relative py-20 bg-white/60 backdrop-blur-md">
            <div class="max-w-5xl mx-auto text-center">
                {{-- Judul --}}
                <h2 class="text-4xl font-bold text-primary mb-12 fade-in-up">Dokter Berpengalaman</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto px-6">
                    {{-- Dokter 1 --}}
                    <div class="bg-white-50 rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <img src="images/graciaslogo.png" alt="Dokter 1" class="w-40 h-40 object-cover rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-semibold text-gray-700">dr. Mutiara</h3>
                        <p class="text-gray-600">Spesialis Estetika Kulit</p>
                        <p class="mt-3 text-sm text-gray-500">Berpengalaman lebih dari 8 tahun dalam perawatan kulit wajah dan rejuvenasi.</p>
                    </div>

                    {{-- Dokter 2 --}}
                    <div class="bg-white-50 rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <img src="images/graciaslogo.png" alt="Dokter 2" class="w-40 h-40 object-cover rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-semibold text-gray-700">dr. Fassya</h3>
                        <p class="text-gray-600">Ahli Dermatologi & Laser</p>
                        <p class="mt-3 text-sm text-gray-500">Fokus pada terapi laser, anti-aging, dan perawatan kulit berteknologi tinggi.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Lokasi / Google Maps --}}
        <div class="relative py-20 bg-white/70 backdrop-blur-md">
            <div class="max-w-6xl mx-auto text-center">
                {{-- Judul --}}
                <h2 class="text-4xl font-bold text-primary mb-8 fade-in-up">Lokasi Kami</h2>
                <p class="text-gray-700 mb-12 fade-in-up">
                    Temukan kami disini!
                </p>

                {{-- Map Container --}}
                <div class="rounded-2xl overflow-hidden shadow-lg fade-in-up max-w-5xl mx-auto">
                    <iframe
                        class="w-full h-[450px] border-0"
                        style="filter: grayscale(20%) contrast(110%) brightness(95%);"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.652185090712!2d101.43125147496471!3d0.5228696994720179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5add0acd6f7c5%3A0xc3d0c3d2f946c02e!2sGracias%20Aesthetic%20Clinic!5e0!3m2!1sen!2sid!4v1761886001566!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ✨ Animasi saat Scroll --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fadeElements = document.querySelectorAll(".fade-in-up");
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate-fade-up");
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => observer.observe(el));
    });
</script>

<style>
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-up {
        animation: fadeUp 0.8s ease-out forwards;
    }

    .fade-in-up {
        opacity: 0;
    }
</style>
@endsection
