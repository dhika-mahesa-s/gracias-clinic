@php use Illuminate\Support\Facades\Storage; @endphp

@extends('layouts.dashboard')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4 animate-fadeIn">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <h2 class="text-3xl font-bold text-[#27374D] flex items-center gap-2">
        <i class="fa-solid fa-spa text-[#27374D]"></i>
        Manajemen Treatment
      </h2>
      <div class="flex flex-wrap gap-3 w-full sm:w-auto">
        <a href="{{ route('treatments.create') }}"
           class="flex items-center justify-center gap-2 flex-1 sm:flex-none px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 text-white shadow-md font-medium text-center">
           <i class="fa-solid fa-plus"></i> Tambah Treatment
        </a>
        <a href="{{ route('treatments.index') }}"
           class="flex items-center justify-center gap-2 flex-1 sm:flex-none px-5 py-2.5 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition-all duration-300 shadow-sm font-medium text-center">
           <i class="fa-solid fa-arrow-rotate-left"></i> Halaman Treatment
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
              <th class="py-3 px-4 whitespace-nowrap text-center">ID</th>
              <th class="py-3 px-4 whitespace-nowrap">Nama</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Harga</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Durasi</th>
              <th class="py-3 px-4 whitespace-nowrap">Deskripsi</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Gambar</th>
              <th class="py-3 px-4 whitespace-nowrap text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#E6EDF3] bg-white">
            @foreach($treatments as $t)
            <tr class="hover:bg-[#F8FBFF] transition duration-300">
              <td class="py-3 px-4 font-medium text-center">{{ $t->id }}</td>
              <td class="py-3 px-4 font-semibold">{{ $t->name }}</td>
              <td class="py-3 px-4 text-center">Rp {{ number_format($t->price, 0, ',', '.') }}</td>
              <td class="py-3 px-4 text-center">{{ $t->duration }} menit</td>
              <td class="py-3 px-4 text-[#526D82]">{{ Str::limit($t->description, 60) }}</td>
              <td class="py-3 px-4 text-center">
                @if($t->image)
                  <img src="{{ Storage::url($t->image) }}" alt="img"
                       class="w-14 h-14 object-cover rounded-lg border border-[#D9E1EC] shadow-sm mx-auto hover:scale-105 transition-transform duration-300">
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
              <td class="py-3 px-4">
                <div class="flex flex-wrap justify-center gap-2">

                  {{-- Tombol Edit --}}
                  <a href="{{ route('treatments.edit', $t) }}"
                     class="flex items-center gap-2 px-3 py-1.5 bg-primary hover:bg-primary/90 transition-all duration-300 text-white rounded-lg text-sm shadow-sm w-full sm:w-auto text-center">
                     <i class="fa-solid fa-pen-to-square"></i> Edit
                  </a>

                  {{-- Tombol Hapus --}}
                  <form action="{{ route('treatments.destroy', $t) }}" method="POST"
                        onsubmit="return confirm('Hapus treatment ini?')" class="inline w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-2 px-3 py-1.5 bg-[#E53E3E] text-white rounded-lg text-sm hover:bg-[#C53030] transition-all duration-300 shadow-sm w-full sm:w-auto">
                            <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                  </form>

                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
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
@endsection
