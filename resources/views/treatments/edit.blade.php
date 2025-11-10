@php 
    use Illuminate\Support\Facades\Storage; 
    use Illuminate\Support\Str; 
@endphp

@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-background py-12">
    <div class="container mx-auto px-6 max-w-2xl">
        <!-- Judul -->
        <h3 class="text-3xl font-bold text-center text-card-foreground mb-8 flex items-center justify-center gap-2 animate-fade-in">
            <i class="fa-solid fa-pen-to-square text-primary"></i>
            Edit Treatment
        </h3>

        <!-- Error Validation -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg animate-slide-down">
                <ul class="list-disc pl-6 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('treatments.update', $treatment) }}" method="POST" enctype="multipart/form-data"
              class="bg-card border border-border shadow-md hover:shadow-lg transition-smooth rounded-2xl p-8 space-y-6 animate-scale-in">
            @csrf
            @method('PUT')

            <!-- Nama Treatment -->
            <div class="animate-slide-up delay-75">
                <label class="flex items-center gap-2 text-card-foreground font-semibold mb-2">
                    <i class="fa-solid fa-spa text-primary"></i> Nama Treatment
                </label>
                <input type="text" name="name" value="{{ old('name', $treatment->name) }}"
                       class="w-full px-4 py-2 border border-input rounded-xl bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth"
                       placeholder="Masukkan nama treatment" required>
            </div>

            <!-- Deskripsi -->
            <div class="animate-slide-up delay-100">
                <label class="flex items-center gap-2 text-card-foreground font-semibold mb-2">
                    <i class="fa-solid fa-align-left text-primary"></i> Deskripsi
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-input rounded-xl bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none resize-none transition-smooth"
                          placeholder="Tuliskan deskripsi treatment" required>{{ old('description', $treatment->description) }}</textarea>
            </div>

            <!-- Harga & Durasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 animate-slide-up delay-150">
                <div>
                    <label class="flex items-center gap-2 text-card-foreground font-semibold mb-2">
                        <i class="fa-solid fa-money-bill-wave text-primary"></i> Harga (Rp)
                    </label>
                    <input type="number" name="price" value="{{ old('price', $treatment->price) }}"
                           class="w-full px-4 py-2 border border-input rounded-xl bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth"
                           placeholder="Masukkan harga" required min="0" step="1">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-card-foreground font-semibold mb-2">
                        <i class="fa-regular fa-clock text-primary"></i> Durasi (menit)
                    </label>
                    <input type="number" name="duration" value="{{ old('duration', $treatment->duration) }}"
                           class="w-full px-4 py-2 border border-input rounded-xl bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth"
                           placeholder="Durasi dalam menit" required min="1" step="1">
                </div>
            </div>

            <!-- Gambar -->
            <div class="animate-slide-up delay-200">
                <label class="flex items-center gap-2 text-card-foreground font-semibold mb-2">
                    <i class="fa-solid fa-image text-primary"></i> Gambar
                </label>

                @php
                    if ($treatment->image) {
                        if (preg_match('#^https?://#', $treatment->image)) {
                            $img = $treatment->image;
                        } elseif (Storage::disk('public')->exists($treatment->image)) {
                            $img = asset('storage/' . $treatment->image);
                        } elseif (file_exists(public_path('images/' . $treatment->image))) {
                            $img = asset('images/' . $treatment->image);
                        } elseif (Str::startsWith($treatment->image, ['storage/', 'images/'])) {
                            $img = asset($treatment->image);
                        } else {
                            $img = 'https://via.placeholder.com/150x150?text=No+Image';
                        }
                    } else {
                        $img = 'https://via.placeholder.com/150x150?text=No+Image';
                    }
                @endphp

                <div class="mb-4">
                    <img src="{{ $img }}" 
                         alt="{{ $treatment->name }}" 
                         class="w-32 h-32 object-cover rounded-xl border border-border shadow-sm hover-scale transition-smooth">
                </div>

                <input type="file" name="image" accept="image/*"
                       class="w-full px-4 py-2 border border-input rounded-xl bg-background text-sm text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth
                              file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-primary-foreground hover:file:bg-primary/90 file:transition-smooth">
                <small class="text-muted-foreground block mt-2">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center gap-4 pt-4 animate-slide-up delay-250">
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl font-medium shadow-md transition-smooth hover-lift active-press">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('treatments.manage') }}"
                   class="flex items-center gap-2 px-6 py-2.5 border border-border text-foreground rounded-xl hover:bg-accent shadow-sm transition-smooth hover-scale-sm active-press">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>
        </form>
    </div>
</section>
@endsection
