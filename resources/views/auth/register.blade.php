@extends('layouts.app')

@section('content')
    {{-- Main Container with Split Layout --}}
    <div class="min-h-screen flex bg-background text-foreground overflow-hidden">
        
        {{-- Left Side - Gradient Brand Section (Hidden on mobile) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-primary via-primary/90 to-primary/80 p-12 items-center justify-center">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtNi42MjcgNS4zNzMtMTIgMTItMTJzMTIgNS4zNzMgMTIgMTItNS4zNzMgMTItMTIgMTItMTItNS4zNzMtMTItMTJ6TTAgMTZjMC02LjYyNyA1LjM3My0xMiAxMi0xMnMxMiA1LjM3MyAxMiAxMi01LjM3MyAxMi0xMiAxMlMwIDIyLjYyNyAwIDE2em0zNiAzNmMwLTYuNjI3IDUuMzczLTEyIDEyLTEyczEyIDUuMzczIDEyIDEyLTUuMzczIDEyLTEyIDEyLTEyLTUuMzczLTEyLTEyem0tMzYgMGMwLTYuNjI3IDUuMzczLTEyIDEyLTEyczEyIDUuMzczIDEyIDEyLTUuMzczIDEyLTEyIDEyUzAgNTguNjI3IDAgNTJ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-30"></div>
            
            <div class="relative z-10 text-white animate-slide-right">
                <div class="mb-8 animate-scale-in">
                    {{-- Icon Sparkles untuk Klinik Kecantikan --}}
                    <svg class="w-16 h-16 mb-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                    </svg>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight animate-slide-right delay-75">
                    Bergabunglah<br/>Bersama Kami
                </h1>
                <p class="text-lg text-white/90 mb-8 max-w-md animate-slide-right delay-100">
                    Daftar sekarang dan nikmati pengalaman perawatan kecantikan terbaik di Pekanbaru dengan teknologi modern dan dokter berpengalaman.
                </p>
                
                <div class="space-y-3 animate-slide-right delay-150">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Reservasi Online 24/7</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Konsultasi dengan Dokter Expert</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-white/90">Treatment Premium Berkualitas</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Register Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                {{-- Header Section --}}
                <div class="text-center mb-8 animate-fade-in">
                    <div class="lg:hidden mb-6 inline-flex w-16 h-16 items-center justify-center rounded-2xl bg-primary/10 text-primary animate-scale-in">
                        {{-- Icon Sparkles untuk Klinik Kecantikan --}}
                        <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-2 animate-slide-up delay-75">
                        Buat Akun Baru
                    </h2>
                    <p class="text-muted-foreground text-base animate-slide-up delay-100">
                        Isi form di bawah untuk mendaftar
                    </p>
                </div>

                {{-- Register Card --}}
                <div class="bg-card rounded-2xl shadow-xl border border-border p-8 backdrop-blur-sm animate-slide-up delay-150">
                    
                    {{-- Form Register --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf
                        
                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-foreground">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    placeholder="Masukkan nama lengkap Anda"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30 {{ $errors->has('name') ? 'border-destructive ring-2 ring-destructive/20' : '' }}">
                            </div>
                            @error('name')
                                <p class="text-sm text-destructive mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-foreground">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="nama@example.com"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30 {{ $errors->has('email') ? 'border-destructive ring-2 ring-destructive/20' : '' }}">
                            </div>
                            @error('email')
                                <p class="text-sm text-destructive mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-foreground">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30 {{ $errors->has('password') ? 'border-destructive ring-2 ring-destructive/20' : '' }}">
                            </div>
                            @error('password')
                                <p class="text-sm text-destructive mt-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="space-y-2">
                            <label for="password-confirm" class="block text-sm font-medium text-foreground">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Ulangi password Anda"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30">
                            </div>
                        </div>

                        {{-- Register Button --}}
                        <button type="submit"
                            class="w-full py-3.5 rounded-xl bg-primary text-primary-foreground font-semibold shadow-md hover-lift hover:shadow-lg hover:bg-primary/90 active-press transition-smooth-fast focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 mt-6">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>

                {{-- Login Link --}}
                <div class="text-center mt-6 animate-fade-in delay-200">
                    <p class="text-muted-foreground">
                        Sudah punya akun?
                        <a class="text-primary hover:text-primary/80 font-semibold transition-smooth-fast hover:underline ml-1" href="{{ route('login') }}">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection