@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - Gracias Aesthetic Clinic')

@section('content')
<section class="min-h-screen bg-[#EEF2F7] text-[#526D82] py-10 px-4">
  <div class="container mx-auto max-w-6xl">
    <h1 class="text-3xl font-bold mb-6 text-[#27374D]">Dashboard</h1>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow rounded-2xl p-6 text-center border border-blue-200">
            <h2 class="text-sm text-gray-600 mb-1">Total Reservasi Hari Ini</h2>
            <p class="text-3xl font-extrabold text-blue-600">{{ $reservationsToday }}</p>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 shadow rounded-2xl p-6 text-center border border-green-200">
            <h2 class="text-sm text-gray-600 mb-1">Total Pendapatan Bulan Ini</h2>
            <p class="text-3xl font-extrabold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 shadow rounded-2xl p-6 text-center border border-gray-200">
            <h2 class="text-sm text-gray-600 mb-1">Total Pengunjung Baru (Bulan Ini)</h2>
            <p class="text-3xl font-extrabold text-gray-700">{{ $newVisitorsThisMonth }}</p>
        </div>

    </div>


    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-2xl p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semi-bold text-gray-700">Reservasi</h2>

                <select id="chartFilter" 
                    class="border border-gray-300 rounded-lg text-sm px-3 py-1 focus:ring-2 focus:ring-blue-500">
                    <option value="bulan" selected>Per Bulan</option>
                    <option value="minggu">Per Minggu</option>
                    <option value="hari">Per Hari</option>
                </select>
            </div>

                <canvas id="chartPerBulan" height="200"></canvas>
        </div>

        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Reservasi</h2>
            <canvas id="chartStatus" height="100"></canvas>
        </div>

        <div class="bg-white shadow rounded-2xl p-6 lg:col-span-3">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Reservasi per Treatment</h2>
            <canvas id="chartTreatment" height="100"></canvas>
        </div>
    </div>

    <div class="mt-10 text-right">
        <a href="{{ route('admin.dashboard.downloadReport') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Unduh Laporan</a>
    </div>
  </div>
</section>
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

    // daftar warna lembut untuk tiap mode
    const chartColors = {
        bulan: '#3b82f6',  // biru
        minggu: '#10b981', // hijau
        hari: '#f59e0b'    // oranye
    };

    // fungsi pembuat gradient biar halus
    function createGradient(ctx, color) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, `${color}66`); // warna dengan transparansi
        gradient.addColorStop(1, `${color}00`);
        return gradient;
    }

    // chart awal (per bulan)
    const chartPerBulan = new Chart(ctxMonth, {
        type: 'line',
        data: {
            labels: monthLabels.map(m => 'Bulan ' + m),
            datasets: [{
                label: 'Total Reservasi',
                data: monthData,
                borderColor: chartColors.bulan,
                backgroundColor: createGradient(ctxMonth, chartColors.bulan),
                borderWidth: 2,
                pointBackgroundColor: chartColors.bulan,
                pointRadius: 4,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
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
                backgroundColor: ['#93c5fd', '#a7f3d0', '#fca5a5', '#fde68a'],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        color: '#334155'
                    }
                }
            }
        }
    });

    // Chart Treatment
    const ctxTreatment = document.getElementById('chartTreatment').getContext('2d');

    const gradientColors = [
        ['#93c5fd', '#3b82f6'], // biru muda ke biru
        ['#6ee7b7', '#10b981'], // hijau muda ke hijau
        ['#fde68a', '#f59e0b'], // kuning muda ke kuning
        ['#fca5a5', '#ef4444'], // merah muda ke merah
        ['#c4b5fd', '#8b5cf6'], // ungu muda ke ungu
        ['#f9a8d4', '#ec4899'], // pink muda ke pink
        ['#5eead4', '#14b8a6'], // teal muda ke teal
        ['#a5b4fc', '#6366f1'], // indigo muda ke indigo
    ];

    const bgGradients = treatmentLabels.map((_, i) => {
        const g = ctxTreatment.createLinearGradient(0, 0, 0, 200);
        const [start, end] = gradientColors[i % gradientColors.length];
        g.addColorStop(0, start);
        g.addColorStop(1, end);
        return g;
    });

    new Chart(ctxTreatment, {
        type: 'bar',
        data: {
            labels: treatmentLabels,
            datasets: [{
                data: treatmentData,
                backgroundColor: bgGradients,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 800,
                easing: 'easeOutCubic'
            },
            scales: {
                x: {
                    ticks: { color: '#64748b' },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#64748b' },
                    grid: { color: 'rgba(226, 232, 240, 0.5)' }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            }
        }
    });



    // Event Listener Dropdown 
    document.getElementById('chartFilter').addEventListener('change', function() {
        const selected = this.value;

        let labels = [];
        let data = [];
        let color = chartColors[selected];

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

        // update chart dengan warna & data baru
        chartPerBulan.data.labels = labels;
        chartPerBulan.data.datasets[0].data = data;
        chartPerBulan.data.datasets[0].borderColor = color;
        chartPerBulan.data.datasets[0].backgroundColor = createGradient(ctxMonth, color);
        chartPerBulan.data.datasets[0].pointBackgroundColor = color;

        chartPerBulan.update({
            duration: 800,
            easing: 'easeInOutQuart'
        });
    });
</script>
@endsection
