@extends('layouts.app')

@section('title', 'Tambah FAQ - Gracias Clinic')

@section('content')
<div class="max-w-2xl mx-auto mt-24 bg-white rounded-2xl shadow-lg p-10">
    <h1 class="text-2xl font-semibold text-center mb-8 text-gray-800">Tambah FAQ Baru</h1>

    <form action="{{ url('admin/faq') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="question" class="block text-gray-700 font-medium mb-2">Pertanyaan:</label>
            <input type="text" id="question" name="question" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">
        </div>

        <div>
            <label for="answer" class="block text-gray-700 font-medium mb-2">Jawaban:</label>
            <textarea id="answer" name="answer" rows="4" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition"></textarea>
        </div>

        <div class="flex justify-end gap-4 pt-2">
            <a href="{{ url('admin/faq') }}"
               class="inline-flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-5 py-2 rounded-lg transition">
                <i class="fa-solid fa-xmark mr-2"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center bg-teal-700 hover:bg-teal-600 text-white text-sm px-5 py-2 rounded-lg transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
