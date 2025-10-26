<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit FAQ - Gracias Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="font-[Poppins] bg-gray-100 pt-24">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <a href="#" class="flex items-center font-serif font-bold text-lg text-gray-800">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-12 h-12 mr-3">
                Gracias Aesthetic Clinic
            </a>
            <button class="lg:hidden text-gray-700 focus:outline-none" id="menu-btn">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <ul id="menu" class="hidden lg:flex space-x-6 text-gray-700">
                <li><a href="#" class="hover:text-teal-700 {{ request()->is('/') ? 'text-teal-700 font-semibold' : '' }}">Home</a></li>
                <li><a href="#" class="hover:text-teal-700">Our Team</a></li>
                <li><a href="#" class="hover:text-teal-700">Product</a></li>
                <li><a href="#" class="hover:text-teal-700">Promo</a></li>
                <li><a href="#" class="hover:text-teal-700">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="bg-white max-w-lg mx-auto mt-16 p-10 rounded-2xl shadow-md">
        <h1 class="text-2xl font-semibold text-center text-gray-800 mb-8">Edit FAQ</h1>

        <form action="{{ url('admin/faq/'.$faq->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="question" class="block text-gray-700 font-medium mb-2">Pertanyaan:</label>
                <input type="text" name="question" id="question"
                       value="{{ $faq->question }}"
                       required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">
            </div>

            <div>
                <label for="answer" class="block text-gray-700 font-medium mb-2">Jawaban:</label>
                <textarea name="answer" id="answer" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">{{ $faq->answer }}</textarea>
            </div>

            <div class="flex justify-end gap-4">
                <button type="submit" class="bg-gray-700 hover:bg-teal-700 text-white px-5 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
                <a href="{{ url('admin/faq') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>
        </form>
    </main>

    <script>
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
