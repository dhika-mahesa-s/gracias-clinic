@php use Illuminate\Support\Facades\Storage; @endphp

@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4">
  <div class="container mx-auto max-w-6xl">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <h2 class="text-3xl font-bold text-[#27374D]">
        Manajemen Treatment
      </h2>
      <div class="flex flex-wrap gap-3 w-full sm:w-auto">
        <a href="{{ route('treatments.create') }}"
           class="flex-1 sm:flex-none px-5 py-2.5 rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 text-white shadow-md font-medium text-center">
           + Tambah Treatment
        </a>
        <a href="{{ route('treatments.index') }}"
           class="flex-1 sm:flex-none px-5 py-2.5 rounded-lg border border-[#526D82] text-[#526D82] hover:bg-[#526D82] hover:text-white transition shadow-sm font-medium text-center">
           Halaman Treatment
        </a>
      </div>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
      <div class="mb-6 p-4 bg-[#E6F6EA] border border-[#BEE7C6] text-[#166534] rounded-lg text-center font-medium">
        {{ session('success') }}
      </div>
    @endif

    {{-- Wrapper tabel responsif --}}
    <div class="bg-[#F3F6FB] border border-[#D9E1EC] rounded-2xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-[#27374D]">
          <thead class="bg-[#EEF6FB] text-[#27374D] uppercase text-xs font-semibold">
            <tr>
              <th class="py-3 px-4 whitespace-nowrap">ID</th>
              <th class="py-3 px-4 whitespace-nowrap">Nama</th>
              <th class="py-3 px-4 whitespace-nowrap">Harga</th>
              <th class="py-3 px-4 whitespace-nowrap">Durasi</th>
              <th class="py-3 px-4 whitespace-nowrap">Deskripsi</th>
              <th class="py-3 px-4 whitespace-nowrap">Gambar</th>
              <th class="py-3 px-4 whitespace-nowrap">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#E6EDF3] bg-white">
            @foreach($treatments as $t)
            <tr class="hover:bg-[#F8FBFF] transition">
              <td class="py-3 px-4 font-medium text-center">{{ $t->id }}</td>
              <td class="py-3 px-4 font-semibold">{{ $t->name }}</td>
              <td class="py-3 px-4 text-center">Rp {{ number_format($t->price, 0, ',', '.') }}</td>
              <td class="py-3 px-4 text-center">{{ $t->duration }} menit</td>
              <td class="py-3 px-4 text-[#526D82]">{{ Str::limit($t->description, 60) }}</td>
              <td class="py-3 px-4 text-center">
                @if($t->image)
                  <img src="{{ Storage::url($t->image) }}" alt="img"
                       class="w-14 h-14 object-cover rounded-lg border border-[#D9E1EC] shadow-sm mx-auto">
                @else
                  <span class="text-gray-400">-</span>
                @endif
              </td>
              <td class="py-3 px-4">
                <div class="flex flex-wrap justify-center gap-2">
                  <a href="{{ route('treatments.edit', $t) }}"
                     class="px-3 py-1.5 bg-primary hover:bg-primary/90 transition-all duration-300 text-white rounded-lg text-sm shadow-sm w-full sm:w-auto text-center">
                     ✏️ Edit
                  </a>

                  <form action="{{ route('treatments.destroy', $t) }}" method="POST"
                        onsubmit="return confirm('Hapus treatment ini?')" class="inline w-full sm:w-auto">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 bg-[#E53E3E] text-white rounded-lg text-sm hover:bg-[#C53030] transition shadow-sm w-full sm:w-auto">
                            🗑️ Hapus
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
@endsection
