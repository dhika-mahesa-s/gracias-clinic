@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - Gracias Aesthetic Clinic')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Total Reservasi Hari Ini</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $reservationsToday }}</p>
        </div>
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Total Pendapatan Bulan Ini</h2>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <h2 class="text-sm text-gray-500">Total Pengunjung Baru (Bulan Ini)</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $newVisitorsThisMonth }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Reservasi</h2>

                <select id="chartFilter" 
                        class="border border-gray-300 rounded-lg text-sm px-3 py-1 focus:ring-2 focus:ring-blue-500">
                    <option value="bulan" selected>Per Bulan</option>
                    <option value="minggu">Per Minggu</option>
                    <option value="hari">Per Hari</option>
                </select>
            </div>

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

    <div class="mt-10 text-right">
        <a href="{{ route('admin.dashboard.downloadReport') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Unduh Laporan</a>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthLabels = {!! json_encode($reservationsByMonth->pluck('month')) !!};
    const monthData = {!! json_encode($reservationsByMonth->pluck('total')) !!};

    const weekLabels = {!! json_encode($reservationsByWeek->pluck('week')) !!};
    const weekData = {!! json_encode($reservationsByWeek->pluck('total')) !!};

    const dayLabels = {!! json_encode($reservationsByDay->pluck('day')) !!};
    const dayData = {!! json_encode($reservationsByDay->pluck('total')) !!};

    const statusLabels = {!! json_encode($reservationsByStatus->pluck('status')) !!};
    const statusData = {!! json_encode($reservationsByStatus->pluck('total')) !!};
    
    const treatmentLabels = {!! json_encode($reservationsByTreatment->pluck('treatment')) !!};
    const treatmentData = {!! json_encode($reservationsByTreatment->pluck('total')) !!};

    // Buat Chart Per Bulan
    const ctxMonth = document.getElementById('chartPerBulan').getContext('2d');
    const chartPerBulan = new Chart(ctxMonth, {
        type: 'line',
        data: {
            labels: monthLabels.map(m => 'Bulan ' + m),
            datasets: [{
                label: 'Total Reservasi',
                data: monthData,
                borderColor: '#3b82f6',
                borderWidth: 2,
                pointBackgroundColor: '#3b82f6',
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000, // durasi animasi (ms)
                easing: 'easeInOutQuart' // gaya transisi halus
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Chart Status 
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#60a5fa', '#34d399', '#f87171', '#fbbf24'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
            }
        }
    });

    // Chart Treatment
    new Chart(document.getElementById('chartTreatment'), {
        type: 'bar',
        data: {
            labels: treatmentLabels,
            datasets: [{
                data: treatmentData,
                backgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 800,
                easing: 'easeOutCubic'
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Event Listener Dropdown 
    document.getElementById('chartFilter').addEventListener('change', function() {
        const selected = this.value;

        let labels = [];
        let data = [];

        if (selected === 'bulan') {
            labels = monthLabels.map(m => 'Bulan ' + m);
            data = monthData;
        } else if (selected === 'minggu') {
            labels = weekLabels.map(w => 'Minggu ' + w);
            data = weekData;
        } else if (selected === 'hari') {
            labels = dayLabels.map(d => 'Hari ' + d);
            data = dayData;
        }

        // transisi halus ke data baru 
        chartPerBulan.data.labels = labels;
        chartPerBulan.data.datasets[0].data = data;
        chartPerBulan.update({
            duration: 800, // durasi animasi update
            easing: 'easeInOutQuart'
        });
    });
</script>
@endsection
