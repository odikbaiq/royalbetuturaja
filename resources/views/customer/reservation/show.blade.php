@extends('layouts.customer')

@section('title', 'Detail Reservasi - Royal Betutu Raja')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Detail Reservasi</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded p-5">
                    <h4>Reservasi #{{ $reservation->id }}</h4>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</p>
                    <p><strong>Waktu:</strong> {{ $reservation->time }}</p>
                    <p><strong>Jumlah Orang:</strong> {{ $reservation->guests }}</p>
                    <p><strong>Layanan:</strong> {{ $reservation->service_type }}</p>
                    <p><strong>Status:</strong> {{ $reservation->status }}</p>
                    <p><strong>Total Harga:</strong> Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                    <p><strong>Catatan:</strong> {{ $reservation->notes ?: 'Tidak ada' }}</p>

                    @if($reservation->payment)
                        <h5>Pembayaran</h5>
                        <p><strong>Status Pembayaran:</strong> {{ $reservation->payment->status }}</p>
                        <p><strong>Metode:</strong> {{ $reservation->payment->method }}</p>
                        <p><strong>Jumlah:</strong> Rp {{ number_format($reservation->payment->amount, 0, ',', '.') }}</p>
                        @if($reservation->payment->status == 'Lunas' && $reservation->status == 'Dikonfirmasi')
                            <a href="{{ route('customer.payment.downloadInvoice', $reservation->id) }}" class="btn btn-success">Download E-Voucher</a>
                        @endif
                    @else
                        <a href="{{ route('customer.payment.pay', $reservation->id) }}" class="btn btn-primary">Bayar Sekarang</a>
                    @endif

                    <a href="{{ route('customer.reservation.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
