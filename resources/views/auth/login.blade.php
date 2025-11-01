@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-background text-foreground py-12 px-6">
    <div class="w-full max-w-md bg-card rounded-2xl shadow-xl p-8 border border-border">
        <h2 class="text-3xl font-semibold text-center mb-6 text-foreground">
            {{ __('Login ke Akun Anda') }}
        </h2>

        {{-- Flash Message --}}
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Email Address') }}
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="Masukkan email Anda"
                    class="w-full px-4 py-2 border border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary bg-background text-foreground placeholder:text-muted-foreground/70">
                @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Password') }}
                </label>
                <input id="password" type="password" name="password" required
                    placeholder="Masukkan password"
                    class="w-full px-4 py-2 border border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary bg-background text-foreground placeholder:text-muted-foreground/70">
                @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Remember Me + Forgot --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded text-primary focus:ring-primary">
                    <span>{{ __('Ingat saya') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-primary hover:underline" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            {{-- Tombol Login --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-primary/90 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    {{ __('Login') }}
                </button>
            </div>

            {{-- 🌟 Divider --}}
            <div class="flex items-center my-4">
                <hr class="flex-1 border-gray-300">
                <span class="px-3 text-gray-500 text-sm">atau</span>
                <hr class="flex-1 border-gray-300">
            </div>

            {{-- 🌟 Tombol Login Google --}}
            <a href="{{ route('auth.redirect') }}"
                class="w-full flex items-center justify-center gap-3 border border-gray-300 bg-white py-2.5 rounded-xl shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5">
                <span class="text-gray-700 font-medium">Login dengan Google</span>
            </a>

            {{-- Tombol Register --}}
            <div class="text-center pt-4">
                <a class="text-primary hover:underline" href="{{ route('register') }}">
                    {{ __('Daftar Sekarang') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
