@extends('Admin.layout.master')

@section('title', 'Dashboard')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <p>Selamat datang di Dashboard Admin.</p>

    {{-- Contoh tempat grafik atau ringkasan data --}}
    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="bg-white p-4 shadow rounded">Total Reservasi: <b>{{ $total_reservasi ?? 0 }}</b></div>
        <div class="bg-white p-4 shadow rounded">Total Treatment: <b>{{ $total_treatment ?? 0 }}</b></div>
        <div class="bg-white p-4 shadow rounded">Feedback Masuk: <b>{{ $total_feedback ?? 0 }}</b></div>
    </div>
@endsection
