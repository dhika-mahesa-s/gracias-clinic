@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-background text-foreground py-12 px-6">
        <div class="w-full max-w-md">
            {{-- Header Section --}}
            <div class="text-center mb-8 animate-fade-in">
                <div class="mb-6 inline-flex w-20 h-20 items-center justify-center rounded-2xl bg-primary/10 text-primary animate-scale-in">
                    {{-- Icon Email --}}
                    <svg class="w-11 h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-2 animate-slide-up delay-75">
                    Verifikasi Email Anda
                </h2>
                <p class="text-muted-foreground text-base animate-slide-up delay-100">
                    Satu langkah lagi untuk menyelesaikan pendaftaran
                </p>
            </div>

            {{-- Card --}}
            <div class="bg-card rounded-2xl shadow-xl border border-border p-8 backdrop-blur-sm animate-slide-up delay-150">
                
                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl animate-bounce-in flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Info Box --}}
                <div class="bg-primary/5 border-l-4 border-primary rounded-lg p-5 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-foreground mb-2">
                                Kami telah mengirim link verifikasi ke email Anda:
                            </p>
                            <p class="text-sm font-semibold text-primary">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="space-y-4 mb-6">
                    <p class="text-sm text-muted-foreground">
                        Silakan cek inbox atau folder spam email Anda dan klik link verifikasi yang kami kirimkan.
                    </p>
                    
                    <div class="bg-muted/30 rounded-xl p-4 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs font-bold shrink-0">
                                1
                            </div>
                            <p class="text-sm text-foreground">Buka email dari <strong>Gracias Clinic</strong></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs font-bold shrink-0">
                                2
                            </div>
                            <p class="text-sm text-foreground">Klik tombol <strong>"Verifikasi Email"</strong></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-primary text-primary-foreground flex items-center justify-center text-xs font-bold shrink-0">
                                3
                            </div>
                            <p class="text-sm text-foreground">Akun Anda akan aktif dan siap digunakan!</p>
                        </div>
                    </div>
                </div>

                {{-- Resend Button --}}
                <div class="border-t border-border pt-6">
                    <p class="text-sm text-muted-foreground text-center mb-4">
                        Tidak menerima email?
                    </p>
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-secondary text-secondary-foreground font-semibold shadow-sm hover-lift hover:shadow-md hover:bg-secondary/90 active-press transition-smooth-fast focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Kirim Ulang Email Verifikasi
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="text-center mt-6 animate-fade-in delay-200">
                <a href="{{ route('landingpage') }}" class="text-muted-foreground hover:text-primary transition-smooth-fast inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
