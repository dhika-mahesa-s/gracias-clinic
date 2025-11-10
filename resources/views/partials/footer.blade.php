{{-- ========================================
     FOOTER - Modern Gradient Design
======================================== --}}
<!-- Footer -->
<footer class="relative bg-linear-to-r from-primary to-primary/80 text-primary-foreground py-12 mt-20 shadow-lg overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-300/20 rounded-full blur-3xl"></div>
    </div>

    {{-- Main Footer Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
            
            {{-- Column 1: Brand & Description (Spanning 5 columns on large screens) --}}
            <div class="lg:col-span-5">
                {{-- Logo & Brand Name --}}
                <div class="flex items-center gap-4 mb-6 animate-fade-in">
                    <div class="relative group flex-shrink-0">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl shadow-lg group-hover:shadow-xl transition-smooth flex items-center justify-center p-2">
                            <img src="{{ asset('images/logo.png') }}" 
                                 alt="Gracias Clinic Logo" 
                                 class="w-full h-full object-contain">
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-1 truncate">
                            Gracias Aesthetic Clinic
                        </h3>
                        <p class="text-xs sm:text-sm text-white/80">Your Beauty, Our Priority</p>
                    </div>
                </div>

                {{-- Description --}}
                <p class="text-white/90 leading-relaxed mb-6 animate-fade-in delay-100">
                    Perawatan kecantikan profesional dan terpercaya untuk semua kebutuhan kulit Anda. 
                    Kami berkomitmen memberikan layanan terbaik dengan teknologi terkini dan dokter berpengalaman.
                </p>

                {{-- Social Media --}}
                <div class="animate-fade-in delay-200">
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                        </svg>
                        <span>Ikuti Kami</span>
                    </h4>
                    <div class="flex gap-3">
                        <a href="https://m.facebook.com/112757268598044/" 
                           target="_blank"
                           class="group w-12 h-12 bg-white rounded-xl flex items-center justify-center border-2 border-white/50 hover:bg-blue-600 hover:border-blue-600 shadow-sm hover:shadow-md hover-lift active-press transition-smooth">
                            <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-smooth" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/graciasaesthetic?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" 
                           target="_blank"
                           class="group w-12 h-12 bg-white rounded-xl flex items-center justify-center border-2 border-white/50 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-600 hover:border-purple-600 shadow-sm hover:shadow-md hover-lift active-press transition-smooth">
                            <svg class="w-5 h-5 text-pink-600 group-hover:text-white transition-smooth" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="group w-12 h-12 bg-white rounded-xl flex items-center justify-center border-2 border-white/50 hover:bg-red-600 hover:border-red-600 shadow-sm hover:shadow-md hover-lift active-press transition-smooth">
                            <svg class="w-5 h-5 text-red-600 group-hover:text-white transition-smooth" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Column 2: Contact Information (WhatsApp) --}}
            <div class="lg:col-span-3 animate-fade-in delay-300">
                <h4 class="text-white font-bold mb-6 flex items-center gap-3 text-lg">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </div>
                    <span>WhatsApp</span>
                </h4>
                <a href="https://wa.me/6282174973339?text=Halo%20Gracias%20Aesthetic%20Clinic%2C%20saya%20ingin%20bertanya" 
                   target="_blank"
                   class="group inline-flex items-center gap-3 px-5 py-3 bg-white rounded-xl border-2 border-gray-200 hover:bg-green-600 hover:border-green-600 shadow-md hover:shadow-lg hover-lift active-press transition-smooth">
                    <svg class="w-5 h-5 text-green-600 group-hover:text-white transition-smooth" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                    </svg>
                    <div class="text-left">
                        <p class="text-xs text-gray-600 group-hover:text-white/90 transition-smooth">Hubungi Kami</p>
                        <p class="text-gray-800 font-semibold group-hover:text-white transition-smooth">+62 821-7497-3339</p>
                    </div>
                </a>
            </div>

            {{-- Column 3: Address --}}
            <div class="lg:col-span-2 animate-fade-in delay-400">
                <h4 class="text-white font-bold mb-6 flex items-center gap-3 text-lg">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span>Alamat</span>
                </h4>
                <p class="text-white/90 leading-relaxed">
                    Jl. Gardenia No.20, Harjosari,<br/>
                    Kec. Sukajadi, Kota Pekanbaru,<br/>
                    Riau 28156
                </p>
            </div>

            {{-- Column 4: Email --}}
            <div class="lg:col-span-2 animate-fade-in delay-500">
                <h4 class="text-white font-bold mb-6 flex items-center gap-3 text-lg">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
                        </svg>
                    </div>
                    <span>Email</span>
                </h4>
                <a href="mailto:gracias.aestheticlinic@gmail.com"
                   class="group inline-flex items-center gap-2 text-white/90 hover:text-white transition-smooth">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm break-all">gracias.aestheticlinic@gmail.com</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Footer Bottom - Copyright --}}
    <div class="relative z-10 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 animate-fade-in delay-600">
                {{-- Copyright --}}
                <p class="text-white/80 text-sm text-center md:text-left">
                    © {{ date('Y') }} <span class="text-white font-semibold">Gracias Aesthetic Clinic</span>. All Rights Reserved.
                </p>

                {{-- Developer Credit --}}
                <p class="text-white/80 text-xs text-center md:text-right flex items-center gap-2">
                    <span>Dikembangkan dengan</span>
                    <svg class="w-4 h-4 text-red-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                    </svg>
                    <span>oleh <span class="text-white font-medium">Kelompok 3 Sistem Informasi 2022 UNRI</span></span>
                </p>
            </div>
        </div>
    </div>
</footer>
