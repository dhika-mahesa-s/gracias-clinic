@extends('layouts.app')

@section('content')
<!-- Include Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Detail Feedback</h1>
                <p class="text-gray-600">Informasi lengkap feedback dari pengguna</p>
            </div>
            <a href="{{ route('feedback.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Information Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 flex items-center text-xl">
                            <i class="fas fa-user mr-2 "></i>Informasi Pengguna
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1 ">Nama Lengkap</label>
                                <p class="text-gray-900 font-medium">{{ $feedback->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-gray-900 font-medium">{{ $feedback->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                                <p class="text-gray-900 font-medium">{{ $feedback->phone ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Layanan</label>
                                <p class="text-gray-900 font-medium">
                                    @if($feedback->service_type)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $feedback->service_type }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Submit</label>
                                <p class="text-gray-900 font-medium">{{ $feedback->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Details Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 flex items-center text-xl">
                            <i class="fas fa-star mr-2"></i>Rating & Penilaian
                        </h5>
                    </div>
                    <div class="p-6">
                        @php
                            $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                        @endphp
                        
                        <!-- Average Rating -->
                        <div class="text-center mb-8">
                            <h4 class="text-blue-600 font-semibold mb-2">Rating Rata-rata</h4>
                            <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($avg, 1) }}/5</div>
                            <div class="flex justify-center mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-2xl {{ $i <= round($avg) ? 'text-yellow-400' : 'text-gray-300' }} mx-1"></i>
                                @endfor
                            </div>
                        </div>

                        <!-- Rating Items -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h6 class="font-semibold text-gray-900 mb-1">Staf klinik tanggap terhadap kebutuhan saya</h6>
                                    <p class="text-sm text-gray-500">Responsivitas staf</p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="flex justify-end mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->staff_rating ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                        @endfor
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feedback->staff_rating }}/5
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h6 class="font-semibold text-gray-900 mb-1">Dokter/terapis bersikap professional</h6>
                                    <p class="text-sm text-gray-500">Profesionalitas tenaga medis</p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="flex justify-end mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->professional_rating ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                        @endfor
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feedback->professional_rating }}/5
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h6 class="font-semibold text-gray-900 mb-1">Hasil perawatan sesuai harapan</h6>
                                    <p class="text-sm text-gray-500">Kepuasan hasil treatment</p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="flex justify-end mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->result_rating ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                        @endfor
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feedback->result_rating }}/5
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h6 class="font-semibold text-gray-900 mb-1">Keinginan untuk kembali berobat</h6>
                                    <p class="text-sm text-gray-500">Loyalitas pengguna</p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="flex justify-end mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->return_rating ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                        @endfor
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feedback->return_rating }}/5
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1">
                                    <h6 class="font-semibold text-gray-900 mb-1">Kepuasan keseluruhan layanan</h6>
                                    <p class="text-sm text-gray-500">Total experience</p>
                                </div>
                                <div class="text-right ml-4">
                                    <div class="flex justify-end mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-sm {{ $i <= $feedback->overall_rating ? 'text-yellow-400' : 'text-gray-300' }} mx-0.5"></i>
                                        @endfor
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $feedback->overall_rating }}/5
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Message Card -->
                @if($feedback->message)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 flex items-center text-xl">
                            <i class="fas fa-comment mr-2"></i>Pesan Tambahan
                        </h5>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 leading-relaxed">{{ $feedback->message }}</p>
                    </div>
                </div>
                @endif

                <!-- Action Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 flex items-center text-xl">
                            <i class="fas fa-cog mr-2"></i>Aksi
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('feedback.edit', $feedback->id) }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Edit Feedback
                            </a>
                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus feedback dari {{ $feedback->name }}?')">
                                    <i class="fas fa-trash mr-2"></i>Hapus Feedback
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h5 class="font-semibold text-gray-900 flex items-center text-xl">
                            <i class="fas fa-chart-bar mr-2"></i>Ringkasan
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $feedback->staff_rating }}</div>
                                <div class="text-sm text-gray-600 mt-1">Rating Staf</div>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $feedback->professional_rating }}</div>
                                <div class="text-sm text-gray-600 mt-1">Profesionalitas</div>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $feedback->result_rating }}</div>
                                <div class="text-sm text-gray-600 mt-1">Hasil</div>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">{{ $feedback->return_rating }}</div>
                                <div class="text-sm text-gray-600 mt-1">Kembali</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling untuk konsistensi */
    .fa-star {
        transition: color 0.2s ease;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .text-4xl {
            font-size: 2rem;
        }
        
        .text-2xl {
            font-size: 1.5rem;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .flex.justify-between {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .flex.justify-between > div:last-child {
            margin-top: 1rem;
            margin-left: 0;
            text-align: left;
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
        
        .text-2xl {
            font-size: 1.25rem;
        }
    }
</style>
@endsection