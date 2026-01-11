@extends('layouts.customer')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-star me-2"></i>Beri Testimoni</h4>
                </div>
                <div class="card-body">
                    <!-- Info Reservasi -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-calendar-check me-2"></i>Detail Reservasi</h6>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($reservation->date)->format('l, d F Y') }}</p>
                        <p class="mb-1"><strong>Waktu:</strong> {{ $reservation->time }}</p>
                        <p class="mb-1"><strong>Jumlah Tamu:</strong> {{ $reservation->guests }} orang</p>
                        <p class="mb-0"><strong>Layanan:</strong> {{ $reservation->service_type }}</p>
                    </div>

                    <form action="{{ route('customer.testimoni.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                <div class="rating-stars mb-2" id="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star-rating" data-rating="{{ $i }}" style="font-size: 30px; cursor: pointer; color: #ddd;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" required>
                                <small class="text-muted">Klik bintang untuk memberikan rating</small>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Pesan Testimoni <span class="text-danger">*</span></label>
                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Bagikan pengalaman Anda di Royal Betutu Raja..."
                                required
                                minlength="10"
                                maxlength="1000"
                            ></textarea>
                            <div class="form-text">Minimal 10 karakter, maksimal 1000 karakter</div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni
                            </button>
                            <a href="{{ route('customer.testimoni.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
