@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-background text-foreground py-12 px-6">
    <div class="w-full max-w-md bg-card rounded-2xl shadow-xl p-8 border border-border">
        {{-- Judul --}}
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
                <input id="email" type="email"
                    class="w-full px-4 py-2 border border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 @error('email') border-red-500 ring-red-200 @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    placeholder="Masukkan email Anda">

                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Password') }}
                </label>
                <input id="password" type="password"
                    class="w-full px-4 py-2 border border-input rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 @error('password') border-red-500 ring-red-200 @enderror"
                    name="password" required autocomplete="current-password"
                    placeholder="Masukkan password">

                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded text-primary focus:ring-primary"
                        {{ old('remember') ? 'checked' : '' }}>
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
                    class="w-full py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-primary/90 transition">
                    {{ __('Login') }}
                </button>
            </div>
            <a class="text-primary hover:underline" href="{{ route('register') }}">
                        {{ __('Daftar Sekarang') }}
                    </a>
        </form>
    </div>
</div>
@endsection