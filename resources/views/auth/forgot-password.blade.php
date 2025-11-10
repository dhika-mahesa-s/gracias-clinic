<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Gracias Clinic</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-background text-foreground font-[Poppins]">
    
    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-0 bg-card rounded-3xl shadow-2xl border border-border overflow-hidden animate-scale-in">
            
            <!-- Left Side - Brand Section -->
            <div class="hidden lg:flex flex-col justify-center p-12 bg-primary text-primary-foreground relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 animate-slide-right">
                    <!-- Logo/Icon -->
                    <div class="mb-8 animate-bounce-in">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mb-6 hover-lift">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold mb-3">Lupa Password?</h1>
                        <p class="text-primary-foreground/80 text-lg">Jangan khawatir, kami siap membantu Anda</p>
                    </div>

                    <!-- Info Steps -->
                    <div class="space-y-6 mt-12">
                        <div class="flex items-start gap-4 animate-slide-right delay-100">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <span class="text-xl font-bold">1</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Masukkan Email</h3>
                                <p class="text-primary-foreground/80 text-sm">Masukkan alamat email yang terdaftar</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 animate-slide-right delay-150">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <span class="text-xl font-bold">2</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Cek Email Anda</h3>
                                <p class="text-primary-foreground/80 text-sm">Kami akan kirim link reset password</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 animate-slide-right delay-200">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <span class="text-xl font-bold">3</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Buat Password Baru</h3>
                                <p class="text-primary-foreground/80 text-sm">Klik link dan buat password baru</p>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Quote -->
                    <div class="mt-16 p-6 bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 animate-slide-up delay-250">
                        <p class="text-sm italic text-primary-foreground/80">
                            "Keamanan akun Anda adalah prioritas kami"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form Section -->
            <div class="flex items-center justify-center p-8 lg:p-12">
                <div class="w-full max-w-md animate-slide-left">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <h2 class="text-3xl font-bold text-primary">
                            Reset Password
                        </h2>
                        <p class="text-muted-foreground mt-2">Masukkan email Anda untuk melanjutkan</p>
                    </div>

                    <!-- Desktop Header -->
                    <div class="hidden lg:block mb-8 animate-fade-in">
                        <h2 class="text-3xl font-bold text-foreground mb-2">Reset Password</h2>
                        <p class="text-muted-foreground">Masukkan email Anda dan kami akan mengirimkan link reset password</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-slide-down">
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <!-- Email Input -->
                        <div class="animate-slide-up delay-100">
                            <label for="email" class="block text-sm font-medium text-foreground mb-2">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    class="w-full pl-12 pr-4 py-3.5 border-2 border-border bg-card text-foreground rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:border-border/80 @error('email') border-red-300 @enderror"
                                    placeholder="nama@email.com"
                                >
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 animate-slide-down">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-slide-up delay-150">
                            <button 
                                type="submit" 
                                class="w-full bg-primary text-primary-foreground py-3.5 rounded-xl font-semibold hover-lift hover:shadow-xl active-press transition-smooth-fast flex items-center justify-center gap-2 group"
                            >
                                <span>Kirim Link Reset Password</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center animate-fade-in delay-200">
                            <a href="{{ route('login') }}" class="text-sm text-muted-foreground hover:text-primary transition-colors inline-flex items-center gap-1 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Login
                            </a>
                        </div>
                    </form>

                    <!-- Help Section -->
                    <div class="mt-8 p-4 bg-primary/5 rounded-xl border border-primary/20 animate-fade-in delay-250">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-foreground">
                                    <span class="font-semibold">Butuh bantuan?</span><br>
                                    Hubungi kami di <a href="mailto:support@graciasclinic.com" class="text-primary hover:underline">support@graciasclinic.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SweetAlert Handler -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: 'oklch(0.4815 0.1178 263.3758)',
            });
        </script>
    @endif

</body>
</html>