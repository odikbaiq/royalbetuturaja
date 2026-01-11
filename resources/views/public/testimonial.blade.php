@extends('layouts.app')

@section('content')
<div class="royal-testimonial">
    <section>
        <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
                <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Testimoni</h1>
                <p class="fs-5 text-white">Apa Kata Mereka Tentang Royal Betutu Raja</p>
            </div>
        </div>
            <!-- Testimonial Start -->
    <div class="container-fluid bg-light bg-icon py-6 mb-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px;">
                <h1 class="display-5 mb-3">Ulasan Pelanggan</h1>
                <p>Kami bangga bisa menghadirkan pengalaman kuliner tradisional Bali yang autentik. Berikut
                    beberapa pengalaman dari tamu setia kami:</p>
            </div>

            @if ($reviews->count() > 0)
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
                    @foreach ($reviews as $review)
                        <div class="testimonial-item position-relative">
                            <i class="fa fa-quote-left fa-2x position-absolute top-0 start-0 mt-3 ms-4"
                                style="color: #D4AF37; opacity: 0.7;"></i>
                            <div class="rating-stars mb-3 mt-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#D4AF37' : '#e9ecef' }};"></i>
                                @endfor
                                <span class="ms-2 small text-muted">{{ $review->rating }}/5</span>
                            </div>
                            <p class="mb-4" style="font-family: 'Georgia', serif; font-size: 16px; line-height: 1.6;">"{{ $review->comment }}"</p>
                            <div class="d-flex align-items-center mt-auto">
                                <div class="flex-shrink-0">
                                    @if($review->user->profile_picture)
                                        <img src="{{ asset('storage/profiles/' . $review->user->profile_picture) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #D4AF37;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px; background: linear-gradient(135deg, #8B0000, #D4AF37); color: #ffffff; font-size: 24px; font-weight: bold;">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-1" style="color: #8B0000; font-family: 'Arial', sans-serif; font-weight: 600;">{{ $review->user->name }}</h5>
                                    <span class="text-muted small" style="font-size: 12px;">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('public.testimonial') }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Testimoni
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada testimoni</h5>
                    <p class="text-muted">Testimoni dari pelanggan akan segera ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </div>
    <!-- Testimonial End -->
@endsection
