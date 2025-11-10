@extends('layouts.dashboard')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.discounts.index') }}" 
               class="inline-flex items-center gap-2 text-muted-foreground hover:text-primary transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
            <h1 class="text-3xl font-bold text-foreground mb-2">Edit Diskon</h1>
            <p class="text-muted-foreground">Update informasi diskon {{ $discount->name }}</p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-border">
            <form action="{{ route('admin.discounts.update', $discount) }}" method="POST" class="p-6 sm:p-8">
                @csrf
                @method('PUT')

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi kesalahan!</h3>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Discount Name --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-foreground mb-2">
                        Nama Diskon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $discount->name) }}"
                           placeholder="Contoh: 11.11 Mega Sale, Black Friday 2024"
                           class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-foreground mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Deskripsi singkat tentang promo ini"
                              class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('description') border-red-500 @enderror">{{ old('description', $discount->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Discount Type & Value --}}
                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type" class="block text-sm font-semibold text-foreground mb-2">
                            Tipe Diskon <span class="text-red-500">*</span>
                        </label>
                        <select id="type" 
                                name="type" 
                                class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('type') border-red-500 @enderror">
                            <option value="percentage" {{ old('type', $discount->type) === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('type', $discount->type) === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="value" class="block text-sm font-semibold text-foreground mb-2">
                            Nilai Diskon <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="value" 
                               name="value" 
                               value="{{ old('value', $discount->value) }}"
                               min="0"
                               step="0.01"
                               placeholder="Contoh: 50 atau 100000"
                               class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('value') border-red-500 @enderror">
                        @error('value')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-muted-foreground">
                            Untuk persentase: 0-100. Untuk nominal: masukkan angka dalam Rupiah
                        </p>
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-foreground mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date', $discount->start_date->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-foreground mb-2">
                            Tanggal Berakhir <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date', $discount->end_date->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Treatments Selection --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-foreground mb-3">
                        Pilih Treatment <span class="text-red-500">*</span>
                    </label>
                    <div class="grid sm:grid-cols-2 gap-3 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-xl">
                        @foreach($treatments as $treatment)
                            <label class="flex items-start gap-3 p-3 bg-white border border-border rounded-lg hover:border-primary cursor-pointer transition-colors">
                                <input type="checkbox" 
                                       name="treatments[]" 
                                       value="{{ $treatment->id }}"
                                       {{ in_array($treatment->id, old('treatments', $selectedTreatments)) ? 'checked' : '' }}
                                       class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="flex-1">
                                    <p class="font-medium text-foreground">{{ $treatment->name }}</p>
                                    <p class="text-sm text-primary font-semibold">Rp {{ number_format($treatment->price, 0, ',', '.') }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('treatments')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Status --}}
                <div class="mb-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $discount->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="text-sm font-medium text-foreground">Aktifkan diskon</span>
                    </label>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 border-t border-border">
                    <a href="{{ route('admin.discounts.index') }}" 
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-border text-foreground font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        <span>Batal</span>
                    </a>
                    <button type="submit" 
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Update Diskon</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
