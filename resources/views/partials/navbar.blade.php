<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border royal-spinner" role="status"></div>
</div>
<div class="container-fluid fixed-top px-0 wow fadeIn shadow-sm royal-navbar-container" data-wow-delay="0.1s">
    <div class="top-bar row gx-0 align-items-center d-none d-lg-flex border-bottom py-2">
        <div class="col-lg-7 px-5 text-start">
            <div class="d-flex align-items-center">
                <small class="me-4"><i class="fa fa-map-marker-alt me-2 text-royal-maroon"></i>Jl. Raya Sukawati, Gianyar, Bali 80582</small>
                <small class="ms-4"><i class="fa fa-envelope me-2 text-royal-maroon"></i>royalbetuturaja13@gmail.com</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <small class="me-2">Ikuti Kami:</small>
            <a class="text-body ms-3" href="https://www.instagram.com/royalbetuturaja_"><i class="fab fa-instagram"></i></a>
            <a class="text-body ms-3" href="https://www.facebook.com/royalbetuturaja"><i class="fab fa-facebook"></i></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white py-lg-0 px-lg-5">
        <a href="{{ url('/') }}" class="navbar-brand ms-4 ms-lg-0 d-flex align-items-center">
            <img src="{{ asset('img/royalbetuturaja.jpg') }}" alt="Logo" class="me-3 royal-brand-logo">
            <h1 class="fw-bold m-0 fs-4 royal-nav-brand-text">Royal Betutu Raja</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang</a>
                <a class="nav-link {{ request()->is('menu') ? 'active' : '' }}" href="{{ url('/menu') }}">Menu</a>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Layanan</a>
                    <div class="dropdown-menu m-0 border-0 shadow-sm">
                        <a href="{{ url('/services/galadinner') }}" class="dropdown-item">Gala Dinner</a>
                        <a href="{{ url('/services/cookingclass') }}" class="dropdown-item">Cooking Class</a>
                        <a href="{{ url('/services/tour') }}" class="dropdown-item">Tour Sejarah</a>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Halaman</a>
                    <div class="dropdown-menu m-0 border-0 shadow-sm">
                        <a href="{{ url('/gallery') }}" class="dropdown-item">Galeri</a>
                        <a href="{{ url('/testimonial') }}" class="dropdown-item">Testimoni</a>
                    </div>
                </div>
                <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Kontak</a>

                <div class="d-flex align-items-start align-items-lg-center">
                    <a class="nav-link btn mt-3 mt-lg-0 ms-0 ms-lg-3 px-4 btn-nav-reserve" href="{{ url('reservasi') }}">
                        Reservasi
                    </a>
                </div>
            </div>

            <div class="d-lg-flex ms-lg-3 p-4 p-lg-0">
                <a class="btn-sm-square bg-light rounded-circle" href="{{ url('/dashboard') }}" title="Profil User">
                    <small class="fa fa-user nav-icon-royal"></small>
                </a>
            </div>
        </div>
    </nav>
</div>
