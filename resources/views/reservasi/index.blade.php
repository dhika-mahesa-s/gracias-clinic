@extends('layouts.app')

@section('content')
<div 
    x-data="reservationForm()" 
    x-init="init()" 
    data-store-url="{{ route('reservasi.store') }}" 
    data-csrf="{{ csrf_token() }}"
    class="max-w-3xl mx-auto mt-16 mb-24 p-8 bg-card rounded-2xl shadow-lg border border-border text-foreground relative overflow-hidden">

    {{-- Progress Bar --}}
    <div class="mb-10">
        <div class="flex justify-between items-center text-sm font-medium text-muted-foreground mb-3">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex-1 text-center" 
                     :class="{'text-primary font-semibold': currentStep === index + 1}">
                    <span x-text="step"></span>
                </div>
            </template>
        </div>

        <div class="w-full bg-muted rounded-full h-2 overflow-hidden">
            <div 
                class="h-2 bg-primary transition-all duration-500" 
                :style="`width: ${(currentStep - 1) / (steps.length - 1) * 100}%`"></div>
        </div>
    </div>

    {{-- Step Container --}}
    <div class="min-h-[360px] relative">
        
        {{-- Step 1 --}}
        <div 
            x-show="currentStep === 1"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-foreground">Pilih Treatment & Dokter</h2>
            
            <!-- Treatment -->
            <div>
                <label class="block font-medium text-foreground mb-1">Treatment</label>
                <select id="treatment-select"
                        x-model="form.treatment_id" 
                        :class="{'border-red-500 focus:border-red-500': errors.treatment_id}"
                        class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background">
                    <option value="">-- Pilih Treatment --</option>
                    @foreach ($treatments as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} - Rp{{ number_format($t->price) }}</option>
                    @endforeach
                </select>
                <!-- Pesan error treatment -->
                <p x-show="errors.treatment_id" 
                x-text="errors.treatment_id" 
                class="text-red-500 text-sm mt-1"></p>
            </div>
            
            <!-- Dokter -->
            <div>
                <label class="block font-medium text-foreground mb-1">Dokter</label>
                <select id="doctor-select"
                        x-model="form.doctor_id" 
                        :class="{'border-red-500 focus:border-red-500': errors.doctor_id}"
                        class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
                <!-- Pesan error dokter -->
                <p x-show="errors.doctor_id" 
                x-text="errors.doctor_id" 
                class="text-red-500 text-sm mt-1"></p>
            </div>

            <div class="flex justify-end mt-8">
                <button @click="nextStep" 
                    class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary text-white font-medium
                        hover:bg-primary/90 transition-all duration-300 shadow-sm hover:shadow-md">
                    Lanjut <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>


        {{-- Step 2 --}}
        <div 
            x-show="currentStep === 2"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-foreground">Pilih Jadwal</h2>
            
            <div>
                <input type="date" 
                       x-model="form.date" 
                       :class="{'border-red-500 focus:border-red-500': errors.date}"
                       class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background"
                       min="{{ date('Y-m-d') }}">
                <p x-show="errors.date" x-text="errors.date" class="text-red-500 text-sm mt-1"></p>
            </div>
            
            <div id="time-slots-container" class="grid grid-cols-4 gap-3 mt-2">
                <p class="col-span-4 text-muted-foreground text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>
            </div>
            <p x-show="errors.time" x-text="errors.time" class="text-red-500 text-sm mt-1"></p>

            <div class="flex justify-between mt-10">
                <button 
                    type="button"
                    @click="prevStep"
                    class="flex items-center gap-2 px-6 py-2 rounded-xl border border-primary text-primary font-medium
                           hover:bg-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </button>

                <button 
                    type="button"
                    @click="nextStep"
                    class="flex items-center gap-2 px-6 py-2 rounded-xl bg-primary text-white font-medium
                           hover:bg-primary/90 transition-all duration-300 shadow-sm hover:shadow-md">
                    Lanjut <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        {{-- Step 3 --}}
        <div 
        x-show="currentStep === 3"
        x-transition
        class="space-y-5">

        <h2 class="text-2xl font-semibold text-foreground">Data Diri</h2>

        <div>
            <label class="block font-medium mb-1 text-foreground">Nama Lengkap</label>
            <input type="text" 
                x-model="form.name"
                class="w-full border-input bg-gray-100 text-gray-600 rounded-lg p-2.5"
                readonly>
        </div>

        <div>
            <label class="block font-medium mb-1 text-foreground">Email</label>
            <input type="email" 
                x-model="form.email"
                class="w-full border-input bg-gray-100 text-gray-600 rounded-lg p-2.5"
                readonly>
        </div>

        <div>
            <label class="block font-medium mb-1 text-foreground">Nomor HP</label>
            <input type="text"
                x-model="form.phone"
                placeholder="Masukkan nomor HP aktif Anda"
                :class="{'border-red-500 focus:border-red-500': errors.phone}"
                class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background">
            <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-sm mt-1"></p>
        </div>

        <div class="flex justify-between mt-10">
            <button 
                type="button"
                @click="prevStep"
                class="flex items-center gap-2 px-6 py-2 rounded-xl border border-primary text-primary font-medium
                    hover:bg-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </button>

            <button 
                type="button"
                @click="nextStep"
                class="flex items-center gap-2 px-6 py-2 rounded-xl bg-primary text-white font-medium
                    hover:bg-primary/90 transition-all duration-300 shadow-sm hover:shadow-md">
                Lanjut <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
        </div>


        {{-- Step 4 --}}
        <div 
            x-show="currentStep === 4"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-foreground">Konfirmasi Reservasi</h2>
            <div class="border border-border rounded-lg p-5 bg-muted/30 space-y-2 text-foreground">
                <p><strong>Treatment:</strong> <span x-text="selectedTreatment"></span></p>
                <p><strong>Dokter:</strong> <span x-text="selectedDoctor"></span></p>
                <p><strong>Tanggal:</strong> <span x-text="form.date"></span></p>
                <p><strong>Waktu:</strong> <span x-text="form.time"></span></p>
                <p><strong>Nama:</strong> <span x-text="form.name"></span></p>
                <p><strong>Email:</strong> <span x-text="form.email"></span></p>
                <p><strong>Nomor HP:</strong> <span x-text="form.phone"></span></p>
            </div>
            

            <div class="flex justify-between mt-10">
                <button 
                    type="button"
                    @click="prevStep"
                    class="flex items-center gap-2 px-6 py-2 rounded-xl border border-primary text-primary font-medium
                           hover:bg-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </button>

                <button type="button" 
                        @click="submitForm" 
                        class="flex items-center gap-2 px-6 py-2 rounded-xl bg-green-600 text-white font-medium
                               hover:bg-green-700 transition-all duration-300 shadow-sm hover:shadow-md">
                    Konfirmasi <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </div>

        {{-- Step 5 --}}
        <div 
            x-show="currentStep === 5"
            x-transition
            class="text-center py-12 space-y-4">
            
            <div class="text-green-600 text-4xl font-bold">✅ Reservasi Berhasil!</div>
            <p class="text-foreground">
                ID Reservasi: <span class="font-mono text-primary" x-text="reservationCode"></span>
            </p>
            <div class="flex justify-center gap-3 mt-8">
                <a :href="`/reservasi/${reservationCode}/cetak`" target="_blank"
                   class="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-green-600 text-white font-medium
                          hover:bg-green-700 transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-file-pdf"></i> Download Resi (PDF)
                </a>
            
                <a href="{{ route('landingpage') }}" 
                   class="flex items-center gap-2 px-6 py-2.5 rounded-xl border border-primary text-primary font-medium
                          hover:bg-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
            </div>
            
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
function reservationForm() {
    return {
        currentStep: 1,
        steps: ['Treatment & Dokter', 'Jadwal', 'Data Diri', 'Konfirmasi'],
        availableTimes: [],
        form: { treatment_id: '', doctor_id: '', date: '', time: '', name: '', email: '', phone: '' },
        errors: {},
        reservationCode: '',

        init() {
            this.$watch('form.date', (value) => {
                if (value && this.form.doctor_id) this.loadAvailableSlots();
            });
            this.$watch('form.doctor_id', () => {
                this.form.time = '';
                this.availableTimes = [];
                document.getElementById('time-slots-container').innerHTML = 
                    '<p class="col-span-4 text-muted-foreground text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>';
            });

            // reset error saat user mengetik ulang input
            this.$watch('form', (val) => {
                for (const key in this.errors) {
                    if (val[key]) delete this.errors[key];
                }
            }, { deep: true });

            // Prefill data user login
            this.form.name = @json(auth()->user()->name ?? '');
            this.form.email = @json(auth()->user()->email ?? '');
            this.form.phone = @json(auth()->user()->phone ?? '');
        },

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
                if (!this.form.name) this.errors.name = 'Nama wajib diisi.';
                if (!this.form.email) this.errors.email = 'Email wajib diisi.';
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email))
                    this.errors.email = 'Format email tidak valid.';
                if (!this.form.phone) this.errors.phone = 'Nomor HP wajib diisi.';
                else if (!/^[0-9]{10,15}$/.test(this.form.phone))
                    this.errors.phone = 'Nomor HP harus angka 10–15 digit.';
            }

            return Object.keys(this.errors).length === 0;
        },

        nextStep() {
            if (!this.validateStep()) return;
            if (this.currentStep < 5) this.currentStep++;
        },

        prevStep() { if (this.currentStep > 1) this.currentStep--; },

        get selectedTreatment() {
            const select = document.getElementById('treatment-select');
            if (!select) return '-';
            const option = select.querySelector(`option[value='${this.form.treatment_id}']`);
            return option ? option.textContent : '-';
        },

        get selectedDoctor() {
            const select = document.getElementById('doctor-select');
            if (!select) return '-';
            const option = select.querySelector(`option[value='${this.form.doctor_id}']`);
            return option ? option.textContent : '-';
        },


        async loadAvailableSlots() {
            const url = `/reservasi/jadwal/${this.form.doctor_id}/${this.form.date}`;
            const container = document.getElementById('time-slots-container');
            container.innerHTML = '<p class="col-span-4 text-muted-foreground animate-pulse">Memuat jadwal...</p>';

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (!data.available_slots?.length) {
                    container.innerHTML = '<p class="col-span-4 text-destructive">Tidak ada slot tersedia untuk tanggal ini.</p>';
                    return;
                }

                container.innerHTML = data.available_slots.map(slot => `
                    <button type="button"
                        class="rounded-lg p-2 border border-border text-foreground hover:bg-primary hover:text-primary-foreground transition"
                        @click="form.time = '${slot}'"
                        x-bind:class="form.time === '${slot}' ? 'bg-primary text-primary-foreground' : ''">
                        ${slot}
                    </button>`).join('');
            } catch {
                container.innerHTML = '<p class="col-span-4 text-destructive">Gagal memuat slot jadwal.</p>';
            }
        },

        async submitForm() {
            const url = this.$root.dataset.storeUrl;
            const token = this.$root.dataset.csrf;

            try {
                // --- PERBAIKAN BUG TANGGAL BERGESER UTC ---
                const formData = { ...this.form };
                if (formData.date) {
                    const d = new Date(formData.date);
                    formData.date = d.toLocaleDateString('en-CA'); // hasil: "2025-10-27"
                }
                // -------------------------------------------

                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(formData)
                });

                const data = await res.json();

                if (data.success) {
                    this.reservationCode = data.code;
                    this.currentStep = 5;
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
@endsection
