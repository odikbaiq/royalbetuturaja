@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-comments me-2"></i>Kelola Testimoni</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($testimonials->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Rating</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $testimonial->user->name }}</div>
                                                    <small class="text-muted">{{ $testimonial->user->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($testimonial->reservation->date)->format('d M Y') }}</td>
                                        <td>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="ms-2 badge bg-secondary">{{ $testimonial->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $testimonial->message }}">
                                                {{ Str::limit($testimonial->message, 100) }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($testimonial->is_approved)
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Disetujui</span>
                                            @else
                                                <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @if(!$testimonial->is_approved)
                                                <form action="{{ route('admin.testimoni.approve', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui Testimoni">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.testimoni.destroy', $testimonial->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Testimoni">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $testimonials->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada testimoni</h5>
                            <p class="text-muted">Belum ada pelanggan yang memberikan testimoni.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rating-stars .fa-star {
    font-size: 14px;
}
.table th {
    vertical-align: middle;
}
.table td {
    vertical-align: middle;
}
</style>
@endpush
