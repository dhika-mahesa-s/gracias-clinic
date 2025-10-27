@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-6 max-w-2xl">
        <!-- Judul -->
        <h3 class="text-3xl font-bold text-center text-gray-800 mb-8">
            Tambah Treatment
        </h3>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-6 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('treatments.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white shadow-xl rounded-2xl p-8 space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Treatment</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                       placeholder="Masukkan nama treatment" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                          placeholder="Tuliskan deskripsi treatment" required>{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                           placeholder="Masukkan harga" required min="0" step="1">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Durasi (menit)</label>
                    <input type="number" name="duration" value="{{ old('duration', 60) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none"
                           placeholder="Durasi dalam menit" required min="1" step="1">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Gambar</label>
                <input type="file" name="image"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                       accept="image/*" required>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center space-x-4 pt-4">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-md transition">
                    Tambah
                </button>
                <a href="{{ route('treatments.manage') }}"
                   class="px-6 py-2 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 shadow-md transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</section>
@endsection
