@extends('layouts.customer')

@section('title', 'Status Transaksi - Royal Betutu Raja')

@section('content')
<div class="container-fluid py-5 mt-5" style="background-color: #fcfcfc;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Status Header --}}
                <div class="text-center mb-5">
                    @php $status = $reservation->status; @endphp

                    @if($status === 'waiting_payment')
                        <div class="status-icon-box bg-warning-light text-warning mb-4 mx-auto shadow-sm">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Menunggu Pembayaran</h2>
                        <p class="text-muted mx-auto" style="max-width: 500px;">Reservasi Anda disetujui dan menunggu pembayaran. Silakan klik "Bayar Sekarang" untuk melanjutkan.</p>
                    @elseif($status === 'lunas')
                        <div class="status-icon-box bg-success-light text-success mb-4 mx-auto shadow-sm">
                            <i class="bi bi-check2-all"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Pembayaran Berhasil</h2>
                        <p class="text-muted mx-auto" style="max-width: 500px;">Terima kasih — pembayaran Anda telah diverifikasi. E-Tiket tersedia.</p>
                    @elseif($status === 'pending')
                        <div class="status-icon-box bg-maroon-light text-maroon mb-4 mx-auto shadow-sm">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Menunggu Persetujuan</h2>
                        <p class="text-muted mx-auto" style="max-width: 500px;">Permintaan reservasi Anda sedang ditinjau oleh admin. Anda akan diberitahu jika disetujui.</p>
                    @elseif($payment && $payment->status == 'pending')
                        <div class="status-icon-box bg-warning-light text-warning mb-4 mx-auto shadow-sm">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Menunggu Verifikasi</h2>
                        <p class="text-muted">Pembayaran Anda sedang kami proses. Mohon tunggu beberapa saat.</p>
                    @else
                        <div class="status-icon-box bg-maroon-light text-maroon mb-4 mx-auto shadow-sm">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">Selesaikan Pembayaran</h2>
                        <p class="text-muted">Jika reservasi sudah disetujui, Anda dapat melanjutkan ke pembayaran.</p>
                    @endif
                </div>

                {{-- Luxury Stepper --}}
                <div class="stepper-wrapper mb-5">
                    <div class="stepper-item active">
                        <div class="step-counter"><i class="bi bi-journal-check"></i></div>
                        <div class="step-name">RESERVASI</div>
                    </div>
                    <div class="stepper-item {{ $payment ? 'active' : '' }}">
                        <div class="step-counter"><i class="bi bi-wallet2"></i></div>
                        <div class="step-name">PEMBAYARAN</div>
                    </div>
                    <div class="stepper-item {{ $reservation->status == 'confirmed' ? 'active' : '' }}">
                        <div class="step-counter"><i class="bi bi-ticket-perforated"></i></div>
                        <div class="step-name">E-TIKET</div>
                    </div>
                </div>

                {{-- Detail Information Card --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-maroon p-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white tracking-widest text-uppercase">Detail Konfirmasi</h6>
                        <span class="badge bg-gold text-white px-3 py-2 rounded-0">ID #{{ $reservation->id }}</span>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-6 col-md-3">
                                <label class="text-muted small d-block mb-1 text-uppercase tracking-wider">Layanan</label>
                                <span class="fw-bold text-dark">{{ $reservation->service_type }}</span>
                            </div>
                            <div class="col-6 col-md-5">
                                <label class="text-muted small d-block mb-1 text-uppercase tracking-wider">Tanggal & Waktu</label>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }} | {{ $reservation->time }}</span>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="text-muted small d-block mb-1 text-uppercase tracking-wider">Tamu</label>
                                <span class="fw-bold text-dark">{{ $reservation->guests }} Orang</span>
                            </div>
                            <div class="col-6 col-md-2 text-md-end">
                                <label class="text-muted small d-block mb-1 text-uppercase tracking-wider">Status</label>
                                @php $s = $reservation->status; @endphp
                                @if($s === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($s === 'waiting_payment')
                                    <span class="badge bg-info text-dark">Waiting Payment</span>
                                @elseif($s === 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif(in_array($s, ['cancelled','rejected']))
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @elseif($s === 'completed')
                                    <span class="badge bg-secondary">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($s) }}</span>
                                @endif
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="text-maroon fw-bold mb-0">Total Pembayaran</h5>
                                <small class="text-muted italic">Sudah termasuk pajak & layanan</small>
                            </div>
                            <h3 class="fw-bold text-dark mb-0">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="row g-3 justify-content-center">
                    @php $s = $reservation->status; @endphp

                    @if($s === 'lunas')
                        <div class="col-md-5">
                            <a href="{{ route('customer.reservation.viewTicket', $reservation->id) }}" class="btn btn-maroon w-100 py-3 rounded-0 shadow-sm fw-bold">
                                <i class="bi bi-ticket-detailed me-2"></i> LIHAT E-TIKET
                            </a>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ route('customer.reservation.downloadTicket', $reservation->id) }}" class="btn btn-outline-dark w-100 py-3 rounded-0 fw-bold">
                                <i class="bi bi-download me-2"></i> DOWNLOAD PDF
                            </a>
                        </div>
                    @elseif($s === 'waiting_payment')
                        <div class="col-md-6">
                            <a href="{{ route('customer.payment.pay', $reservation) }}" class="btn btn-primary w-100 py-3 rounded-0 fw-bold">
                                <i class="bi bi-wallet2 me-2"></i> BAYAR SEKARANG
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button onclick="location.reload()" class="btn btn-maroon w-100 py-3 rounded-0 fw-bold">
                                <i class="bi bi-arrow-clockwise me-2"></i> PERBARUI STATUS
                            </button>
                        </div>
                    @else
                        <div class="col-md-6">
                            <button onclick="location.reload()" class="btn btn-maroon w-100 py-3 rounded-0 fw-bold">
                                <i class="bi bi-arrow-clockwise me-2"></i> PERBARUI STATUS
                            </button>
                        </div>
                    @endif

                    <div class="col-12 text-center mt-4">
                        <a href="{{ route('customer.dashboard') }}" class="text-decoration-none text-muted small fw-bold tracking-widest text-uppercase border-bottom pb-1">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Royal Color Palette */
    :root {
        --maroon: #8B0000;
        --maroon-hover: #610000;
        --gold: #D4AF37;
    }

    .bg-maroon { background-color: var(--maroon) !important; }
    .text-maroon { color: var(--maroon) !important; }
    .bg-gold { background-color: var(--gold) !important; }
    .bg-maroon-light { background-color: rgba(139, 0, 0, 0.05); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.08); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.08); }

    /* Icons Box */
    .status-icon-box {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    /* Professional Stepper */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }
    .stepper-wrapper::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #e9ecef;
        z-index: 1;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        z-index: 2;
    }
    .step-counter {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        color: #adb5bd;
        transition: all 0.4s ease;
    }
    .stepper-item.active .step-counter {
        background: var(--maroon);
        color: white;
        border-color: var(--maroon);
        box-shadow: 0 4px 10px rgba(139, 0, 0, 0.2);
    }
    .step-name {
        font-size: 11px;
        font-weight: 800;
        color: #adb5bd;
        letter-spacing: 1px;
    }
    .stepper-item.active .step-name {
        color: var(--maroon);
    }

    /* Buttons */
    .btn-maroon {
        background-color: var(--maroon);
        color: white;
        border: none;
        transition: 0.3s;
    }
    .btn-maroon:hover {
        background-color: var(--maroon-hover);
        color: white;
        transform: translateY(-2px);
    }
    .tracking-wider { letter-spacing: 1px; }
    .tracking-widest { letter-spacing: 2px; }
</style>
@endsection
