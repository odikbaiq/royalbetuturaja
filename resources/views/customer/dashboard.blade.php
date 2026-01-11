@extends('layouts.customer')

@section('title','Dashboard Pelanggan - Royal Betutu Raja')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark mb-1">Selamat datang kembali, {{ explode(' ', auth()->user()->name)[0] }}!</h3>
            <p class="text-muted">Pantau reservasi dan nikmati layanan eksklusif Royal Betutu Raja.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('customer.reservation.create') }}" class="btn btn-primary shadow-sm px-4 py-2" style="background-color: #700505; border: none;">
                <i class="fas fa-plus me-2"></i>Buat Reservasi Baru
            </a>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="flex-shrink-0 bg-primary-soft p-3 rounded-circle me-3">
                        <i class="fas fa-calendar-check fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1 small fw-bold">Total Reservasi</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalReservations }}</h2>
                    </div>
                </div>
                <div class="bg-primary" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="flex-shrink-0 bg-success-soft p-3 rounded-circle me-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1 small fw-bold">Telah Dikonfirmasi</h6>
                        <h2 class="mb-0 fw-bold">{{ $confirmedCount }}</h2>
                    </div>
                </div>
                <div class="bg-success" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="flex-shrink-0 bg-warning-soft p-3 rounded-circle me-3">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1 small fw-bold">Perlu Dibayar</h6>
                        <h2 class="mb-0 fw-bold">{{ $waitingPaymentCount }}</h2>
                    </div>
                </div>
                <div class="bg-warning" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="flex-shrink-0 bg-info-soft p-3 rounded-circle me-3">
                        <i class="fas fa-wallet fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted mb-1 small fw-bold">Total Pengeluaran</h6>
                        <h2 class="mb-0 fw-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
                    </div>
                </div>
                <div class="bg-info" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Riwayat Reservasi Table --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Riwayat Reservasi Terakhir</h5>
                    <a href="{{ route('customer.reservation.index') }}" class="btn btn-sm btn-link text-decoration-none text-muted">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Layanan</th>
                                    <th class="py-3 border-0">Tanggal</th>
                                    <th class="py-3 border-0 text-center">Status</th>
                                    <th class="py-3 border-0 text-center">Pembayaran</th>
                                    <th class="pe-4 py-3 border-0 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                @php
                                    $statusLower = strtolower($reservation->status);
                                    $pStatus = strtolower($reservation->payment->status ?? 'pending');
                                    $isPaid = in_array($pStatus, ['lunas', 'paid', 'settlement', 'success']);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3">
                                                <i class="fas fa-utensils text-dark"></i>
                                            </div>
                                            <div>
                                                <span class="d-block fw-bold mb-0">{{ ucfirst($reservation->service_type) }}</span>
                                                <small class="text-muted">#{{ $reservation->code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-3 py-2
                                            @if($statusLower == 'confirmed' || $statusLower == 'completed') bg-success-soft text-success
                                            @elseif($statusLower == 'waiting_payment') bg-primary-soft text-primary
                                            @elseif($statusLower == 'pending') bg-warning-soft text-warning
                                            @else bg-secondary-soft text-secondary @endif">
                                            @if($statusLower == 'waiting_payment')
                                                Siap Dibayar
                                            @else
                                                {{ ucfirst($reservation->status) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($isPaid)
                                            <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Lunas</span>
                                        @else
                                            <span class="text-danger small fw-bold"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        @if($statusLower == 'waiting_payment')
                                            <a href="{{ route('customer.payment.pay', $reservation->id) }}" class="btn btn-warning btn-sm fw-bold shadow-sm">
                                                <i class="fas fa-money-bill-wave me-1"></i> Bayar Sekarang
                                            </a>
                                        @elseif($statusLower == 'confirmed')
                                            <a href="{{ route('customer.reservation.downloadTicket', $reservation->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-ticket-alt me-1"></i> E-Tiket
                                            </a>
                                        @elseif($statusLower == 'pending')
                                            <span class="text-muted small italic">Menunggu Approval</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p class="text-muted">Anda belum memiliki riwayat reservasi.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Section --}}
        <div class="col-lg-4">
            @if($latestReservation)
            <div class="card border-0 shadow-sm bg-dark text-white rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 border-bottom border-secondary pb-2">Agenda Terdekat</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tanggal & Waktu</span>
                        <span class="fw-bold text-warning">{{ \Carbon\Carbon::parse($latestReservation->date)->format('d M Y') }} | {{ $latestReservation->time }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Layanan</span>
                        <span class="badge bg-warning text-dark">{{ ucfirst($latestReservation->service_type) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Jumlah Tamu</span>
                        <span class="fw-bold">{{ $latestReservation->guests }} Orang</span>
                    </div>
                    <hr class="border-secondary">
                    <div class="text-center">
                        <small class="d-block text-secondary mb-2">Punya pertanyaan mengenai reservasi ini?</small>
                        <a href="https://wa.me/081617319185" class="btn btn-outline-light w-100 rounded-pill btn-sm">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 text-center bg-light">
                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                <h6>Tidak ada agenda terdekat</h6>
                <p class="small text-muted">Ayo buat reservasi untuk menikmati hidangan kami.</p>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-gold-gradient">
                <div class="card-body p-4 position-relative">
                    <h5 class="fw-bold text-dark">Tulis Ulasan</h5>
                    <p class="small text-dark mb-3">Bagikan pengalaman Anda dan bantu tamu lain mengenal Royal Betutu Raja.</p>
                    <a href="{{ route('customer.reviews.create') }}" class="btn btn-dark btn-sm rounded-pill px-3">Tulis Sekarang</a>
                    <i class="fas fa-star position-absolute end-0 bottom-0 p-3 text-white-50" style="font-size: 4rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
