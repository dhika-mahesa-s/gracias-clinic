@extends('layouts.app')

@section('content')
<!-- Include Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Feedback</h1>
            <p class="text-gray-600">Perbarui data feedback dari pengguna</p>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="p-6">
                <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Pengguna -->
                    <div class="mb-6">
                        <h5 class="text-blue-600 font-semibold mb-4 flex items-center">
                            <i class="fas fa-user mr-2"></i>Informasi Pengguna
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                       value="{{ old('name', $feedback->name) }}" 
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                       value="{{ old('email', $feedback->email) }}" 
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" 
                                       name="phone" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror" 
                                       value="{{ old('phone', $feedback->phone) }}" 
                                       placeholder="Opsional"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                                <select name="service_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('service_type') border-red-500 @enderror">
                                    <option value="">Pilih Layanan</option>
                                    <option value="Facial" {{ old('service_type', $feedback->service_type) == 'Facial' ? 'selected' : '' }}>Facial</option>
                                    <option value="Injection" {{ old('service_type', $feedback->service_type) == 'Injection' ? 'selected' : '' }}>Injection</option>
                                    <option value="Laser" {{ old('service_type', $feedback->service_type) == 'Laser' ? 'selected' : '' }}>Laser Treatment</option>
                                    <option value="Konsultasi" {{ old('service_type', $feedback->service_type) == 'Konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                                    <option value="Lainnya" {{ old('service_type', $feedback->service_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('service_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div class="mb-6">
                        <h5 class="text-blue-600 font-semibold mb-4 flex items-center">
                            <i class="fas fa-star mr-2"></i>Rating & Penilaian
                        </h5>

                        @php
                            $fields = [
                                'staff_rating' => 'Staf Klinik',
                                'professional_rating' => 'Profesionalitas',
                                'result_rating' => 'Hasil Perawatan',
                                'return_rating' => 'Kembali Berobat',
                                'overall_rating' => 'Kepuasan Keseluruhan'
                            ];
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($fields as $name => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $label }} <span class="text-red-500">*</span>
                                    </label>
                                    <select name="{{ $name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($name) border-red-500 @enderror" required>
                                        <option value="">Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old($name, $feedback->$name) == $i ? 'selected' : '' }}>
                                                {{ $i }} Bintang {{ str_repeat('★', $i) }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error($name)
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Message Section -->
                    <div class="mb-6">
                        <h5 class="text-blue-600 font-semibold mb-4 flex items-center">
                            <i class="fas fa-comment mr-2"></i>Pesan Tambahan
                        </h5>
                        <textarea name="message" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror" 
                                  rows="3" 
                                  placeholder="Masukkan pesan atau komentar tambahan...">{{ old('message', $feedback->message) }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mt-8">
                        <a href="{{ route('feedback.show', $feedback->id) }}" class="w-full md:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Detail
                        </a>

                        <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>Update Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ringkasan Rating -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h5 class="font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i> Ringkasan Rating Saat Ini
                </h5>
            </div>
            <div class="p-6">
                @php
                    $currentAvg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-center">
                    <div>
                        <h5 class="font-bold text-blue-600 text-lg">{{ $feedback->staff_rating }}/5</h5>
                        <p class="text-gray-600 text-sm">Staf</p>
                    </div>
                    <div>
                        <h5 class="font-bold text-blue-600 text-lg">{{ $feedback->professional_rating }}/5</h5>
                        <p class="text-gray-600 text-sm">Profesional</p>
                    </div>
                    <div>
                        <h5 class="font-bold text-blue-600 text-lg">{{ $feedback->result_rating }}/5</h5>
                        <p class="text-gray-600 text-sm">Hasil</p>
                    </div>
                    <div>
                        <h5 class="font-bold text-blue-600 text-lg">{{ $feedback->return_rating }}/5</h5>
                        <p class="text-gray-600 text-sm">Kembali</p>
                    </div>
                    <div>
                        <h5 class="font-bold text-blue-600 text-lg">{{ $feedback->overall_rating }}/5</h5>
                        <p class="text-gray-600 text-sm">Keseluruhan</p>
                    </div>
                    <div>
                        <h5 class="font-bold text-green-600 text-lg">{{ number_format($currentAvg, 1) }}/5</h5>
                        <p class="text-gray-600 text-sm">Rata-rata</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling untuk select options dengan bintang */
    select option {
        padding: 8px;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .text-3xl {
            font-size: 1.5rem;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .flex-col {
            flex-direction: column;
        }
        
        .w-full {
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .p-6 {
            padding: 1rem;
        }
        
        .text-lg {
            font-size: 1rem;
        }
    }
</style>
@endsection