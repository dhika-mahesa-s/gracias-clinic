@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-background py-10 px-4">
  <div class="container mx-auto max-w-3xl">
    <div class="bg-card border border-border rounded-2xl shadow-md p-8 hover:shadow-lg transition-smooth animate-fade-in">
      
      {{-- Header --}}
      <h2 class="text-3xl font-bold text-card-foreground mb-6 flex items-center gap-2">
        <i class="fa-solid fa-calendar-pen text-primary"></i>
        Edit Jadwal Dokter
      </h2>

      {{-- Error Validation --}}
      @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg animate-slide-down">
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
        <div class="animate-slide-up delay-75">
          <label class="flex items-center gap-2 font-semibold text-card-foreground mb-2">
            <i class="fa-solid fa-user-md text-primary"></i> Pilih Dokter
          </label>
          <select name="doctor_id" 
                  class="w-full p-3 rounded-xl border border-input bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth">
            <option value="">-- Pilih Dokter --</option>
            @foreach($doctors as $doctor)
              <option value="{{ $doctor->id }}" {{ $doctor->id == $schedule->doctor_id ? 'selected' : '' }}>
                {{ $doctor->name }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Hari --}}
        <div class="animate-slide-up delay-100">
          <label class="flex items-center gap-2 font-semibold text-card-foreground mb-2">
            <i class="fa-solid fa-calendar-day text-primary"></i> Hari
          </label>
          <select name="day_of_week" 
                  class="w-full p-3 rounded-xl border border-input bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
              <option value="{{ $day }}" {{ $schedule->day_of_week == $day ? 'selected' : '' }}>
                {{ $day }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Waktu --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 animate-slide-up delay-150">
          <div>
            <label class="flex items-center gap-2 font-semibold text-card-foreground mb-2">
              <i class="fa-regular fa-clock text-primary"></i> Waktu Mulai
            </label>
            <input type="time" name="start_time" value="{{ $schedule->start_time }}"
                   class="w-full p-3 rounded-xl border border-input bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth">
          </div>
          <div>
            <label class="flex items-center gap-2 font-semibold text-card-foreground mb-2">
              <i class="fa-regular fa-hourglass-half text-primary"></i> Waktu Selesai
            </label>
            <input type="time" name="end_time" value="{{ $schedule->end_time }}"
                   class="w-full p-3 rounded-xl border border-input bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth">
          </div>
        </div>

        {{-- Kuota --}}
        <div class="animate-slide-up delay-200">
          <label class="flex items-center gap-2 font-semibold text-card-foreground mb-2">
            <i class="fa-solid fa-users text-primary"></i> Kuota
          </label>
          <input type="number" name="quota" value="{{ $schedule->quota }}"
                 class="w-full p-3 rounded-xl border border-input bg-background text-foreground focus:ring-2 focus:ring-ring focus:outline-none transition-smooth">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3 pt-6 animate-slide-up delay-250">
          <a href="{{ route('schedules.index') }}"
             class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-border text-foreground hover:bg-accent transition-smooth font-medium shadow-sm hover-scale-sm active-press">
            <i class="fa-solid fa-arrow-left"></i> Batal
          </a>
          <button type="submit"
                  class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 text-primary-foreground font-medium transition-smooth shadow-md hover-lift active-press">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>
      </form>

    </div>
  </div>
</section>
@endsection
