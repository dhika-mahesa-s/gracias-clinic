@php use Illuminate\Support\Facades\Storage; @endphp

@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
  <div class="max-w-7xl mx-auto">

    {{-- Header Section --}}
    <div class="mb-8 animate-fade-in">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2 flex items-center gap-3">
            <div class="p-2 bg-primary rounded-xl">
              <i class="fa-solid fa-calendar-days text-primary-foreground text-2xl"></i>
            </div>
            Kelola Jadwal Dokter
          </h1>
          <p class="text-muted-foreground ml-14">Manajemen jadwal praktik dokter</p>
        </div>
        <a href="{{ route('schedules.create') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
           <i class="fa-solid fa-plus"></i>
           <span>Tambah Jadwal</span>
        </a>
      </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3 shadow-sm animate-slide-down">
        <div class="flex-shrink-0">
          <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
        </div>
        <div class="flex-1">
          <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
      </div>
    @endif

    {{-- Schedule Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($schedules as $index => $schedule)
        @php
          $delays = ['', 'delay-75', 'delay-100', 'delay-150', 'delay-200', 'delay-250'];
          $delayClass = $delays[$index % 6] ?? '';
        @endphp
        <div class="bg-card rounded-2xl shadow-md hover:shadow-xl transition-smooth overflow-hidden border border-border hover-lift animate-slide-up {{ $delayClass }}">
          {{-- Card Header --}}
          <div class="p-6 bg-muted border-b border-border">
            <div class="flex items-start justify-between mb-3">
              <div class="flex items-center gap-3">
                <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-xl flex items-center justify-center shadow-lg">
                  <i class="fa-solid fa-user-doctor text-primary-foreground text-xl"></i>
                </div>
                <div>
                  <h3 class="text-lg font-bold text-card-foreground">{{ $schedule->doctor->name ?? '—' }}</h3>
                  <p class="text-xs text-muted-foreground">Dokter Praktik</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Card Body --}}
          <div class="p-6 space-y-4">
            {{-- Day --}}
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-calendar-day text-purple-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-xs text-muted-foreground mb-0.5">Hari Praktik</p>
                <p class="text-sm font-semibold text-card-foreground capitalize">{{ $schedule->day_of_week }}</p>
              </div>
            </div>

            {{-- Time --}}
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-clock text-blue-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-xs text-muted-foreground mb-0.5">Waktu Praktik</p>
                <p class="text-sm font-semibold text-card-foreground">
                  {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                  {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </p>
              </div>
            </div>

            {{-- Quota --}}
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-users text-green-600"></i>
              </div>
              <div class="flex-1">
                <p class="text-xs text-muted-foreground mb-0.5">Kuota Pasien</p>
                <p class="text-sm font-semibold text-card-foreground">{{ $schedule->quota }} Pasien</p>
              </div>
            </div>
          </div>

          {{-- Card Actions --}}
          <div class="p-4 bg-muted border-t border-border flex gap-2">
            <a href="{{ route('schedules.edit', $schedule->id) }}"
               class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-smooth shadow-sm hover:shadow hover-scale-sm active-press">
               <i class="fa-solid fa-pen-to-square"></i>
               <span>Edit</span>
            </a>

            <button 
              onclick="openDeleteModal({{ $schedule->id }})"
              class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-smooth shadow-sm hover:shadow hover-scale-sm active-press">
              <i class="fa-solid fa-trash"></i>
              <span>Hapus</span>
            </button>

            <form id="delete-form-{{ $schedule->id }}" 
                  action="{{ route('schedules.destroy', $schedule->id) }}" 
                  method="POST" class="hidden">
              @csrf
              @method('DELETE')
            </form>
          </div>
        </div>
      @empty
        <div class="col-span-full bg-card rounded-2xl shadow-md border border-border p-16 text-center animate-fade-in">
          <i class="fa-solid fa-calendar-xmark text-6xl text-muted mb-4"></i>
          <h3 class="text-xl font-semibold text-card-foreground mb-2">Belum Ada Jadwal</h3>
          <p class="text-muted-foreground mb-6">Mulai tambahkan jadwal praktik dokter</p>
          <a href="{{ route('schedules.create') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Jadwal Pertama</span>
          </a>
        </div>
      @endforelse
    </div>
  </div>
</section>

{{-- Modern Delete Confirmation Modal --}}
<div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm transition-smooth">
  <div class="bg-card rounded-2xl shadow-2xl max-w-md w-full transform transition-smooth scale-95 opacity-0" id="modalContent">
    <div class="p-6">
      {{-- Modal Icon --}}
      <div class="flex items-center justify-center mb-4">
        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
          <i class="fa-solid fa-triangle-exclamation text-3xl text-red-600"></i>
        </div>
      </div>

      {{-- Modal Title --}}
      <h3 class="text-2xl font-bold text-card-foreground text-center mb-3">Hapus Jadwal?</h3>

      {{-- Modal Message --}}
      <p class="text-muted-foreground text-center mb-6">Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.</p>

      {{-- Modal Actions --}}
      <div class="flex gap-3">
        <button id="cancelBtn"
          class="flex-1 px-6 py-3 rounded-xl border-2 border-border text-foreground font-semibold hover:bg-accent transition-smooth">
          Batal
        </button>
        <button id="confirmBtn"
          class="flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 transition-smooth shadow-lg hover:shadow-xl hover-scale-sm active-press">
          Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
  <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black bg-opacity-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-card rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
      <div class="p-6">
        {{-- Modal Icon --}}
        <div class="flex items-center justify-center mb-4">
          <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
            <i class="fa-solid fa-triangle-exclamation text-3xl text-red-600"></i>
          </div>
        </div>

        {{-- Modal Title --}}
        <h3 class="text-2xl font-bold text-card-foreground text-center mb-3">Hapus Jadwal?</h3>

        {{-- Modal Message --}}
        <p class="text-muted-foreground text-center mb-6">Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.</p>

        {{-- Modal Actions --}}
        <div class="flex gap-3">
          <button id="cancelBtn"
            class="flex-1 px-6 py-3 rounded-xl border-2 border-border text-foreground font-semibold hover:bg-accent transition-all duration-150">
            Batal
          </button>
          <button id="confirmBtn"
            class="flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 transition-all duration-150 shadow-lg hover:shadow-xl transform hover:scale-105">
            Ya, Hapus
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Scripts --}}
<script>
let deleteId = null;

function openDeleteModal(id) {
  deleteId = id;
  const modal = document.getElementById('confirmModal');
  const modalContent = document.getElementById('modalContent');

  modalContent.classList.remove('scale-100', 'opacity-100');
  modalContent.classList.add('scale-95', 'opacity-0');

  modal.classList.remove('hidden');
  modal.classList.add('flex');

  setTimeout(() => {
    modalContent.classList.remove('scale-95', 'opacity-0');
    modalContent.classList.add('scale-100', 'opacity-100');
  }, 10);
}

function closeModal() {
  const modal = document.getElementById('confirmModal');
  const modalContent = document.getElementById('modalContent');

  modalContent.classList.remove('scale-100', 'opacity-100');
  modalContent.classList.add('scale-95', 'opacity-0');

  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }, 300);
}

document.getElementById('cancelBtn').addEventListener('click', closeModal);

document.getElementById('confirmBtn').addEventListener('click', () => {
  if (deleteId) {
    document.getElementById(`delete-form-${deleteId}`).submit();
  }
  closeModal();
});

document.getElementById('confirmModal').addEventListener('click', (e) => {
  if (e.target.id === 'confirmModal') {
    closeModal();
  }
});
</script>
@endsection
