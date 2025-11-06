@extends('layouts.app')

@section('title', 'Buat Reservasi - Gracias Aesthetic Clinic')

@section('content')
<div class="relative min-h-screen bg-background overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Hero Section --}}
    <section class="relative max-w-6xl mx-auto mb-12 animate-fade-in">
        <div class="text-center">
            <div class="inline-flex items-center justify-center p-3 bg-gradient-to-br from-primary to-primary/80 rounded-2xl shadow-lg mb-6 animate-bounce-slow">
                <i class="fa-solid fa-calendar-check text-primary-foreground text-3xl"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-foreground mb-4 animate-slide-up delay-75">
                Buat <span class="text-primary">Reservasi</span> Anda
            </h1>
            <p class="text-base sm:text-lg text-muted-foreground max-w-2xl mx-auto leading-relaxed animate-slide-up delay-100">
                <i class="fa-solid fa-info-circle text-primary mr-2"></i>
                Isi formulir di bawah untuk membuat reservasi di Gracias Aesthetic Clinic
            </p>
        </div>
    </section>

    {{-- Main Form Container --}}
    {{-- Main Form Container --}}
    <div x-data="reservationForm()" 
         x-init="init()" 
         data-store-url="{{ route('reservasi.store') }}"
         data-csrf="{{ csrf_token() }}" 
         data-pre-selected-treatment="{{ $preSelectedTreatmentId ?? '' }}"
         class="max-w-6xl mx-auto animate-scale-in delay-150">
        
        <div class="bg-gradient-to-br from-card to-card/50 rounded-3xl shadow-2xl border border-border p-6 sm:p-8 lg:p-12 relative overflow-hidden">
            
            {{-- Decorative Elements --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary/10 rounded-full blur-3xl -z-10"></div>

            {{-- Progress Bar --}}
            <div class="mb-12">
                <div class="flex justify-between items-center text-xs sm:text-sm font-medium text-muted-foreground mb-4">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex-1 text-center transition-all duration-300"
                            :class="{ 'text-primary font-bold scale-110': currentStep === index + 1 }">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center border-2 transition-all duration-300"
                                     :class="currentStep === index + 1 
                                        ? 'bg-primary border-primary text-primary-foreground shadow-lg scale-110' 
                                        : currentStep > index + 1 
                                            ? 'bg-green-500 border-green-500 text-white'
                                            : 'bg-muted border-border text-muted-foreground'">
                                    <template x-if="currentStep > index + 1">
                                        <i class="fa-solid fa-check text-sm"></i>
                                    </template>
                                    <template x-if="currentStep <= index + 1">
                                        <span x-text="index + 1" class="font-bold"></span>
                                    </template>
                                </div>
                                <span x-text="step" class="hidden sm:block"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="w-full bg-muted rounded-full h-3 overflow-hidden shadow-inner">
                    <div class="h-3 bg-gradient-to-r from-primary to-primary/80 transition-all duration-500 rounded-full shadow-md"
                        :style="`width: ${(currentStep - 1) / (steps.length - 1) * 100}%`"></div>
                </div>
            </div>

            {{-- Step Container --}}
            <div class="min-h-[400px] relative">
                {{-- Step 1: Treatment & Dokter --}}
                <div x-show="currentStep === 1" x-transition class="space-y-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary/80 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-spa text-primary-foreground text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-foreground">Pilih Treatment & Dokter</h2>
                            <p class="text-sm text-muted-foreground">Pilih layanan dan dokter yang Anda inginkan</p>
                        </div>
                    </div>

                    {{-- Treatment Cards --}}
                    <div>
                        <label class="block font-semibold text-foreground mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-hand-sparkles text-primary"></i>
                            <span>Pilih Treatment</span>
                        </label>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($treatments as $t)
                                <div @click="form.treatment_id = '{{ $t->id }}'"
                                    data-treatment-id="{{ $t->id }}"
                                    data-treatment-name="{{ addslashes($t->name) }}"
                                    class="cursor-pointer rounded-2xl border-2 border-border bg-gradient-to-br from-card to-card/50 overflow-hidden 
                                    transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-2 group"
                                    :class="form.treatment_id == '{{ $t->id }}' ?
                                        'ring-4 ring-primary/50 scale-[1.02] border-primary shadow-xl' : 'hover:border-primary/30'">
                                    @php
                                        $imagePath = null;
                                        if ($t->image) {
                                            if (Str::startsWith($t->image, ['storage/', 'images/', 'http'])) {
                                                $imagePath = asset($t->image);
                                            } elseif (file_exists(public_path('storage/' . $t->image))) {
                                                $imagePath = asset('storage/' . $t->image);
                                            } elseif (file_exists(public_path('images/' . $t->image))) {
                                                $imagePath = asset('images/' . $t->image);
                                            }
                                        }
                                        if (!$imagePath) {
                                            $imagePath = asset('images/pic.jpg');
                                        }
                                    @endphp

                                    <div class="relative overflow-hidden">
                                        <img src="{{ $imagePath }}" alt="{{ $t->name }}"
                                            class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="absolute top-3 right-3 opacity-0 transition-opacity duration-300"
                                             :class="{ 'opacity-100': form.treatment_id == '{{ $t->id }}' }">
                                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center shadow-lg">
                                                <i class="fa-solid fa-check text-primary-foreground text-sm"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 space-y-2">
                                        <h3 class="font-bold text-base sm:text-lg text-foreground group-hover:text-primary transition-colors line-clamp-1">
                                            {{ $t->name }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-muted-foreground line-clamp-2 leading-relaxed">
                                            {{ $t->description }}
                                        </p>
                                        <div class="flex justify-between items-center pt-3 border-t border-border/50">
                                            <div>
                                                <p class="text-xs text-muted-foreground">Harga</p>
                                                <p class="font-bold text-lg text-primary">
                                                    Rp{{ number_format($t->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                                <i class="fa-solid fa-arrow-right text-primary group-hover:text-primary-foreground text-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p x-show="errors.treatment_id" x-text="errors.treatment_id" class="text-red-500 text-sm mt-2 flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </p>
                    </div>

                    {{-- Dokter Selection --}}
                    <div>
                        <label class="block font-semibold text-foreground mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-user-doctor text-primary"></i>
                            <span>Pilih Dokter</span>
                        </label>
                        <div class="relative">
                            <select id="doctor-select" x-model="form.doctor_id"
                                :class="{ 'border-red-500 focus:border-red-500 ring-2 ring-red-200': errors.doctor_id }"
                                class="w-full border-2 border-input focus:ring-2 focus:ring-primary focus:border-primary rounded-xl p-4 bg-background text-foreground font-medium transition-all shadow-sm hover:shadow-md appearance-none pr-12">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($doctors as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-muted-foreground"></i>
                            </div>
                        </div>
                        <p x-show="errors.doctor_id" x-text="errors.doctor_id" class="text-red-500 text-sm mt-2 flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </p>
                    </div>

                    <div class="flex justify-end mt-10 pt-6 border-t border-border">
                        <button type="button" @click="nextStep"
                            class="flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-primary to-primary/90 rounded-lg hover:from-primary/90 hover:to-primary hover:shadow-lg active:scale-95 transition-all duration-300 shadow-sm">
                            <span>Lanjut ke Jadwal</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                {{-- Step 2: Kalender & Waktu --}}
                <div x-show="currentStep === 2" x-transition class="space-y-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-calendar-days text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-foreground">Pilih Tanggal & Waktu</h2>
                            <p class="text-sm text-muted-foreground">Tentukan jadwal reservasi Anda</p>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-6 lg:gap-8">
                        {{-- Kalender --}}
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/30 border-2 border-blue-200 rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center justify-between mb-5">
                                <button type="button" @click="prevMonth" 
                                    class="p-2.5 rounded-xl hover:bg-blue-200/50 transition-smooth text-blue-700 hover:scale-110 active:scale-95">
                                    <i class="fa-solid fa-chevron-left text-lg"></i>
                                </button>
                                <h3 class="font-bold text-xl text-blue-900" x-text="monthLabel"></h3>
                                <button type="button" @click="nextMonth" 
                                    class="p-2.5 rounded-xl hover:bg-blue-200/50 transition-smooth text-blue-700 hover:scale-110 active:scale-95">
                                    <i class="fa-solid fa-chevron-right text-lg"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-7 text-center text-sm font-bold mb-3 text-blue-700">
                                <template x-for="day in days" :key="day">
                                    <div x-text="day" class="py-2"></div>
                                </template>
                            </div>

                            <div class="grid grid-cols-7 gap-1.5 text-center">
                                <template x-for="(_, i) in blanks" :key="'b' + i">
                                    <div class="p-2"></div>
                                </template>

                                <template x-for="d in daysInMonth" :key="d">
                                    <button type="button" @click="selectDate(d)"
                                        class="p-2.5 rounded-lg w-full font-semibold transition-all duration-300 text-sm"
                                        :class="{
                                            'bg-primary text-primary-foreground shadow-lg scale-110 ring-2 ring-primary/30': form.date === formatDateLocal(year, month, d),
                                            'opacity-40 cursor-not-allowed': isPastDate(year, month, d),
                                            'hover:bg-blue-200 hover:scale-105 text-blue-900': !isPastDate(year, month, d) && form.date !== formatDateLocal(year, month, d)
                                        }"
                                        :disabled="isPastDate(year, month, d)" 
                                        x-text="d"></button>
                                </template>
                            </div>
                        </div>

                        {{-- Slot Waktu --}}
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100/30 border-2 border-purple-200 rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                                    <i class="fa-solid fa-clock text-white"></i>
                                </div>
                                <h3 class="font-bold text-xl text-purple-900">Waktu Tersedia</h3>
                            </div>

                            <div class="mb-4 p-3 bg-white/60 rounded-xl border border-purple-200">
                                <p class="text-sm text-purple-700 font-medium" x-text="form.date ? `📅 ${form.date}` : '⚠️ Silakan pilih tanggal terlebih dahulu'"></p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 max-h-[320px] overflow-y-auto pr-1 pl-0.5 py-1 custom-scrollbar">
                                <!-- Loading -->
                                <template x-if="loadingSlots">
                                    <div class="col-span-2 text-center py-8">
                                        <div class="inline-block w-10 h-10 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
                                        <p class="text-purple-600 mt-3 font-medium">Memuat jadwal...</p>
                                    </div>
                                </template>

                                <!-- Empty -->
                                <template x-if="!loadingSlots && availableTimes.length === 0">
                                    <div class="col-span-2 text-center py-8">
                                        <i class="fa-solid fa-calendar-xmark text-5xl text-purple-300 mb-3"></i>
                                        <p class="text-purple-600 font-medium">Tidak ada slot tersedia</p>
                                    </div>
                                </template>

                                <!-- Slots -->
                                <template x-for="slot in availableTimes" :key="slot">
                                    <button type="button" @click="selectTime(slot)"
                                        class="rounded-xl p-4 border-2 font-bold text-sm transition-all duration-300 shadow-sm hover:shadow-md"
                                        :class="form.time === slot 
                                            ? 'bg-primary border-primary text-primary-foreground shadow-lg' 
                                            : 'bg-white border-purple-200 text-purple-900 hover:border-primary hover:bg-primary/10 hover:scale-95'">
                                        <i class="fa-solid fa-clock mr-1.5"></i>
                                        <span x-text="slot"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <p x-show="errors.time" x-text="errors.time" class="text-red-500 text-sm mt-2 flex items-center gap-2 bg-red-50 p-3 rounded-xl border border-red-200">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </p>

                    <div class="flex justify-between items-center gap-3 mt-10 pt-6 border-t border-border">
                        <button type="button" @click="prevStep"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-foreground border-2 border-border bg-white rounded-lg hover:bg-muted hover:border-foreground/30 hover:shadow-sm active:scale-95 transition-all duration-300">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Kembali</span>
                        </button>

                        <button type="button" @click="nextStep"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-lg active:scale-95 transition-all duration-300 shadow-sm">
                            <span>Lanjut ke Data Diri</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>
                {{-- Step 3: Data Diri --}}
                <div x-show="currentStep === 3" x-transition class="space-y-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-user-pen text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-foreground">Data Diri</h2>
                            <p class="text-sm text-muted-foreground">Lengkapi informasi kontak Anda</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-green-50 to-green-100/30 rounded-2xl p-6 border-2 border-green-200">
                            <label class="block font-semibold text-green-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user text-green-600"></i>
                                <span>Nama Lengkap</span>
                            </label>
                            <input type="text" x-model="form.name"
                                class="w-full border-2 border-green-200 bg-white text-foreground rounded-xl p-4 font-medium focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all shadow-sm"
                                readonly>
                            <p class="text-xs text-green-600 mt-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-info-circle"></i>
                                <span>Data diambil dari profil akun Anda</span>
                            </p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/30 rounded-2xl p-6 border-2 border-blue-200">
                            <label class="block font-semibold text-blue-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-blue-600"></i>
                                <span>Email</span>
                            </label>
                            <input type="email" x-model="form.email"
                                class="w-full border-2 border-blue-200 bg-white text-foreground rounded-xl p-4 font-medium focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all shadow-sm"
                                readonly>
                            <p class="text-xs text-blue-600 mt-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-lock"></i>
                                <span>Email terdaftar dan terverifikasi</span>
                            </p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-purple-100/30 rounded-2xl p-6 border-2 border-purple-200"
                             :class="{ 'border-red-500 ring-2 ring-red-200': errors.phone }">
                            <label class="block font-semibold text-purple-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-phone text-purple-600"></i>
                                <span>Nomor HP</span>
                                <span class="text-xs font-normal text-red-500">*Wajib</span>
                            </label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-muted-foreground">
                                    <i class="fa-brands fa-whatsapp text-green-500"></i>
                                </div>
                                <input type="text" x-model="form.phone" 
                                    value="{{ auth()->user()->phone ?? '' }}"
                                    placeholder="Contoh: 08123456789"
                                    :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-400': errors.phone }"
                                    class="w-full border-2 border-purple-200 bg-white text-foreground rounded-xl p-4 pl-12 font-medium focus:ring-2 focus:ring-purple-400 focus:border-purple-400 transition-all shadow-sm">
                            </div>
                            <p x-show="errors.phone" x-text="errors.phone" 
                               class="text-red-500 text-sm mt-2 flex items-center gap-2 bg-red-50 p-3 rounded-xl border border-red-200">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </p>
                            <p x-show="!errors.phone" class="text-xs text-purple-600 mt-2 flex items-center gap-1.5">
                                <i class="fa-solid fa-info-circle"></i>
                                <span>Nomor yang bisa dihubungi via WhatsApp</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-3 mt-10 pt-6 border-t border-border">
                        <button type="button" @click="prevStep"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-foreground border-2 border-border bg-white rounded-lg hover:bg-muted hover:border-foreground/30 hover:shadow-sm active:scale-95 transition-all duration-300">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Kembali</span>
                        </button>

                        <button type="button" @click="nextStep"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 hover:shadow-lg active:scale-95 transition-all duration-300 shadow-sm">
                            <span>Lanjut ke Konfirmasi</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>
                {{-- Step 4: Konfirmasi --}}
                <div x-show="currentStep === 4" x-transition class="space-y-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-clipboard-check text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-foreground">Konfirmasi Reservasi</h2>
                            <p class="text-sm text-muted-foreground">Periksa kembali detail reservasi Anda</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-card to-card/50 rounded-2xl border-2 border-border shadow-lg overflow-hidden">
                        {{-- Header --}}
                        <div class="bg-gradient-to-r from-primary to-primary/80 px-6 py-4">
                            <h3 class="text-lg font-bold text-primary-foreground flex items-center gap-2">
                                <i class="fa-solid fa-file-lines"></i>
                                <span>Detail Reservasi</span>
                            </h3>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 space-y-4">
                            <div class="flex items-start gap-4 p-4 bg-purple-50 rounded-xl border border-purple-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-spa text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-purple-600 font-semibold mb-1">Treatment</p>
                                    <p class="text-base font-bold text-purple-900" x-text="selectedTreatment"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-green-50 rounded-xl border border-green-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-user-doctor text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-green-600 font-semibold mb-1">Dokter</p>
                                    <p class="text-base font-bold text-green-900" x-text="selectedDoctor"></p>
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-calendar text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-blue-600 font-semibold mb-1">Tanggal</p>
                                        <p class="text-base font-bold text-blue-900" x-text="form.date"></p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fa-solid fa-clock text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-blue-600 font-semibold mb-1">Waktu</p>
                                        <p class="text-base font-bold text-blue-900" x-text="form.time"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-user text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-yellow-600 font-semibold mb-1">Nama</p>
                                    <p class="text-base font-bold text-yellow-900" x-text="form.name"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-pink-50 rounded-xl border border-pink-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-envelope text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-pink-600 font-semibold mb-1">Email</p>
                                    <p class="text-base font-bold text-pink-900" x-text="form.email"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-teal-50 rounded-xl border border-teal-200">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-phone text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-teal-600 font-semibold mb-1">Nomor HP</p>
                                    <p class="text-base font-bold text-teal-900" x-text="form.phone"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Warning Box --}}
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100/50 border-2 border-orange-300 rounded-xl p-5 flex items-start gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-orange-900 mb-1">Perhatian!</p>
                            <p class="text-sm text-orange-700">Pastikan semua data sudah benar sebelum mengkonfirmasi. Data yang sudah dikonfirmasi tidak dapat diubah.</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-3 mt-10 pt-6 border-t border-border">
                        <button type="button" @click="prevStep"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-foreground border-2 border-border bg-white rounded-lg hover:bg-muted hover:border-foreground/30 hover:shadow-sm active:scale-95 transition-all duration-300">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Kembali</span>
                        </button>

                        <button type="button" @click="showConfirmModal = true"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 hover:shadow-lg active:scale-95 transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-check-circle"></i>
                            <span>Konfirmasi Reservasi</span>
                        </button>
                    </div>
                </div>
                {{-- Step 5: Success --}}
                <div x-show="currentStep === 5" x-transition class="text-center py-12 space-y-6">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-2xl mb-4 animate-bounce-slow">
                        <i class="fa-solid fa-check text-white text-5xl"></i>
                    </div>
                    
                    <div class="space-y-3">
                        <h2 class="text-3xl sm:text-4xl font-bold text-green-600">Reservasi Berhasil!</h2>
                        <p class="text-lg text-muted-foreground">Terima kasih telah membuat reservasi di Gracias Aesthetic Clinic</p>
                    </div>

                    <div class="bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl p-6 border-2 border-primary/20 max-w-md mx-auto">
                        <p class="text-sm text-muted-foreground mb-2">Kode Reservasi Anda</p>
                        <div class="flex items-center justify-center gap-3">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-hashtag text-primary-foreground"></i>
                            </div>
                            <p class="text-2xl font-mono font-bold text-primary" x-text="reservationCode"></p>
                        </div>
                        <p class="text-xs text-muted-foreground mt-3">Simpan kode ini untuk referensi reservasi Anda</p>
                    </div>

                    <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl p-5 max-w-lg mx-auto border border-blue-200">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-blue-900 mb-1">Langkah Selanjutnya:</p>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>✓ Anda akan menerima email konfirmasi</li>
                                    <li>✓ Download resi PDF sebagai bukti</li>
                                    <li>✓ Datang 10 menit sebelum jadwal</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8 pt-6">
                        <a :href="`/reservasi/${reservationCode}/cetak`" target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-base font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 hover:shadow-xl active:scale-95 transition-all duration-300 shadow-md">
                            <i class="fa-solid fa-file-pdf text-lg"></i>
                            <span>Download Resi (PDF)</span>
                        </a>

                        <a href="{{ route('landingpage') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-base font-bold text-primary border-2 border-primary bg-white rounded-xl hover:bg-primary hover:text-white hover:shadow-lg active:scale-95 transition-all duration-300 shadow-sm">
                            <i class="fa-solid fa-house"></i>
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Modal Konfirmasi --}}
            <div x-show="showConfirmModal" 
                 x-cloak 
                 x-on:keydown.escape.window="showConfirmModal = false"
                 class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div @click.away="showConfirmModal = false"
                    class="bg-gradient-to-br from-card to-card/90 rounded-3xl shadow-2xl p-8 w-full max-w-md border-2 border-border"
                    role="dialog"
                    aria-modal="true"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90">
                    
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-lg mb-4">
                            <i class="fa-solid fa-circle-question text-white text-2xl"></i>
                        </div>
                        <h2 id="modal-title" class="text-2xl font-bold mb-3 text-foreground">Konfirmasi Reservasi</h2>
                        <p class="text-base text-muted-foreground leading-relaxed">
                            Apakah Anda yakin ingin mengonfirmasi reservasi ini? Pastikan semua data sudah benar.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-3">
                        <button type="button" @click="showConfirmModal = false"
                            class="flex-1 px-6 py-3.5 bg-muted hover:bg-muted/80 text-foreground font-semibold rounded-xl border-2 border-border hover:border-foreground/20 shadow-sm hover:shadow-md active:scale-95 transition-all duration-300">
                            <i class="fa-solid fa-times mr-2"></i>
                            Batal
                        </button>
                        <button type="button" @click="submitForm(); showConfirmModal = false"
                            class="flex-1 px-6 py-3.5 text-base font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 shadow-md hover:shadow-xl active:scale-95 transition-all duration-300">
                            <i class="fa-solid fa-check mr-2"></i>
                            Ya, Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Padding --}}
        <div class="h-16"></div>
    </div>

    {{-- Custom Scrollbar Style --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #9333ea;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #7e22ce;
        }
    </style>

            <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

            <script>
                function reservationForm() {
                    return {
                        currentStep: 1,
                        showConfirmModal: false,
                        steps: ['Treatment & Dokter', 'Jadwal', 'Data Diri', 'Konfirmasi'],
                        availableTimes: [],
                        loadingSlots: false,
                        form: {
                            treatment_id: '',
                            doctor_id: '',
                            date: '',
                            time: '',
                            name: '',
                            email: '',
                            phone: ''
                        },
                        errors: {},
                        reservationCode: '',

                        // Calendar state (month is 0-based)
                        month: new Date().getMonth(),
                        year: new Date().getFullYear(),
                        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                        blanks: [],
                        daysInMonth: [],
                        monthLabel: '',

                        init() {
                            // render initial calendar
                            this.updateCalendar();

                            // Pre-select treatment if provided via URL parameter
                            const preSelectedTreatment = this.$root.dataset.preSelectedTreatment;
                            if (preSelectedTreatment) {
                                this.form.treatment_id = preSelectedTreatment;
                            }

                            // when doctor changes reset selected time & slots
                            this.$watch('form.doctor_id', () => {
                                this.form.time = '';
                                this.availableTimes = [];
                            });

                            // when date changes (if doctor already set) load slots
                            this.$watch('form.date', (value) => {
                                if (value && this.form.doctor_id) this.loadAvailableSlots();
                            });

                            // prefill user
                            this.form.name = @json(auth()->user()->name ?? '');
                            this.form.email = @json(auth()->user()->email ?? '');
                            this.form.phone = @json(auth()->user()->phone ?? '');
                        },

                        // helper: format a date as YYYY-MM-DD without timezone conversions
                        formatDateLocal(y, m0, d) {
                            const mm = String(m0 + 1).padStart(2, '0');
                            const dd = String(d).padStart(2, '0');
                            return `${y}-${mm}-${dd}`;
                        },

                        // expose for template (can't call inside :class expression easily)
                        formatDateLocalWrapper(y, m0, d) {
                            return this.formatDateLocal(y, m0, d);
                        },

                        // check if date already passed (local)
                        isPastDate(y, m0, d) {
                            const today = new Date();
                            const target = new Date(y, m0, d, 0, 0, 0, 0);
                            // normalize only date part
                            const t0 = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                            return target < t0;
                        },

                        updateCalendar() {
                            const firstDay = new Date(this.year, this.month, 1).getDay();
                            const totalDays = new Date(this.year, this.month + 1, 0).getDate();
                            this.blanks = Array.from({
                                length: firstDay
                            });
                            this.daysInMonth = Array.from({
                                length: totalDays
                            }, (_, i) => i + 1);
                            this.monthLabel = new Date(this.year, this.month).toLocaleString('default', {
                                month: 'long',
                                year: 'numeric'
                            });
                        },

                        prevMonth() {
                            if (this.month === 0) {
                                this.month = 11;
                                this.year--;
                            } else this.month--;
                            this.updateCalendar();
                        },
                        nextMonth() {
                            if (this.month === 11) {
                                this.month = 0;
                                this.year++;
                            } else this.month++;
                            this.updateCalendar();
                        },

                        // when clicking a day: set date string without toISOString
                        selectDate(day) {
                            if (this.isPastDate(this.year, this.month, day)) return;
                            this.form.date = this.formatDateLocal(this.year, this.month, day);
                            this.form.time = ''; // clear previous selected time
                            // loadAvailableSlots will be triggered by watch on form.date (if doctor selected)
                            if (this.form.doctor_id) this.loadAvailableSlots();
                        },

                        // choose time slot
                        selectTime(slot) {
                            this.form.time = slot;
                            if (this.errors.time) delete this.errors.time;
                        },

                        // Step control & validation
                        validateStep() {
                            this.errors = {};

                            if (this.currentStep === 1) {
                                if (!this.form.treatment_id) this.errors.treatment_id = 'Pilih treatment terlebih dahulu.';
                                if (!this.form.doctor_id) this.errors.doctor_id = 'Pilih dokter terlebih dahulu.';
                            }

                            if (this.currentStep === 2) {
                                if (!this.form.date) this.errors.date = 'Tanggal reservasi wajib diisi.';
                                if (!this.form.time) this.errors.time = 'Waktu reservasi wajib dipilih.';
                            }

                            if (this.currentStep === 3) {
                                if (!this.form.phone) this.errors.phone = 'Nomor HP wajib diisi.';
                            }

                            return Object.keys(this.errors).length === 0;
                        },

                        nextStep() {
                            if (!this.validateStep()) return;
                            if (this.currentStep < 5) this.currentStep++;
                        },
                        prevStep() {
                            if (this.currentStep > 1) this.currentStep--;
                        },

                        get selectedTreatment() {
                            if (!this.form.treatment_id) return '-';
                            const card = this.$root.querySelector(`[data-treatment-id='${this.form.treatment_id}']`);
                            return card ? card.dataset.treatmentName : '-';
                        },

                        get selectedDoctor() {
                            const select = document.getElementById('doctor-select');
                            if (!select) return '-';
                            const option = select.querySelector(`option[value='${this.form.doctor_id}']`);
                            return option ? option.textContent : '-';
                        },

                        // helper: check if slot is too close to current time (<= 1 hour)
                        isSlotTooClose(slot) {
                            const now = new Date();
                            const slotDateTime = new Date(this.form.date + 'T' + slot + ':00');
                            const oneHourFromNow = new Date(now.getTime() + 60 * 60 * 1000);
                            return slotDateTime <= oneHourFromNow;
                        },

                        // load available slots from server and set reactive array (no innerHTML injection)
                        async loadAvailableSlots() {
                            if (!this.form.doctor_id || !this.form.date) return;
                            this.loadingSlots = true;
                            this.availableTimes = [];

                            try {
                                const url = `/reservasi/jadwal/${this.form.doctor_id}/${this.form.date}`;
                                const res = await fetch(url, {
                                    headers: {
                                        'Accept': 'application/json'
                                    }
                                });
                                if (!res.ok) throw new Error('HTTP error ' + res.status);
                                const data = await res.json();

                                // Expect data.available_slots = ['08:00','09:00',...]
                                if (Array.isArray(data.available_slots) && data.available_slots.length) {
                                    // Filter out slots that are too close to current time and exclude 12:00 lunch break
                                    this.availableTimes = data.available_slots.filter(slot => !this.isSlotTooClose(slot) &&
                                        slot !== '12:00');
                                } else {
                                    this.availableTimes = [];
                                }
                            } catch (e) {
                                console.error(e);
                                this.availableTimes = [];
                            } finally {
                                this.loadingSlots = false;
                            }
                        },

                        // submit
                        async submitForm() {
                            const url = this.$root.dataset.storeUrl;
                            const token = this.$root.dataset.csrf;

                            // Validate final
                            if (!this.validateStep()) return;

                            try {
                                const payload = {
                                    ...this.form
                                };
                                // payload.date already in YYYY-MM-DD (local), keep as is
                                const res = await fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'X-Requested-With': 'XMLHttpRequest',
                                    },
                                    body: JSON.stringify(payload)
                                });

                                const data = await res.json();
                                if (data.success) {
                                    this.reservationCode = data.code;
                                    this.currentStep = 5;
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Reservasi Berhasil!',
                                        text: `Kode reservasi Anda: ${data.code}`,
                                        confirmButtonColor: '#16a34a'
                                    });
                                } else if (data.errors) {
                                    this.errors = data.errors;
                                } else {
                                    alert(data.message || 'Terjadi kesalahan saat menyimpan reservasi.');
                                }
                            } catch (e) {
                                alert('Gagal mengirim data ke server.\n' + (e?.message || ''));
                            }
                        }
                    }
                }
            </script>
        </div>
    @endsection
