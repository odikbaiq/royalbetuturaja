@extends('layouts.customer')

@section('title', 'Pembayaran Aman - Royal Betutu Raja')

@section('content')
    <div class="container-fluid py-5 mt-5" style="background: #f8f9fa; min-height: 90vh;">
        <div class="container">
            {{-- Header Section --}}
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"
                                    class="text-gold text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.payment.index') }}"
                                    class="text-gold text-decoration-none">Daftar Pembayaran</a></li>
                            <li class="breadcrumb-item active text-dark fw-bold">Konfirmasi</li>
                        </ol>
                    </nav>
                    <h2 class="display-6 fw-bold text-dark mt-2">Selesaikan Reservasi Anda</h2>
                    <div class="mx-auto" style="width: 80px; height: 4px; background: #8B0000; border-radius: 2px;"></div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                {{-- Ringkasan Tagihan (Kiri) --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                        <div class="card-header bg-dark py-3">
                            <h5 class="card-title mb-0 text-white d-flex align-items-center">
                                <i class="bi bi-receipt-cutoff me-2 text-gold"></i> Ringkasan Detail Reservasi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small uppercase">Kode Transaksi</span>
                                <span class="fw-bold text-dark">#{{ $reservation->code }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Tipe Layanan</span>
                                <span class="fw-bold">{{ ucfirst($reservation->service_type) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Waktu Kedatangan</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }} |
                                    {{ $reservation->time }}</span>
                            </div>

                            <div class="mt-4 p-3 rounded-3"
                                style="background: rgba(139, 0, 0, 0.05); border: 1px dashed #8B0000;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h6 mb-0 text-dark fw-bold">Total Pembayaran</span>
                                    <span class="h4 mb-0 fw-bold" style="color: #8B0000;">Rp
                                        {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Panel Pembayaran (Kanan) --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 h-100 text-center p-4">
                        <div class="mb-4">
                            <div class="icon-circle mx-auto bg-primary text-white mb-3 shadow-sm"
                                style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #8B0000 !important;">
                                <i class="bi bi-shield-lock-fill fs-2"></i>
                            </div>
                            <h5 class="fw-bold">Metode Pembayaran</h5>
                            <p class="text-muted small">Silakan klik tombol di bawah untuk memilih metode pembayaran melalui
                                Midtrans.</p>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="button"
                                class="btn btn-primary btn-lg py-3 rounded-pill fw-bold shadow-sm hover-up" id="pay-button">
                                <i class="bi bi-credit-card-2-back me-2"></i> BAYAR SEKARANG
                            </button>

                            <a href="{{ route('customer.payment.index') }}"
                                class="btn btn-outline-dark btn-lg py-3 rounded-pill fw-bold transition">
                                <i class="bi bi-arrow-left me-2"></i> Batalkan
                            </a>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <p class="text-muted x-small mb-2">Didukung secara aman oleh:</p>
                            <img src="https://midtrans.com/assets/img/logo-midtrans-color.svg" alt="Midtrans Logo"
                                style="height: 20px; opacity: 0.7;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- Midtrans Snap --}}
    <script type="text/javascript"
        src="{{ config('midtrans.isProduction') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');

            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyiapkan Pembayaran',
                        text: 'Mohon tunggu sebentar...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Ambil Snap Token dari Controller
                    fetch('{{ route('customer.payment.process', $reservation->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Gagal menghubungi server');
                            return response.json();
                        })
                        .then(data => {
                            Swal.close();

                            if (data.error) {
                                Swal.fire('Gagal!', data.error, 'error');
                                return;
                            }

                            // Munculkan Popup Midtrans
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    Swal.fire('Berhasil!', 'Pembayaran telah kami terima.',
                                            'success')
                                        .then(() => {
                                            // Ubah arah redirect ke Payment Index
                                            window.location.href =
                                                '{{ route('customer.payment.index') }}';
                                        });
                                },
                                onPending: function(result) {
                                    Swal.fire('Menunggu!',
                                            'Selesaikan pembayaran Anda segera.', 'info')
                                        .then(() => window.location.href =
                                            '{{ route('customer.payment.index') }}');
                                },
                                onError: function(result) {
                                    Swal.fire('Error!', 'Terjadi kesalahan pembayaran.',
                                        'error');
                                },
                                onClose: function() {
                                    Swal.fire({
                                        text: 'Jendela pembayaran ditutup.',
                                        icon: 'warning',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            });
                        })
                        .catch(error => {
                            Swal.close();
                            console.error('Error:', error);
                            Swal.fire('Sistem Error', 'Tidak dapat terhubung ke Midtrans.', 'error');
                        });
                });
            }
        });
    </script>
@endpush

<style>
    .text-gold {
        color: #D4AF37;
    }

    .text-gold:hover {
        color: #B8860B;
    }

    .btn-primary {
        background-color: #8B0000;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #a50000;
        transform: translateY(-2px);
    }

    .hover-up:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .transition {
        transition: all 0.3s ease;
    }

    .x-small {
        font-size: 0.75rem;
    }
</style>
