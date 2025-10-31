@extends('layouts.dashboard')

@section('content')
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

        <!-- 🔍 Filter & Search -->
        <form method="GET" action="{{ route('admin.feedback.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Search -->
            <div class="col-span-1 md:col-span-1">
                <div class="flex">
                    <div class="relative grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               class="block w-full pl-10 pr-3 py-2 border bg-white border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Cari nama..." 
                               value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg border border-blue-600">
                        Cari
                    </button>
                </div>
            </div>

            <!-- Rating Filter -->
            <div>
                <select name="rating_filter" class="w-full px-3 py-2 border bg-white border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Filter Bintang</option>
                    <option value="5" {{ request('rating_filter') == '5' ? 'selected' : '' }}>★★★★★ (5 Bintang)</option>
                    <option value="4" {{ request('rating_filter') == '4' ? 'selected' : '' }}>★★★★☆ (4 ke atas)</option>
                    <option value="3" {{ request('rating_filter') == '3' ? 'selected' : '' }}>★★★☆☆ (3 ke atas)</option>
                    <option value="2" {{ request('rating_filter') == '2' ? 'selected' : '' }}>★★☆☆☆ (2 ke atas)</option>
                    <option value="1" {{ request('rating_filter') == '1' ? 'selected' : '' }}>★☆☆☆☆ (1 ke atas)</option>
                </select>
            </div>

            <!-- Visibility Filter -->
            <div>
                <select name="visibility" class="w-full px-3 py-2 border bg-white border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>Tampil di Homepage</option>
                    <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>Disembunyikan</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="col-span-1 md:col-span-3 flex justify-end space-x-2 mt-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.feedback.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </a>
            </div>
        </form>

        <!-- Feedback Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($feedbacks as $feedback)
                                @php
                                    $avg = ($feedback->staff_rating + $feedback->professional_rating + $feedback->result_rating + $feedback->return_rating + $feedback->overall_rating) / 5;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $feedback->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $feedback->email }}</td>
                                    <td class="px-4 py-3">
                                        ⭐ {{ number_format($avg, 1) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($feedback->is_visible)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Tampil</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-gray-200 text-gray-800 rounded">Tersembunyi</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="toggle-visibility bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 transition"
                                            data-id="{{ $feedback->id }}">
                                            {{ $feedback->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500">
                                        Tidak ada data feedback.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $feedbacks->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ⚡ AJAX Toggle --}}
<script>
document.querySelectorAll('.toggle-visibility').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;

        const response = await fetch(`/admin/feedback/${id}/toggle-visibility`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Gagal mengubah visibilitas.');
        }
    });
});
</script>
@endsection
