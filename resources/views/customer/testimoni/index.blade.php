@extends('layouts.customer')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-comments me-2"></i>Daftar Testimoni Saya</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($testimonials->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Rating</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($testimonial->reservation->date)->format('d M Y') }}</td>
                                        <td>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="ms-2">{{ $testimonial->rating }}/5</span>
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
                                                <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu Persetujuan</span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->created_at->format('d M Y H:i') }}</td>
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
                            <p class="text-muted">Anda belum memberikan testimoni untuk reservasi yang telah selesai.</p>
                            <a href="{{ route('customer.reservation.index') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-check me-2"></i>Lihat Reservasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
