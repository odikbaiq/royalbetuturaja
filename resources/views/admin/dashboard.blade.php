@extends('layouts.admin')

@section('title', 'Dashboard Admin | Royal Betutu Raja')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Dashboard Royal Betutu Raja</h3>
                    <p class="text-muted mb-0">Selamat datang kembali, Panglima Kuliner! Berikut ringkasan hari ini.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('public.home') }}" class="btn btn-outline-dark rounded-pill px-4">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase small fw-bold mb-1">Total Reservasi</p>
                            <h2 class="fw-bold mb-0">{{ $totalReservations }}</h2>
                        </div>
                        <div class="icon-shape bg-gold-soft text-gold rounded-3 p-3">
                            <i class="fas fa-calendar-check fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($reservationPercentage >= 0)
                            <span class="text-success small fw-bold"><i class="fas fa-arrow-up"></i> {{ number_format($reservationPercentage, 1) }}%</span>
                        @else
                            <span class="text-danger small fw-bold"><i class="fas fa-arrow-down"></i> {{ number_format(abs($reservationPercentage), 1) }}%</span>
                        @endif
                        <span class="text-muted small ms-1">dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase small fw-bold mb-1">Dikonfirmasi</p>
                            <h2 class="fw-bold mb-0">{{ $confirmedReservations }}</h2>
                        </div>
                        <div class="icon-shape bg-primary-soft text-primary rounded-3 p-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small fw-bold">Rasio Konfirmasi: </span>
                        <span class="badge bg-primary-soft text-primary rounded-pill">Tinggi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase small fw-bold mb-1">Total Pendapatan</p>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue / 1000000, 1) }}jt</h2>
                        </div>
                        <div class="icon-shape bg-success-soft text-success rounded-3 p-3">
                            <i class="fas fa-wallet fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-muted small">
                         Total: <strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase small fw-bold mb-1">Customer</p>
                            <h2 class="fw-bold mb-0">{{ $totalCustomers }}</h2>
                        </div>
                        <div class="icon-shape bg-info-soft text-info rounded-3 p-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted small">Pelanggan terdaftar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Tren Pendapatan Bulanan</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Peminatan Layanan</h5>
                </div>
                <div class="card-body px-4 pb-4 d-flex align-items-center">
                    <canvas id="serviceChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Reservasi Terbaru</h5>
                    <button class="btn btn-light btn-sm rounded-pill px-3">Lihat Semua</button>
                </div>
                <div class="table-responsive px-4 pb-4">
                    <table class="table align-middle table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start ps-3">ID</th>
                                <th class="border-0">Customer</th>
                                <th class="border-0">Layanan</th>
                                <th class="border-0">Tanggal</th>
                                <th class="border-0">Status</th>
                                <th class="border-0 rounded-end text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReservations as $reservation)
                            <tr>
                                <td class="ps-3 fw-bold text-muted">#{{ $reservation->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                            {{ strtoupper(substr($reservation->user->name, 0, 2)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $reservation->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $reservation->service_type }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d M, Y') }}</td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'Dikonfirmasi' => 'bg-success-soft text-success',
                                            'Pending' => 'bg-warning-soft text-warning',
                                            'Batal' => 'bg-danger-soft text-danger'
                                        ][$reservation->status] ?? 'bg-secondary-soft text-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.reservation.show', $reservation->id) }}" class="btn btn-sm btn-dark rounded-pill px-3">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --royal-maroon: #700505;
        --royal-gold: #c5a059;
    }

    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }

    .text-primary { color: var(--royal-maroon) !important; }
    .text-gold { color: var(--royal-gold) !important; }
    .bg-primary-soft { background-color: rgba(112, 5, 5, 0.1); }
    .bg-gold-soft { background-color: rgba(197, 160, 89, 0.1); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }

    .card { border: none; transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table thead th {
        color: #8898aa;
        font-size: .85rem;
        padding-top: .75rem;
        padding-bottom: .75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .btn-dark { background-color: var(--royal-maroon); border-color: var(--royal-maroon); }
    .btn-dark:hover { background-color: #5a0404; border-color: #5a0404; }

    .btn-outline-dark { color: var(--royal-maroon); border-color: var(--royal-maroon); }
    .btn-outline-dark:hover { background-color: var(--royal-maroon); color: white; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service Chart
        const serviceCtx = document.getElementById('serviceChart');
        if (serviceCtx) {
            const serviceData = @json($reservationsByService);
            new Chart(serviceCtx, {
                type: 'doughnut',
                data: {
                    labels: serviceData.map(item => item.service_type + ' (' + item.percentage + '%)'),
                    datasets: [{
                        data: serviceData.map(item => item.percentage),
                        backgroundColor: ['#700505', '#c5a059', '#2c3e50', '#95a5a6'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const revenueData = @json($monthlyRevenue);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueData.map(item => months[item.month - 1]),
                    datasets: [{
                        label: 'Pendapatan',
                        data: revenueData.map(item => item.revenue),
                        borderColor: '#700505',
                        backgroundColor: 'rgba(112, 5, 5, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
@endsection
