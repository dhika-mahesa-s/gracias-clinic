@extends('layouts.dashboard')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-foreground mb-2">Kelola Diskon</h1>
                    <p class="text-muted-foreground">Atur promo dan diskon untuk treatment</p>
                </div>
                <a href="{{ route('admin.discounts.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Buat Diskon Baru</span>
                </a>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl animate-fade-in">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Discounts List --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-border">
            @if($discounts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-primary/5 to-blue-500/5">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-foreground uppercase tracking-wider">Nama Diskon</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-foreground uppercase tracking-wider">Tipe & Nilai</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-foreground uppercase tracking-wider">Periode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-foreground uppercase tracking-wider">Treatments</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-foreground uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-foreground uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($discounts as $discount)
                                <tr class="hover:bg-blue-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-semibold text-foreground">{{ $discount->name }}</p>
                                            @if($discount->description)
                                                <p class="text-sm text-muted-foreground mt-1">{{ Str::limit($discount->description, 50) }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if($discount->type === 'percentage')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $discount->value }}%
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Rp {{ number_format($discount->value, 0, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <p class="text-foreground">{{ $discount->start_date->format('d M Y, H:i') }}</p>
                                            <p class="text-muted-foreground">s/d {{ $discount->end_date->format('d M Y, H:i') }}</p>
                                            @if($discount->isCurrentlyActive())
                                                <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Sedang Berlangsung</span>
                                            @elseif($discount->start_date->isFuture())
                                                <span class="inline-block mt-1 px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Akan Datang</span>
                                            @else
                                                <span class="inline-block mt-1 px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">Berakhir</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-1 bg-primary/10 text-primary text-xs rounded-full">
                                                {{ $discount->treatments->count() }} treatment
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.discounts.toggle-status', $discount) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $discount->is_active ? 'bg-primary' : 'bg-gray-300' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $discount->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.discounts.edit', $discount) }}" 
                                               class="inline-flex items-center gap-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span class="text-sm">Edit</span>
                                            </a>
                                            <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus diskon ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <span class="text-sm">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-border">
                    {{ $discounts->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-foreground mb-2">Belum Ada Diskon</h3>
                    <p class="text-muted-foreground mb-6">Buat diskon pertama Anda untuk menarik lebih banyak pelanggan</p>
                    <a href="{{ route('admin.discounts.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Buat Diskon Baru</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
