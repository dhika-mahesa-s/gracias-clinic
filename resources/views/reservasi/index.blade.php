@extends('layouts.app')

@section('content')
<div 
    x-data="reservationForm()" 
    x-init="init()" 
    data-store-url="{{ route('reservasi.store') }}" 
    data-csrf="{{ csrf_token() }}"
    class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-2xl relative overflow-hidden">

    <!-- Progress Bar -->
    <div class="mb-10">
        <div class="flex justify-between items-center text-sm font-medium text-gray-600 mb-3">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex-1 text-center" :class="{'text-pink-600 font-semibold': currentStep === index + 1}">
                    <span x-text="step"></span>
                </div>
            </template>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div 
                class="h-2 bg-pink-500 transition-all duration-500" 
                :style="`width: ${(currentStep - 1) / (steps.length - 1) * 100}%`"></div>
        </div>
    </div>

    <!-- Step Container -->
    <div class="min-h-[360px] relative">
        <!-- Step 1 -->
        <div 
            x-show="currentStep === 1"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-x-6"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-end="opacity-0 -translate-x-6"
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-gray-800">Pilih Treatment & Dokter</h2>
            
            <div>
                <label class="block font-medium text-gray-700 mb-1">Treatment</label>
                <select x-model="form.treatment_id" class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5">
                    <option value="">-- Pilih Treatment --</option>
                    @foreach ($treatments as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} - Rp{{ number_format($t->price) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Dokter</label>
                <select x-model="form.doctor_id" class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button @click="nextStep" 
                    class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-lg shadow transition">
                    Lanjut →
                </button>
            </div>
        </div>

        <!-- Step 2 -->
        <div 
            x-show="currentStep === 2"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-gray-800">Pilih Jadwal</h2>
            <input type="date" 
                   x-model="form.date" 
                   class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5"
                   min="{{ date('Y-m-d') }}">
            
            <div id="time-slots-container" class="grid grid-cols-4 gap-3 mt-2">
                <p class="col-span-4 text-gray-500 text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>
            </div>

            <div class="flex justify-between mt-6">
                <button @click="prevStep" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200">
                    ← Kembali
                </button>
                <button @click="nextStep" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-lg shadow">
                    Lanjut →
                </button>
            </div>
        </div>

        <!-- Step 3 -->
        <div 
            x-show="currentStep === 3"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-gray-800">Lengkapi Data Diri</h2>
            
            <input type="text" placeholder="Nama Lengkap" x-model="form.name" class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5">
            <input type="email" placeholder="Email" x-model="form.email" class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5">
            <input type="text" placeholder="Nomor HP" x-model="form.phone" class="w-full border-gray-300 focus:ring-pink-400 focus:border-pink-400 rounded-lg p-2.5">

            <div class="flex justify-between mt-6">
                <button @click="prevStep" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200">
                    ← Kembali
                </button>
                <button @click="nextStep" class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-lg shadow">
                    Lanjut →
                </button>
            </div>
        </div>

        <!-- Step 4 -->
        <div 
            x-show="currentStep === 4"
            x-transition
            class="space-y-5">
            
            <h2 class="text-2xl font-semibold text-gray-800">Konfirmasi Reservasi</h2>
            <div class="border border-gray-200 rounded-lg p-5 bg-gray-50 space-y-2 text-gray-700">
                <p><strong>Treatment:</strong> <span x-text="selectedTreatment"></span></p>
                <p><strong>Dokter:</strong> <span x-text="selectedDoctor"></span></p>
                <p><strong>Tanggal:</strong> <span x-text="form.date"></span></p>
                <p><strong>Waktu:</strong> <span x-text="form.time"></span></p>
                <p><strong>Nama:</strong> <span x-text="form.name"></span></p>
                <p><strong>Email:</strong> <span x-text="form.email"></span></p>
                <p><strong>Nomor HP:</strong> <span x-text="form.phone"></span></p>
            </div>

            <div class="flex justify-between mt-6">
                <button @click="prevStep" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200">
                    ← Kembali
                </button>
                <button type="button" 
                        @click="submitForm" 
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-lg shadow">
                    Konfirmasi Reservasi
                </button>
            </div>
        </div>

        <!-- Step 5 -->
        <div 
            x-show="currentStep === 5"
            x-transition
            class="text-center py-12 space-y-4">
            
            <div class="text-green-600 text-4xl font-bold">✅ Reservasi Berhasil!</div>
            <p class="text-gray-700">ID Reservasi: <span class="font-mono text-pink-600" x-text="reservationCode"></span></p>
            <a href="{{ route('landingpage') }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-lg shadow">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function reservationForm() {
    return {
        currentStep: 1,
        steps: ['Treatment & Dokter', 'Jadwal', 'Data Diri', 'Konfirmasi'],
        availableTimes: [],
        form: {
            treatment_id: '', doctor_id: '', date: '', time: '',
            name: '', email: '', phone: ''
        },
        reservationCode: '',

        init() {
            this.$watch('form.date', (value) => {
                if (value && this.form.doctor_id) this.loadAvailableSlots();
            });
            this.$watch('form.doctor_id', () => {
                this.form.time = '';
                this.availableTimes = [];
                document.getElementById('time-slots-container').innerHTML = 
                    '<p class="col-span-4 text-gray-500 text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>';
            });
        },

        nextStep() { if (this.currentStep < 5) this.currentStep++; },
        prevStep() { if (this.currentStep > 1) this.currentStep--; },

        get selectedTreatment() {
            const el = document.querySelector(`[value='${this.form.treatment_id}']`);
            return el ? el.textContent : '-';
        },
        get selectedDoctor() {
            const el = document.querySelector(`[value='${this.form.doctor_id}']`);
            return el ? el.textContent : '-';
        },

        async loadAvailableSlots() {
            const url = `/reservasi/jadwal/${this.form.doctor_id}/${this.form.date}`;
            const container = document.getElementById('time-slots-container');
            container.innerHTML = '<p class="col-span-4 text-gray-500 animate-pulse">Memuat jadwal...</p>';

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (!data.available_slots?.length) {
                    container.innerHTML = '<p class="col-span-4 text-red-500">Tidak ada slot tersedia untuk tanggal ini.</p>';
                    return;
                }

                container.innerHTML = data.available_slots.map(slot => `
                    <button type="button"
                        class="rounded-lg p-2 border text-gray-700 hover:bg-pink-500 hover:text-white transition"
                        @click="form.time = '${slot}'"
                        x-bind:class="form.time === '${slot}' ? 'bg-pink-500 text-white' : ''">
                        ${slot}
                    </button>`).join('');
            } catch {
                container.innerHTML = '<p class="col-span-4 text-red-500">Gagal memuat slot jadwal.</p>';
            }
        },

        async submitForm() {
            const url = this.$root.dataset.storeUrl;
            const token = this.$root.dataset.csrf;

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': token,},
                    body: JSON.stringify(this.form)
                });

                const data = await res.json();
                if (data.success) {
                    this.reservationCode = data.code;
                    this.currentStep = 5;
                } else alert('Terjadi kesalahan saat menyimpan reservasi.');
            } catch {
                alert('Gagal mengirim data ke server.');
            }
        }
    }
}
</script>
@endsection
