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
                    Welcome to<br/>Gracias Clinic
                </h1>
                <p class="text-lg text-white/90 mb-8 max-w-md animate-slide-right delay-100">
                    Klinik kecantikan terpercaya di Pekanbaru. Wujudkan impian kecantikan Anda bersama dokter profesional dan berpengalaman.
                </p>
                
                <div class="flex items-center gap-4 animate-slide-right delay-150">
                    {{-- Icon Stars untuk Rating/Kepuasan --}}
                    <div class="flex gap-1">
                        <svg class="w-10 h-10 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"/>
                        </svg>
                        <svg class="w-10 h-10 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"/>
                        </svg>
                        <svg class="w-10 h-10 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"/>
                        </svg>
                    </div>
                    <div class="text-sm">
                        <p class="font-semibold">1000+ Pasien Puas</p>
                        <p class="text-white/80">Dipercaya di Pekanbaru</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            
            {{-- Peringatan In-App Browser --}}
            <div id="webview-warning" class="hidden fixed top-20 left-0 right-0 z-50 mx-4 animate-slide-down">
                <div class="max-w-md mx-auto bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-lg">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-yellow-800">
                                Anda mengakses dari dalam aplikasi
                            </p>
                            <p class="mt-1 text-xs text-yellow-700">
                                Login Google mungkin tidak berfungsi. Buka di browser untuk login dengan Google.
                            </p>
                        </div>
                        <button onclick="document.getElementById('webview-warning').classList.add('hidden')" class="ml-3 shrink-0 hover-scale-sm">
                            <svg class="h-4 w-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

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
                        Selamat Datang di Gracias Aesthetic Clinic
                    </h2>
                    <p class="text-muted-foreground text-base animate-slide-up delay-100">
                        Silakan login untuk melanjutkan
                    </p>
                </div>

                {{-- Login Card --}}
                <div class="bg-card rounded-2xl shadow-xl border border-border p-8 backdrop-blur-sm animate-slide-up delay-150">
                    
                    {{-- Flash Message --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl animate-bounce-in">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Google Login Button - Prioritas Teratas --}}
                    @php
                        // Ambil intended URL dari session jika ada (dari middleware auth)
                        $intendedUrl = session('url.intended');
                        $googleRedirectUrl = route('auth.redirect');
                        
                        // Jika ada intended URL, tambahkan sebagai parameter
                        if ($intendedUrl) {
                            $googleRedirectUrl .= '?redirect_to=' . urlencode($intendedUrl);
                        }
                    @endphp
                    <a href="{{ $googleRedirectUrl }}" id="google-login-btn"
                        class="group w-full flex items-center justify-center gap-3 bg-white border-2 border-border py-3.5 rounded-xl shadow-sm hover-lift hover:shadow-md hover:border-primary/30 active-press transition-smooth-fast mb-6">
                        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5">
                        <span class="text-foreground font-semibold group-hover:text-primary transition-smooth-fast">Lanjutkan dengan Google</span>
                    </a>

                    {{-- Divider --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-border"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-card text-muted-foreground">atau login dengan email</span>
                        </div>
                    </div>

                    {{-- Form Login --}}
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        
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
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="nama@example.com"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30">
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
                                <input id="password" type="password" name="password" required placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/60 transition-smooth-fast hover:border-primary/30">
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

                        {{-- Remember Me + Forgot Password --}}
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember" id="remember"
                                    class="w-4 h-4 rounded border-input text-primary focus:ring-2 focus:ring-primary focus:ring-offset-0 transition-smooth-fast">
                                <span class="text-foreground group-hover:text-primary transition-smooth-fast">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-primary hover:text-primary/80 font-medium transition-smooth-fast hover:underline" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        {{-- Login Button --}}
                        <button type="submit"
                            class="w-full py-3.5 rounded-xl bg-primary text-primary-foreground font-semibold shadow-md hover-lift hover:shadow-lg hover:bg-primary/90 active-press transition-smooth-fast focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Masuk ke Akun
                        </button>

                        {{-- Edge Info --}}
                        <div id="edge-info" class="hidden text-xs text-center text-muted-foreground">
                            <p>💡 Pengguna Edge: Jika login gagal, coba nonaktifkan "Tracking Prevention"</p>
                        </div>
                    </form>
                </div>

                {{-- Register Link --}}
                <div class="text-center mt-6 animate-fade-in delay-200">
                    <p class="text-muted-foreground">
                        Belum punya akun?
                        <a class="text-primary hover:text-primary/80 font-semibold transition-smooth-fast hover:underline ml-1" href="{{ route('register') }}">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {

        // Deteksi WebView atau In-App Browser
        function isInAppBrowser() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            
            // Deteksi Instagram, Facebook, LINE, dll
            return (ua.indexOf('Instagram') > -1) ||
                   (ua.indexOf('FBAN') > -1) || (ua.indexOf('FBAV') > -1) ||
                   (ua.indexOf('Line/') > -1) ||
                   (ua.indexOf('Twitter') > -1) ||
                   (ua.indexOf('LinkedIn') > -1) ||
                   (ua.indexOf('WhatsApp') > -1) ||
                   // Deteksi WebView Android
                   (ua.indexOf('wv') > -1 && ua.indexOf('Android') > -1) ||
                   // Deteksi iOS WebView  
                   (ua.indexOf('iPhone') > -1 && ua.indexOf('Safari') === -1 && ua.indexOf('CriOS') === -1 && ua.indexOf('FxiOS') === -1);
        }

        // Deteksi Edge browser
        function isEdgeBrowser() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            return ua.indexOf('Edg/') > -1 || ua.indexOf('Edge/') > -1;
        }

        // Deteksi Device Emulation Mode (problematic untuk Google OAuth)
        function isDeviceEmulation() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            
            // PENTING: Hanya deteksi jika benar-benar device emulation
            // Cek 1: User-Agent mengandung mobile device tapi width screen terlalu besar (emulator)
            const hasEdg = ua.indexOf('Edg/') > -1;
            const hasMobile = ua.indexOf('Mobile') > -1;
            const hasIPhone = ua.indexOf('iPhone') > -1;
            const hasAndroid = ua.indexOf('Android') > -1;
            
            // Jika Edge dan mengirim UA mobile/iPhone/Android
            const isSuspiciousUA = hasEdg && (hasIPhone || (hasAndroid && ua.indexOf('Samsung') > -1));
            
            // Cek 2: Bandingkan screen width dengan yang dilaporkan UA
            // Device emulation biasanya screen width desktop tapi UA mobile
            const isLikelyEmulation = isSuspiciousUA && window.screen.width > 1024;
            
            // Cek 3: Deteksi webdriver atau automation tools
            const hasWebDriver = navigator.webdriver === true;
            
            return isLikelyEmulation || hasWebDriver;
        }

        // Tampilkan info untuk Edge user
        if (isEdgeBrowser()) {
            const edgeInfo = document.getElementById('edge-info');
            if (edgeInfo) edgeInfo.classList.remove('hidden');
        }

        // Tampilkan warning banner jika di in-app browser
        if (isInAppBrowser()) {
            document.getElementById('webview-warning').classList.remove('hidden');
        }

        // Warning khusus untuk device emulation
        if (isDeviceEmulation()) {
            document.getElementById('webview-warning').classList.remove('hidden');
            const warningEl = document.getElementById('webview-warning');
            warningEl.querySelector('p.text-sm').textContent = 'Browser Device Emulation Terdeteksi';
            warningEl.querySelector('p.text-xs').textContent = 'Login Google tidak berfungsi saat menggunakan Device Emulation (F12 → Toggle Device Toolbar). Matikan emulasi atau resize window secara manual.';
        }

        // Warning untuk user jika menggunakan in-app browser
        if (googleBtn && isInAppBrowser()) {
            googleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    html: `
                        <p class="mb-3">Anda mengakses dari dalam aplikasi. Login Google mungkin tidak berfungsi.</p>
                        <p class="font-semibold">Silakan:</p>
                        <ol class="text-left list-decimal list-inside mt-2 space-y-1">
                            <li>Klik tombol menu (⋮) di browser</li>
                            <li>Pilih "Buka di Browser" atau "Open in Browser"</li>
                            <li>Login ulang menggunakan Google</li>
                        </ol>
                    `,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#3085d6',
                    footer: '<small>Atau gunakan login dengan Email & Password</small>'
                });
            });
        }

        // Warning untuk device emulation - HARUS MATIKAN EMULASI
        if (googleBtn && isDeviceEmulation()) {
            googleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    icon: 'error',
                    title: 'Google Memblokir Device Emulation',
                    html: `
                        <div class="text-left">
                            <p class="mb-3"><strong>Google OAuth tidak mengizinkan browser device emulation karena alasan keamanan.</strong></p>
                            
                            <p class="font-semibold mb-2 text-red-600">Ini BUKAN bug aplikasi, tapi policy Google yang tidak bisa di-bypass.</p>
                            
                            <div class="bg-blue-50 p-3 rounded mb-3">
                                <p class="font-semibold mb-2">✅ Solusi untuk Testing Mobile View:</p>
                                <ol class="list-decimal list-inside space-y-1 text-sm">
                                    <li><strong>Matikan Device Toolbar</strong>
                                        <br><span class="text-xs text-gray-600">→ Tekan F12 → Klik ikon device (Ctrl+Shift+M)</span>
                                    </li>
                                    <li><strong>Resize window manual</strong>
                                        <br><span class="text-xs text-gray-600">→ Drag pojok window hingga kecil</span>
                                    </li>
                                    <li><strong>Gunakan HP/Tablet asli</strong>
                                        <br><span class="text-xs text-gray-600">→ Buka di browser mobile sebenarnya</span>
                                    </li>
                                </ol>
                            </div>
                            
                            <div class="bg-yellow-50 p-3 rounded">
                                <p class="font-semibold mb-1">🔐 Kenapa Google memblokir?</p>
                                <p class="text-xs text-gray-700">Device emulation terdeteksi sebagai "embedded webview" yang bisa digunakan untuk intercept credentials. Google memblokir untuk melindungi keamanan akun user.</p>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Gunakan Email/Password Login',
                    cancelButtonText: 'Tutup',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6b7280',
                    width: '600px',
                    customClass: {
                        htmlContainer: 'text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Fokus ke form email/password
                        document.getElementById('email').focus();
                    }
                });
            });
        }

        // Fix untuk Edge browser - pastikan link bekerja dengan baik
        if (googleBtn && isEdgeBrowser() && !isDeviceEmulation()) {
            // Mode normal Edge - biarkan berfungsi normal tanpa intercept
        }
    });
</script>
@endpush