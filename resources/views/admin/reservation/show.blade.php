@extends('layouts.admin')

@section('title', 'Lembar Konfirmasi Reservasi Tamu - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Lembar Konfirmasi Reservasi Tamu</h3>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.reservation.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Profil Korespondensi Tamu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pelanggan:</strong> {{ $reservation->user ? $reservation->user->name : $reservation->name }}</p>
                            <p><strong>Email:</strong> {{ $reservation->user ? $reservation->user->email : $reservation->email }}</p>
                            <p><strong>Tanggal Reservasi:</strong> {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('d F Y') }}</p>
                            <p><strong>Waktu:</strong> {{ $reservation->time }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Kapasitas Kursi:</strong> {{ $reservation->guests }}</p>
                            <p><strong>Layanan:</strong> {{ ucfirst($reservation->service_type) }}</p>
                            <p><strong>Status:</strong>
    @if($reservation->status == 'pending')
        <span class="badge bg-warning text-dark">Menunggu Tinjauan</span>
    @elseif($reservation->status == 'approved' || $reservation->status == 'success')
        <span class="badge bg-success">Reservasi Terkonfirmasi</span>
    @elseif($reservation->status == 'waiting_payment')
        <span class="badge bg-info text-dark">Menunggu Pembayaran</span>
    @elseif($reservation->status == 'rejected' || $reservation->status == 'cancelled')
        <span class="badge bg-danger">Reservasi Dibatalkan</span>
    @else
        <span class="badge bg-secondary">{{ ucfirst($reservation->status) }}</span>
        {{-- Ini akan menampilkan teks asli jika status tidak cocok dengan di atas --}}
    @endif
</p>
                            <p><strong>Total Harga:</strong> Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @if($reservation->notes)
                    <div class="mt-3">
                        <strong>Permintaan Khusus (Special Requests):</strong>
                        <p>{{ $reservation->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-secondary">Pembayaran</h5>
                </div>
                <div class="card-body">
                    @if($reservation->payment)
                        <p><strong>Status:</strong>
                            <span class="badge {{ $reservation->payment->verified ? 'bg-success' : 'bg-warning' }}">
                                {{ $reservation->payment->verified ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                            </span>
                        </p>
                        <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($reservation->payment->amount, 0, ',', '.') }}</p>
                        <p><strong>Metode:</strong> {{ $reservation->payment->method }}</p>
                        @if($reservation->payment->proof)
                        <p><strong>Bukti Bayar:</strong> <a href="{{ asset('storage/' . $reservation->payment->proof) }}" target="_blank">Lihat</a></p>
                        @endif
                    @else
                        <p class="text-muted">Belum ada pembayaran</p>
                    @endif
                </div>
            </div>

            @if($reservation->status == 'pending')
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reservation.approve', $reservation) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success me-2">Setujui</button>
                    </form>
                    <form action="{{ route('admin.reservation.reject', $reservation) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
