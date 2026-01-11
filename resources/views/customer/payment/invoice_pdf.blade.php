<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: a4 portrait;
            margin: 20mm;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .invoice-header {
            text-align: center;
            border-bottom: 2px solid #8B0000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-header h1 {
            color: #8B0000;
            font-size: 28px;
            margin: 0;
            font-weight: 700;
        }

        .invoice-header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .invoice-details div {
            width: 48%;
        }

        .invoice-details h3 {
            color: #8B0000;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .invoice-details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f8f9fa;
            color: #8B0000;
            font-weight: 600;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #8B0000;
        }

        .total-section .total {
            font-size: 18px;
            font-weight: 700;
            color: #8B0000;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 12px;
        }

        .status-paid {
            color: #27ae60;
            background: rgba(39, 174, 96, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>ROYAL BETUTU RAJA</h1>
        <p class="subtitle">Authentic Heritage Cuisine</p>
        <h2>INVOICE PEMBAYARAN</h2>
    </div>

    <div class="invoice-details">
        <div>
            <h3>Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ $reservation->user->name }}</p>
            <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
        </div>
        <div>
            <h3>Detail Invoice</h3>
            <p><strong>Nomor Invoice:</strong> {{ $reservation->code }}</p>
            <p><strong>Tanggal Invoice:</strong> {{ now()->format('d M Y') }}</p>
            <p><strong>Status:</strong> <span class="status-paid">{{ ucfirst($reservation->status) }}</span></p>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reservation->service_type }}</td>
                <td>{{ $reservation->guests }} Orang</td>
                <td>Rp {{ number_format($reservation->total_price / $reservation->guests, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p class="total">Total Pembayaran: Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih telah memilih Royal Betutu Raja</p>
        <p>Puri Ageng Sukawati, Gianyar, Bali | WhatsApp: +62 816-1731-9185</p>
    </div>
</body>
</html>
