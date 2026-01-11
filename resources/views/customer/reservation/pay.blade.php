@extends('layouts.customer')

@section('title', 'Pembayaran Reservasi - Royal Betutu Raja')

@section('scripts')
{{-- Gunakan sandbox untuk testing, ganti ke app.midtrans.com saat production --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>
{{-- Pastikan SweetAlert2 terpasang untuk notifikasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container">
        {{-- Breadcrumb & Header --}}
        <div class="row mb-4">
            <div class="col-12 text-center text-lg-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}" class="text-gold text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('customer.reservation.index') }}" class="text-gold text-decoration-none">Reservasi</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark border-bottom pb-3">Bayar Reservasi Anda</h2>
                <p class="text-muted">Lengkapi pembayaran untuk mengonfirmasi reservasi Anda.</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- Detail Reservasi & Tagihan --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-receipt me-2"></i>Detail Reservasi</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <small class="text-muted d-block">Kode Reservasi</small>
                                <span class="fw-bold text-dark">#{{ $reservation->code }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Tanggal Event</small>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Waktu</small>
                                <span class="fw-bold text-dark">{{ $reservation->time }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Jumlah Tamu</small>
                                <span class="fw-bold text-dark">{{ $reservation->guests }} orang</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <small class="text-muted d-block">Layanan</small>
                            <span class="fw-bold text-dark">{{ $reservation->service_type }}</span>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 border-start border-4 border-primary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Total Pembayaran</small>
                                    <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</h3>
                                </div>
                                <span class="badge bg-success text-white px-3 py-2">
                                    Disetujui
                                </span>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 d-flex align-items-center" role="alert">
                            <i class="bi bi-shield-check fs-4 me-3"></i>
                            <div>
                                Pembayaran diproses secara aman melalui Midtrans. Status reservasi akan berubah menjadi <strong>Selesai</strong> secara otomatis setelah pembayaran berhasil.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Aksi --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-primary text-white py-3 text-center">
                        <h5 class="card-title mb-0">Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <p class="small text-muted mb-4">Pilih metode pembayaran yang tersedia.</p>

                        <div class="d-grid gap-3">
                            <button type="button" class="btn btn-primary btn-lg py-3 rounded-pill fw-bold shadow-sm" id="pay-button">
                                <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                            </button>

                            <a href="{{ route('customer.reservation.index') }}" class="btn btn-outline-dark btn-lg py-3 rounded-pill fw-bold">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        <hr class="my-4">

                        <div class="text-center opacity-75">
                            <small class="text-muted">Didukung oleh</small><br>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_GPN.png" alt="GPN" height="25" class="mx-2 grayscale">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_QRIS.svg" alt="QRIS" height="20" class="mx-2 grayscale">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        const snapToken = '{{ $reservation->snap_token }}';

        if (!snapToken) {
            Swal.fire('Error', 'Token pembayaran tidak ditemukan. Silakan coba lagi.', 'error');
            return;
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                Swal.fire('Berhasil!', 'Pembayaran berhasil. Reservasi Anda telah dikonfirmasi.', 'success').then(() => {
                    window.location.href = '{{ route("customer.reservation.index") }}';
                });
            },
            onPending: function(result) {
                Swal.fire('Menunggu', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.', 'info').then(() => {
                    window.location.href = '{{ route("customer.reservation.index") }}';
                });
            },
            onError: function(result) {
                Swal.fire('Gagal', 'Pembayaran gagal. Silakan coba lagi.', 'error');
            },
            onClose: function() {
                console.log('User closed the snap popup without finishing the payment');
            }
        });
    });
</script>

<style>
    .text-gold { color: #D4AF37; }
    .bg-dark { background-color: #1a1a1a !important; }
    .grayscale { filter: grayscale(100%); opacity: 0.6; }
    .btn-primary { background-color: #8B0000; border: none; }
    .btn-primary:hover { background-color: #660000; }
    .border-primary { border-color: #8B0000 !important; }
</style>
@endsection
