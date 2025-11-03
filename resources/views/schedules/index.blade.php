@php use Illuminate\Support\Facades\Storage; @endphp

@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4 animate-fadeIn">
  <div class="container mx-auto max-w-6xl transition-all duration-500">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <h2 class="text-3xl font-bold text-[#27374D] flex items-center gap-2">
        <i class="fa-solid fa-calendar-days text-[#27374D]"></i>
        Manajemen Jadwal Dokter
      </h2>
      <div class="flex flex-wrap gap-3 w-full sm:w-auto">
        <a href="{{ route('schedules.create') }}"
           class="flex items-center justify-center gap-2 flex-1 sm:flex-none px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 text-white shadow-md font-medium text-center">
           <i class="fa-solid fa-plus"></i> Tambah Jadwal
        </a>
      </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
      <div class="mb-6 p-4 bg-[#E6F6EA] border border-[#BEE7C6] text-[#166534] rounded-lg text-center font-medium animate-fadeInSlow">
        <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
      </div>
    @endif

    {{-- Wrapper tabel responsif --}}
    <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-sm overflow-hidden animate-fadeUp">
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-[#27374D]">
          <thead class="bg-[#EEF6FB] text-[#27374D] uppercase text-xs font-semibold">
            <tr>
              <th class="py-3 px-4 whitespace-nowrap text-center">No</th>
              <th class="py-3 px-4 whitespace-nowrap text-left">Dokter</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Hari</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Waktu</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Kuota</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#E6EDF3] bg-white">
            @forelse($schedules as $index => $schedule)
              <tr class="hover:bg-[#F8FBFF] transition duration-300">
                <td class="py-3 px-4 text-center font-medium">{{ $index + 1 }}</td>
                <td class="py-3 px-4 font-semibold">{{ $schedule->doctor->name ?? '-' }}</td>
                <td class="py-3 px-4 text-center capitalize">{{ $schedule->day_of_week }}</td>
                <td class="py-3 px-4 text-center">
                  {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                  {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </td>
                <td class="py-3 px-4 text-center">{{ $schedule->quota }}</td>
                <td class="py-3 px-4">
                  <div class="flex flex-wrap justify-center gap-2">

                    {{-- Tombol Edit --}}
                    <a href="{{ route('schedules.edit', $schedule->id) }}"
                       class="flex items-center gap-2 px-3 py-1.5 bg-primary hover:bg-primary/90 transition-all duration-300 text-white rounded-lg text-sm shadow-sm w-full sm:w-auto text-center">
                       <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>

                    {{-- Tombol Hapus --}}
                    <button 
                      onclick="openModal({{ $schedule->id }})"
                      class="flex items-center gap-2 px-3 py-1.5 bg-[#E53E3E] text-white rounded-lg text-sm hover:bg-[#C53030] transition-all duration-300 shadow-sm w-full sm:w-auto">
                      <i class="fa-solid fa-trash"></i> Hapus
                    </button>

                    {{-- Hidden form for deletion --}}
                    <form id="delete-form-{{ $schedule->id }}" 
                          action="{{ route('schedules.destroy', $schedule->id) }}" 
                          method="POST" class="hidden">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada jadwal yang ditambahkan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{-- Modal Konfirmasi Hapus --}}
  <div id="confirmModal" 
       class="fixed inset-0 hidden items-center justify-center z-50 bg-[#EEF2F7]/80 transition-all duration-300 animate-fadeIn">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-[90%] max-w-md text-center animate-fadeIn border border-[#D9E1EC]">
      <i class="fa-solid fa-triangle-exclamation text-[#E53E3E] text-4xl mb-3"></i>
      <h3 class="text-xl font-bold text-[#27374D] mb-3">Konfirmasi Penghapusan</h3>
      <p class="text-[#526D82] mb-6">
        Apakah Anda yakin ingin menghapus jadwal ini?<br>Tindakan ini tidak dapat dibatalkan.
      </p>
      <div class="flex justify-center gap-4">
        <button 
          id="cancelBtn"
          class="px-6 py-2 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition font-medium">
          Batal
        </button>
        <button 
          id="confirmBtn"
          class="px-6 py-2 rounded-lg bg-[#E53E3E] text-white font-medium hover:bg-[#C53030] transition shadow-md">
          Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</section>

{{-- Animasi modern --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.97); }
  to { opacity: 1; transform: scale(1); }
}
@keyframes fadeInSlow {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.3s ease-out; }
.animate-fadeInSlow { animation: fadeInSlow 0.6s ease-out; }
.animate-fadeUp { animation: fadeUp 0.5s ease-out; }
</style>

{{-- Script Modal --}}
<script>
let deleteId = null;

function openModal(id) {
  deleteId = id;
  document.getElementById('confirmModal').classList.remove('hidden');
  document.getElementById('confirmModal').classList.add('flex');
}

document.getElementById('cancelBtn').addEventListener('click', () => {
  document.getElementById('confirmModal').classList.add('hidden');
});

document.getElementById('confirmBtn').addEventListener('click', () => {
  if (deleteId) {
    document.getElementById(`delete-form-${deleteId}`).submit();
  }
});
</script>
@endsection
