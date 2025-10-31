@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] text-[#526D82] py-10 px-4">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-bold text-[#27374D]">Manajemen Jadwal Dokter</h2>
      <a href="{{ route('schedules.create') }}"
         class="px-5 py-2.5 rounded-lg bg-[#27374D] text-white hover:bg-[#1f2e45] transition shadow-md font-medium">
         + Tambah Jadwal
      </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
      <div class="mb-6 p-4 bg-[#E6F6EA] border border-[#BEE7C6] text-[#166534] rounded-lg text-center font-medium">
        {{ session('success') }}
      </div>
    @endif

    {{-- Tabel responsif --}}
    <div class="overflow-x-auto bg-gray-100 border border-gray-300 rounded-2xl shadow-sm">
      <table class="min-w-full text-sm text-[#27374D]">
        <thead class="bg-[#DDE6ED] text-[#27374D] uppercase text-xs font-semibold">
          <tr>
            <th class="py-3 px-4 text-center">No</th>
            <th class="py-3 px-4 text-left">Dokter</th>
            <th class="py-3 px-4 text-center">Hari</th>
            <th class="py-3 px-4 text-center">Waktu</th>
            <th class="py-3 px-4 text-center">Kuota</th>
            <th class="py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 bg-white">
          @forelse($schedules as $index => $schedule)
            <tr class="hover:bg-[#F8FAFC] transition">
              <td class="py-3 px-4 text-center font-medium">{{ $index + 1 }}</td>
              <td class="py-3 px-4 font-semibold">{{ $schedule->doctor->name ?? '-' }}</td>
              <td class="py-3 px-4 text-center capitalize">{{ $schedule->day_of_week }}</td>
              <td class="py-3 px-4 text-center">
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
              </td>
              <td class="py-3 px-4 text-center">{{ $schedule->quota }}</td>
              <td class="py-3 px-4 text-center">
                <button 
                  onclick="openModal({{ $schedule->id }})"
                  class="px-3 py-1.5 bg-[#E53E3E] text-white rounded-lg text-sm hover:bg-[#C53030] transition shadow-sm">
                  🗑️ Hapus
                </button>

                {{-- Hidden form for deletion --}}
                <form id="delete-form-{{ $schedule->id }}" 
                      action="{{ route('schedules.destroy', $schedule->id) }}" 
                      method="POST" class="hidden">
                  @csrf
                  @method('DELETE')
                </form>
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

 {{-- Modal Popup Konfirmasi --}}
<div id="confirmModal" 
     class="fixed inset-0 hidden items-center justify-center z-50 bg-[#F1F5F9]/70 transition-all duration-300">
  <div class="bg-white rounded-2xl shadow-2xl p-8 w-[90%] max-w-md text-center animate-fadeIn border border-[#DDE6ED]">
    <h3 class="text-xl font-bold text-[#27374D] mb-4">Konfirmasi Penghapusan</h3>
    <p class="text-[#526D82] mb-6">
      Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.
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


{{-- Animasi popup --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
  animation: fadeIn 0.25s ease-out;
}
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
