@extends('layouts.admin')

@section('title', 'Kelola Reservasi - Royal Betutu Raja')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-4 px-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1"><i class="bi bi-journal-check me-2 text-primary"></i>Manajemen Reservasi</h2>
            <p class="text-muted">Verifikasi pesanan masuk dan kelola status kunjungan.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <button class="btn btn-outline-primary rounded-3 shadow-sm" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i> Segarkan Data
            </button>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reservation.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="status_filter" class="form-label fw-bold">Filter Status</label>
                    <select name="status" id="status_filter" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="waiting_payment" {{ request('status') == 'waiting_payment' ? 'selected' : '' }}>Waiting Payment</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="date_filter" class="form-label fw-bold">Filter Tanggal</label>
                    <input type="date" name="date" id="date_filter" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.reservation.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-x-circle me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase small fw-bold text-dark">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeReservations as $res)
                    <tr>
                        <td class="ps-4 py-3"><span class="badge bg-dark">#{{ $res->code }}</span></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $res->user ? $res->user->name : $res->name }}</div>
                            <small class="text-muted">{{ $res->guests }} Orang</small>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $res->service_type }}</div>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($res->date)->format('d M Y') }}</div>
                            <small class="text-muted">{{ $res->time }} WITA</small>
                        </td>
                        <td>
                            @if($res->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 rounded-pill">Pending</span>
                            @elseif($res->status == 'waiting_payment')
                                <span class="badge bg-primary text-white px-3 rounded-pill">Waiting Payment</span>
                            @elseif($res->status == 'success')
                                <span class="badge bg-success text-white px-3 rounded-pill">Success</span>
                            @elseif($res->status == 'cancelled')
                                <span class="badge bg-danger text-white px-3 rounded-pill">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($res->status == 'pending')
                                <button class="btn btn-success btn-sm rounded-pill px-3 shadow-sm me-1" onclick="handleAction({{ $res->id }}, 'approve')">
                                    <i class="bi bi-check-circle me-1"></i>Setujui
                                </button>
                                <button class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm" onclick="handleAction({{ $res->id }}, 'reject')">
                                    <i class="bi bi-x-circle me-1"></i>Tolak
                                </button>
                            @elseif($res->status == 'success')
                                <a href="{{ route('admin.reservation.show', $res->id) }}" class="btn btn-info btn-sm rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            @if(request()->has('status') || request()->has('date'))
                                <div class="text-muted">
                                    <i class="bi bi-search me-2"></i>
                                    Tidak ada reservasi yang sesuai dengan filter yang dipilih.
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    Coba ubah kriteria filter atau <a href="{{ route('admin.reservation.index') }}" class="text-decoration-none">reset filter</a>.
                                </small>
                            @else
                                Belum ada reservasi aktif.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($activeReservations->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $activeReservations->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function handleAction(id, type) {
    const actionMap = {
        approve: {
            title: 'Setujui Reservasi?',
            text: 'Customer akan diberikan akses untuk membayar.',
            suffix: 'approve',
            confirmButtonColor: '#198754',
            confirmButtonText: 'Ya, Setujui'
        },
        reject: {
            title: 'Tolak Reservasi?',
            text: 'Reservasi akan dibatalkan dan tidak dapat dikembalikan.',
            suffix: 'reject',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Tolak'
        }
    };

    Swal.fire({
        title: actionMap[type].title,
        text: actionMap[type].text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: actionMap[type].confirmButtonColor,
        confirmButtonText: actionMap[type].confirmButtonText,
        cancelButtonText: 'Batal',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Tampilkan loading yang tidak bisa ditutup manual
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Bagian Fetch yang sudah diperbaiki
            fetch(`/admin/reservation/${id}/${actionMap[type].suffix}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Penting agar Laravel kirim JSON, bukan Redirect
                }
            })
            .then(async res => {
                const contentType = res.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return res.json();
                } else {
                    // Jika server kirim HTML (error), ambil teksnya untuk debug
                    const text = await res.text();
                    console.error("Server Response:", text);
                    throw new Error("Server tidak mengirimkan format JSON yang valid.");
                }
            })
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Refresh halaman agar status berubah
                    });
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan pada sistem.', 'error');
                }
            })
            .catch(err => {
                console.error("Fetch Error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan',
                    text: 'Gagal menghubungi server. Pastikan Controller mengembalikan response JSON.',
                    confirmButtonText: 'Refresh Halaman'
                }).then(() => {
                    location.reload();
                });
            });
        }
    });
}
</script>
@endsection
