@extends('layouts.app')

@section('content')
<div class="royal-service-page">
    <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Cooking Class</h1>
            <p class="fs-5 text-white animated slideInDown">Belajar Memasak Tradisi Bali dari Ahlinya</p>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-5 mb-4 text-royal-maroon">Cooking Class di Royal Betutu Raja</h1>
                    <p class="mb-4 fs-5">Pelajari seni memasak hidangan tradisional Bali yang autentik. Dipandu oleh koki berpengalaman, Anda akan mendapatkan wawasan mendalam tentang teknik memasak dan budaya kuliner Bali.</p>

                    <div class="row g-4 mb-4">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-user-tie text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Koki Ahli</h6><small class="text-muted">Pengalaman Bertahun</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-leaf text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Bahan Segar</h6><small class="text-muted">Langsung dari Kebun</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-book-open text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Resep Tradisional</h6><small class="text-muted">Rahasia Keluarga</small></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle"><i class="fa fa-certificate text-white fs-5"></i></div>
                                <div class="ms-3"><h6 class="mb-0 fw-bold">Sertifikat</h6><small class="text-muted">Penyelesaian Kelas</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="position-relative p-4">
                        <div class="image-frame-bg"></div>
                        <div class="shadow rounded overflow-hidden">
                            <img class="img-fluid w-100 service-img" src="{{ asset('img/feature/cooking-class.png') }}" alt="Cooking Class">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5 bg-light">
        <div class="container text-center">
            <h2 class="display-6 mb-4 text-royal-maroon">Paket Cooking Class</h2>
            <div class="card shadow border-0 package-card mx-auto mb-5" style="max-width: 700px;">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
                        <h4 class="mb-0 text-royal-maroon">Traditional Package</h4>
                        <span class="badge fs-6 px-3 py-2 btn btn-primary">Rp 300.000</span>
                    </div>
                    <ul class="list-unstyled text-start mb-4">
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Teori & praktik memasak</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Bahan lengkap disediakan</li>
                        <li class="mb-3"><i class="fa fa-check me-2 text-royal-maroon"></i> Resep & teknik tradisional</li>
                        <li class="mb-0"><i class="fa fa-check me-2 text-royal-maroon"></i> Pengalaman berharga</li>
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
