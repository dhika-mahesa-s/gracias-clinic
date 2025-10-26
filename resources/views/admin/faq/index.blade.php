<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin FAQ - Gracias Clinic</title>

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
    <main class="flex-grow pt-24">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-10 mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Kelola FAQ</h2>
                <a href="{{ url('admin/faq/create') }}" class="inline-flex items-center bg-teal-700 hover:bg-teal-600 text-white text-sm px-4 py-2 rounded-lg transition">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah FAQ
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="border-b border-gray-200 px-4 py-3 text-left">Pertanyaan</th>
                            <th class="border-b border-gray-200 px-4 py-3 text-left">Jawaban</th>
                            <th class="border-b border-gray-200 px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                        <tr class="even:bg-gray-50 hover:bg-gray-100 transition">
                            <td class="border-b border-gray-200 px-4 py-3 align-top">{{ $faq->question ?? $faq->pertanyaan }}</td>
                            <td class="border-b border-gray-200 px-4 py-3 align-top">{{ $faq->answer ?? $faq->jawaban }}</td>
                            <td class="border-b border-gray-200 px-4 py-3">
                                <div class="flex space-x-3">
                                    <a href="{{ url('admin/faq/'.$faq->id.'/edit') }}" class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ url('admin/faq/'.$faq->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500 italic">Belum ada data FAQ</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer Wave -->
    <footer class="w-full mt-auto">
        <div class="w-full h-24 bg-[#4b5a68] rounded-t-[100%_100%]"></div>
    </footer>

</body>
</html>
