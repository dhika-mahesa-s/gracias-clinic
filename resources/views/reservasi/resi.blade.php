<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi Reservasi - {{ $reservasi->reservation_code }}</title>
    <style>
        @page {
            margin: 25px 25px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #fafbfc;
            color: #1e293b;
            padding: 0;
        }

        .container {
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 25px 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            color: #2563eb; /* primary color */
            font-size: 22px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .section-title {
            font-weight: bold;
            color: #334155;
            margin-top: 20px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info {
            margin: 8px 0;
            font-size: 14px;
        }

        .label {
            font-weight: 600;
            color: #475569;
            display: inline-block;
            width: 140px;
        }

        .value {
            color: #0f172a;
        }

        .divider {
            border: none;
            border-top: 1px dashed #cbd5e1;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #64748b;
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
        }

        .clinic-name {
            font-weight: bold;
            color: #2563eb;
        }

        .code-box {
            text-align: center;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 8px;
            margin: 10px 0 20px 0;
            font-weight: bold;
            color: #1d4ed8;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Resi Reservasi</h2>
            <p>Gracias Clinic — Kecantikan & Perawatan Kulit</p>
        </div>

        <div class="code-box">
            KODE RESERVASI: {{ $reservasi->reservation_code }}
        </div>

        <div class="section-title">Data Pemesan</div>
        <div class="info"><span class="label">Nama</span> <span class="value">{{ $reservasi->customer_name }}</span></div>
        <div class="info"><span class="label">Email</span> <span class="value">{{ $reservasi->customer_email }}</span></div>
        <div class="info"><span class="label">Telepon</span> <span class="value">{{ $reservasi->customer_phone }}</span></div>

        <div class="section-title">Detail Reservasi</div>
        <div class="info"><span class="label">Dokter</span> <span class="value">{{ $reservasi->doctor->name }}</span></div>
        <div class="info"><span class="label">Treatment</span> <span class="value">{{ $reservasi->treatment->name }}</span></div>
        
        @php
            $originalPrice = $reservasi->treatment->price;
            $paidPrice = $reservasi->total_price;
            $hasDiscount = $paidPrice < $originalPrice;
        @endphp
        
        @if($hasDiscount)
            <div class="info"><span class="label">Harga Normal</span> <span class="value" style="text-decoration: line-through; color: #94a3b8;">Rp. {{ number_format($originalPrice, 0, ',', '.') }}</span></div>
            <div class="info"><span class="label">Diskon</span> <span class="value" style="color: #ef4444; font-weight: bold;">- Rp. {{ number_format($originalPrice - $paidPrice, 0, ',', '.') }}</span></div>
            <div class="info"><span class="label">Total Harga</span> <span class="value" style="font-weight: bold; color: #16a34a;">Rp. {{ number_format($paidPrice, 0, ',', '.') }}</span></div>
        @else
            <div class="info"><span class="label">Total Harga</span> <span class="value">Rp. {{ number_format($paidPrice, 0, ',', '.') }}</span></div>
        @endif
        
        <div class="info"><span class="label">Tanggal</span> <span class="value">{{ \Carbon\Carbon::parse($reservasi->reservation_date)->format('d F Y') }}</span></div>
        <div class="info"><span class="label">Waktu</span> <span class="value">{{ $reservasi->reservation_time }}</span></div>

        <div class="footer">
            Terima kasih telah melakukan reservasi di <span class="clinic-name">Gracias Clinic</span>.<br>
            Tunjukkan resi ini kepada petugas saat kedatangan.
        </div>
    </div>
</body>
</html>