@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('img/feature/galadinner.png') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-7 text-start">
                                    <h1 class="display-2 mb-5 animated slideInDown text-white">Resep Otentik Gungniang Oka
                                    </h1>
                                    <a href="{{ url('/gallery') }}"
                                        class="btn btn-primary rounded-pill py-sm-3 px-sm-5">Galeri</a>
                                    <a href="{{ route('customer.reservation.create') }}"
                                        class="btn btn-secondary rounded-pill py-sm-3 px-sm-5 ms-3">Reservasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="{{ asset('img/about.png') }}" alt="About">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">Royal Betutu Raja</h1>
                    <p class="mb-4">Royal Betutu Raja adalah perwujudan cita rasa luhur yang lahir dari resep warisan
                        turun-temurun keluarga kerajaan Puri
                        Ageng Sukawati, sebuah pusaka kuliner yang dijaga kerahasiaan dan keasliannya selama lintas
                        generasi. Setiap sajian diolah dengan
                        teknik tradisional base genep yang kaya rempah, mencerminkan kemewahan selera para raja dan dedikasi
                        terhadap tradisi adiluhung Bali.
                        Menikmati Royal Betutu Raja bukan sekadar menyantap hidangan, melainkan sebuah perjalanan sensorik
                        yang membawa Anda merasakan kemegahan
                        suasana istana dan kehangatan jamuan makan malam kerajaan yang autentik di setiap suapan...</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="{{ url('/about') }}">Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Start -->
    <div class="container-fluid bg-galeri bg-icon mt-5 py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-7 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 text-black mb-3">Kunjungi Galeri Royal Betutu Raja </h1>
                    <p class="text-black mb-0"> Kunjungi galeri Royal Betutu Raja untuk melihat koleksi dan informasi
                        menarik. </p>
                </div>
                <div class="col-md-5 text-md-end wow fadeIn" data-wow-delay="0.5s">
                    <a class="btn btn-lg btn-primary rounded-pill py-3 px-5" href="{{ url('/gallery') }}">Kunjungi
                        Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Firm Visit End -->

   <div class="container-xxl py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Ketersediaan Jadwal</h6>
            <h1 class="display-5 mb-3 text-dark">Event yang Sudah Dipesan</h1>
            <p class="text-dark">Informasi tanggal yang telah terisi. Silakan pilih tanggal lain untuk kenyamanan reservasi Anda.</p>
        </div>

        @if($bookedEvents->isNotEmpty())
            <div class="row g-4">
                @php
                    $groupedEvents = $bookedEvents->groupBy('service_type');
                @endphp

                @foreach (['Gala Dinner', 'Cooking Class', 'Tour Sejarah'] as $eventType)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-header bg-dark py-3 rounded-top">
                                <h5 class="text-white mb-0 text-center">
                                    <i class="bi bi-calendar-check me-2 text-secondary"></i>{{ $eventType }}
                                </h5>
                            </div>

                            <div class="card-body p-0">
                                @if (isset($groupedEvents[$eventType]))
                                    <ul class="list-group list-group-flush">
                                        @foreach ($groupedEvents[$eventType]->groupBy('date')->sortKeys() as $date => $reservations)
                                            @php
                                                $carbonDate = \Carbon\Carbon::parse($date);
                                            @endphp
                                            <li class="list-group-item p-3 border-0 border-bottom">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary text-white text-center rounded-2 py-2 px-3 me-3" style="min-width: 70px;">
                                                            <span class="d-block fs-4 fw-bold lh-1">{{ $carbonDate->format('d') }}</span>
                                                            <small class="text-uppercase fw-bold" style="font-size: 11px;">{{ $carbonDate->translatedFormat('M') }}</small>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-bold text-dark">{{ $carbonDate->translatedFormat('l') }}</span>
                                                            <small class="text-muted">{{ $carbonDate->format('Y') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                                            {{ $reservations->count() }} Booking
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="py-5 text-center px-4">
                                        <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted small">Belum ada event yang dipesan untuk kategori ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3 shadow-sm p-5 text-center wow fadeInUp">
                <i class="bi bi-calendar-event fs-1 text-primary mb-3"></i>
                <h4 class="fw-bold">Semua Jadwal Tersedia</h4>
                <p class="text-muted mb-0">Belum ada tanggal yang terisi, Anda bebas memilih jadwal reservasi.</p>
            </div>
        @endif
    </div>
</div>

    <!-- Layanan -->
    <div class="container-fluid bg-light bg-icon my-5 py-6">
    <div class="container">
        <div class="section-header text-center mx-auto mb-5" style="max-width: 500px;">
            <h1 class="display-5 mb-3">Layanan Kami</h1>
            <p>Kami memiliki layanan yang terbaik</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow-sm service-card d-flex flex-column">
                    <div class="image-wrapper mb-4">
                        <a href="/services/tour">
                            <img class="img-fluid" src="{{ asset('img/feature/tur-sejarah.png') }}" alt="Tour Sejarah">
                        </a>
                    </div>

                    <div class="content-wrapper flex-grow-1">
                        <h4 class="mb-3 service-title">Tour Sejarah</h4>
                        <p class="mb-4 service-desc">Nikmati perjalanan menyusuri sejarah kerajaan Puri Ageng Sukawati.</p>
                        <div class="mb-3">
                            <span class="text-primary fw-bold">Rp. 100.000</span>
                        </div>
                        <div class="mb-3">
                            <span class="badge rounded-pill bg-success status-badge">Tersedia</span>
                        </div>
                    </div>

                    <div class="button-wrapper mt-auto">
                        <a class="btn btn-primary rounded-pill py-3 px-5 w-100" href="{{ route('public.services.tour') }}">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow-sm service-card d-flex flex-column">
                    <div class="image-wrapper mb-4">
                        <a href="/services/gala-dinner">
                            <img class="img-fluid" src="{{ asset('img/feature/galladinner.png') }}" alt="Gala Dinner">
                        </a>
                    </div>

                    <div class="content-wrapper flex-grow-1">
                        <h4 class="mb-3 service-title">Gala Dinner</h4>
                        <p class="mb-4 service-desc">Makan malam eksklusif dengan menu otentik Raja Bali.</p>
                        <div class="mb-3">
                            <span class="text-primary fw-bold">Rp. 500.000</span>
                        </div>
                        <div class="mb-3">
                            <span class="badge rounded-pill bg-success status-badge">Tersedia</span>
                        </div>
                    </div>

                    <div class="button-wrapper mt-auto">
                        <a class="btn btn-primary rounded-pill py-3 px-5 w-100" href="{{ route('public.services.galaDinner') }}">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white text-center h-100 p-4 p-xl-5 rounded shadow-sm service-card d-flex flex-column">
                    <div class="image-wrapper mb-4">
                        <a href="/services/cooking-class">
                            <img class="img-fluid" src="{{ asset('img/feature/cooking-class.png') }}" alt="Cooking Class">
                        </a>
                    </div>

                    <div class="content-wrapper flex-grow-1">
                        <h4 class="mb-3 service-title">Cooking Class</h4>
                        <p class="mb-4 service-desc">Belajar memasak Bebek Betutu langsung dari ahlinya.</p>
                        <div class="mb-3">
                            <span class="text-primary fw-bold">Rp. 350.000</span>
                        </div>
                        <div class="mb-3">
                            <span class="badge rounded-pill bg-success status-badge">Tersedia</span>
                        </div>
                    </div>

                    <div class="button-wrapper mt-auto">
                        <a class="btn btn-primary rounded-pill py-3 px-5 w-100" href="{{ route('public.services.cookingClass') }}">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Layanan End -->

    <!-- Menu Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 500px;">
                <h1 class="display-5 mb-3">Daftar Menu</h1>
                <p>Royal Betutu Raja memiliki beberapa pilihan makanan dan minuman</p>
            </div>
            <div class="text-center mb-5">
                <ul class="nav nav-pills d-inline-flex justify-content-center">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-secondary border-2 active" data-bs-toggle="pill"
                            href="#tab-1">Makanan</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary border-2" data-bs-toggle="pill" href="#tab-2">Minuman</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane show p-0 active">
                    <div class="row g-4">
                        @forelse($makanan as $item)
                            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="product-item">
                                    <div class="position-relative bg-light overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}">
                                        <div
                                            class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                            Best</div>
                                    </div>
                                    <div class="text-center p-4">
                                        <p class="d-block h5 mb-2">{{ $item->name }}</p>
                                        <span
                                            class="text-black me-1">Rp.{{ number_format($item->price, 0, ',', '.') }}/pax</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p>Belum ada menu makanan terbaik tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div id="tab-2" class="tab-pane fade p-0">
                    <div class="row g-4">
                        @forelse($minuman as $item)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-item">
                                    <div class="position-relative bg-light overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ $item->name }}">
                                        <div
                                            class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                            Best</div>
                                    </div>
                                    <div class="text-center p-4">
                                        <p class="d-block h5 mb-2">{{ $item->name }}</p>
                                        <span
                                            class="text-black me-1">Rp.{{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('public.menu') }}" class="btn btn-primary rounded-pill py-3 px-5">Lihat Selengkapnya</a>
    </div>
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
