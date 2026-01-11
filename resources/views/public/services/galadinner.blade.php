@extends('layouts.app')

@section('content')
<div class="royal-service-page">
    <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Gala Dinner</h1>
            <p class="fs-5 text-white animated slideInDown">Pengalaman Kuliner Istana yang Tak Terlupakan</p>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 mb-4 text-royal-maroon">Gala Dinner di Royal Betutu Raja</h1>
                    <p class="mb-4 fs-5">Nikmati pengalaman makan malam istimewa dengan hidangan tradisional Bali autentik, disajikan dalam suasana kerajaan yang megah di Puri Ageng Sukawati.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-utensils text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Menu Otentik</h6><small class="text-muted">Resep Asli Raja</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-music text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Hiburan Seni</h6><small class="text-muted">Tari & Gamelan</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-crown text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Atmosfer Royal</h6><small class="text-muted">Suasana Kerajaan</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-camera text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Dokumentasi</h6><small class="text-muted">Momen Berharga</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="position-relative p-4">
                        <div class="image-frame-bg"></div>
                        <div class="shadow rounded overflow-hidden">
                            <img class="img-fluid w-100 service-img" src="{{ asset('img/feature/galladinner.png') }}" alt="Gala Dinner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5 bg-light">
        <div class="container text-center">
            <h2 class="display-6 mb-4 text-royal-maroon">Paket Gala Dinner</h2>
            <div class="card shadow border-0 package-card mx-auto mb-5" style="max-width: 700px;">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
                        <h4 class="mb-0 text-royal-maroon">Premium Package</h4>
                        <span class="badge fs-6 px-3 py-2 btn btn-primary">Rp 500.000</span>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Tour Sejarah Puri Ageng Sukawati</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Welcome Drink & Snack Tradisional</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Pertunjukan Tari & Gamelan Live</li>
                        <li class="mb-0"><i class="fa fa-check me-2 text-royal-maroon"></i> Makan Malam Menu Lengkap Raja</li>
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
