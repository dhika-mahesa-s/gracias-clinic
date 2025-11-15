<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi Reservasi - {{ $reservasi->reservation_code }}</title>
    <style>
        @page {
            margin: 15px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'DejaVu Sans', sans-serif;
            background: #f0f9ff;
            color: #1e293b;
            line-height: 1.4;
            padding: 10px;
        }

        .container {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            max-width: 100%;
        }

        /* Header dengan Gradient */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 20px;
            text-align: center;
            color: white;
            position: relative;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }

        .header .subtitle {
            font-size: 10px;
            opacity: 0.95;
            font-weight: 400;
        }

        /* Success Badge */
        .success-badge {
            background: #10b981;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Reservation Code Box */
        .code-section {
            background: #eff6ff;
            border: 2px dashed #3b82f6;
            border-radius: 8px;
            padding: 12px;
            margin: 12px 20px;
            text-align: center;
        }

        .code-label {
            font-size: 9px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .code-value {
            font-size: 16px;
            font-weight: 800;
            color: #1e40af;
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
        }

        /* Content Section */
        .content {
            padding: 15px 20px;
        }

        .section-header {
            background: #667eea;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 12px 0 8px 0;
        }

        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            display: table-cell;
            padding: 6px 10px 6px 0;
            font-weight: 600;
            color: #64748b;
            font-size: 10px;
            width: 35%;
            vertical-align: top;
        }

        .info-value {
            display: table-cell;
            padding: 6px 0;
            color: #1e293b;
            font-size: 10px;
            font-weight: 500;
            vertical-align: top;
        }

        /* Status Badge */
        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-block;
            border: 1px solid #6ee7b7;
        }

        /* Price Highlight */
        .price-section {
            background: #fef3c7;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
            border-left: 3px solid #f59e0b;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 4px 0;
        }

        .price-label {
            font-size: 10px;
            color: #78350f;
            font-weight: 600;
        }

        .price-value {
            font-size: 10px;
            color: #78350f;
            font-weight: 600;
        }

        .price-original {
            text-decoration: line-through;
            color: #92400e;
            opacity: 0.7;
        }

        .price-discount {
            color: #dc2626;
            font-weight: 700;
        }

        .price-total {
            font-size: 14px;
            font-weight: 800;
            color: #065f46;
        }

        .price-total-label {
            font-size: 11px;
            font-weight: 700;
            color: #065f46;
        }

        .divider {
            border: none;
            border-top: 1px dashed #cbd5e1;
            margin: 5px 0;
        }

        /* Important Note */
        .note-box {
            background: #fef3c7;
            border-left: 3px solid #f59e0b;
            padding: 10px;
            border-radius: 6px;
            margin: 12px 0;
        }

        .note-box .note-icon {
            color: #f59e0b;
            font-weight: 700;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .note-box p {
            color: #92400e;
            font-size: 9px;
            line-height: 1.5;
            margin: 0;
        }

        /* Footer */
        .footer {
            background: #f8fafc;
            padding: 12px 20px;
            text-align: center;
            border-top: 2px solid #e2e8f0;
            margin-top: 12px;
        }

        .footer-brand {
            font-weight: 700;
            font-size: 11px;
            color: #667eea;
            margin-bottom: 4px;
        }

        .footer p {
            color: #64748b;
            font-size: 8px;
            margin: 2px 0;
            line-height: 1.4;
        }

        .footer-highlight {
            color: #334155;
            font-weight: 600;
        }

        /* Print Optimization */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header with Gradient --}}
        <div class="header">
            <div class="header-content">
                <h1>✓ RESI RESERVASI</h1>
                <p class="subtitle">Gracias Aesthetic Clinic — Kecantikan & Perawatan Kulit</p>
            </div>
        </div>

        {{-- Success Badge --}}
        <div style="text-align: center; margin-top: -15px; position: relative; z-index: 10;">
            <div class="success-badge">Reservasi Dikonfirmasi!</div>
        </div>

        {{-- Reservation Code --}}
        <div class="code-section">
            <div class="code-label">Kode Reservasi Anda</div>
            <div class="code-value">{{ $reservasi->reservation_code }}</div>
        </div>

        {{-- Content --}}
        <div class="content">
            {{-- Customer Information --}}
            <div class="section-header">👤 Data Pemesan</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $reservasi->customer_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $reservasi->customer_email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $reservasi->customer_phone }}</div>
                </div>
            </div>

            {{-- Reservation Details --}}
            <div class="section-header">📋 Detail Reservasi</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-confirmed">{{ strtoupper($reservasi->status) }}</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Treatment</div>
                    <div class="info-value"><strong>{{ $reservasi->treatment->name }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Dokter</div>
                    <div class="info-value">{{ $reservasi->doctor->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($reservasi->reservation_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu</div>
                    <div class="info-value"><strong>{{ \Carbon\Carbon::parse($reservasi->reservation_time)->format('H:i') }} WIB</strong></div>
                </div>
            </div>

            {{-- Price Information --}}
            @php
                $originalPrice = $reservasi->treatment->price;
                $paidPrice = $reservasi->total_price;
                $hasDiscount = $paidPrice < $originalPrice;
            @endphp

            <div class="section-header">💰 Rincian Biaya</div>
            <div class="price-section">
                @if($hasDiscount)
                    <div class="price-row">
                        <span class="price-label">Harga Normal</span>
                        <span class="price-value price-original">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Potongan Diskon</span>
                        <span class="price-value price-discount">- Rp {{ number_format($originalPrice - $paidPrice, 0, ',', '.') }}</span>
                    </div>
                    <hr class="divider">
                @endif
                <div class="price-row" style="margin-top: 8px;">
                    <span class="price-total-label">Total Biaya</span>
                    <span class="price-total">Rp {{ number_format($paidPrice, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Important Note --}}
            <div class="note-box">
                <div class="note-icon">⏰ Catatan Penting:</div>
                <p>
                    • Mohon hadir <strong>10 menit sebelum</strong> waktu reservasi Anda.<br>
                    • Tunjukkan <strong>resi ini</strong> kepada petugas saat kedatangan.<br>
                    • Jika ada perubahan atau pembatalan, hubungi kami sesegera mungkin.
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div class="footer-brand">GRACIAS AESTHETIC CLINIC</div>
            <p>Jl. Gardenia No.20, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156</p>
            <p class="footer-highlight">WhatsApp: +62-8217-4973-339 | Email: gracias.aestheticlinic@gmail.com</p>
            <p style="margin-top: 10px; font-size: 9px; color: #94a3b8;">
                © {{ date('Y') }} Gracias Aesthetic Clinic. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
