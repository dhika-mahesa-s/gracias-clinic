<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background: #f3f3f3; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    <h2>{{ now()->format('d F Y') }}</h2>

    <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    <p><strong>Reservasi Hari Ini:</strong> {{ $reservationsToday }}</p>

    <h3>Reservasi per Bulan</h3>
    <table>
        <tr><th>Bulan</th><th>Total Reservasi</th></tr>
        @foreach ($reservationsByMonth as $item)
            <tr>
                <td>Bulan {{ $item->month }}</td>
                <td>{{ $item->total }}</td>
            </tr>
        @endforeach
    </table>

    <h3>Reservasi per Status</h3>
    <table>
        <tr><th>Status</th><th>Total</th></tr>
        @foreach ($reservationsByStatus as $item)
            <tr>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->total }}</td>
            </tr>
        @endforeach
    </table>

    <h3>Reservasi per Treatment</h3>
    <table>
        <tr><th>Treatment</th><th>Total</th></tr>
        @foreach ($reservationsByTreatment as $item)
            <tr>
                <td>{{ $item->treatment }}</td>
                <td>{{ $item->total }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
