@extends('layouts.app')

@section('title', 'Edit FAQ - Gracias Clinic')

@section('content')
<div class="max-w-2xl mx-auto mt-24 bg-white rounded-2xl shadow-lg p-10">
    <h1 class="text-2xl font-semibold text-center mb-8 text-gray-800">Edit FAQ</h1>

    <form id="editFaqForm" action="{{ url('admin/faq/'.$faq->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="question" class="block text-gray-700 font-medium mb-2">Pertanyaan:</label>
            <input type="text" id="question" name="question"
                   value="{{ $faq->question }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">
        </div>

        <div>
            <label for="answer" class="block text-gray-700 font-medium mb-2">Jawaban:</label>
            <textarea id="answer" name="answer" rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-teal-700 focus:ring-2 focus:ring-teal-300 outline-none transition">{{ $faq->answer }}</textarea>
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

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('editFaqForm').addEventListener('submit', function(event) {
    const question = document.getElementById('question').value.trim();
    const answer = document.getElementById('answer').value.trim();

    // Validasi: jika kosong, tampilkan pesan error
    if (!question || !answer) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan!',
            text: 'Pertanyaan dan Jawaban wajib diisi.',
            confirmButtonColor: '#0d9488'
        });
        return;
    }

    // Jika terisi, tampilkan pop-up sukses sebelum submit
    event.preventDefault();
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'FAQ berhasil diperbarui.',
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        event.target.submit();
    });
});
</script>
@endsection
