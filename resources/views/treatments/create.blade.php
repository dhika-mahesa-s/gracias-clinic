@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] py-12 animate-fadeIn">
    <div class="container mx-auto px-6 max-w-2xl animate-fadeUp">

        <!-- Judul -->
        <h3 class="text-3xl font-bold text-center text-[#27374D] mb-8 flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus-circle text-primary"></i>
            Tambah Treatment
        </h3>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg animate-fadeInSlow">
                <ul class="list-disc pl-6 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('treatments.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-[#F3F6FB] border border-[#D9E1EC] shadow-md hover:shadow-lg transition-all duration-300 rounded-2xl p-8 space-y-6">
            @csrf

            <!-- Nama Treatment -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-spa text-[#27374D]"></i> Nama Treatment
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-primary focus:outline-none"
                       placeholder="Masukkan nama treatment" required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-[#27374D]"></i> Deskripsi
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-primary focus:outline-none resize-none"
                          placeholder="Tuliskan deskripsi treatment" required>{{ old('description') }}</textarea>
            </div>

            <!-- Harga & Durasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[#27374D] font-semibold mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-money-bill-wave text-[#27374D]"></i> Harga (Rp)
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-primary focus:outline-none"
                           placeholder="Masukkan harga" required min="0" step="1">
                </div>

                <div>
                    <label class="block text-[#27374D] font-semibold mb-2 flex items-center gap-2">
                        <i class="fa-regular fa-clock text-[#27374D]"></i> Durasi (menit)
                    </label>
                    <input type="number" name="duration" value="{{ old('duration', 60) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-primary focus:outline-none"
                           placeholder="Durasi dalam menit" required min="1" step="1">
                </div>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2 flex items-center gap-2">
                    <i class="fa-solid fa-image text-[#27374D]"></i> Gambar
                </label>
                <input type="file" name="image"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-sm text-[#526D82] focus:ring-2 focus:ring-primary focus:outline-none 
                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white hover:file:bg-primary/90 transition"
                       accept="image/*" required>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center gap-4 pt-4">
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-xl font-medium shadow-md transition-all duration-300">
                    <i class="fa-solid fa-circle-plus"></i> Tambah
                </button>
                <a href="{{ route('treatments.manage') }}"
                   class="flex items-center gap-2 px-6 py-2.5 border border-[#526D82] text-[#526D82] rounded-xl hover:bg-[#526D82] hover:text-white shadow-sm transition-all duration-300">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</section>

{{-- Animasi Halus --}}
<style>
@keyframes fadeIn { from {opacity: 0; transform: scale(0.97);} to {opacity: 1; transform: scale(1);} }
@keyframes fadeUp { from {opacity: 0; transform: translateY(25px);} to {opacity: 1; transform: translateY(0);} }
@keyframes fadeInSlow { from {opacity: 0;} to {opacity: 1;} }
.animate-fadeIn { animation: fadeIn 0.4s ease-out; }
.animate-fadeUp { animation: fadeUp 0.6s ease-out; }
.animate-fadeInSlow { animation: fadeInSlow 0.7s ease-in; }
</style>
@endsection
