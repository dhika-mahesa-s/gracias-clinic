@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4">
  <div class="container mx-auto max-w-3xl">
    <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-md p-8 hover:shadow-lg transition-all duration-300">
      <h2 class="text-3xl font-bold text-[#27374D] mb-6">Tambah Jadwal Dokter</h2>

      {{-- Error Validation --}}
      @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
          <ul class="list-disc pl-6 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('schedules.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
          <label class="block font-semibold text-[#27374D] mb-2">Pilih Dokter</label>
          <select name="doctor_id" 
                  class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $doctor)
              <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block font-semibold text-[#27374D] mb-2">Hari</label>
          <select name="day_of_week" 
                  class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
              <option value="{{ $day }}">{{ $day }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-[#27374D] mb-2">Waktu Mulai</label>
            <input type="time" name="start_time" 
                   class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
          </div>
          <div>
            <label class="block font-semibold text-[#27374D] mb-2">Waktu Selesai</label>
            <input type="time" name="end_time" 
                   class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
          </div>
        </div>

        <div>
          <label class="block font-semibold text-[#27374D] mb-2">Kuota</label>
          <input type="number" name="quota" value="10"
                 class="w-full p-3 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D] focus:outline-none">
        </div>

        <div class="flex justify-end gap-3 pt-6">
          <a href="{{ route('schedules.index') }}"
             class="px-5 py-2.5 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition font-medium shadow-sm">
            Batal
          </a>
          <button type="submit"
                  class="px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 text-white font-medium transition-all duration-300 shadow-md">
            💾 Simpan Jadwal
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
