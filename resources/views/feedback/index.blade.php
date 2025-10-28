@extends('layouts.dashboard')

@section('content')
<!-- Include Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<div class="min-h-screen bg-[#E3EAF2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2 pt-10">Gracias Clinic</h1>
            <h2 class="text-xl text-gray-600">Kelola Feedback</h2>
        </div>

        <!-- Search and Filter -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Search Form -->
            <div>
                <form method="GET" action="{{ route('feedback.index') }}">
                    <div class="flex">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   class="block w-full pl-10 pr-3 py-2 border border-r-0 bg-white border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Cari nama..." 
                                   value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg border border-blue-600">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('feedback.index') }}" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg border border-gray-300">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Filter Form -->
            <div>
                <form method="GET" action="{{ route('feedback.index') }}" id="filterForm">
                    <div class="flex items-center space-x-2">
                        <select name="rating_filter" class="w-full px-3 py-2 border bg-white border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Filter Bintang</option>
                            <option value="5" {{ request('rating_filter') == '5' ? 'selected' : '' }}>★★★★★ (5 Bintang)</option>
                            <option value="4" {{ request('rating_filter') == '4' ? 'selected' : '' }}>★★★★☆ (4 Bintang ke atas)</option>
                            <option value="3" {{ request('rating_filter') == '3' ? 'selected' : '' }}>★★★☆☆ (3 Bintang ke atas)</option>
                            <option value="2" {{ request('rating_filter') == '2' ? 'selected' : '' }}>★★☆☆☆ (2 Bintang ke atas)</option>
                            <option value="1" {{ request('rating_filter') == '1' ? 'selected' : '' }}>★☆☆☆☆ (1 Bintang ke atas)</option>
                        </select>
                        @if(request('rating_filter'))
                            <a href="{{ route('feedback.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg border border-gray-300 text-sm whitespace-nowrap">
                                Clear Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Info Filter Aktif -->
        @if(request('search') || request('rating_filter'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6 relative">
            <strong>Filter Aktif:</strong>
            @if(request('search')) Pencarian: "{{ request('search') }}" @endif
            @if(request('search') && request('rating_filter')) | @endif
            @if(request('rating_filter')) Rating: {{ request('rating_filter') }} bintang ke atas @endif
            <a href="{{ route('feedback.index') }}" class="absolute top-3 right-3 text-blue-600 hover:text-blue-800">Tampilkan Semua</a>
        </div>
        @endif

        <!-- Tombol Tambah Feedback - DITAMBAHKAN DI SINI -->
        <div class="mb-6 text-right">
            <a href="{{ route('feedback.create') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Tambah Feedback Baru
            </a>
        </div>

        <!-- Feedback List Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Layanan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Rating Rata-rata</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Tanggal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($feedbacks as $feedback)
                                @php
                                    $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration + (($feedbacks->currentPage() - 1) * $feedbacks->perPage()) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-semibold text-gray-900">{{ $feedback->name }}</div>
                                        @if($feedback->phone)
                                            <div class="text-sm text-gray-500">{{ $feedback->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $feedback->email }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $feedback->service_type ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= round($avg) ? '' : ' text-gray-300' }} text-sm"></i>
                                                @endfor
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ number_format($avg, 1) }}/5</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $feedback->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-1">
                                            <!-- Button Detail -->
                                            <a href="{{ route('feedback.show', $feedback->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition-colors duration-200"
                                               title="Detail Feedback">
                                                <i class="fas fa-eye w-4 h-4"></i>
                                            </a>
                                            
                                            <!-- Button Hapus -->
                                            <form action="{{ route('feedback.destroy', $feedback->id) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback dari {{ $feedback->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition-colors duration-200" title="Hapus Feedback">
                                                    <i class="fas fa-trash w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-3"></i>
                                            <h4 class="text-lg font-medium text-gray-900 mb-2">
                                                @if(request('search') || request('rating_filter'))
                                                    Tidak ada feedback yang sesuai dengan filter
                                                @else
                                                    Belum ada feedback
                                                @endif
                                            </h4>
                                            <p class="text-gray-600 mb-4">
                                                @if(request('search') || request('rating_filter'))
                                                    Coba ubah kata kunci pencarian atau filter rating
                                                @else
                                                    Belum ada pengguna yang memberikan feedback.
                                                @endif
                                            </p>
                                            <div class="space-y-2">
                                                <a href="{{ route('feedback.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-plus mr-2"></i>Tambah Feedback Pertama
                                                </a>
                                                @if(request('search') || request('rating_filter'))
                                                    <a href="{{ route('feedback.index') }}" class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200 ml-2">
                                                        Tampilkan Semua Feedback
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($feedbacks->hasPages())
                    <div class="mt-6">
                        <!-- Teks jumlah hasil -->
                        <div class="text-sm text-gray-600 text-center mb-4">
                            Menampilkan 
                            {{ $feedbacks->firstItem() }} 
                            sampai 
                            {{ $feedbacks->lastItem() }} 
                            dari 
                            {{ $feedbacks->total() }} 
                            hasil
                        </div>

                        <!-- Tombol Pagination -->
                        <div class="flex justify-center">
                            <div class="flex space-x-1">
                                {{ $feedbacks->appends(request()->query())->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .fa-star {
        color: #fbbf24;
    }
    
    .fa-star.text-gray-300 {
        color: #d1d5db;
    }
    
    /* Custom pagination styling jika menggunakan default Tailwind pagination */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .pagination li {
        margin: 0 2px;
    }
    
    .pagination .page-link {
        display: block;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination .page-link:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }
    
    .pagination .active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
</style>
@endsection