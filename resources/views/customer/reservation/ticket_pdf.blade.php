<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: a6 portrait;
            margin: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            -webkit-print-color-adjust: exact;
        }

        /* Kontainer Utama */
        .ticket-wrapper {
            width: 105mm;
            height: 148mm;
            position: relative;
            box-sizing: border-box;
            background-color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: auto;
        }

        /* Elemen Dekoratif Latar Belakang */
        .ticket-wrapper::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(139, 0, 0, 0.03);
            border-radius: 50%;
            z-index: 1;
        }

        /* Bingkai Emas */
        .border-gold {
            position: absolute;
            top: 4mm;
            left: 4mm;
            right: 4mm;
            bottom: 4mm;
            border: 1pt solid #D4AF37;
            z-index: 10;
            pointer-events: none;
            opacity: 0.6;
        }

        /* Header */
        .header {
            background-color: #8B0000;
            color: #D4AF37;
            text-align: center;
            padding: 20pt 10pt 15pt;
            position: relative;
            z-index: 2;
        }

        .header h1 {
            margin: 0;
            font-size: 13pt;
            font-weight: 700;
            letter-spacing: 1.5pt;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 7pt;
            color: #ffffff;
            margin-top: 4pt;
            letter-spacing: 2pt;
            font-weight: 300;
            text-transform: uppercase;
            opacity: 0.9;
        }

        /* Seksi Kode Booking */
        .booking-section {
            text-align: center;
            margin-top: -10pt;
            z-index: 3;
        }

        .booking-box {
            display: inline-block;
            background-color: #ffffff;
            padding: 8pt 20pt;
            border: 1.5pt solid #D4AF37;
            border-radius: 4pt;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .booking-label {
            font-size: 6pt;
            color: #8B0000;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2pt;
        }

        .booking-code {
            font-size: 16pt;
            font-weight: 700;
            color: #222;
            margin: 0;
            letter-spacing: 3pt;
        }

        /* Detail Table */
        .details-container {
            padding: 15pt 15mm 5pt;
            flex-grow: 1;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 6pt 0;
            font-size: 8pt;
            border-bottom: 0.5pt solid #eee;
        }

        .label {
            color: #888;
            font-weight: 400;
            width: 40%;
        }

        .value {
            text-align: right;
            font-weight: 600;
            color: #333;
        }

        .status-paid {
            color: #27ae60;
            background: rgba(39, 174, 96, 0.1);
            padding: 2pt 6pt;
            border-radius: 10pt;
            font-size: 7pt;
        }

        /* Instruksi */
        .instruction-section {
            margin: 0 12mm 15pt;
            padding: 8pt;
            background-color: #fff9f9;
            border-radius: 4pt;
        }

        .ins-title {
            font-size: 7.5pt;
            font-weight: 700;
            color: #8B0000;
            margin-bottom: 4pt;
            display: flex;
            align-items: center;
        }

        .ins-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .ins-list li {
            font-size: 6.5pt;
            color: #666;
            margin-bottom: 3pt;
            line-height: 1.3;
            padding-left: 10pt;
            position: relative;
        }

        .ins-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #D4AF37;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            padding-bottom: 12mm;
            text-align: center;
        }

        .footer p {
            margin: 0;
            font-size: 6.5pt;
            color: #777;
            font-weight: 400;
        }

        .footer .contact {
            font-size: 7pt;
            color: #8B0000;
            font-weight: 600;
            margin-top: 4pt;
        }

        /* Potongan Tiket (Visual) */
        .notch {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #f4f4f4;
            border-radius: 50%;
            top: 50%;
            z-index: 11;
        }
        .notch-left { left: -10px; }
        .notch-right { right: -10px; }

    </style>
</head>
<body>
    <div class="ticket-wrapper">
        <div class="border-gold"></div>

        <div class="notch notch-left"></div>
        <div class="notch notch-right"></div>

        <div class="header">
            <h1>ROYAL BETUTU RAJA</h1>
            <p class="subtitle">Authentic Heritage Cuisine</p>
        </div>

        <div class="booking-section">
            <div class="booking-box">
                <div class="booking-label">Ticket Code</div>
                <p class="booking-code">{{ $reservation->ticket_code ?? $reservation->code }}</p>
            </div>
        </div>

        <div class="details-container">
            <table class="details-table">
                <tr>
                    <td class="label">Nama Tamu</td>
                    <td class="value">{{ $reservation->user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="value">{{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d M Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Kedatangan</td>
                    <td class="value">{{ $reservation->time }} WITA</td>
                </tr>
                <tr>
                    <td class="label">Jumlah Tamu</td>
                    <td class="value">{{ $reservation->guests }} Orang</td>
                </tr>
                <tr>
                    <td class="label">Layanan</td>
                    <td class="value">{{ $reservation->service_type }}</td>
                </tr>
                <tr>
                    <td class="label">Status Pembayaran</td>
                    <td class="value"><span class="status-paid">{{ $reservation->status }}</span></td>
                </tr>
            </table>
        </div>

        <div class="instruction-section">
            <div class="ins-title">Panduan Kedatangan</div>
            <ul class="ins-list">
                <li>Tiba 15 menit lebih awal untuk kenyamanan sambutan Anda.</li>
                <li>Cukup tunjukkan tiket digital ini kepada staf kami.</li>
                <li>Siapkan kartu identitas untuk verifikasi singkat di lokasi.</li>
            </ul>
            <div style="text-align: center; margin-top: 10pt;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode($reservation->ticket_code ?? $reservation->code) }}" alt="QR Code" style="width: 80px; height: 80px;">
            </div>
        </div>

        <div class="footer">
            <p>Puri Ageng Sukawati, Gianyar, Bali</p>
            <div class="contact">WhatsApp: +62 816-1731-9185</div>
        </div>
    </div>
</body>
</html>
