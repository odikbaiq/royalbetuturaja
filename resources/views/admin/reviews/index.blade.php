@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-star me-2"></i>Kelola Ulasan</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($reviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Rating</th>
                                        <th>Komentar</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $review->user->name ?? 'Unknown' }}</div>
                                                    <small class="text-muted">{{ $review->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= ($review->rating ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="ms-2 badge bg-secondary">{{ $review->rating ?? 0 }}/5</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;">
                                                {{ strlen($review->comment ?? '') > 100 ? substr($review->comment ?? '', 0, 100) . '...' : $review->comment ?? '' }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($review->is_visible)
                                                <span class="badge bg-success"><i class="fas fa-eye me-1"></i>Visible</span>
                                            @else
                                                <span class="badge bg-warning"><i class="fas fa-eye-slash me-1"></i>Hidden</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at ? $review->created_at->format('d M Y H:i') : 'N/A' }}</td>
                                        <td>
                                            @if(!$review->is_visible)
                                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui Ulasan">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Ulasan">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $reviews->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada ulasan</h5>
                            <p class="text-muted">Belum ada pelanggan yang memberikan ulasan.</p>
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
