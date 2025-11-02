@extends('layouts.app')

@section('content')
    <div class="relative min-h-screen py-20 px-6 bg-gray-50 overflow-hidden">

        {{-- Background Hero --}}
        <div class="absolute inset-0 bg-[url('{{ asset('images/about-us2.jpg') }}')] bg-cover bg-center opacity-10"></div>

        <div class="relative max-w-6xl mx-auto space-y-24 z-10">

            {{-- Hero Title --}}
            <section class="text-center">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Tentang Kami</h1>
                <p class="text-gray-600 text-2xl max-w-2xl mx-auto">
                    Klinik kecantikan modern dengan pendekatan personal dan profesional.
                </p>
            </section>

            {{-- Profil Klinik --}}
            <section class="grid md:grid-cols-2 gap-10 bg-white rounded-3xl shadow-sm p-10">
                {{-- Text --}}
                <div class="flex flex-col justify-center space-y-4">
                    <h2 class="text-4xl font-semibold text-center text-gray-800">Profil Klinik</h2>
                    <p class="text-gray-600 text-2xl leading-relaxed">
                        Gracias Aesthetic Clinic adalah Klinik Pratama yang berfokus pada Aesthetic Medicine dan Anti Aging
                        di Pekanbaru.
                        Kami melayani dengan dokter bersertifikat internasional (USA) serta menggunakan produk premium dari
                        Korea dan Eropa
                        dengan izin edar resmi, memastikan keamanan dan hasil optimal.
                    </p>
                </div>
                {{-- Video --}}
                <div class="rounded-2xl overflow-hidden">
                    <video class="w-full h-[450px] md:h-[550px] lg:h-[650px] object-cover rounded-2xl" autoplay loop muted
                        playsinline>
                        <source src="{{ asset('videos/profil-klinik.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung video tag.
                    </video>
                </div>

            </section>

            {{-- Mengapa Gracias Klinik --}}
            <section class="bg-white rounded-3xl shadow-sm p-10 md:px-16 md:py-14">
                <div class="max-w-3xl mx-auto text-center space-y-6">
                    <h2 class="text-4xl font-bold text-[#526D82]">Mengapa Gracias Klinik?</h2>
                    <p class="text-gray-600 text-xl leading-relaxed">
                        Gracias Clinic berkomitmen memberikan layanan kecantikan terbaik melalui teknologi modern,
                        tenaga profesional berpengalaman, dan pendekatan yang berfokus pada kepuasan serta kenyamanan
                        pasien.
                    </p>
                    <p class="text-gray-600 text-xl leading-relaxed">
                        Setiap individu memiliki kebutuhan unik. Karena itu, setiap perawatan dilakukan secara personal,
                        terukur, dan aman untuk memberikan hasil yang alami dan optimal.
                    </p>
                    <p class="text-gray-600 text-xl leading-relaxed">
                        Kami percaya bahwa kecantikan sejati lahir dari keseimbangan antara penampilan luar dan rasa percaya
                        diri dalam diri.
                    </p>
                </div>
            </section>

            {{-- Visi & Misi --}}
            <section class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl shadow-sm p-10 hover:shadow-md transition">
                    <h3 class="text-3xl font-semibold text-[#526D82] mb-6 text-center">Visi</h3>
                    <ul class="text-gray-600 space-y-3 leading-relaxed list-disc list-inside">
                        <li>Menjadi klinik kecantikan profesional dan terpercaya.</li>
                        <li>Menjadi pilihan utama masyarakat dalam perawatan kulit.</li>
                        <li>Terus berinovasi menghadirkan perawatan terbaik.</li>
                    </ul>
                </div>

                <div class="bg-white rounded-3xl shadow-sm p-10 hover:shadow-md transition">
                    <h3 class="text-3xl font-semibold text-[#526D82] mb-6 text-center">Misi</h3>
                    <ul class="text-gray-600 space-y-3 leading-relaxed list-disc list-inside">
                        <li>Menyediakan pelayanan estetika berkualitas tinggi dengan teknologi terkini.</li>
                        <li>Memberikan perawatan wajah dan tubuh sesuai kebutuhan individu.</li>
                        <li>Menciptakan suasana klinik yang aman, nyaman, dan profesional.</li>
                        <li>Mengembangkan staf kompeten dan berdedikasi tinggi.</li>
                        <li>Meningkatkan kesadaran masyarakat akan pentingnya perawatan kulit.</li>
                    </ul>
                </div>
            </section>

            {{-- Tim Dokter --}}
            <section class="bg-white rounded-3xl shadow-sm p-10 text-center">
                <h2 class="text-4xl font-bold text-[#526D82] mb-12">Tim Dokter Berpengalaman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="rounded-2xl p-8 bg-gray-50 hover:bg-gray-100 transition">
                        <img src="{{ asset('images/dokter1.png') }}" alt="Dokter 1"
                            class="w-40 h-40 object-cover rounded-xl mx-auto mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">dr. Jessica Natasia</h3>
                        <p class="text-gray-600">Spesialis Estetika Kulit</p>
                        <p class="mt-3 text-sm text-gray-500">Berpengalaman lebih dari 8 tahun dalam perawatan wajah dan
                            rejuvenasi.</p>
                    </div>

                    <div class="rounded-2xl p-8 bg-gray-50 hover:bg-gray-100 transition">
                        <img src="{{ asset('images/dokter2.png') }}" alt="Dokter 2"
                            class="w-40 h-40 object-cover rounded-xl mx-auto mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">dr. Stella Verinda</h3>
                        <p class="text-gray-600">Ahli Dermatologi & Laser</p>
                        <p class="mt-3 text-sm text-gray-500">Fokus pada terapi laser, anti-aging, dan perawatan kulit
                            berteknologi tinggi.</p>
                    </div>
                </div>
            </section>

            {{-- Lokasi --}}
            <section class="bg-white rounded-3xl shadow-sm p-10 text-center">
                <h2 class="text-4xl font-bold text-[#526D82] mb-6">Lokasi Kami</h2>
                <p class="text-gray-600 mb-8">Temukan kami di lokasi berikut:</p>
                <div class="rounded-2xl overflow-hidden">
                    <iframe class="w-full h-[400px] border-0" style="filter: grayscale(15%) contrast(110%) brightness(98%);"
                        loading="lazy" allowfullscreen
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.652185090712!2d101.43125147496471!3d0.5228696994720179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5add0acd6f7c5%3A0xc3d0c3d2f946c02e!2sGracias%20Aesthetic%20Clinic!5e0!3m2!1sen!2sid!4v1761886001566!5m2!1sen!2sid">
                    </iframe>
                </div>
            </section>
        </div>
    </div>
@endsection
