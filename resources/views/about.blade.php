@extends('layouts.app')

@section('content')
<div class="relative min-h-screen py-16 px-6 overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0 bg-cover bg-center bg-[url('{{ asset('images/about-us2.jpg') }}')] z-0"></div>


    {{-- Overlay putih transparan --}}
    <div class="absolute inset-0 bg-opacity-05 z-0"></div>

    {{-- Konten utama --}}
    <div class="relative z-10">
        <div class="max-w-5xl mx-auto text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Tentang Kami</h1>
        </div>

        {{-- Section Profil --}}
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-8 mb-12 transform transition duration-700 hover:-translate-y-1 hover:shadow-lg">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                {{-- Kolom teks --}}
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Profil Klinik</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Gracias Aesthetic Clinic merupakan Klinik Pratama dengan pelayanan khusus di bidang Aesthetic Medicine dan Anti Aging di Pekanbaru. 
                        Dilayani oleh dokter yang berpengalaman di bidang Aesthetic Medicine dengan sertifikasi Internasional (USA) serta menggunakan produk dari Korea hingga Eropa yang memiliki izin edar resmi — memastikan setiap perawatan aman dan profesional.
                    </p>
                </div>

                {{-- Kolom video --}}
                <div class="flex justify-center">
                    <video 
                        class="w-full h-full object-cover object-center" 
                        autoplay 
                        muted 
                        loop 
                        playsinline>
                        <source src="{{ asset('videos/profil-klinik.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung video tag.
                    </video>
                </div>

                {{-- Teks --}}
                <div class="md:w-1/2 w-full p-8 flex flex-col justify-center">
                    <h2 class="text-3xl font-bold mb-4 text-[#526D82]">Mengapa Gracias Klinik?</h2>
                    <p class="text-gray-800 mb-4">
                        Gracias Clinic berkomitmen untuk memberikan layanan kecantikan terbaik melalui kombinasi teknologi modern, tenaga profesional berpengalaman, serta pendekatan yang berfokus pada kepuasan dan kenyamanan pasien. 
                        Kami memahami bahwa setiap individu memiliki kebutuhan dan karakter kulit yang unik, sehingga setiap perawatan dilakukan secara personal dan terukur untuk memberikan hasil yang optimal.
                    </p>
                    <p class="text-gray-800 mb-4">
                        Kami percaya bahwa kecantikan sejati tidak hanya berasal dari tampilan luar, tetapi juga dari rasa percaya diri dan keseimbangan diri. 
                        Karena itu, setiap layanan yang kami tawarkan didesain untuk tidak sekadar mempercantik, tetapi juga membantu Anda merasa lebih baik dan nyaman dengan diri sendiri.
                    </p>
                    
                </div>
            </div>
        </div>             

        {{-- Section: Visi & Misi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-md p-8 hover:-translate-y-1 hover:shadow-xl transition">
                <h3 class="text-3xl font-bold text-[#526D82] mb-4 text-center">Visi</h3>
                <ul class="text-gray-800 space-y-3 text-justify leading-relaxed">
                    <li>Menjadi klinik kecantikan yang memberikan solusi terbaik untuk perawatan kulit dan penampilan secara profesional.</li>
                    <li>Menjadi klinik kecantikan yang dipercaya dan menjadi pilihan utama masyarakat.</li>
                    <li>Menjadi klinik kecantikan yang inovatif dan selalu menghadirkan perawatan terbaru.</li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8 hover:-translate-y-1 hover:shadow-xl transition">
                <h3 class="text-3xl font-bold text-[#526D82] mb-4 text-center">Misi</h3>
                <ul class="text-gray-800 space-y-3 text-justify leading-relaxed">
                    <li>Memberikan pelayanan estetika berkualitas tinggi dengan teknologi terkini dan produk terbaik.</li>
                    <li>Menyediakan perawatan wajah dan tubuh lengkap sesuai kebutuhan individu.</li>
                    <li>Menciptakan lingkungan yang nyaman, aman, dan profesional.</li>
                    <li>Mengembangkan staf yang kompeten dan berdedikasi tinggi.</li>
                    <li>Meningkatkan kesadaran masyarakat tentang pentingnya perawatan kulit dan penampilan.</li>
                </ul>
            </div>
        </div>

        {{-- Section: Tim Dokter --}}
        <div class="bg-white rounded-2xl shadow-lg p-10 text-center hover:shadow-2xl transition duration-300 mb-16">
            <h2 class="text-4xl font-bold text-[#526D82] mb-10">Dokter Berpengalaman</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-gray-50 rounded-2xl p-8 shadow hover:-translate-y-1 hover:shadow-md transition">
                    <img src="{{ asset('images/dokter1.png') }}" alt="Dokter 1"
                        class="w-40 h-40 object-cover rounded-lg mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-700">dr. Jessica Natasia</h3>
                    <p class="text-gray-600">Spesialis Estetika Kulit</p>
                    <p class="mt-3 text-sm text-gray-500">
                        Berpengalaman lebih dari 8 tahun dalam perawatan kulit wajah dan rejuvenasi.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8 shadow hover:-translate-y-1 hover:shadow-md transition">
                    <img src="{{ asset('images/dokter2.png') }}" alt="Dokter 2"
                        class="w-40 h-40 object-cover rounded-lg mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-gray-700">dr. Stella Verinda</h3>
                    <p class="text-gray-600">Ahli Dermatologi & Laser</p>
                    <p class="mt-3 text-sm text-gray-500">
                        Fokus pada terapi laser, anti-aging, dan perawatan kulit berteknologi tinggi.
                    </p>
                </div>
            </div>
        </div>


        {{-- Section: Lokasi --}}
        <div class="bg-white rounded-2xl shadow-lg p-10 text-center hover:shadow-2xl transition duration-300">
            <h2 class="text-4xl font-bold text-[#526D82] mb-6">Lokasi Kami</h2>
            <p class="text-gray-600 mb-8">Temukan kami disini!</p>
            <div class="rounded-2xl overflow-hidden shadow-md">
                <iframe
                    class="w-full h-[400px] border-0"
                    style="filter: grayscale(20%) contrast(110%) brightness(95%);"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.652185090712!2d101.43125147496471!3d0.5228696994720179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5add0acd6f7c5%3A0xc3d0c3d2f946c02e!2sGracias%20Aesthetic%20Clinic!5e0!3m2!1sen!2sid!4v1761886001566!5m2!1sen!2sid">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
