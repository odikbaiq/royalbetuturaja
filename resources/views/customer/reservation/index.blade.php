@extends('layouts.customer')

@section('title', 'Daftar Reservasi - Royal Betutu Raja')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Daftar Reservasi</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Reservasi Saya</h4>
                        <a href="{{ route('customer.reservation.create') }}" class="btn btn-primary rounded-pill">
                            <i class="bi bi-plus-lg me-2"></i>Buat Reservasi Baru
                        </a>
                    </div>

                    @if($reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tanggal & Waktu</th>
                                        <th>Layanan</th>
                                        <th>Jumlah Orang</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr data-reservation-id="{{ $reservation->id }}">
                                            <td>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $reservation->time }} WITA</small>
                                            </td>
                                            <td>{{ ucfirst($reservation->service_type) }}</td>
                                            <td>{{ $reservation->guests }} Orang</td>
                                            <td class="fw-bold">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @php $status = $reservation->status; @endphp

                                                {{-- Logika Status --}}
                                                @if($status === 'pending')
                                                    <span class="badge bg-secondary px-3 py-2 status-badge">Menunggu Konfirmasi Admin</span>
                                                @elseif($status === 'waiting_payment')
                                                    <span class="badge bg-warning text-dark px-3 py-2 status-badge">Menunggu Pembayaran</span>
                                                @elseif(in_array($status, ['success', 'settlement', 'completed']))
                                                    <span class="badge bg-success px-3 py-2 text-white status-badge">Lunas / Berhasil</span>
                                                @elseif(in_array($status, ['cancelled', 'expire', 'failed']))
                                                    <span class="badge bg-danger px-3 py-2 text-white status-badge">Gagal / Kadaluwarsa</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2 status-badge">{{ ucfirst($status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center action-buttons">
                                                {{-- JIKA MENUNGGU KONFIRMASI --}}
                                                @if($status === 'pending')
                                                    <form action="{{ route('customer.reservation.destroy', $reservation) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                                onclick="return confirm('Batalkan reservasi ini?')">
                                                            <i class="bi bi-trash"></i> Batal
                                                        </button>
                                                    </form>

                                                {{-- JIKA BELUM BAYAR --}}
                                                @elseif($status === 'waiting_payment')
                                                    <a href="{{ route('customer.payment.pay', $reservation) }}"
                                                       class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm pay-button">
                                                       <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                                                    </a>

                                                {{-- JIKA SUDAH LUNAS --}}
                                                @elseif(in_array($status, ['success', 'settlement', 'completed']))
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('customer.reservation.viewTicket', $reservation) }}"
                                                           class="btn btn-sm btn-success rounded-start-pill px-3 text-white">
                                                           <i class="bi bi-ticket-perforated me-1"></i> Lihat Tiket
                                                        </a>
                                                        <a href="{{ route('customer.reservation.downloadTicket', $reservation) }}"
                                                           class="btn btn-sm btn-outline-success rounded-end-pill px-3">
                                                           <i class="bi bi-download"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada reservasi</h5>
                            <p class="text-muted mb-4">Buat reservasi pertama Anda untuk menikmati hidangan Royal Betutu Raja.</p>
                            <a href="{{ route('customer.reservation.create') }}" class="btn btn-primary rounded-pill px-4">Buat Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Store initial statuses
    const initialStatuses = {};
    document.querySelectorAll('tr[data-reservation-id]').forEach(row => {
        const id = row.getAttribute('data-reservation-id');
        const badge = row.querySelector('.status-badge');
        initialStatuses[id] = badge ? badge.textContent.trim() : '';
    });

    // Function to check for status updates
    function checkStatusUpdates() {
        fetch('/customer/reservation/statuses/get', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update each row if status changed
            document.querySelectorAll('tr[data-reservation-id]').forEach(row => {
                const id = row.getAttribute('data-reservation-id');
                const currentStatus = data[id];

                if (currentStatus && initialStatuses[id] !== getStatusText(currentStatus)) {
                    updateRowStatus(row, currentStatus);
                    initialStatuses[id] = getStatusText(currentStatus);
                }
            });
        })
        .catch(error => {
            console.error('Error checking status updates:', error);
        });
    }

    // Function to get status text based on status value
    function getStatusText(status) {
        if (status === 'pending') {
            return 'Menunggu Konfirmasi Admin';
        } else if (status === 'waiting_payment') {
            return 'Menunggu Pembayaran';
        } else if (['success', 'settlement', 'completed'].includes(status)) {
            return 'Lunas / Berhasil';
        } else if (['cancelled', 'expire', 'failed'].includes(status)) {
            return 'Gagal / Kadaluwarsa';
        } else {
            return status.charAt(0).toUpperCase() + status.slice(1);
        }
    }

    // Function to update row status and buttons
    function updateRowStatus(row, newStatus) {
        const badge = row.querySelector('.status-badge');
        const actionButtons = row.querySelector('.action-buttons');
        const reservationId = row.getAttribute('data-reservation-id');

        // Update badge
        badge.className = 'badge px-3 py-2 status-badge';
        badge.textContent = getStatusText(newStatus);

        if (newStatus === 'pending') {
            badge.classList.add('bg-secondary');
        } else if (newStatus === 'waiting_payment') {
            badge.classList.add('bg-warning', 'text-dark');
        } else if (['success', 'settlement', 'completed'].includes(newStatus)) {
            badge.classList.add('bg-success', 'text-white');
        } else if (['cancelled', 'expire', 'failed'].includes(newStatus)) {
            badge.classList.add('bg-danger', 'text-white');
        } else {
            badge.classList.add('bg-secondary');
        }

        // Update action buttons
        if (newStatus === 'pending') {
            actionButtons.innerHTML = `
                <form action="/customer/reservation/${reservationId}" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                            onclick="return confirm('Batalkan reservasi ini?')">
                        <i class="bi bi-trash"></i> Batal
                    </button>
                </form>
            `;
        } else if (newStatus === 'waiting_payment') {
            actionButtons.innerHTML = `
                <a href="/customer/payment/${reservationId}/pay"
                   class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm pay-button">
                    <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                </a>
            `;
        } else if (['success', 'settlement', 'completed'].includes(newStatus)) {
            actionButtons.innerHTML = `
                <div class="btn-group" role="group">
                    <a href="/customer/reservation/${reservationId}/view-ticket"
                       class="btn btn-sm btn-success rounded-start-pill px-3 text-white">
                        <i class="bi bi-ticket-perforated me-1"></i> Lihat Tiket
                    </a>
                    <a href="/customer/reservation/${reservationId}/download-ticket"
                       class="btn btn-sm btn-outline-success rounded-end-pill px-3">
                        <i class="bi bi-download"></i>
                    </a>
                </div>
            `;
        } else {
            actionButtons.innerHTML = '';
        }
    }

    // Check for updates every 5 seconds
    setInterval(checkStatusUpdates, 5000);
});
</script>
@endsection
