<x-app-layout>
    <div 
        x-data="reservationForm()" 
        x-init="init()" 
        data-store-url="{{ route('reservasi.store') }}" 
        data-csrf="{{ csrf_token() }}"
        class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-lg">
    
        <!-- Step Indicator -->
        <div class="flex justify-between mb-8">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex flex-col items-center w-1/4">
                    <div :class="currentStep === index + 1 ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-600'"
                         class="w-10 h-10 flex items-center justify-center rounded-full font-bold mb-2">
                        <span x-text="index + 1"></span>
                    </div>
                    <span x-text="step" class="text-sm"></span>
                </div>
            </template>
        </div>
    
        <!-- Step 1: Treatment & Dokter -->
        <div x-show="currentStep === 1" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Pilih Treatment & Dokter</h2>
            <div>
                <label class="font-medium">Treatment</label>
                <select x-model="form.treatment_id" class="w-full border rounded-lg p-2">
                    <option value="">-- Pilih Treatment --</option>
                    @foreach ($treatments as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} - Rp{{ number_format($t->price) }}</option>
                    @endforeach
                    @error('treatment_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </select>
            </div>
    
            <div>
                <label class="font-medium">Dokter</label>
                <select x-model="form.doctor_id" class="w-full border rounded-lg p-2">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach ($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <button
                @click="nextStep"
                class="bg-pink-500 text-white px-4 py-2 rounded-lg transition">
                Lanjut
            </button>
    
        </div>
    
        <!-- Step 2: Jadwal -->
        <div x-show="currentStep === 2" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Pilih Jadwal</h2>
            <input type="date" x-model="form.date" class="w-full border rounded-lg p-2" min="{{ date('Y-m-d') }}">
            <div id="time-slots-container" class="grid grid-cols-4 gap-2 mt-2">
                <p class="col-span-4 text-gray-500 text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>
            </div>            
            <div class="flex justify-between">
                <button @click="prevStep" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Kembali</button>
                <button @click="nextStep" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Lanjut</button>
            </div>
        </div>
    
        <!-- Step 3: Data Diri -->
        <div x-show="currentStep === 3" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Lengkapi Data Diri</h2>
            <input type="text" placeholder="Nama Lengkap" x-model="form.name" class="w-full border rounded-lg p-2">
            <input type="email" placeholder="Email" x-model="form.email" class="w-full border rounded-lg p-2">
            <input type="text" placeholder="Nomor HP" x-model="form.phone" class="w-full border rounded-lg p-2">
    
            <div class="flex justify-between">
                <button @click="prevStep" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Kembali</button>
                <button @click="nextStep" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Lanjut</button>
            </div>
        </div>
    
        <!-- Step 4: Konfirmasi -->
        <div x-show="currentStep === 4" class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Konfirmasi Reservasi</h2>
            <div class="border rounded-lg p-4">
                <p><strong>Treatment:</strong> <span x-text="selectedTreatment"></span></p>
                <p><strong>Dokter:</strong> <span x-text="selectedDoctor"></span></p>
                <p><strong>Tanggal:</strong> <span x-text="form.date"></span></p>
                <p><strong>Waktu:</strong> <span x-text="form.time"></span></p>
                <p><strong>Nama:</strong> <span x-text="form.name"></span></p>
                <p><strong>Email:</strong> <span x-text="form.email"></span></p>
                <p><strong>Nomor HP:</strong> <span x-text="form.phone"></span></p>
            </div>
    
            <div class="flex justify-between">
                <button @click="prevStep" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Kembali</button>
                <button type="button" @click=" console.log('klik!'); submitForm()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Konfirmasi Reservasi</button>
            </div>
        </div>
    
        <!-- Step 5: Selesai -->
        <div x-show="currentStep === 5" class="text-center space-y-3">
            <div class="text-green-600 text-3xl font-bold">✅ Reservasi Berhasil!</div>
            <p>ID Reservasi: <span class="font-mono text-pink-600" x-text="reservationCode"></span></p>
            <a href="{{ route('dashboard') }}" class="bg-pink-500 text-white px-4 py-2 rounded-lg">Kembali ke Dashboard</a>
        </div>
    </div>
    
    <script>
        function reservationForm() {
            return {
                currentStep: 1,
                steps: ['Treatment & Dokter', 'Jadwal', 'Data Diri', 'Konfirmasi'],
                availableTimes: [],
                form: {
                    treatment_id: '',
                    doctor_id: '',
                    date: '',
                    time: '',
                    name: '',
                    email: '',
                    phone: ''
                },
                reservationCode: '',
        
                init() {
                    console.log('Alpine initialized');
                    this.$watch('form.date', (value) => {
                        if (value && this.form.doctor_id) {
                            this.loadAvailableSlots();
                        }
                    });
        
                    this.$watch('form.doctor_id', () => {
                        this.form.time = '';
                        this.availableTimes = [];
                        const container = document.getElementById('time-slots-container');
                        if (container) {
                            container.innerHTML = '<p class="col-span-4 text-gray-500 text-sm">Pilih tanggal untuk melihat jadwal tersedia</p>';
                        }
                    });
                },
        
                nextStep() {
                    if (this.currentStep < 5) this.currentStep++;
                },
        
                prevStep() {
                    if (this.currentStep > 1) this.currentStep--;
                },
        
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
                    container.innerHTML = '<p class="col-span-4 text-gray-500">Memuat jadwal...</p>';
        
                    try {
                        const res = await fetch(url);
                        const data = await res.json();
        
                        if (!data.available_slots || data.available_slots.length === 0) {
                            container.innerHTML = '<p class="col-span-4 text-red-500">Tidak ada slot tersedia untuk tanggal ini.</p>';
                            return;
                        }
        
                        this.availableTimes = data.available_slots;
        
                        let html = '';
                        data.available_slots.forEach(slot => {
                            html += `
                                <button type="button"
                                    class="rounded-lg p-2 border text-gray-700 hover:bg-pink-500 hover:text-white transition"
                                    @click="form.time = '${slot}'"
                                    x-bind:class="form.time === '${slot}' ? 'bg-pink-500 text-white' : ''">
                                    ${slot}
                                </button>`;
                        });
                        container.innerHTML = html;
        
                    } catch (error) {
                        console.error(error);
                        container.innerHTML = '<p class="col-span-4 text-red-500">Gagal memuat slot jadwal.</p>';
                    }
                },
        
                async submitForm() {
                    const url = this.$root.dataset.storeUrl;
                    const token = this.$root.dataset.csrf;
        
                    console.log('Mengirim ke:', url);
                    console.log('Data:', this.form);
        
                    try {
                        const res = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: JSON.stringify(this.form)
                        });
        
                        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        
                        const data = await res.json();
                        console.log('Response:', data);
        
                        if (data.success) {
                            this.reservationCode = data.code;
                            this.currentStep = 5;
                        } else {
                            alert('Terjadi kesalahan saat menyimpan reservasi.');
                        }
        
                    } catch (error) {
                        console.error(error);
                        alert('Gagal mengirim data ke server. Cek console untuk detail.');
                    }
                }
            }
        }
        </script>
        
        
    </x-app-layout>
    