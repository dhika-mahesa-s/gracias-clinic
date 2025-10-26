<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Gracias Aesthetic Clinic</title>

    @vite('resources/css/app.css')

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="flex flex-col min-h-screen font-[Poppins] bg-gray-100 text-gray-800 pt-24">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center space-x-2 text-gray-800 font-semibold text-lg font-[Playfair_Display]">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-10 h-10">
                <span>Gracias Aesthetic Clinic</span>
            </a>
            <button class="lg:hidden text-gray-700 focus:outline-none" id="menu-btn">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <ul id="menu" class="hidden lg:flex space-x-8 text-gray-700 text-sm font-medium">
                <li><a href="#" class="hover:text-teal-700 {{ request()->is('/') ? 'text-teal-700 font-semibold' : '' }}">Home</a></li>
                <li><a href="#" class="hover:text-teal-700">Our Team</a></li>
                <li><a href="#" class="hover:text-teal-700">Product</a></li>
                <li><a href="#" class="hover:text-teal-700">Promo</a></li>
                <li><a href="#" class="hover:text-teal-700">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- FAQ Section -->
    <main class="flex-grow max-w-3xl mx-auto mt-16 bg-white rounded-2xl shadow-lg p-10">
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
    </main>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="w-full h-24 bg-[#4b5a68] rounded-t-[100%_100%]"></div>
    </footer>

    <script>
        // Mobile menu toggle
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));

        // FAQ accordion toggle
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
</body>
</html>
