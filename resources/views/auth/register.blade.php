@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-background text-foreground py-12 px-6">
    <div class="w-full max-w-md bg-card rounded-2xl shadow-xl p-8 border border-border">
        {{-- Judul --}}
        <h2 class="text-3xl font-semibold text-center mb-6 text-foreground">
            {{ __('Buat Akun Baru') }}
        </h2>

        {{-- Form Register --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Nama Lengkap') }}
                </label>
                <input id="name" type="text"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 {{ $errors->has('name') ? 'border-red-500 ring-red-200' : 'border-input' }}"
                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                    placeholder="Masukkan nama Anda">

                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Email Address') }}
                </label>
                <input id="email" type="email"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 {{ $errors->has('email') ? 'border-red-500 ring-red-200' : 'border-input' }}"
                    name="email" value="{{ old('email') }}" required autocomplete="email"
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
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 {{ $errors->has('password') ? 'border-red-500 ring-red-200' : 'border-input' }}"
                    name="password" required autocomplete="new-password"
                    placeholder="Masukkan password">

                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password-confirm" class="block text-sm font-medium text-muted-foreground mb-1">
                    {{ __('Konfirmasi Password') }}
                </label>
                <input id="password-confirm" type="password"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-background text-foreground placeholder:text-muted-foreground/70 border-input"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="Ulangi password">
            </div>

            {{-- Tombol Register --}}
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-primary/90 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    {{ __('Register') }}
                </button>
            </div>

            {{-- Sudah punya akun --}}
            <p class="text-sm text-center text-muted-foreground mt-3">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">
                    Masuk di sini
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
