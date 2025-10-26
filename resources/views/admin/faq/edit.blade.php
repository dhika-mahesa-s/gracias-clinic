@extends('layouts.app')

@section('title', 'Edit FAQ - Gracias Clinic')

@section('content')
<div class="max-w-2xl mx-auto mt-24 bg-white rounded-2xl shadow-lg p-10">
    <h1 class="text-2xl font-semibold text-center text-gray-800 mb-8">Edit FAQ</h1>

    <form action="{{ url('admin/faq/'.$faq->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="question" class="block text-gray-700 font-medium mb-2">Pertanyaan:</label>
            <input type="text" name="question" id="question"
                   value="{{ $faq->question }}"
                   required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">
        </div>

        <div>
            <label for="answer" class="block text-gray-700 font-medium mb-2">Jawaban:</label>
            <textarea name="answer" id="answer" rows="4" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">{{ $faq->answer }}</textarea>
        </div>

        <div class="flex justify-end gap-4">
            <button type="submit" class="bg-teal-700 hover:bg-teal-600 text-white px-5 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
            <a href="{{ url('admin/faq') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-xmark"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
