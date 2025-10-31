<!DOCTYPE html>
<html>

<head>
    <title>Laporan Reservasi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
            margin: 20px;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <h1>Laporan Riwayat Reservasi Klinik (Admin)</h1>
    <h2>Filter Aktif: {{ http_build_query($request->query()) }}</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Booking</th>
                <th>Pasien</th>
                <th>Treatment</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $r->reservation_code }}</td>
                <td>{{ optional($r->user)->name ?? '—' }}</td>
                <td>{{ optional($r->treatment)->name ?? '—' }}</td>
                <td>{{ optional($r->doctor)->name ?? '—' }}</td>
                <td>{{ $r->reservation_date->format('d M Y') }}</td>
                <td>{{ substr($r->reservation_time, 0, 5) }}</td>
                <td>Rp {{ number_format($r->total_price, 0, ',', '.') }}</td>
                <td>{{ ucfirst($r->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="font-weight: bold;">Total Data: {{ $reservations->count() }}</p>
</body>

</html>