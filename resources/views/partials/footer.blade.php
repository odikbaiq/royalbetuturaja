<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <a href="{{ url('/') }}" class="d-flex mb-3">
                    <h1 class="fw-bold text-secondary m-0 fs-2">Royal Betutu Raja</h1>
                </a>
                <p>Royal Betutu Raja adalah perwujudan cita rasa luhur yang lahir dari resep warisan turun-temurun keluarga kerajaan Puri Ageng Sukawati, sebuah pusaka kuliner yang dijaga keasliannya selama lintas generasi.</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://www.instagram.com/royalbetuturaja_"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="https://www.facebook.com/royalbetuturaja"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Menu Cepat</h4>
                <a class="btn btn-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                <a class="btn btn-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
                <a class="btn btn-link {{ request()->is('menu') ? 'active' : '' }}" href="{{ url('/menu') }}">Menu Kuliner</a>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Layanan</h4>
                <a class="btn btn-link {{ request()->is('services/galadinner') ? 'active' : '' }}" href="{{ url('/services/galadinner') }}">Gala Dinner</a>
                <a class="btn btn-link {{ request()->is('services/cookingclass') ? 'active' : '' }}" href="{{ url('/services/cookingclass') }}">Cooking Class</a>
                <a class="btn btn-link {{ request()->is('services/tour') ? 'active' : '' }}" href="{{ url('/services/tour') }}">Tour Sejarah</a>
                <a class="btn btn-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Kontak Kami</a>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Alamat</h4>
                <p><i class="fa fa-map-marker-alt me-3"></i>Jl. Raya Sukawati, Gianyar, Bali 80582</p>
                <p><i class="fa fa-phone-alt me-3"></i>+62 89 687994 095</p>
                <p><i class="fa fa-envelope me-3"></i>royalbetuturaja13@gmail.com</p>
            </div>
        </div>
    </div>

    <div class="container-fluid copyright py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} <a class="text-secondary fw-bold" href="#">Royal Betutu Raja</a>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </div>
</div>
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
    <i class="bi bi-arrow-up"></i>
</a>
