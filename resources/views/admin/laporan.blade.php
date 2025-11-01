<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 40px;
            font-size: 12px;
        }

        header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #4A708B;
            padding-bottom: 8px;
        }

        h1 {
            margin: 0;
            color: #2F4F6F;
            font-size: 22px;
        }

        h2 {
            color: #777;
            margin-top: 3px;
            font-weight: normal;
            font-size: 13px;
        }

        h3 {
            color: #2F4F6F;
            margin-top: 25px;
            font-size: 15px;
            border-left: 4px solid #4A708B;
            padding-left: 6px;
        }

        p {
            font-size: 12px;
            margin: 4px 0;
        }

        strong {
            color: #2F4F6F;
        }

        .summary {
            background-color: #f1f5f9;
            padding: 10px;
            border: 1px solid #cdd5de;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #999;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #4A708B;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Laporan Penjualan</h1>
        <h2>{{ now()->translatedFormat('d F Y') }}</h2>
    </header>

    <div class="summary">
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p><strong>Reservasi Hari Ini:</strong> {{ $reservationsToday }}</p>
    </div>

    <h3>Reservasi per Bulan</h3>
    <table>
        <thead>
            <tr><th>Bulan</th><th>Total Reservasi</th></tr>
        </thead>
        <tbody>
            @foreach ($reservationsByMonth as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($item->month)->translatedFormat('F') }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Reservasi per Status</h3>
    <table>
        <thead>
            <tr><th>Status</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($reservationsByStatus as $item)
                <tr>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Reservasi per Treatment</h3>
    <table>
        <thead>
            <tr><th>Treatment</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($reservationsByTreatment as $item)
                <tr>
                    <td>{{ $item->treatment }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <p>© {{ date('Y') }} Gracias Clinic — Sistem Dashboard Laporan Penjualan</p>
    </footer>
</body>
</html>
