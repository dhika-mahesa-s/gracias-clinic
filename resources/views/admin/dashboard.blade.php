@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md">
        <div class="p-6 border-b">
            <h6 class="text-1xl font-bold text-gray-600">Selamat Datang, Admin!</h6>
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('reservasi.admin') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                        Kelola Reservasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('reservations.create') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                        Kelola Riwayat Reservasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('treatments.manage') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                        Kelola Treatment
                    </a>
                </li>
                <li>
                    <a href="{{ route('feedback.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                        Kelola Feedback
                    </a>
                </li>                
                <li>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="block px-4 py-2 rounded-lg hover:bg-red-50 text-red-600 font-medium">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

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
        <div class="mt-10 text-right">
                <a href="{{ route('admin.dashboard.downloadReport') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Unduh Laporan</a>
        </div>
    </main>
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

    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#60a5fa', '#34d399', '#f87171', '#fbbf24']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('chartTreatment'), {
        type: 'bar',
        data: {
            labels: treatmentLabels,
            datasets: [{
                data: treatmentData,
                backgroundColor: '#6366f1'
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection
