@extends('layouts.dashboard')

@section('title', 'Kelola Reservasi - Gracias Aesthetic Clinic')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Kelola Reservasi</h1>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @elseif(session('info'))
        <div class="mb-4 p-4 rounded-lg bg-blue-100 text-blue-800 border border-blue-300">
            {{ session('info') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-sm overflow-hidden animate-fadeIn">
        <table class="min-w-full text-sm text-left text-gray-800 animate-fadeUp">
            <thead class="bg-grabg-[#EEF6FB] text-[#27374D] uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama Pelanggan</th>
                    <th class="px-4 py-3">Treatment</th>
                    <th class="px-4 py-3">Dokter</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E6EDF3] bg-white">
                @forelse ($reservations as $r)
                    <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium">{{ $r->reservation_code }}</td>
                        <td class="px-4 py-3">{{ $r->customer_name }}</td>
                        <td class="px-4 py-3">{{ $r->treatment->name }}</td>
                        <td class="px-4 py-3">{{ $r->doctor->name }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $r->reservation_time }}</td>
                        <td class="px-4 py-3">
                            @switch($r->status)
                                @case('pending')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @break

                                @case('confirmed')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Confirmed
                                    </span>
                                @break

                                @case('completed')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @break

                                @case('cancelled')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                @break
                            @endswitch
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center flex-wrap gap-2">

                                {{-- Jika reservasi masih pending --}}
                                @if ($r->status === 'pending')
                                    <form id="confirm-form-{{ $r->id }}"
                                        action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="button" onclick="openModal('confirm', {{ $r->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 border border-blue-200
                                               hover:bg-blue-200 hover:text-blue-900 hover:shadow-md hover:border-blue-400
                                               active:scale-95 rounded-full transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 11V7m0 8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Konfirmasi
                                        </button>
                                    </form>


                                    <form id="cancel-form-{{ $r->id }}"
                                        action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-red-800 bg-red-100 border border-red-200
                                                   hover:bg-red-200 hover:text-red-900 hover:shadow-md hover:border-red-400
                                                   active:scale-95 rounded-full transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>

                                    {{-- Jika reservasi sudah dikonfirmasi --}}
                                @elseif ($r->status === 'confirmed')
                                    <form id="done-form-{{ $r->id }}"
                                        action="{{ route('admin.reservasi.selesai', $r->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="button" onclick="openModal('done', {{ $r->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-green-800 bg-green-100 border border-green-200
                                               hover:bg-green-200 hover:text-green-900 hover:shadow-md hover:border-green-400
                                               active:scale-95 rounded-full transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Tandai Selesai
                                        </button>
                                    </form>


                                    <form id="cancel-form-{{ $r->id }}"
                                        action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="button" onclick="openModal('cancel', {{ $r->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-red-800 bg-red-100 border border-red-200
                                                   hover:bg-red-200 hover:text-red-900 hover:shadow-md hover:border-red-400
                                                   active:scale-95 rounded-full transition-all duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>

                                    {{-- Jika sudah selesai atau dibatalkan --}}
                                @else
                                    <button disabled
                                        class="px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                        Tidak ada aksi
                                    </button>
                                @endif

                            </div>
                        </td>

                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                Belum ada data reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($reservations->hasPages())
            <nav role="navigation" aria-label="Pagination" class="mt-6">
                <ul class="flex items-center justify-center gap-2 text-sm font-medium">

                    {{-- Previous --}}
                    @if ($reservations->onFirstPage())
                        <li class="px-3 py-2 rounded-xl text-(--color-muted-foreground) cursor-not-allowed">
                            <span aria-hidden="true">‹</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $reservations->previousPageUrl() }}"
                                class="px-3 py-2 rounded-xl text-(--color-foreground) hover:bg-(--color-primary) hover:text-(--color-primary-foreground) transition">
                                ‹
                            </a>
                        </li>
                    @endif

                    {{-- Pages (simple loop sehingga tidak bergantung pada vendor view) --}}
                    @for ($page = 1; $page <= $reservations->lastPage(); $page++)
                        @if ($page == $reservations->currentPage())
                            <li>
                                <span
                                    class="px-3 py-2 rounded-xl bg-(--color-primary) text-(--color-primary-foreground) font-semibold shadow-sm">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $reservations->url($page) }}"
                                    class="px-3 py-2 rounded-xl text-(--color-foreground) hover:bg-(--color-card) hover:text-(--color-primary) transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if ($reservations->hasMorePages())
                        <li>
                            <a href="{{ $reservations->nextPageUrl() }}"
                                class="px-3 py-2 rounded-xl text-(--color-foreground) hover:bg-(--color-primary) hover:text-(--color-primary-foreground) transition">
                                ›
                            </a>
                        </li>
                    @else
                        <li class="px-3 py-2 rounded-xl text-(--color-muted-foreground) cursor-not-allowed">
                            <span aria-hidden="true">›</span>
                        </li>
                    @endif

                </ul>
            </nav>
        @endif

        {{-- Modal Konfirmasi Aksi --}}
        <div id="confirmModal"
            class="fixed inset-0 hidden items-center justify-center z-50 bg-[#EEF2F7]/80 transition-all duration-300">
            <div
                class="bg-white rounded-2xl shadow-2xl p-8 w-[90%] max-w-md text-center animate-fadeIn border border-[#D9E1EC]">
                <h3 id="modalTitle" class="text-xl font-bold text-[#27374D] mb-4">Konfirmasi Aksi</h3>
                <p id="modalMessage" class="text-[#526D82] mb-6">Apakah Anda yakin ingin melanjutkan aksi ini?</p>
                <div class="flex justify-center gap-4">
                    <button id="cancelBtn"
                        class="px-6 py-2 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition font-medium">
                        Batal
                    </button>
                    <button id="confirmBtn"
                        class="px-6 py-2 rounded-lg bg-[#3B82F6] text-white font-medium hover:bg-[#2563EB] ">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            @keyframes fadeInSlow {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }

            .animate-fadeInSlow {
                animation: fadeInSlow 0.6s ease-out;
            }

            .animate-fadeUp {
                animation: fadeUp 0.5s ease-out;
            }
        </style>

        <script>
            let actionType = null;
            let actionId = null;

            function openModal(type, id) {
                actionType = type;
                actionId = id;

                const modal = document.getElementById('confirmModal');
                const title = document.getElementById('modalTitle');
                const message = document.getElementById('modalMessage');
                const confirmBtn = document.getElementById('confirmBtn');

                // Sesuaikan isi modal berdasarkan tipe aksi
                if (type === 'cancel') {
                    title.textContent = 'Konfirmasi Pembatalan';
                    message.textContent =
                        'Apakah Anda yakin ingin membatalkan reservasi ini? Tindakan ini tidak dapat dibatalkan.';
                    confirmBtn.textContent = 'Ya, Batalkan';
                    confirmBtn.className =
                        'px-6 py-2 rounded-lg bg-red-500 text-white font-medium hover:bg-[#C53030] shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-red-600';
                } else if (type === 'confirm') {
                    title.textContent = 'Konfirmasi Reservasi';
                    message.textContent = 'Apakah Anda yakin ingin mengonfirmasi reservasi ini?';
                    confirmBtn.textContent = 'Ya, Konfirmasi';
                    confirmBtn.className =
                        'px-6 py-2 rounded-lg bg-primary text-white font-medium hover:bg-[#2563EB] shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-primary';
                } else if (type === 'done') {
                    title.textContent = 'Konfirmasi Penyelesaian';
                    message.textContent = 'Apakah Anda yakin reservasi ini telah selesai?';
                    confirmBtn.textContent = 'Ya, Tandai Selesai';
                    confirmBtn.className =
                        'px-6 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white font-medium hover:bg-[#15803D] shadow-md hover:shadow-xl hover:from-10% hover:to-50% active:scale-95 transition-all duration-300 focus:ring-2 focus:ring-offset-2 focus:ring-green-500';
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            document.getElementById('cancelBtn').addEventListener('click', () => {
                const modal = document.getElementById('confirmModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            document.getElementById('confirmBtn').addEventListener('click', () => {
                if (!actionId || !actionType) return;

                let formId = '';
                if (actionType === 'cancel') formId = `cancel-form-${actionId}`;
                else if (actionType === 'confirm') formId = `confirm-form-${actionId}`;
                else if (actionType === 'done') formId = `done-form-${actionId}`;

                const form = document.getElementById(formId);
                if (form) {
                    form.submit();
                } else {
                    console.error('Form tidak ditemukan:', formId);
                }

                const modal = document.getElementById('confirmModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        </script>

    @endsection
