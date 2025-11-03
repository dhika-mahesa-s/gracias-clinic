@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4 animate-fadeIn">
  <div class="container mx-auto max-w-3xl">
    <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-md p-8 hover:shadow-lg transition-all duration-300 animate-fadeUp">
      
      {{-- Header --}}
      <h2 class="text-3xl font-bold text-[#27374D] mb-6 flex items-center gap-2">
        <i class="fa-solid fa-calendar-pen text-[#27374D]"></i>
        Edit Jadwal Dokter
      </h2>

      {{-- Error Validation --}}
      @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg animate-fadeInSlow">
          <ul class="list-disc pl-6 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Form Edit Jadwal --}}
      <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Dokter --}}
        <div>
          <label class="block font-semibold text-[#27374D] mb-2 flex items-center gap-2">
            <i class="fa-solid fa-user-md text-[#27374D]"></i> Pilih Dokter
          </label>
          <select name="doctor_id" 
                  class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $doctor)
              <option value="{{ $doctor->id }}" {{ $doctor->id == $schedule->doctor_id ? 'selected' : '' }}>
                {{ $doctor->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Hari --}}
        <div>
          <label class="block font-semibold text-[#27374D] mb-2 flex items-center gap-2">
            <i class="fa-solid fa-calendar-day text-[#27374D]"></i> Hari
          </label>
          <select name="day_of_week" 
                  class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
              <option value="{{ $day }}" {{ $schedule->day_of_week == $day ? 'selected' : '' }}>
                {{ $day }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Waktu --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-[#27374D] mb-2 flex items-center gap-2">
              <i class="fa-regular fa-clock text-[#27374D]"></i> Waktu Mulai
            </label>
            <input type="time" name="start_time" value="{{ $schedule->start_time }}"
                   class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
          </div>
          <div>
            <label class="block font-semibold text-[#27374D] mb-2 flex items-center gap-2">
              <i class="fa-regular fa-hourglass-half text-[#27374D]"></i> Waktu Selesai
            </label>
            <input type="time" name="end_time" value="{{ $schedule->end_time }}"
                   class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
          </div>
        </div>

        {{-- Kuota --}}
        <div>
          <label class="block font-semibold text-[#27374D] mb-2 flex items-center gap-2">
            <i class="fa-solid fa-users text-[#27374D]"></i> Kuota
          </label>
          <input type="number" name="quota" value="{{ $schedule->quota }}"
                 class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3 pt-6">
          <a href="{{ route('schedules.index') }}"
             class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition font-medium shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> Batal
          </a>
          <button type="submit"
                  class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 text-white font-medium transition-all duration-300 shadow-md">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>
      </form>

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
@endsection
