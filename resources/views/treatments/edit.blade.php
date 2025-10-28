@php 
    use Illuminate\Support\Facades\Storage; 
@endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] py-12">
    <div class="container mx-auto px-6 max-w-2xl">
        <!-- Judul -->
        <h3 class="text-3xl font-bold text-center text-[#27374D] mb-8">
            Edit Treatment
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
        <form action="{{ route('treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data"
              class="bg-gray-100 border border-gray-300 shadow-md rounded-2xl p-8 space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Nama Treatment</label>
                <input type="text" name="name" value="{{ old('name', $treatment->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                       placeholder="Masukkan nama treatment" required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none resize-none"
                          placeholder="Tuliskan deskripsi treatment" required>{{ old('description', $treatment->description) }}</textarea>
            </div>

            <!-- Harga & Durasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[#27374D] font-semibold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $treatment->price) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                           placeholder="Masukkan harga" required min="0" step="1">
                </div>

                <div>
                    <label class="block text-[#27374D] font-semibold mb-2">Durasi (menit)</label>
                    <input type="number" name="duration" value="{{ old('duration', $treatment->duration) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none"
                           placeholder="Durasi dalam menit" required min="1" step="1">
                </div>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-[#27374D] font-semibold mb-2">Gambar</label>

                <div class="mb-3">
                    @if ($treatment->image)
                        <img src="{{ Storage::url($treatment->image) }}" 
                             alt="{{ $treatment->name }}" 
                             class="w-32 h-32 object-cover rounded-xl border border-gray-300 shadow-sm">
                    @else
                        <div class="w-32 h-32 flex items-center justify-center border border-dashed border-gray-400 rounded-lg text-sm text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                <input type="file" name="image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl bg-white text-sm text-[#526D82] focus:ring-2 focus:ring-[#27374D] focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white hover:file:bg-primary/90 transition:all">
                <small class="text-gray-500 block mt-1">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center space-x-4 pt-4">
                <button type="submit"
                        class="px-6 py-2.5 bg-primary hover:bg-primary/90 transition text-white rounded-xl font-medium shadow-md ">
                    💾 Simpan Perubahan
                </button>
                <a href="{{ route('treatments.manage') }}"
                   class="px-6 py-2.5 border border-[#526D82] text-[#526D82] rounded-xl hover:bg-[#526D82] hover:text-white shadow-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</section>
@endsection
