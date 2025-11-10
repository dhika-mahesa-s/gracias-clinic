<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Gracias Clinic</title>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold mb-3">Buat Password Baru</h1>
                        <p class="text-primary-foreground/80 text-lg">Amankan akun Anda dengan password yang kuat</p>
                    </div>

                    <!-- Security Tips -->
                    <div class="space-y-6 mt-12">
                        <div class="flex items-start gap-4 animate-slide-right delay-100">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Minimal 8 Karakter</h3>
                                <p class="text-primary-foreground/80 text-sm">Gunakan kombinasi huruf dan angka</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 animate-slide-right delay-150">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Karakter Spesial</h3>
                                <p class="text-primary-foreground/80 text-sm">Tambahkan @, #, $, atau simbol lain</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 animate-slide-right delay-200">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center flex-shrink-0 hover-scale-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg mb-1">Huruf Besar & Kecil</h3>
                                <p class="text-primary-foreground/80 text-sm">Kombinasi huruf kapital dan kecil</p>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Quote -->
                    <div class="mt-16 p-6 bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 animate-slide-up delay-250">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold">Password Aman</span>
                        </div>
                        <p class="text-sm text-primary-foreground/80">
                            Password yang kuat melindungi data pribadi Anda
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
                            Password Baru
                        </h2>
                        <p class="text-muted-foreground mt-2">Buat password yang aman</p>
                    </div>

                    <!-- Desktop Header -->
                    <div class="hidden lg:block mb-8 animate-fade-in">
                        <h2 class="text-3xl font-bold text-foreground mb-2">Buat Password Baru</h2>
                        <p class="text-muted-foreground">Pastikan password Anda kuat dan mudah diingat</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Input (Read-only) -->
                        <div class="animate-slide-up delay-75">
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
                                    value="{{ old('email', $request->email) }}"
                                    required 
                                    autofocus
                                    readonly
                                    class="w-full pl-12 pr-4 py-3.5 border-2 border-border rounded-xl bg-muted text-muted-foreground cursor-not-allowed"
                                >
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 animate-slide-down">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="animate-slide-up delay-100">
                            <label for="password" class="block text-sm font-medium text-foreground mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password"
                                    required
                                    class="w-full pl-12 pr-12 py-3.5 border-2 border-border bg-card text-foreground rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:border-border/80 @error('password') border-red-300 @enderror"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-muted-foreground hover:text-foreground transition-colors"
                                >
                                    <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 animate-slide-down">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="animate-slide-up delay-150">
                            <label for="password_confirmation" class="block text-sm font-medium text-foreground mb-2">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <input 
                                    id="password_confirmation" 
                                    type="password" 
                                    name="password_confirmation"
                                    required
                                    class="w-full pl-12 pr-12 py-3.5 border-2 border-border bg-card text-foreground rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all duration-300 hover:border-border/80"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-muted-foreground hover:text-foreground transition-colors"
                                >
                                    <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div id="password-strength" class="hidden animate-slide-down">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="strength-bar" class="h-full transition-all duration-300"></div>
                                </div>
                                <span id="strength-text" class="text-xs font-medium"></span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="animate-slide-up delay-200">
                            <button 
                                type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3.5 rounded-xl font-semibold hover-lift hover:shadow-xl active-press transition-smooth-fast flex items-center justify-center gap-2 group"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Reset Password</span>
                            </button>
                        </div>

                        <!-- Back to Login -->
                        <div class="text-center animate-fade-in delay-250">
                            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-purple-600 transition-colors inline-flex items-center gap-1 group">
                                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle Password Visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById('eye-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                field.type = 'password';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Password Strength Checker
        const passwordInput = document.getElementById('password');
        const strengthIndicator = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password.length === 0) {
                strengthIndicator.classList.add('hidden');
                return;
            }

            strengthIndicator.classList.remove('hidden');
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch(strength) {
                case 1:
                    strengthBar.style.width = '25%';
                    strengthBar.className = 'h-full bg-red-500 transition-all duration-300';
                    strengthText.textContent = 'Lemah';
                    strengthText.className = 'text-xs font-medium text-red-500';
                    break;
                case 2:
                    strengthBar.style.width = '50%';
                    strengthBar.className = 'h-full bg-orange-500 transition-all duration-300';
                    strengthText.textContent = 'Sedang';
                    strengthText.className = 'text-xs font-medium text-orange-500';
                    break;
                case 3:
                    strengthBar.style.width = '75%';
                    strengthBar.className = 'h-full bg-yellow-500 transition-all duration-300';
                    strengthText.textContent = 'Baik';
                    strengthText.className = 'text-xs font-medium text-yellow-500';
                    break;
                case 4:
                    strengthBar.style.width = '100%';
                    strengthBar.className = 'h-full bg-green-500 transition-all duration-300';
                    strengthText.textContent = 'Kuat';
                    strengthText.className = 'text-xs font-medium text-green-500';
                    break;
                default:
                    strengthBar.style.width = '10%';
                    strengthBar.className = 'h-full bg-red-500 transition-all duration-300';
                    strengthText.textContent = 'Sangat Lemah';
                    strengthText.className = 'text-xs font-medium text-red-500';
            }
        });
    </script>

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