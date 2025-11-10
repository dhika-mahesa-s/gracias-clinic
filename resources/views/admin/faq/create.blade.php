@extends('layouts.dashboard')

@section('title', 'Tambah FAQ - Gracias Clinic')

@section('content')
<div class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-card rounded-2xl shadow-lg p-10 border border-border animate-fade-in">
            <h1 class="text-2xl font-semibold text-center mb-8 text-card-foreground">Tambah FAQ Baru</h1>

            <form id="faqForm" action="{{ url('admin/faq') }}" method="POST" class="space-y-6">
                @csrf

                <div class="animate-slide-up delay-75">
                    <label for="question" class="block text-foreground font-medium mb-2">Pertanyaan:</label>
                    <input type="text" id="question" name="question"
                           class="w-full border border-input rounded-lg px-4 py-2 focus:border-ring focus:ring-2 focus:ring-ring outline-none transition-smooth bg-background text-foreground">
                </div>

                <div class="animate-slide-up delay-100">
                    <label for="answer" class="block text-foreground font-medium mb-2">Jawaban:</label>
                    <textarea id="answer" name="answer" rows="4"
                              class="w-full border border-input rounded-lg px-4 py-2 focus:border-ring focus:ring-2 focus:ring-ring outline-none transition-smooth bg-background text-foreground"></textarea>
                </div>

                <div class="flex justify-end gap-4 pt-2 animate-slide-up delay-150">
                    <a href="{{ url('admin/faq') }}"
                       class="inline-flex items-center bg-muted hover:bg-accent text-foreground text-sm px-5 py-2 rounded-lg transition-smooth hover-scale-sm active-press">
                        <i class="fa-solid fa-xmark mr-2"></i> Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center bg-primary hover:bg-primary/90 text-primary-foreground text-sm px-5 py-2 rounded-lg transition-smooth hover-lift active-press">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('faqForm').addEventListener('submit', function(event) {
    const question = document.getElementById('question').value.trim();
    const answer = document.getElementById('answer').value.trim();

    // Jika salah satu kosong, cegah submit dan tampilkan pop-up
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

    // Kalau semua terisi, tampilkan notifikasi berhasil (sebentar) sebelum submit
    event.preventDefault();
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'FAQ berhasil disimpan.',
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        event.target.submit();
    });
});
</script>
@endsection
