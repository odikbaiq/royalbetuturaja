@extends('layouts.app')

@section('content')
<div class="royal-service-page">
    <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Tour Sejarah</h1>
            <p class="fs-5 text-white animated slideInDown">Menjelajahi Warisan Kerajaan Sukawati</p>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 mb-4 text-royal-maroon">Tour Sejarah Puri Ageng Sukawati</h1>
                    <p class="mb-4 fs-5">Memberikan pengalaman mendalam tentang sejarah dan budaya kerajaan Sukawati. Anda akan menjelajahi situs-situs bersejarah dan memahami warisan budaya yang kaya.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-landmark text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Situs Sejarah</h6><small class="text-muted">Eksplorasi Puri</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-user-tie text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Pemandu Ahli</h6><small class="text-muted">Sejarawan Lokal</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-book-open text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Legenda Raja</h6><small class="text-muted">Kisah Autentik</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-camera text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Dokumentasi</h6><small class="text-muted">Foto Area Terbatas</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="position-relative p-4">
                        <div class="image-frame-bg"></div>
                        <div class="shadow rounded overflow-hidden">
                            <img class="img-fluid w-100 service-img" src="{{ asset('img/feature/tur-sejarah.png') }}" alt="Tour Sejarah">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5 bg-light">
        <div class="container text-center">
            <h2 class="display-6 mb-4 text-royal-maroon">Paket Tour Sejarah</h2>
            <div class="card shadow border-0 package-card mx-auto mb-5" style="max-width: 700px;">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
                        <h4 class="mb-0 text-royal-maroon">Heritage Package</h4>
                        <span class="badge fs-6 px-3 py-2 bg-royal-gold btn btn-primary">Rp 100.000</span>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Akses Area Eksklusif Puri</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Pemandu Wisata Profesional</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Brosur Sejarah Eksklusif</li>
                        <li class="mb-0"><i class="fa fa-check me-2 text-royal-maroon"></i> Minuman Tradisional</li>
                    </ul>
                    <a href="{{ route('customer.reservation.create') }}" class="btn btn-lg px-5 py-3 btn-reserve shadow btn btn-primary">
                        <i class="fa fa-calendar-check me-2 btn btn-secondary"></i>Reservasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
