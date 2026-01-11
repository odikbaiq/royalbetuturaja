@extends('layouts.customer')

@section('title', 'Pembayaran Reservasi - Royal Betutu Raja')

@section('content')
{{-- Menambahkan padding top agar tidak tertutup navbar --}}
<div class="container-fluid py-5 mt-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark">Daftar Pembayaran Reservasi</h2>
                <p class="text-muted">Kelola pembayaran untuk reservasi Anda yang belum lunas.</p>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>Status pembayaran diperbarui otomatis saat halaman dimuat.
                </div>
            </div>
        </div>

        @if($reservations->count() > 0)
            <div class="row g-4">
                @foreach($reservations as $reservation)
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark py-3">
                                <h5 class="card-title text-white mb-0"><i class="bi bi-receipt me-2 text-warning"></i>Reservasi {{ $reservation->code }}</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Layanan</span>
                                    <span class="fw-bold">{{ ucfirst($reservation->service_type) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Tanggal & Waktu</span>
                                    <span class="fw-bold">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }} | {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Jumlah Tamu</span>
                                    <span class="fw-bold">{{ $reservation->guests }} Orang</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Status</span>
                                    <span class="badge bg-{{ $reservation->status == 'pending' ? 'warning' : ($reservation->status == 'waiting_payment' ? 'info' : 'success') }}">{{ ucfirst(str_replace('_', ' ', $reservation->status)) }}</span>
                                </div>
                                <hr class="text-muted opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h5 mb-0">Total Bayar</span>
                                    <span class="h4 mb-0 fw-bold" style="color: #700505;">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-light border-0 p-4">
                                <div class="d-grid gap-2">
                                    @if($reservation->status == 'success')
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <a href="{{ route('customer.reservation.viewTicket', $reservation) }}" class="btn btn-outline-success btn-lg py-3 fw-bold shadow text-decoration-none" style="border-radius: 12px;">
                                                    <i class="bi bi-eye me-2"></i>Lihat E-Tiket
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('customer.reservation.ticket', $reservation) }}" class="btn btn-success btn-lg py-3 fw-bold shadow text-decoration-none" style="border-radius: 12px;">
                                                    <i class="bi bi-download me-2"></i>Download Tiket
                                                </a>
                                            </div>
                                        </div>
                                    @elseif($reservation->status == 'waiting_payment')
                                        <a href="{{ route('customer.payment.pay', $reservation) }}" class="btn btn-primary btn-lg py-3 fw-bold shadow text-decoration-none" style="background-color: #700505; border: none; border-radius: 12px;">
                                            <i class="bi bi-credit-card me-2"></i>BAYAR SEKARANG
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-lg py-3 fw-bold shadow" disabled style="border-radius: 12px;">
                                            <i class="bi bi-clock me-2"></i>Menunggu Persetujuan Admin
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
       @else
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    {{-- Mengganti ikon menjadi Ikon Dompet/Tagihan Kosong --}}
                    <div class="mb-4">
                        <i class="bi bi-wallet2 text-muted" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Tidak Ada Tagihan Aktif</h4>
                    <p class="text-muted mb-4">
                        Saat ini Anda tidak memiliki reservasi yang perlu dibayar.<br>
                        Silakan buat reservasi baru atau tunggu persetujuan admin untuk pesanan yang sudah ada.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('customer.reservation.create') }}" class="btn btn-outline-dark px-4 py-2" style="border-radius: 10px;">
                            Buat Reservasi Baru
                        </a>
                        <a href="{{ route('customer.reservation.index') }}" class="btn btn-primary px-4 py-2" style="background-color: #700505; border: none; border-radius: 10px;">
                            Cek Riwayat Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    </div>
</div>

<style>
    .breadcrumb-item a { color: #700505; }
</style>
@endsection
