@extends('layouts.app') 

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Total Reservasi</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalReservations }}</p>
        </div>
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Total Pendapatan</h2>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Customer Unik</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $uniqueCustomers }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Reservasi per Bulan</h2>
            <canvas id="chartPerBulan" height="100"></canvas>
        </div>

        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Reservasi</h2>
            <canvas id="chartStatus" height="100"></canvas>
        </div>

        <div class="bg-white shadow rounded-2xl p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Reservasi per Treatment</h2>
            <canvas id="chartTreatment" height="100"></canvas>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthLabels = {!! json_encode($reservationsByMonth->pluck('month')) !!};
    const monthData = {!! json_encode($reservationsByMonth->pluck('total')) !!};

    const statusLabels = {!! json_encode($reservationsByStatus->pluck('status')) !!};
    const statusData = {!! json_encode($reservationsByStatus->pluck('total')) !!};

    const treatmentLabels = {!! json_encode($reservationsByTreatment->pluck('treatment')) !!};
    const treatmentData = {!! json_encode($reservationsByTreatment->pluck('total')) !!};

    // Chart per bulan
    new Chart(document.getElementById('chartPerBulan'), {
        type: 'line',
        data: {
            labels: monthLabels.map(m => 'Bulan ' + m),
            datasets: [{
                label: 'Total Reservasi',
                data: monthData,
                borderColor: '#3b82f6',
                fill: false,
                tension: 0.3
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Chart status
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Jumlah',
                data: statusData,
                backgroundColor: ['#60a5fa', '#34d399', '#f87171', '#fbbf24']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    // Chart treatment
    new Chart(document.getElementById('chartTreatment'), {
        type: 'bar',
        data: {
            labels: treatmentLabels,
            datasets: [{
                label: 'Total Reservasi',
                data: treatmentData,
                backgroundColor: '#6366f1'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection