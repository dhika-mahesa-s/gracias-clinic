<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah FAQ - Gracias Clinic</title>

    @vite('resources/css/app.css')

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <a href="#" class="flex items-center space-x-2 text-gray-800 font-semibold text-lg font-[Playfair_Display]">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-10 h-10">
                <span>Gracias Aesthetic Clinic</span>
            </a>
            <ul class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <li><a href="#" class="hover:text-teal-600 text-gray-700">Home</a></li>
                <li><a href="#" class="hover:text-teal-600 text-gray-700">Our Team</a></li>
                <li><a href="#" class="hover:text-teal-600 text-gray-700">Product</a></li>
                <li><a href="#" class="hover:text-teal-600 text-gray-700">Promo</a></li>
                <li><a href="#" class="hover:text-teal-600 text-gray-700">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-28">
        <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg p-10">
            <h1 class="text-2xl font-semibold text-center mb-6 text-gray-800">Tambah FAQ Baru</h1>

            <form action="{{ url('admin/faq') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan:</label>
                    <input type="text" id="question" name="question" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent transition">
                </div>

                <div>
                    <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">Jawaban:</label>
                    <textarea id="answer" name="answer" rows="4" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent transition"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <a href="{{ url('admin/faq') }}"
                        class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-4 py-2 rounded-lg transition">
                        <i class="fa-solid fa-xmark mr-2"></i> Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center bg-teal-700 hover:bg-teal-600 text-white text-sm px-4 py-2 rounded-lg transition">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer Wave -->
    <footer class="w-full mt-auto">
        <div class="w-full h-24 bg-[#4b5a68] rounded-t-[100%_100%]"></div>
    </footer>

</body>
</html>
