@extends('layouts.app')

@section('title', 'FAQ - Gracias Aesthetic Clinic')

@section('content')
<div class="relative min-h-screen bg-background overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Hero Section --}}
    <section class="relative max-w-5xl mx-auto mb-12 animate-fade-in">
        <div class="text-center">
            <div class="inline-flex items-center justify-center p-3 bg-gradient-to-br from-primary to-primary/80 rounded-2xl shadow-lg mb-6 animate-bounce-slow">
                <i class="fa-solid fa-circle-question text-primary-foreground text-3xl"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-foreground mb-4 animate-slide-up delay-75">
                Frequently Asked <span class="text-primary">Questions</span>
            </h1>
            <p class="text-base sm:text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed animate-slide-up delay-100">
                Temukan jawaban dari pertanyaan yang sering diajukan seputar layanan kami
            </p>
        </div>
    </section>

    {{-- FAQ Container --}}
    <section class="max-w-4xl mx-auto">
        {{-- Stats Card --}}
        <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 mb-8 border border-primary/20 shadow-md animate-scale-in delay-150">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-primary/80 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-list-check text-primary-foreground text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-muted-foreground font-semibold">Total Pertanyaan</p>
                        <p class="text-2xl font-bold text-primary">{{ $faqs->count() }} FAQ</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <i class="fa-solid fa-lightbulb text-primary"></i>
                    <span>Klik pertanyaan untuk melihat jawaban</span>
                </div>
            </div>
        </div>

        {{-- FAQ Accordion --}}
        <div class="space-y-4 mb-8">
            @forelse ($faqs as $index => $faq)
                @php
                    $delays = ['delay-75', 'delay-100', 'delay-150', 'delay-200'];
                    $delayClass = $delays[$index % 4] ?? '';
                @endphp
                <div class="bg-gradient-to-br from-card to-card/50 rounded-2xl shadow-lg border border-border overflow-hidden hover:shadow-xl transition-smooth animate-slide-up {{ $delayClass }} group">
                    <button 
                        class="w-full flex justify-between items-center px-6 py-5 text-left hover:bg-primary/5 transition-smooth"
                        onclick="toggleFAQ({{ $index }})">
                        <div class="flex items-start gap-4 flex-1 pr-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl flex items-center justify-center border border-primary/20 group-hover:border-primary/40 transition-smooth">
                                <span class="text-primary font-bold text-sm">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="text-base sm:text-lg font-semibold text-card-foreground group-hover:text-primary transition-smooth leading-relaxed">
                                    {{ $faq->question }}
                                </h3>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div id="icon{{ $index }}" class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center transition-all duration-300 group-hover:bg-primary group-hover:scale-110">
                                <i class="fa-solid fa-chevron-down text-primary group-hover:text-primary-foreground text-sm transition-all duration-300"></i>
                            </div>
                        </div>
                    </button>
                    <div id="answer{{ $index }}" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="px-6 pb-6 border-t border-border/50">
                            <div class="pt-5 flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                                        <i class="fa-solid fa-check text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-sm sm:text-base text-muted-foreground leading-relaxed whitespace-pre-line">{{ $faq->answer }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-card rounded-2xl shadow-lg border border-border p-16 text-center animate-fade-in">
                    <div class="w-24 h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-inbox text-6xl text-muted-foreground"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-card-foreground mb-2">Belum Ada FAQ</h3>
                    <p class="text-muted-foreground text-lg">Pertanyaan yang sering diajukan akan muncul di sini</p>
                </div>
            @endforelse
        </div>

        {{-- Contact WhatsApp Card --}}
        <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-2xl shadow-lg border border-green-200 p-8 animate-scale-in delay-200 hover:shadow-xl transition-smooth hover-lift">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg animate-bounce-slow">
                        <i class="fa-brands fa-whatsapp text-white text-4xl"></i>
                    </div>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h3 class="text-xl sm:text-2xl font-bold text-green-900 mb-2">
                        Masih Ada Pertanyaan?
                    </h3>
                    <p class="text-sm sm:text-base text-green-700 mb-4">
                        Tim kami siap membantu menjawab pertanyaan Anda melalui WhatsApp
                    </p>
                    <a href="https://wa.me/6282174973339?text=Halo%20Gracias%20Aesthetic%20Clinic%2C%20saya%20ingin%20bertanya" 
                       target="_blank"
                       class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-smooth hover-scale-sm active-press">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                        <span>Hubungi Kami via WhatsApp</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Additional Info --}}
        <div class="mt-8 text-center animate-fade-in delay-250">
            <p class="text-sm text-muted-foreground flex items-center justify-center gap-2 flex-wrap">
                <i class="fa-solid fa-clock text-primary"></i>
                <span>FAQ diperbarui secara berkala untuk memberikan informasi terkini</span>
            </p>
        </div>
    </section>

    {{-- Bottom Padding --}}
    <div class="h-16"></div>
</div>

<script>
    function toggleFAQ(index) {
        const content = document.getElementById('answer' + index);
        const icon = document.getElementById('icon' + index);
        const iconElement = icon.querySelector('i');
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

        // Close all other FAQs
        document.querySelectorAll('[id^="answer"]').forEach(el => {
            el.style.maxHeight = '0px';
        });
        document.querySelectorAll('[id^="icon"] i').forEach(ic => {
            ic.classList.remove('rotate-180');
        });

        // Toggle current FAQ
        if (!isOpen) {
            content.style.maxHeight = content.scrollHeight + 'px';
            iconElement.classList.add('rotate-180');
        }
    }
</script>
@endsection
