@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] py-12">
    <div class="container mx-auto px-6 max-w-2xl">
        <!-- Judul -->
        <h3 class="text-3xl font-bold text-center text-[#27374D] mb-8">
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
              class="bg-gray-100 border border-gray-300 shadow-md rounded-2xl p-8 space-y-5">
            @csrf

            <!-- Nama Treatment -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Nama Treatment</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                       placeholder="Masukkan nama treatment" required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none resize-none"
                          placeholder="Tuliskan deskripsi treatment" required>{{ old('description') }}</textarea>
            </div>

            <!-- Harga & Durasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[#27374D] font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                           placeholder="Masukkan harga" required min="0" step="1">
                </div>

                <div>
                    <label class="block text-[#27374D] font-semibold mb-2">Durasi (menit)</label>
                    <input type="number" name="duration" value="{{ old('duration', 60) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                           placeholder="Durasi dalam menit" required min="1" step="1">
                </div>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Gambar</label>
                <input type="file" name="image"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-sm text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary  file:text-white hover:file:bg-primary/90 transition"
                       accept="image/*" required>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center space-x-4 pt-4">
                <button type="submit"
                        class="px-6 py-2.5 bg-primary hover:bg-primary/90 transition-all duration-300 text-white rounded-xl font-medium shadow-md">
                    ➕ Tambah
                </button>
                <a href="{{ route('treatments.manage') }}"
                   class="px-6 py-2.5 border border-[#526D82] text-[#526D82] rounded-xl hover:bg-[#526D82] hover:text-white shadow-sm transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</section>
@endsection
