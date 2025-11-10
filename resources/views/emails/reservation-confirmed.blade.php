<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Dikonfirmasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 16px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .reservation-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }
        .reservation-code {
            background-color: #667eea;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6b7280;
            width: 140px;
            flex-shrink: 0;
        }
        .detail-value {
            color: #1f2937;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .info-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .info-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .social-links {
            margin-top: 15px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 20px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                width: 100%;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        {{-- Header --}}
        <div class="header">
            <h1>✅ Reservasi Dikonfirmasi!</h1>
            <p>Terima kasih atas kepercayaan Anda</p>
        </div>

        {{-- Content --}}
        <div class="content">
            <div class="greeting">
                Halo, <strong>{{ $reservation->customer_name }}</strong> 👋
            </div>

            <div class="message">
                Kami dengan senang hati mengabarkan bahwa reservasi Anda di <strong>{{ config('app.name') }}</strong> 
                telah <strong>dikonfirmasi</strong> oleh admin kami. Silakan datang sesuai jadwal yang telah ditentukan.
            </div>

            {{-- Reservation Details Card --}}
            <div class="reservation-card">
                <div class="reservation-code">
                    {{ $reservation->reservation_code }}
                </div>

                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-confirmed">Confirmed</span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Treatment</div>
                    <div class="detail-value">{{ $reservation->treatment->name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Dokter</div>
                    <div class="detail-value">{{ $reservation->doctor->name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Tanggal</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->isoFormat('dddd, D MMMM YYYY') }}
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Waktu</div>
                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }} WIB
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Total Biaya</div>
                    <div class="detail-value">
                        <strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="info-box">
                <p>
                    <strong>⏰ Catatan Penting:</strong><br>
                    Mohon hadir <strong>10 menit sebelum</strong> waktu reservasi Anda. 
                    Jika ada perubahan jadwal atau pembatalan, silakan hubungi kami sesegera mungkin.
                </p>
            </div>

            {{-- CTA Button --}}
            <div style="text-align: center;">
                <a href="{{ url('/riwayat-reservasi') }}" class="cta-button">
                    📋 Lihat Detail Reservasi
                </a>
            </div>

            <div class="message" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami 
                melalui WhatsApp atau email.
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Jl. Gardenia No.20, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156</p>
            <p>Email: gracias.aestheticlinic@gmail.com | WhatsApp: +62-8217-4973-339</p>
            
            <div class="social-links">
                <a href="https://www.instagram.com/graciasaesthetic?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Instagram</a> • 
                <a href="https://m.facebook.com/112757268598044/">Facebook</a> • 
                <a href="https://gracias-clinic.test">Website</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
