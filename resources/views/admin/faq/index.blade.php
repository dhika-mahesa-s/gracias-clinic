@extends('layouts.dashboard')

@section('title', 'Kelola FAQ - Gracias Clinic')

@section('content')
<div class="max-w-6xl mx-auto mt-24 bg-white rounded-2xl shadow-lg p-10">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Kelola FAQ</h2>
        <a href="{{ url('admin/faq/create') }}" 
           class="inline-flex items-center bg-teal-700 hover:bg-teal-600 text-white text-sm px-4 py-2 rounded-lg transition">
            <i class="fa-solid fa-plus mr-2"></i> Tambah FAQ
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="border-b border-gray-200 px-4 py-3 text-left">Pertanyaan</th>
                    <th class="border-b border-gray-200 px-4 py-3 text-left">Jawaban</th>
                    <th class="border-b border-gray-200 px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr class="even:bg-gray-50 hover:bg-gray-100 transition">
                    <td class="border-b border-gray-200 px-4 py-3 align-top">
                        {{ $faq->question ?? $faq->pertanyaan }}
                    </td>
                    <td class="border-b border-gray-200 px-4 py-3 align-top">
                        {{ $faq->answer ?? $faq->jawaban }}
                    </td>
                    <td class="border-b border-gray-200 px-4 py-3">
                        <div class="flex space-x-3">
                            <a href="{{ url('admin/faq/'.$faq->id.'/edit') }}" 
                               class="text-blue-600 hover:text-blue-800 transition" 
                               title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ url('admin/faq/'.$faq->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 transition" 
                                        title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500 italic">
                        Belum ada data FAQ
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tambahkan padding bawah biar nggak nempel ke footer --}}
<div class="pb-20"></div>
@endsection
