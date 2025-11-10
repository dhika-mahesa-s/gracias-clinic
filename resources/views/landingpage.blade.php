@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')

    {{-- ========================================
         HERO SECTION - Modern Split Design
    ======================================== --}}
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-background via-blue-50/30 to-background overflow-hidden">
        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse-slow delay-1000"></div>
        </div>

        <div class="container mx-auto px-6 lg:px-12 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                {{-- Left Content --}}
                <div class="animate-slide-right">
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-6 animate-bounce-in">
                        <svg class="w-5 h-5 text-primary animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        <span class="text-sm font-semibold text-primary">Klinik Kecantikan Terpercaya #1 di Pekanbaru</span>
                    </div>

                    {{-- Main Heading --}}
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-foreground mb-6 leading-tight animate-slide-up delay-100">
                        Your Beauty,<br/>
                        <span class="text-primary">Our Priority</span>
                    </h1>

                    {{-- Description --}}
                    <p class="text-lg text-muted-foreground mb-8 leading-relaxed animate-slide-up delay-200">
                        Wujudkan kecantikan impian Anda bersama dokter profesional dan berpengalaman. 
                        Kami berkomitmen memberikan pelayanan terbaik dengan teknologi modern dan standar internasional.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4 animate-slide-up delay-300">
                        <a href="{{ route('reservasi.index') }}"
                           class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                            <i class="fa-solid fa-calendar-check text-lg"></i>
                            <span>Reservasi Sekarang</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        
                        <a href="{{ route('treatments.index') }}"
                           class="inline-flex items-center gap-2 px-8 py-4 bg-white border-2 border-border text-foreground font-semibold rounded-xl hover:border-primary hover:bg-primary/5 active-press transition-smooth">
                            <i class="fa-solid fa-sparkles"></i>
                            <span>Lihat Treatment</span>
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-border animate-fade-in delay-400">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-1">1000+</div>
                            <div class="text-sm text-muted-foreground">Pasien Puas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-1">10+</div>
                            <div class="text-sm text-muted-foreground">Tahun Pengalaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-1">50+</div>
                            <div class="text-sm text-muted-foreground">Jenis Treatment</div>
                        </div>
                    </div>
                </div>

                {{-- Right Image/Illustration --}}
                <div class="relative animate-slide-left delay-200">
                    {{-- Decorative Background Card --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-blue-500/5 rounded-3xl transform rotate-6"></div>
                    
                    {{-- Main Card Container --}}
                    <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl border-8 border-white/50">
                        {{-- Image Container with proper aspect ratio --}}
                        <div class="relative aspect-[4/3] sm:aspect-[3/2] lg:aspect-[4/3]">
                            <img src="{{ asset('images/hd-bg.jpg') }}" 
                                 alt="Gracias Clinic - Aesthetic, Wellness & Anti Aging" 
                                 class="w-full h-full object-cover object-center">
                            
                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/40"></div>
                            
                            {{-- Logo Overlay (Optional) --}}
                        </div>
                        
                        {{-- Floating Rating Card - Positioned at bottom --}}
                        <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 lg:p-8">
                            <div class="bg-white/95 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-2xl border border-white/20 animate-bounce-in delay-500">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    {{-- Heart Icon --}}
                                    <div class="flex-shrink-0 w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-600 to-blue-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 lg:w-8 lg:h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                                        </svg>
                                    </div>
                                    
                                    {{-- Rating Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            {{-- Stars --}}
                                            <div class="flex">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            {{-- Rating Number --}}
                                            <span class="text-base sm:text-lg lg:text-xl font-bold text-foreground">5.0</span>
                                        </div>
                                        {{-- Rating Text --}}
                                        <p class="text-xs sm:text-sm text-blue-600 font-semibold">
                                            Rating dari 1000+ pasien
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Decorative Dots Pattern --}}
                    <div class="absolute -top-6 -right-6 w-20 h-20 sm:w-24 sm:h-24 grid grid-cols-4 gap-2 opacity-20 pointer-events-none">
                        @for ($i = 0; $i < 16; $i++)
                            <div class="w-2 h-2 bg-primary rounded-full animate-pulse" style="animation-delay: {{ $i * 50 }}ms"></div>
                        @endfor
                    </div>
                    
                    {{-- Decorative Circle --}}
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-primary/10 to-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         WHY CHOOSE US SECTION
    ======================================== --}}
    <section class="py-20 lg:py-28 bg-background relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzYjgyZjYiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PHBhdGggZD0iTTM2IDE2YzAtNi42MjcgNS4zNzMtMTIgMTItMTJzMTIgNS4zNzMgMTIgMTItNS4zNzMgMTItMTIgMTItMTItNS4zNzMtMTItMTJ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-40"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-4">
                    <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-primary">Keunggulan Kami</span>
                </div>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mb-4 animate-slide-up delay-100">
                    Mengapa Memilih <span class="text-primary">Gracias Clinic?</span>
                </h2>
                <p class="text-lg text-muted-foreground animate-slide-up delay-200">
                    Kami berkomitmen memberikan pelayanan terbaik dengan standar internasional untuk kepuasan dan keamanan Anda.
                </p>
            </div>

            {{-- Features Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Feature 1 --}}
                <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-smooth">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-smooth">
                        Dokter Berpengalaman
                    </h4>
                    <p class="text-muted-foreground leading-relaxed">
                        Tim dokter ahli dengan pengalaman lebih dari 10 tahun di bidang kecantikan dan dermatologi.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500/10 to-blue-500/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-smooth">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2.25 6a3 3 0 013-3h13.5a3 3 0 013 3v12a3 3 0 01-3 3H5.25a3 3 0 01-3-3V6zm3.97.97a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 01-1.06-1.06l1.72-1.72-1.72-1.72a.75.75 0 010-1.06zm4.28 4.28a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-smooth">
                        Fasilitas Modern
                    </h4>
                    <p class="text-muted-foreground leading-relaxed">
                        Peralatan medis terkini dan teknologi canggih untuk hasil optimal dan aman.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500/10 to-green-500/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-smooth">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/>
                            <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-smooth">
                        Treatment Berkualitas
                    </h4>
                    <p class="text-muted-foreground leading-relaxed">
                        Prosedur aman, teruji klinis, dan mengikuti standar internasional terbaik.
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500/10 to-purple-500/5 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-smooth">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-foreground mb-3 group-hover:text-primary transition-smooth">
                        Reservasi Mudah
                    </h4>
                    <p class="text-muted-foreground leading-relaxed">
                        Sistem booking online yang mudah dan fleksibel sesuai dengan jadwal Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         FEATURED TREATMENTS SECTION
    ======================================== --}}
    <section class="py-20 lg:py-28 bg-gradient-to-br from-blue-50/30 via-background to-purple-50/20 relative overflow-hidden">
        {{-- Decorative Elements --}}
        <div class="absolute top-0 left-1/4 w-72 h-72 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-purple-500/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-4">
                    <svg class="w-4 h-4 text-primary animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                    <span class="text-sm font-semibold text-primary">Treatment Unggulan</span>
                </div>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mb-4 animate-slide-up delay-100">
                    Layanan <span class="text-primary">Unggulan Kami</span>
                </h2>
                <p class="text-lg text-muted-foreground animate-slide-up delay-200">
                    Berbagai pilihan perawatan premium untuk kebutuhan kecantikan dan perawatan kulit Anda
                </p>
            </div>

            @if (isset($treatments) && $treatments->isNotEmpty())
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    @foreach ($treatments->take(4) as $index => $t)
                        @php
                            if ($t->image) {
                                if (preg_match('#^https?://#', $t->image)) {
                                    $img = $t->image;
                                } elseif (Storage::disk('public')->exists($t->image)) {
                                    $img = asset('storage/' . $t->image);
                                } elseif (file_exists(public_path($t->image))) {
                                    $img = asset($t->image);
                                } else {
                                    $img = 'https://via.placeholder.com/400x300?text=No+Image';
                                }
                            } else {
                                $img = 'https://via.placeholder.com/400x300?text=No+Image';
                            }
                        @endphp

                        <div class="group bg-white rounded-2xl overflow-hidden border border-border hover:border-primary/30 shadow-lg hover:shadow-2xl transition-smooth hover-lift animate-scale-in"
                             style="animation-delay: {{ $index * 100 }}ms">
                            {{-- Image --}}
                            <div class="relative h-48 sm:h-56 overflow-hidden">
                                <img src="{{ $img }}" 
                                     alt="{{ $t->name }}"
                                     class="w-full h-full object-cover object-center group-hover:scale-110 transition-smooth">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-smooth"></div>
                                
                                {{-- Discount Badge --}}
                                @if($t->hasActiveDiscount())
                                    @php
                                        $discount = $t->getActiveDiscount();
                                    @endphp
                                    <div class="absolute top-4 right-4 px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full text-xs font-bold shadow-lg animate-bounce">
                                        <i class="fa-solid fa-tags mr-1"></i>
                                        {{ $discount->type === 'percentage' ? $discount->value . '%' : 'DISKON' }}
                                    </div>
                                @else
                                    {{-- Premium Badge --}}
                                    <div class="absolute top-4 right-4 px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full text-xs font-semibold text-primary shadow-lg opacity-0 group-hover:opacity-100 transition-smooth">
                                        <i class="fa-solid fa-sparkles mr-1"></i>
                                        Premium
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-foreground mb-3 line-clamp-1 group-hover:text-primary transition-smooth">
                                    {{ $t->name }}
                                </h3>
                                <p class="text-sm text-muted-foreground leading-relaxed mb-4 line-clamp-3">
                                    {{ $t->description ?? 'Perawatan berkualitas tinggi dengan teknologi modern dan hasil yang memuaskan.' }}
                                </p>

                                {{-- Price with Discount --}}
                                <div class="mb-6">
                                    @if($t->hasActiveDiscount())
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-lg font-bold text-primary">
                                                Rp {{ number_format($t->getDiscountedPrice(), 0, ',', '.') }}
                                            </span>
                                            <span class="text-sm text-red-500 font-semibold bg-red-50 px-2 py-0.5 rounded">
                                                HEMAT
                                            </span>
                                        </div>
                                        <div class="text-sm text-muted-foreground line-through">
                                            Rp {{ number_format($t->price, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-bold text-primary">
                                            Rp {{ number_format($t->price, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </div>

                                {{-- CTA Button --}}
                                <a href="{{ route('treatments.show', $t) }}"
                                   class="group/btn w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-primary/10 to-blue-500/10 border border-primary/20 text-primary font-semibold rounded-xl hover:from-primary hover:to-blue-600 hover:text-white hover:shadow-lg active-press transition-smooth">
                                    <span>Lihat Detail</span>
                                    <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 animate-fade-in">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-lg text-muted-foreground">Belum ada treatment yang tersedia saat ini</p>
                </div>
            @endif

            {{-- View All Button --}}
            <div class="text-center animate-fade-in delay-500">
                <a href="{{ route('treatments.index') }}"
                   class="group inline-flex items-center gap-3 px-8 py-4 bg-white border-2 border-primary text-primary font-semibold rounded-xl hover:bg-primary hover:text-white shadow-lg hover:shadow-xl active-press transition-smooth">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                    <span>Lihat Semua Treatment</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ========================================
         TESTIMONIALS SECTION
    ======================================== --}}
    <section class="py-20 lg:py-28 bg-background relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzYjgyZjYiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PHBhdGggZD0iTTM2IDE2YzAtNi42MjcgNS4zNzMtMTIgMTItMTJzMTIgNS4zNzMgMTIgMTItNS4zNzMgMTItMTIgMTItMTItNS4zNzMtMTItMTJ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-40"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16 animate-fade-in">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full mb-4">
                    <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-semibold text-primary">Testimoni</span>
                </div>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-foreground mb-4 animate-slide-up delay-100">
                    Kata <span class="text-primary">Mereka</span>
                </h2>
                <p class="text-lg text-muted-foreground animate-slide-up delay-200">
                    Pengalaman nyata dari pelanggan yang puas dengan layanan kami
                </p>
            </div>

            {{-- Testimonials Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @if ($featuredFeedbacks->isNotEmpty())
                    @foreach ($featuredFeedbacks as $index => $feedback)
                        @php
                            $ratings = [$feedback->staff_rating, $feedback->professional_rating, $feedback->result_rating, $feedback->return_rating, $feedback->overall_rating];
                            $validRatings = array_filter($ratings, function ($rating) { return !is_null($rating) && $rating > 0; });
                            $avg = count($validRatings) > 0 ? array_sum($validRatings) / count($validRatings) : $feedback->overall_rating;
                        @endphp
                        
                        <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in"
                             style="animation-delay: {{ $index * 100 }}ms">
                            {{-- Quote Icon --}}
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                            </div>

                            {{-- Stars Rating --}}
                            <div class="flex items-center gap-1 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= round($avg) ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm font-semibold text-foreground">{{ number_format($avg, 1) }}</span>
                            </div>

                            {{-- Testimonial Text --}}
                            <p class="text-muted-foreground leading-relaxed mb-6 italic line-clamp-4">
                                "{{ $feedback->message ?: 'Pelayanan sangat memuaskan! Dokter profesional dan hasil treatment sangat bagus.' }}"
                            </p>

                            {{-- Customer Info --}}
                            <div class="flex items-center gap-4 pt-6 border-t border-border">
                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($feedback->name ?: 'P', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-foreground">{{ $feedback->name ?: 'Pelanggan' }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ $feedback->service_type ?? 'Beauty Treatment' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-muted-foreground">{{ $feedback->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Default Testimonials --}}
                    <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-foreground">5.0</span>
                        </div>
                        <p class="text-muted-foreground leading-relaxed mb-6 italic">
                            "Pelayanan sangat profesional dan hasil treatment sangat memuaskan! Dokter ramah dan fasilitasnya modern."
                        </p>
                        <div class="flex items-center gap-4 pt-6 border-t border-border">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">R</div>
                            <div class="flex-1">
                                <p class="font-semibold text-foreground">Rini Kusuma</p>
                                <p class="text-sm text-muted-foreground">Facial Treatment</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-100">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-foreground">5.0</span>
                        </div>
                        <p class="text-muted-foreground leading-relaxed mb-6 italic">
                            "Tempat nyaman, dokter ramah, dan hasilnya langsung terlihat. Sangat recommended!"
                        </p>
                        <div class="flex items-center gap-4 pt-6 border-t border-border">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">S</div>
                            <div class="flex-1">
                                <p class="font-semibold text-foreground">Sari Dewi</p>
                                <p class="text-sm text-muted-foreground">Skin Rejuvenation</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-gradient-to-br from-card to-card/50 rounded-2xl p-8 border border-border hover:border-primary/30 hover:shadow-xl transition-smooth hover-lift animate-scale-in delay-200">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-foreground">5.0</span>
                        </div>
                        <p class="text-muted-foreground leading-relaxed mb-6 italic">
                            "Gracias Clinic adalah tempat terbaik untuk perawatan kecantikan. Puas banget!"
                        </p>
                        <div class="flex items-center gap-4 pt-6 border-t border-border">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">M</div>
                            <div class="flex-1">
                                <p class="font-semibold text-foreground">Maya Sari</p>
                                <p class="text-sm text-muted-foreground">Aesthetic Injection</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- CTA Button --}}
            <div class="text-center animate-fade-in delay-400">
                <a href="{{ route('feedback.create') }}"
                   class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                    </svg>
                    <span>Berikan Feedback Anda</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <style>
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-4 { display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
@endsection
