@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - Gracias Aesthetic Clinic')

@section('content')
<section class="min-h-screen bg-background py-8 px-4 sm:px-6 lg:px-8 mt-4">
  <div class="max-w-7xl mx-auto">
    
    {{-- Header Section --}}
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-foreground mb-2">Dashboard</h1>
                <p class="text-muted-foreground flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-primary"></i>
                    <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.dashboard.downloadReport') }}" 
                   class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-primary-foreground px-6 py-3 rounded-xl transition-smooth shadow-lg hover:shadow-xl hover-lift active-press">
                    <i class="fa-solid fa-download"></i>
                    <span class="font-semibold">Unduh Laporan</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Reservasi Hari Ini --}}
        <div class="group bg-card rounded-xl shadow-md hover:shadow-xl overflow-hidden border border-border animate-slide-up hover-lift transition-smooth">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-primary/10 rounded-xl transition-smooth hover-scale-sm">
                        <i class="fa-solid fa-calendar-check text-2xl text-primary"></i>
                    </div>
                    <span class="text-xs font-semibold text-primary bg-primary/10 px-3 py-1 rounded-full">Hari Ini</span>
                </div>
                <h3 class="text-muted-foreground text-sm font-medium mb-1">Total Reservasi</h3>
                <p class="text-4xl font-bold text-card-foreground mb-2">{{ $reservationsToday }}</p>
                <div class="flex items-center text-xs text-primary">
                    <i class="fa-solid fa-arrow-up mr-1"></i>
                    <span>Reservasi aktif</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Pendapatan --}}
        <div class="group bg-card rounded-xl shadow-md hover:shadow-xl overflow-hidden border border-border animate-slide-up delay-100 hover-lift transition-smooth">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-500/10 rounded-xl transition-smooth hover-scale-sm">
                        <i class="fa-solid fa-sack-dollar text-2xl text-green-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-500/10 px-3 py-1 rounded-full">Bulan Ini</span>
                </div>
                <h3 class="text-muted-foreground text-sm font-medium mb-1">Total Pendapatan</h3>
                <p class="text-3xl font-bold text-card-foreground mb-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <div class="flex items-center text-xs text-green-600">
                    <i class="fa-solid fa-chart-line mr-1"></i>
                    <span>Revenue bulan ini</span>
                </div>
            </div>
        </div>

        {{-- Card 3: Pengunjung Baru --}}
        <div class="group bg-card rounded-xl shadow-md hover:shadow-xl overflow-hidden border border-border animate-slide-up delay-200 hover-lift transition-smooth">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-500/10 rounded-xl transition-smooth hover-scale-sm">
                        <i class="fa-solid fa-user-plus text-2xl text-purple-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-600 bg-purple-500/10 px-3 py-1 rounded-full">Bulan Ini</span>
                </div>
                <h3 class="text-muted-foreground text-sm font-medium mb-1">Pengunjung Baru</h3>
                <p class="text-4xl font-bold text-card-foreground mb-2">{{ $newVisitorsThisMonth }}</p>
                <div class="flex items-center text-xs text-purple-600">
                    <i class="fa-solid fa-users mr-1"></i>
                    <span>Customer baru</span>
                </div>
            </div>
        </div>
    </div>


    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Main Chart - Reservasi --}}
        <div class="lg:col-span-2 bg-card rounded-xl shadow-md border border-border overflow-hidden animate-slide-up delay-75 hover-scale-sm transition-smooth">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-card-foreground mb-1">Grafik Reservasi</h2>
                        <p class="text-sm text-muted-foreground">Tracking reservasi berdasarkan periode</p>
                    </div>
                    <div class="relative">
                        <select id="chartFilter" 
                            class="appearance-none bg-secondary border border-border rounded-xl text-sm px-4 py-2.5 pr-10 focus:ring-2 focus:ring-ring focus:border-input transition-smooth cursor-pointer font-medium text-foreground hover-brightness">
                            <option value="bulan" selected>Per Bulan</option>
                            <option value="minggu">Per Minggu</option>
                            <option value="hari">Per Hari</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-muted-foreground pointer-events-none"></i>
                    </div>
                </div>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartPerBulan"></canvas>
                </div>
            </div>
        </div>

        {{-- Status Chart --}}
        <div class="bg-card rounded-xl shadow-md border border-border overflow-hidden animate-slide-up delay-150 hover-scale-sm transition-smooth">
            <div class="p-6">
                <h2 class="text-xl font-bold text-card-foreground mb-1">Status Reservasi</h2>
                <p class="text-sm text-muted-foreground mb-6">Distribusi status saat ini</p>
                <div class="relative" style="height: 300px;">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>

        {{-- Treatment Chart --}}
        <div class="lg:col-span-3 bg-card rounded-xl shadow-md border border-border overflow-hidden animate-slide-up delay-200 hover-scale-sm transition-smooth">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-card-foreground mb-1">Reservasi per Treatment</h2>
                    <p class="text-sm text-muted-foreground">Treatment paling populer</p>
                </div>
                <div class="relative" style="height: 350px;">
                    <canvas id="chartTreatment"></canvas>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get CSS theme colors
    const getCSSVar = (name) => getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    
    // Convert OKLCH to RGB for Chart.js
    const getChartColor = (varName, opacity = 1) => {
        const oklch = getCSSVar(varName);
        // For simplicity, using predefined RGB equivalents of our OKLCH values
        const colorMap = {
            '--chart-1': '59, 130, 246',   // blue
            '--chart-2': '16, 185, 129',   // green
            '--chart-3': '239, 68, 68',    // red
            '--chart-4': '245, 158, 11',   // amber
            '--chart-5': '168, 85, 247',   // purple
        };
        const rgb = colorMap[varName] || '59, 130, 246';
        return `rgba(${rgb}, ${opacity})`;
    };

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

    // Chart Colors - Using theme variables
    const chartColors = {
        bulan: getChartColor('--chart-1'),
        minggu: getChartColor('--chart-2'),
        hari: getChartColor('--chart-4')
    };

    // Gradient Generator
    function createGradient(ctx, color) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        // Extract RGB and create gradient
        const rgb = color.match(/rgba?\(([^)]+)\)/)[1].split(',').slice(0, 3).join(',');
        gradient.addColorStop(0, `rgba(${rgb}, 0.6)`);
        gradient.addColorStop(1, `rgba(${rgb}, 0)`);
        return gradient;
    }

    // Main Chart - Reservasi
    const ctxMonth = document.getElementById('chartPerBulan').getContext('2d');
    const chartPerBulan = new Chart(ctxMonth, {
        type: 'line',
        data: {
            labels: monthLabels.map(m => 'Bulan ' + m),
            datasets: [{
                label: 'Total Reservasi',
                data: monthData,
                borderColor: chartColors.bulan,
                backgroundColor: createGradient(ctxMonth, chartColors.bulan),
                borderWidth: 3,
                pointBackgroundColor: getChartColor('--chart-1'),
                pointBorderColor: getChartColor('--chart-1'),
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: 'easeInOutQuart'
            },
            scales: {
                x: {
                    grid: { 
                        display: false 
                    },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: '#6b7280'
                    }
                },
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 12, weight: '500' },
                        color: '#6b7280',
                        padding: 10
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#e5e7eb',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            }
        }
    });


    // Chart Status - Modern Doughnut
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: [
                    getChartColor('--chart-1'),
                    getChartColor('--chart-2'),
                    getChartColor('--chart-3'),
                    getChartColor('--chart-4')
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        color: '#6b7280',
                        font: { size: 12, weight: '500' }
                    }
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            }
        }
    });

    // Chart Treatment - Modern Bar Chart
    const ctxTreatment = document.getElementById('chartTreatment').getContext('2d');
    
    const bgGradients = treatmentLabels.map((_, i) => {
        const g = ctxTreatment.createLinearGradient(0, 0, 0, 300);
        const chartIndex = (i % 5) + 1;
        const color = getChartColor(`--chart-${chartIndex}`);
        const rgb = color.match(/rgba?\(([^)]+)\)/)[1].split(',').slice(0, 3).join(',');
        g.addColorStop(0, `rgba(${rgb}, 0.9)`);
        g.addColorStop(1, `rgba(${rgb}, 0.7)`);
        return g;
    });

    new Chart(ctxTreatment, {
        type: 'bar',
        data: {
            labels: treatmentLabels,
            datasets: [{
                data: treatmentData,
                backgroundColor: bgGradients,
                borderRadius: 10,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutCubic'
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { 
                        font: { size: 12, weight: '500' },
                        color: '#6b7280' 
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: { 
                        font: { size: 12, weight: '500' },
                        color: '#6b7280',
                        padding: 10
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#fff',
                    bodyColor: '#e5e7eb',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            }
        }
    });



    // Event Listener Dropdown - Smooth Transition
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

        // Update chart with smooth animation
        chartPerBulan.data.labels = labels;
        chartPerBulan.data.datasets[0].data = data;
        chartPerBulan.data.datasets[0].borderColor = color;
        chartPerBulan.data.datasets[0].backgroundColor = createGradient(ctxMonth, color);
        chartPerBulan.data.datasets[0].pointBorderColor = color;

        chartPerBulan.update({
            duration: 800,
            easing: 'easeInOutQuart'
        });
    });
</script>
@endsection
