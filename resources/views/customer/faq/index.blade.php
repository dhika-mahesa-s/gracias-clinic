@extends('layouts.app')

@section('title', 'FAQ - Gracias Aesthetic Clinic')

@section('content')
<section class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl shadow-lg p-10 relative">
    <h2 class="text-3xl font-semibold text-center mb-8">Frequently Asked Questions</h2>

    <div class="space-y-4">
        @foreach ($faqs as $index => $faq)
        <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <button 
                class="w-full flex justify-between items-center px-5 py-4 text-left text-gray-800 font-medium hover:bg-gray-50 transition"
                onclick="toggleFAQ({{ $index }})">
                <span>{{ $faq->question }}</span>
                <i id="icon{{ $index }}" class="fa-solid fa-chevron-down transition-transform duration-300"></i>
            </button>
            <div id="answer{{ $index }}" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                <div class="px-5 pb-4 text-gray-700 border-t border-gray-100">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pesan kontak WhatsApp di pojok kanan --}}
    <div class="text-sm text-gray-700 mt-8 text-right">
        <p>
            Ingin tahu lebih banyak?, hubungi kami melalui 
            <a href="https://wa.me/6282174973339" target="_blank" 
               class="text-green-600 hover:text-green-700 font-medium underline">
                WhatsApp
            </a>.
        </p>
    </div>
</section>

<script>
    function toggleFAQ(index) {
        const content = document.getElementById('answer' + index);
        const icon = document.getElementById('icon' + index);
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

        document.querySelectorAll('[id^="answer"]').forEach(el => el.style.maxHeight = '0px');
        document.querySelectorAll('[id^="icon"]').forEach(ic => ic.classList.remove('rotate-180'));

        if (!isOpen) {
            content.style.maxHeight = content.scrollHeight + 'px';
            icon.classList.add('rotate-180');
        }
    }
</script>
@endsection
