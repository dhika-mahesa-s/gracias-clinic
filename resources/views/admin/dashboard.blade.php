<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Gracias Aesthetic Clinic</title>

    {{-- ✅ Tailwind CSS via Vite --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- ✅ Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer">

    {{-- ✅ Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="font-[Poppins] bg-gray-50 text-gray-800">

    {{-- 🌟 Navbar Dashboard Admin --}}
    <nav class="fixed top-0 left-0 right-0 bg-primary text-primary-foreground shadow-sm border-b border-border z-50">
    <div class="flex items-center justify-between px-6 py-3">
        {{-- Kiri: Logo dan Nama --}}
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center bg-white/80 rounded-full p-1 shadow-sm">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 md:w-12 md:h-12 object-contain">
            </div>
            <span class="font-semibold text-lg md:text-xl tracking-wide">Gracias Admin Dashboard</span>
        </div>

        {{-- Kanan: Salam dan Tombol Logout --}}
        <div class="flex items-center space-x-4">
            <span class="text-sm md:text-base">Halo, <b>Admin</b></span>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center gap-2 bg-secondary text-secondary-foreground px-4 py-2 rounded-lg hover:bg-secondary/90 transition-all shadow-sm">
               <i class="fa-solid fa-right-from-bracket"></i>
               <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</nav>


    {{-- 🌟 Konten Utama Dashboard --}}
    <div class="flex min-h-screen pt-16">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md">
            <div class="pl-8 pt-6 border- mt-2">
                <h6 class="text-lg font-bold text-gray-700">Menu Admin</h6>
            </div>
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-blue-600 font-semibold">
                            <i class="fa-solid fa-chart-line mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reservasi.admin') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                            <i class="fa-solid fa-calendar-check mr-2"></i> Kelola Reservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reservations.history') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                            <i class="fa-solid fa-clock-rotate-left mr-2"></i> Riwayat Reservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('treatments.manage') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                            <i class="fa-solid fa-spa mr-2"></i> Kelola Treatment
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faq.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                            <i class="fa-solid fa-circle-question mr-2"></i> Kelola FAQ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.feedback.index') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-50 text-gray-700 font-medium">
                            <i class="fa-solid fa-comments mr-2"></i> Kelola Feedback
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6 bg-gray-50">
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

</body>
</html>
