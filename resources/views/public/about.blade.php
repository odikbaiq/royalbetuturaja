@extends('layouts.app')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Tentang Kami</h1>
            <p class="fs-5 text-white">Sejarah Royal Betutu Raja</p>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="{{ asset('img/about.png') }}" alt="Royal Betutu Raja">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">Sejarah Royal Betutu Raja</h1>
                    <p class="mb-4">Royal Betutu Raja adalah restoran tradisional yang menawarkan masakan tradisional Bali
                        yang dapat dinikmati oleh semua orang. Restoran ini memiliki resep yang diwariskan dari generasi ke
                        generasi dari keluarga kerajaan Puri Ageng Sukawati. Kami menyediakan makanan kerajaan tradisional
                        yang disajikan dalam suasana makan di istana. Para tamu akan dilayani seperti tamu kerajaan dan
                        diiringi tarian tradisional dan gamelan khas kerajaan Puri Ageng Sukawati.</p>
                    <p>Gung Niang Oka adalah salah satu keturunan kerajaan yang mewariskan resep makanan khas istana Puri
                        Ageng Sukawati. Beliau juga menciptakan hidangan tradisional yang dapat dinikmati oleh semua pecinta
                        kuliner.</p>

                    <div class="row g-2 mb-4">
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Bahan Rempah Asli Bali
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Suasana Makan di Puri Ageng Sukawati
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Resep Turun Temurun
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-check text-primary me-2"></i>Pelayanan Ala Kerajaan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
