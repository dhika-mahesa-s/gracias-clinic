@extends('layouts.app')

@section('content')
    <div x-data="reservationForm()" x-init="init()" data-store-url="{{ route('reservasi.store') }}"
        data-csrf="{{ csrf_token() }}" data-pre-selected-treatment="{{ $preSelectedTreatmentId ?? '' }}"
        class="max-w-3xl mx-auto mt-16 mb-24 p-8 bg-card rounded-2xl shadow-lg border border-border text-foreground relative overflow-hidden">

        {{-- Progress Bar --}}
        <div class="mb-10">
            <div class="flex justify-between items-center text-sm font-medium text-muted-foreground mb-3">
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex-1 text-center" :class="{ 'text-primary font-semibold': currentStep === index + 1 }">
                        <span x-text="step"></span>
                    </div>
                </template>
            </div>

            <div class="w-full bg-muted rounded-full h-2 overflow-hidden">
                <div class="h-2 bg-primary transition-all duration-500"
                    :style="`width: ${(currentStep - 1) / (steps.length - 1) * 100}%`"></div>
            </div>
        </div>

        {{-- Step Container --}}
        <div class="min-h-[360px] relative">
            {{-- Step 1 --}}
            <div x-show="currentStep === 1" x-transition class="space-y-6">
                <h2 class="text-2xl font-semibold text-foreground">Pilih Treatment & Dokter</h2>

                {{-- Treatment Cards --}}
                <div>
                    <label class="block font-medium text-foreground mb-2">Treatment</label>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($treatments as $t)
                            <div @click="form.treatment_id = '{{ $t->id }}'" data-treatment-id="{{ $t->id }}"
                                data-treatment-name="{{ addslashes($t->name) }}" data-aos="fade-up"
                                class="cursor-pointer rounded-xl border border-border bg-card overflow-hidden 
                            transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-1"
                                :class="form.treatment_id == '{{ $t->id }}' ?
                                    'ring-2 ring-primary scale-[1.02] bg-primary/5' : ''">
                                @if ($t->image)
                                    <img src="{{ asset('storage/' . $t->image) }}" alt="{{ $t->name }}"
                                        class="w-full h-36 object-cover">
                                @else
                                    <div
                                        class="w-full h-36 bg-muted flex items-center justify-center text-muted-foreground">
                                        <i class="fa-solid fa-image text-3xl"></i>
                                    </div>
                                @endif

                                <div class="p-4 space-y-1">
                                    <h3 class="font-semibold text-lg text-foreground">{{ $t->name }}</h3>
                                    <p class="text-sm text-muted-foreground line-clamp-2">{{ $t->description }}</p>
                                    <div class="flex justify-between items-center pt-2">
                                        <p class="font-semibold text-primary">Rp{{ number_format($t->price, 0, ',', '.') }}
                                        </p>
                                        <i class="fa-solid fa-chevron-right text-muted-foreground text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p x-show="errors.treatment_id" x-text="errors.treatment_id" class="text-red-500 text-sm mt-1"></p>
                </div>

                {{-- Dokter --}}
                <div>
                    <label class="block font-medium text-foreground mb-1">Dokter</label>
                    <select id="doctor-select" x-model="form.doctor_id"
                        :class="{ 'border-red-500 focus:border-red-500': errors.doctor_id }"
                        class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($doctors as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.doctor_id" x-text="errors.doctor_id" class="text-red-500 text-sm mt-1"></p>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="button" @click="nextStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-semibold text-[color:var(--color-primary-foreground)] bg-[color:var(--color-primary)] rounded-xl hover:bg-[color:var(--color-primary)]/90 hover:shadow-lg active:scale-95 transition-all duration-200">
                        Lanjut
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </div>


            {{-- Step 2 (Kalender & Waktu) --}}
            <div x-show="currentStep === 2" x-transition class="space-y-6">
                <h2 class="text-2xl font-semibold text-foreground">Pilih Tanggal & Waktu</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Kalender --}}
                    <div class="border border-border rounded-xl bg-white p-4">
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" @click="prevMonth" class="p-2 rounded hover:bg-muted">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <h3 class="font-semibold text-lg" x-text="monthLabel"></h3>
                            <button type="button" @click="nextMonth" class="p-2 rounded hover:bg-muted">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-7 text-center text-sm font-medium mb-2">
                            <template x-for="day in days" :key="day">
                                <div x-text="day"></div>
                            </template>
                        </div>

                        <div class="grid grid-cols-7 gap-1 text-center">
                            <template x-for="(_, i) in blanks" :key="'b' + i">
                                <div class="p-2"></div>
                            </template>

                            <template x-for="d in daysInMonth" :key="d">
                                <button type="button" @click="selectDate(d)" class="p-2 rounded-lg w-full transition"
                                    :class="{
                                        'bg-primary text-white font-semibold': form.date === formatDateLocal(year,
                                            month, d),
                                        'opacity-50 cursor-not-allowed': isPastDate(year, month, d)
                                    }"
                                    :disabled="isPastDate(year, month, d)" x-text="d"></button>
                            </template>
                        </div>
                    </div>

                    {{-- Slot waktu --}}
                    <div class="border border-border rounded-xl bg-white p-4">
                        <h3 class="font-semibold text-lg mb-3">Waktu Tersedia</h3>

                        <div class="mb-2 text-sm text-muted-foreground"
                            x-text="form.date ? `Tanggal dipilih: ${form.date}` : 'Silakan pilih tanggal'"></div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Loading -->
                            <template x-if="loadingSlots">
                                <div class="col-span-2 text-muted-foreground">Memuat jadwal...</div>
                            </template>

                            <!-- Empty -->
                            <template x-if="!loadingSlots && availableTimes.length === 0">
                                <div class="col-span-2 text-muted-foreground">Tidak ada slot tersedia</div>
                            </template>

                            <!-- Slots -->
                            <template x-for="slot in availableTimes" :key="slot">
                                <button type="button" @click="selectTime(slot)"
                                    class="rounded-lg p-3 border border-border text-foreground hover:bg-primary hover:text-primary-foreground transition"
                                    :class="{ 'bg-primary text-white font-semibold': form.time === slot }">
                                    <span x-text="slot"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <p x-show="errors.time" x-text="errors.time" class="text-red-500 text-sm mt-1"></p>

                <div class="flex justify-between mt-10">
                    <!-- Tombol Kembali -->
                    <button type="button" @click="prevStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-mediumtext-[color:var(--color-primary)] border border-[color:var(--color-border)] bg-[color:var(--color-card)] rounded-xl hover:bg-[color:var(--color-primary)] hover:text-[color:var(--color-primary-foreground)] hover:shadow-md active:scale-95 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Kembali
                    </button>

                    <!-- Tombol Lanjut -->
                    <button type="button" @click="nextStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-semibold text-[color:var(--color-primary-foreground)] bg-[color:var(--color-primary)] rounded-xl hover:bg-[color:var(--color-primary)]/90 hover:shadow-lg active:scale-95 transition-all duration-200">
                        Lanjut
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 3 --}}
            <div x-show="currentStep === 3" x-transition class="space-y-5">
                <h2 class="text-2xl font-semibold text-foreground">Data Diri</h2>

                <div>
                    <label class="block font-medium mb-1 text-foreground">Nama Lengkap</label>
                    <input type="text" x-model="form.name"
                        class="w-full border-input bg-gray-100 text-gray-600 rounded-lg p-2.5" readonly>
                </div>

                <div>
                    <label class="block font-medium mb-1 text-foreground">Email</label>
                    <input type="email" x-model="form.email"
                        class="w-full border-input bg-gray-100 text-gray-600 rounded-lg p-2.5" readonly>
                </div>

                <div>
                    <label class="block font-medium mb-1 text-foreground">Nomor HP</label>
                    <input type="text" x-model="form.phone" value="{{ auth()->user()->phone ?? '' }}"
                        placeholder="Masukkan nomor HP aktif Anda"
                        :class="{ 'border-red-500 focus:border-red-500': errors.phone }"
                        class="w-full border-input focus:ring-primary focus:border-primary rounded-lg p-2.5 bg-background">
                    <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-sm mt-1"></p>
                </div>

                <div class="flex justify-between mt-10">
                    <!-- Tombol Kembali -->
                    <button type="button" @click="prevStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-mediumtext-[color:var(--color-primary)] border border-[color:var(--color-border)] bg-[color:var(--color-card)] rounded-xl hover:bg-[color:var(--color-primary)] hover:text-[color:var(--color-primary-foreground)] hover:shadow-md active:scale-95 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Kembali
                    </button>

                    <!-- Tombol Lanjut -->
                    <button type="button" @click="nextStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-semibold text-[color:var(--color-primary-foreground)] bg-[color:var(--color-primary)] rounded-xl hover:bg-[color:var(--color-primary)]/90 hover:shadow-lg active:scale-95 transition-all duration-200">
                        Lanjut
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 4 (Confirm) --}}
            <div x-show="currentStep === 4" x-transition class="space-y-5">
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

                <div class="flex justify-between items-center mt-10 pb-2">
                    <!-- Tombol Kembali -->
                    <button type="button" @click="prevStep"
                        class="flex items-center gap-2 px-8 py-3 text-base font-medium text-[color:var(--color-primary)] border border-[color:var(--color-border)] bg-gradient-to-br from-[color:var(--color-card)] to-[color:var(--color-muted)] rounded-xl shadow-sm hover:shadow-md hover:from-[color:var(--color-primary)] hover:to-[color:var(--color-primary)]/90 hover:text-[color:var(--color-primary-foreground)] active:scale-95 transition-all duration-300">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Kembali
                    </button>

                    <!-- Tombol Konfirmasi -->
                    <button type="button" @click="showConfirmModal = true"
                        class="flex items-center gap-2 px-8 py-3 text-base font-semibold text-white rounded-xl bg-gradient-to-r from-green-500 to-green-600 shadow-md hover:shadow-xl hover:from-green-600 hover:to-green-700 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        Konfirmasi
                        <i class="fa-solid fa-check text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Step 5 (Success) --}}
            <div x-show="currentStep === 5" x-transition class="text-center py-12 space-y-4">
                <div class="text-green-600 text-4xl font-bold">✅ Reservasi Berhasil!</div>
                <p class="text-foreground">
                    ID Reservasi: <span class="font-mono text-primary" x-text="reservationCode"></span>
                </p>
                <div class="flex justify-center gap-3 mt-8">
                    <a :href="`/reservasi/${reservationCode}/cetak`" target="_blank"
                        class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-base font-semibold text-white rounded-xl bg-gradient-to-r from-green-500 to-green-600 shadow-md hover:shadow-xl hover:from-green-600 hover:to-green-700 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        <i class="fa-solid fa-file-pdf"></i> Download Resi (PDF)
                    </a>

                    <a href="{{ route('landingpage') }}"
                        class="flex items-center gap-2 px-6 py-2.5 rounded-xl border border-primary text-primary font-medium hover:bg-primary hover:text-white shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fa-solid fa-house"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        {{-- Modal Konfirmasi --}}
        <div x-show="showConfirmModal" x-cloak x-on:keydown.escape.window="showConfirmModal = false"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50" x-transition.opacity>
            <div @click.away="showConfirmModal = false"
                class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md text-center" role="dialog" aria-modal="true">
                <h2 id="modal-title" class="text-xl font-semibold mb-3 text-gray-800">Konfirmasi Reservasi</h2>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengonfirmasi reservasi ini? Pastikan semua data
                    sudah benar</p>

                <div class="flex justify-center gap-4">
                    <button type="button" @click="showConfirmModal = false"
                        class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 ">
                        Batal
                    </button>
                    <button type="button" @click="submitForm(); showConfirmModal = false"
                        class="px-6 py-2 text-base font-semibold text-white rounded-xl bg-gradient-to-r from-green-500 to-green-600 shadow-md hover:shadow-xl hover:from-green-600 hover:to-green-700 active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                        Ya, Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                                this.availableTimes = data.available_slots;
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
