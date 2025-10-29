@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-16 px-6">
    <div class="max-w-5xl mx-auto text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Tentang Kami</h1>
    </div>

    {{-- Section Profil --}}
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-md p-8 mb-12 transform transition duration-700 hover:-translate-y-1 hover:shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Profil Klinik</h2>
        <p class="text-gray-600 leading-relaxed">
            Gracias Aesthetic Clinic merupakan Klinik Pratama dengan pelayanan khusus dibidang Aesthetic Medicine dan Anti Aging di Pekanbaru. 
            Dilayani oleh Dokter yg berpengalaman di bidang Aesthetic Medicine dengan sertifikasi Internasional (USA) dan Produk Korea sampai Eropa dengan izin edar resmi, memastikan perawatan yg diberikan aman dan dikerjakan secara profesional

        </p>
    </div>

    {{-- Section Visi & Misi --}}
    <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-12">
        <div class="bg-white rounded-2xl shadow-md p-8 transform transition duration-700 hover:scale-105">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Visi</h2>
            <ul class="text-gray-600 list-disc list-inside space-y-2 text-left">
                <li>Menjadi klinik kecantikan yang memberikan solusi terbaik untuk perawatan kulit dan penampilan secara profesional.</li>
                <li>Menjadi klinik kecantikan yang dipercaya dan menjadi pilihan utama masyarakat.</li>
                <li>Menjadi klinik kecantikan yang inovatif dan selalu menghadirkan perawatan terbaru.</li>
            </ul>            
        </div>

        <div class="bg-white rounded-2xl shadow-md p-8 transform transition duration-700 hover:scale-105">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Misi</h2>
            <ul class="text-gray-600 list-disc list-inside space-y-2 text-left">
                <li>Memberikan pelayanan estetika berkualitas tinggi dengan menggunakan teknologi terkini dan produk terbaik.</li>
                <li>Menyediakan berbagai macam perawatan wajah dan tubuh yang lengkap dan disesuaikan dengan kebutuhan setiap individu.</li>
                <li>Menciptakan lingkungan yang nyaman, aman, dan profesional bagi pelanggan.</li>
                <li>Mengembangkan staf yang kompeten dan berdedikasi tinggi dalam memberikan pelayanan.</li>
                <li>Meningkatkan kesadaran masyarakat tentang pentingnya perawatan kulit dan penampilan.</li>
            </ul>
        </div>
    </div>

    {{-- Section Tim --}}
    <div class="max-w-5xl mx-auto text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tim Profesional Kami</h2>
        <div class="text-center mb-12">
            <p class="text-gray-500">Profesional dan berpengalaman di bidang estetika</p>
        </div>

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
@endsection
