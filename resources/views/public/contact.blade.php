@extends('layouts.app')

@section('content')
    <section>


        <!-- Page Header Start -->
        <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
                <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Kontak Kami</h1>
                <p class="fs-5 text-white">Hubungi Kami Untuk Informasi Lebih Lanjut</p>
            </div>
        </div>
        <!-- Page Header End -->

        <div class="container-xxl py-6">
            <div class="container">
                <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                    style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Hubungi Kami Sekarang</h1>
                    <p>Kami siap membantu Anda! Tim kami akan dengan senang hati merespons pesan Anda secepat mungkin.</p>
                </div>

                <div class="row g-5 justify-content-center">
                    <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-primary text-white d-flex flex-column justify-content-center h-100 p-5">
                            <h5 class="text-white">Nomor Telepon</h5>
                            <p class="mb-4"><i class="fa fa-phone-alt me-3"></i>089668637513</p>
                            <h5 class="text-white">Email Kami</h5>
                            <p class="mb-4"><i class="fa fa-envelope me-3"></i>odikpramana08@gmail.com</p>
                            <h5 class="text-white">Alamat Kami</h5>
                            <p class="mb-4"><i class="fa fa-map-marker-alt me-3"></i>Jln.Batuyang, Gang Walet No.16,
                                Batubulan Kangin, Gianyar</p>
                            <h5 class="text-white">Sosial Media</h5>
                            <div class="d-flex pt-2">
                                <a class="btn btn-square btn-outline-light rounded-circle me-1"
                                    href="https://instagram.com/royalbetuturaja_"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-square btn-outline-light rounded-circle me-1"
                                    href="https://facebook.com/royalbetuturaja"><i class="fab fa-facebook-f"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="nama" type="text" class="form-control" id="name"
                                            placeholder="Nama" value="{{ old('nama') }}" required>
                                        <label for="name">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="Email" value="{{ old('email') }}" required>
                                        <label for="email">Alamat Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input name="subject" type="text" class="form-control" id="subject"
                                            placeholder="Subject" value="{{ old('subject') }}" required>
                                        <label for="subject">Topik Pesan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="pesan" class="form-control" placeholder="Pesan" id="message" style="height: 200px" required>{{ old('pesan') }}</textarea>
                                        <label for="message">Isi Pesan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Kirim
                                        Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-xxl px-0 wow fadeIn" data-wow-delay="0.1s" style="margin-bottom: -6px;">
            <iframe class="w-100" style="height: 450px; border:0;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.070365820732!2d115.2828354!3d-8.594809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23fbff5e5028b%3A0xcaa97b4ae6aaf0dc!2sRoyal%20Betutu%20Raja%20(Puri%20Agung%20Sukawati)!5e0!3m2!1sid!2sid!4v1733730000000!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>
@endsection
