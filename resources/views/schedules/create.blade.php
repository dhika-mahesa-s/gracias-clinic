@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#F1F5F9] py-10 px-6 text-[#526D82]">
  <div class="container mx-auto max-w-3xl">
    <div class="bg-gray-100 border border-gray-300 rounded-2xl shadow-md p-8">
      <h2 class="text-3xl font-bold text-[#27374D] mb-6">Tambah Jadwal Dokter</h2>

      @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
          <ul class="list-disc pl-6">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('schedules.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
          <label class="block font-semibold text-[#27374D] mb-1">Pilih Dokter</label>
          <select name="doctor_id" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D]">
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $doctor)
              <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block font-semibold text-[#27374D] mb-1">Hari</label>
          <select name="day_of_week" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D]">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
              <option value="{{ $day }}">{{ $day }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-[#27374D] mb-1">Waktu Mulai</label>
            <input type="time" name="start_time" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D]">
          </div>
          <div>
            <label class="block font-semibold text-[#27374D] mb-1">Waktu Selesai</label>
            <input type="time" name="end_time" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D]">
          </div>
        </div>

        <div>
          <label class="block font-semibold text-[#27374D] mb-1">Kuota</label>
          <input type="number" name="quota" value="10" class="w-full p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-[#27374D]">
        </div>

        <div class="flex justify-end gap-3 pt-4">
          <a href="{{ route('schedules.index') }}" class="px-5 py-2.5 border border-[#526D82] text-[#526D82] rounded-lg hover:bg-[#526D82] hover:text-white transition shadow-sm">Batal</a>
          <button type="submit" class="px-5 py-2.5 bg-[#27374D] text-white font-semibold rounded-lg hover:bg-[#1f2e45] transition shadow-md">
            💾 Simpan Jadwal
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
