@extends('layouts.dashboard')

@section('content')
<!-- Modal Konfirmasi Buat Diskon -->
<div id="confirmCreateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all scale-95 opacity-0" id="createModalContent">
        <div class="p-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Konfirmasi Buat Diskon</h3>
            <p class="text-center text-gray-600 mb-4">
                Pastikan semua data sudah benar sebelum menyimpan
            </p>
            
            <!-- Summary Preview -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-3 max-h-96 overflow-y-auto">
                <div class="flex justify-between items-start pb-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-gray-600">Nama Diskon:</span>
                    <span class="text-sm font-bold text-gray-900 text-right max-w-xs" id="preview-name">-</span>
                </div>
                <div class="flex justify-between items-start pb-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-gray-600">Tipe & Nilai:</span>
                    <span class="text-sm font-bold text-primary text-right" id="preview-value">-</span>
                </div>
                <div class="flex justify-between items-start pb-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-gray-600">Periode:</span>
                    <span class="text-sm text-gray-900 text-right max-w-xs" id="preview-period">-</span>
                </div>
                <div class="flex justify-between items-start pb-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-gray-600">Treatment:</span>
                    <span class="text-sm text-gray-900 text-right max-w-xs" id="preview-treatments">-</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-600">Status:</span>
                    <span class="text-sm font-bold" id="preview-status">-</span>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeCreateModal()" 
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Periksa Lagi
                </button>
                <button type="button" onclick="confirmCreate()" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                    <i class="fas fa-check mr-2"></i>Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>

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
            <h1 class="text-3xl font-bold text-foreground mb-2">Buat Diskon Baru</h1>
            <p class="text-muted-foreground">Atur promo spesial untuk treatment Anda</p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-border">
            <form id="discountForm" action="{{ route('admin.discounts.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

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
                           value="{{ old('name') }}"
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
                              class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
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
                               value="{{ old('value') }}"
                               min="0"
                               step="0.01"
                               placeholder="Contoh: 50 atau 100000"
                               class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('value') border-red-500 @enderror">
                        @error('value')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-muted-foreground" id="value-hint">
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
                               value="{{ old('start_date') }}"
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
                               value="{{ old('end_date') }}"
                               class="w-full px-4 py-3 border border-border rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Quick Date Presets --}}
                <div class="mb-6 p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm font-semibold text-foreground mb-3">Template Tanggal Cepat:</p>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="setDateRange(1)" class="px-3 py-1.5 bg-white border border-primary/30 text-primary text-sm rounded-lg hover:bg-primary hover:text-white transition-colors">1 Hari</button>
                        <button type="button" onclick="setDateRange(3)" class="px-3 py-1.5 bg-white border border-primary/30 text-primary text-sm rounded-lg hover:bg-primary hover:text-white transition-colors">3 Hari</button>
                        <button type="button" onclick="setDateRange(7)" class="px-3 py-1.5 bg-white border border-primary/30 text-primary text-sm rounded-lg hover:bg-primary hover:text-white transition-colors">1 Minggu</button>
                        <button type="button" onclick="setDateRange(30)" class="px-3 py-1.5 bg-white border border-primary/30 text-primary text-sm rounded-lg hover:bg-primary hover:text-white transition-colors">1 Bulan</button>
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
                                       {{ in_array($treatment->id, old('treatments', [])) ? 'checked' : '' }}
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
                               {{ old('is_active', true) ? 'checked' : '' }}
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
                    <button type="button" 
                            onclick="openCreateModal()"
                            class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primary/90 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover-lift active-press transition-smooth">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Diskon</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Quick Date Range Setter
function setDateRange(days) {
    const now = new Date();
    const startDate = new Date(now);
    const endDate = new Date(now);
    endDate.setDate(endDate.getDate() + days);
    
    // Format to datetime-local input format
    const formatDateTime = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${year}-${month}-${day}T${hours}:${minutes}`;
    };
    
    document.getElementById('start_date').value = formatDateTime(startDate);
    document.getElementById('end_date').value = formatDateTime(endDate);
}

// Modal Functions
function openCreateModal() {
    // Validate required fields first
    const form = document.getElementById('discountForm');
    const name = document.getElementById('name').value;
    const value = document.getElementById('value').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const treatments = document.querySelectorAll('input[name="treatments[]"]:checked');
    
    // Basic validation
    if (!name || !value || !startDate || !endDate || treatments.length === 0) {
        alert('⚠️ Mohon lengkapi semua field yang wajib diisi (*)');
        return;
    }
    
    // Populate preview data
    const type = document.getElementById('type').value;
    const isActive = document.querySelector('input[name="is_active"]').checked;
    
    // Set preview values
    document.getElementById('preview-name').textContent = name;
    
    // Format value
    const valueDisplay = type === 'percentage' 
        ? `${value}%` 
        : `Rp ${parseInt(value).toLocaleString('id-ID')}`;
    const typeDisplay = type === 'percentage' ? 'Persentase' : 'Nominal';
    document.getElementById('preview-value').textContent = `${typeDisplay}: ${valueDisplay}`;
    
    // Format dates
    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'short', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };
    document.getElementById('preview-period').innerHTML = `
        <strong>Mulai:</strong> ${formatDate(startDate)}<br>
        <strong>Sampai:</strong> ${formatDate(endDate)}
    `;
    
    // Treatment list
    const treatmentNames = Array.from(treatments).map(cb => {
        const label = cb.closest('label');
        return label.querySelector('p.font-medium').textContent;
    });
    document.getElementById('preview-treatments').innerHTML = 
        `<strong>${treatments.length} treatment:</strong><br>` + 
        treatmentNames.map(name => `• ${name}`).join('<br>');
    
    // Status
    const statusEl = document.getElementById('preview-status');
    if (isActive) {
        statusEl.className = 'text-sm font-bold text-green-600';
        statusEl.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Aktif';
    } else {
        statusEl.className = 'text-sm font-bold text-gray-500';
        statusEl.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Nonaktif';
    }
    
    // Show modal
    const modal = document.getElementById('confirmCreateModal');
    const modalContent = document.getElementById('createModalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeCreateModal() {
    const modal = document.getElementById('confirmCreateModal');
    const modalContent = document.getElementById('createModalContent');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function confirmCreate() {
    // Submit the form
    document.getElementById('discountForm').submit();
}

// Close modal when clicking outside
document.getElementById('confirmCreateModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
    }
});
</script>
@endsection
