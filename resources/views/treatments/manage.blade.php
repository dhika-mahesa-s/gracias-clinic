@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-6">
        <!-- Judul Halaman -->
        <h3 class="text-3xl font-bold text-center text-gray-800 mb-8">Daftar Treatment</h3>

        <!-- Tombol Aksi -->
        <div class="flex justify-center mb-6 space-x-4">
            <a href="{{ route('treatments.create') }}" 
               class="px-6 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-md transition">
               + Tambahkan Treatment
            </a>
            <a href="{{ route('treatments.index') }}" 
               class="px-6 py-2 bg-gray-300 text-gray-800 rounded-xl hover:bg-gray-400 shadow-md transition">
               Lihat Halaman Treatment
            </a>
        </div>

        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="max-w-xl mx-auto mb-6 p-4 bg-green-100 text-green-700 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Treatment -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
            <table class="min-w-full text-gray-800 text-sm text-center">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Harga</th>
                        <th class="py-3 px-4">Durasi</th>
                        <th class="py-3 px-4">Deskripsi</th>
                        <th class="py-3 px-4">Gambar</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($treatments as $t)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-medium">{{ $t->id }}</td>
                        <td class="py-3 px-4 font-semibold text-gray-700">{{ $t->name }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($t->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">{{ $t->duration }} menit</td>
                        <td class="py-3 px-4 text-gray-500">{{ Str::limit($t->description, 60) }}</td>
                        <td class="py-3 px-4">
                            @if($t->image)
                                <img src="{{ Storage::url($t->image) }}" alt="img" class="w-14 h-14 object-cover rounded-lg mx-auto">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('treatments.edit', $t) }}" 
                                   class="px-3 py-1 bg-emerald-500 text-white text-sm rounded-lg hover:bg-emerald-600 transition">
                                   Edit
                                </a>
                                <form action="{{ route('treatments.destroy', $t) }}" method="POST" 
                                      onsubmit="return confirm('Hapus treatment ini?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition">
                                        Hapus
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
</section>
@endsection
