<footer class="bg-[#003366] text-white py-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-8">
        <!-- Kolom 1 -->
        <div class="col-span-2">
            <div class="flex items-center space-x-3 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
                <span class="font-semibold text-lg">Gracias Aesthetic Clinic</span>
            </div>
            <p class="text-sm mb-4">Perawatan kecantikan profesional dan terpercaya untuk semua kebutuhan kulit Anda.</p>

            <p class="font-semibold text-[#FFD700] mb-2">Ikuti Kami</p>
            <div class="flex space-x-4 text-xl">
                <a href="#" class="hover:text-[#FFD700] transition"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="hover:text-[#FFD700] transition"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-[#FFD700] transition"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        <div>
            <p class="font-semibold text-white mb-3">Whatsapp</p>
            <a href="https://api.whatsapp.com/send/?phone=6282174973339&text&type=phone_number&app_absent=0" class="hover:text-[#FFD700] transition">
                <i class="fa-brands fa-whatsapp px-1"></i> +62-8217-4973-339
            </a>
        </div>

        <div>
            <p class="font-semibold text-white mb-3">Alamat</p>
            <p>Jl. Gardenia No.20, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156</p>
        </div>

        <div>
            <p class="font-semibold text-white mb-3">Email</p>
            <a href="#" class="hover:text-gray-50">+62-8217-4973-339</a>
        </div>
    </div>

    <div class="border-t border-white/20 mt-8 pt-4 text-center text-gray-300 text-sm">
        © {{ date('Y') }} Gracias Aesthetic Clinic. All Rights Reserved.
    </div>
</footer>
