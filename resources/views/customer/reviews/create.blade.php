@extends('layouts.customer')

@section('title', 'Tulis Ulasan - Royal Betutu Raja')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Tulis Ulasan</h1>
            <p class="mb-4">Bagikan pengalaman Anda dan bantu tamu lain mengenal Royal Betutu Raja</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded p-5">
                    <form method="POST" action="{{ route('customer.reviews.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Rating</label>
                            <div class="rating-stars">
                                <div class="stars" id="rating-stars">
                                    <i class="star-rating far fa-star" data-rating="1"></i>
                                    <i class="star-rating far fa-star" data-rating="2"></i>
                                    <i class="star-rating far fa-star" data-rating="3"></i>
                                    <i class="star-rating far fa-star" data-rating="4"></i>
                                    <i class="star-rating far fa-star" data-rating="5"></i>
                                </div>
                                <input type="hidden" name="rating" id="rating-input" required>
                                <div class="rating-text mt-2" id="rating-text">Pilih rating</div>
                            </div>
                            @error('rating')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Komentar</label>
                            <textarea
                                class="form-control"
                                id="comment"
                                name="comment"
                                rows="5"
                                placeholder="Bagikan pengalaman Anda di Royal Betutu Raja..."
                                required
                            ></textarea>
                            @error('comment')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Ulasan Anda akan ditampilkan setelah disetujui oleh admin.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
