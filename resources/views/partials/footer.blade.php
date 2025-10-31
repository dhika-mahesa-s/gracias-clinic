<footer class="bg-gradient-to-r from-primary to-primary/80 text-primary-foreground py-12 mt-20 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 lg:gap-8">
            <!-- Kolom 1: Logo dan Deskripsi -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-2">
                <div class="flex items-center space-x-3 mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Gracias Aesthetic Clinic" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full shadow-md">
                    <span class="font-bold text-xl sm:text-2xl tracking-wide">Gracias Aesthetic Clinic</span>
                </div>
                <p class="text-sm sm:text-base mb-6 leading-relaxed">Perawatan kecantikan profesional dan terpercaya untuk semua kebutuhan kulit Anda. Kami berkomitmen memberikan layanan terbaik dengan teknologi terkini.</p>

                <p class="font-semibold text-accent mb-4 text-lg">Ikuti Kami</p>
                <div class="flex space-x-4 text-2xl">
                    <a href="https://m.facebook.com/112757268598044/" class="hover:text-accent hover:scale-110 transition-all duration-300" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/graciasaesthetic?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="hover:text-accent hover:scale-110 transition-all duration-300" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="hover:text-accent hover:scale-110 transition-all duration-300" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Kolom 2: WhatsApp -->
            <div class="col-span-1">
                <div class="flex items-center mb-4">
                    <i class="fa-brands fa-whatsapp text-accent text-xl mr-3"></i>
                    <p class="font-semibold text-lg">WhatsApp</p>
                </div>
                <a href="https://api.whatsapp.com/send/?phone=6282174973339&text&type=phone_number&app_absent=0" class="hover:text-accent transition-colors duration-300 text-sm sm:text-base break-words">
                    +62-8217-4973-339
                </a>
            </div>

            <!-- Kolom 3: Alamat -->
            <div class="col-span-1">
                <div class="flex items-center mb-4">
                    <i class="fa-solid fa-map-marker-alt text-accent text-xl mr-3"></i>
                    <p class="font-semibold text-lg">Alamat</p>
                </div>
                <p class="text-sm sm:text-base leading-relaxed">Jl. Gardenia No.20, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156</p>
            </div>

            <!-- Kolom 4: Email -->
            <div class="col-span-1 sm:col-span-2 md:col-span-1">
                <div class="flex items-center mb-4">
                    <i class="fa-solid fa-envelope text-accent text-xl mr-3"></i>
                    <p class="font-semibold text-lg">Email</p>
                </div>
                <a href="mailto:gracias.aestheticlinic@gmail.com" class="hover:text-accent transition-colors duration-300 text-sm sm:text-base break-words">gracias.aestheticlinic@gmail.com</a>
            </div>
        </div>
    </div>

    <div class="border-t border-primary-foreground/20 mt-10 pt-6 text-center">
        <p class="text-primary-foreground/80 text-sm sm:text-base mb-2">
            © {{ date('Y') }} Gracias Aesthetic Clinic. All Rights Reserved.
        </p>
        <p class="text-primary-foreground/60 text-xs sm:text-sm">
            Dikembangkan dengan penuh ❤ oleh Kelompok 3 Sistem Informasi 2022 UNRI
        </p>
    </div>
</footer>
