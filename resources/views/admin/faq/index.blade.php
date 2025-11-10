@extends('layouts.dashboard')

@section('title', 'Kelola FAQ - Gracias Clinic')

@section('content')
<div class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
    <div class="max-w-6xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2 flex items-center gap-3">
                        <div class="p-2 bg-primary rounded-xl">
                            <i class="fa-solid fa-circle-question text-primary-foreground text-2xl"></i>
                        </div>
                        Kelola FAQ
                    </h1>
                    <p class="text-muted-foreground ml-14">Manajemen Frequently Asked Questions</p>
                </div>
                <a href="{{ url('admin/faq/create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah FAQ</span>
                </a>
            </div>
        </div>

        {{-- FAQ Cards --}}
        <div class="space-y-4">
            @forelse($faqs as $index => $faq)
                @php
                    $delays = ['', 'delay-75', 'delay-100', 'delay-150', 'delay-200', 'delay-250'];
                    $delayClass = $delays[$index % 6] ?? '';
                @endphp
                <div class="bg-card rounded-2xl shadow-md hover:shadow-lg transition-smooth overflow-hidden border border-border animate-slide-up {{ $delayClass }} hover-lift">
                    {{-- Card Header --}}
                    <div class="p-6 bg-muted border-b border-border">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3 flex-1">
                                <div class="flex-shrink-0 w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-question text-primary-foreground"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-card-foreground mb-1">
                                        {{ $faq->question ?? $faq->pertanyaan }}
                                    </h3>
                                </div>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex gap-2 flex-shrink-0">
                                <a href="{{ url('admin/faq/'.$faq->id.'/edit') }}" 
                                   class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-smooth shadow-sm hover:shadow hover-scale-sm active-press"
                                   title="Edit FAQ">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ url('admin/faq/'.$faq->id) }}" 
                                      method="POST" 
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="inline-flex items-center justify-center w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-smooth shadow-sm hover:shadow hover-scale-sm active-press delete-btn"
                                            title="Hapus FAQ">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-muted rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-lightbulb text-muted-foreground"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-muted-foreground leading-relaxed">
                                    {{ $faq->answer ?? $faq->jawaban }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-card rounded-2xl shadow-md border border-border p-16 text-center animate-fade-in">
                    <i class="fa-solid fa-circle-question text-6xl text-muted mb-4"></i>
                    <h3 class="text-xl font-semibold text-card-foreground mb-2">Belum Ada FAQ</h3>
                    <p class="text-muted-foreground mb-6">Mulai tambahkan pertanyaan yang sering ditanyakan</p>
                    <a href="{{ url('admin/faq/create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-primary-foreground rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press font-semibold">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah FAQ Pertama</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

{{-- 🧠 Tambahkan script SweetAlert di bawah --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data FAQ ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
