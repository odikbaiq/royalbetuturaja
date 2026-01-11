@extends('layouts.auth')

@section('title', 'Register - Royal Betutu Raja')


@section('content')
<div class="rbr-auth-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">

                <div class="text-center mb-4 rbr-auth-header">
                    <h2 class="fw-bold text-dark mb-1">Registrasi Akun</h2>
                    <p class="text-muted small">Bergabunglah untuk reservasi lebih mudah</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 rbr-auth-card">
                    <div class="card-body p-4 p-sm-5">

                        @if (session('message'))
                            <div class="alert alert-info border-0 small py-2">{{ session('message') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 small py-2">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label rbr-label">NAMA LENGKAP</label>
                                <input type="text" name="name" class="form-control rbr-input"
                                    placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label rbr-label">EMAIL</label>
                                <input type="email" name="email" class="form-control rbr-input"
                                    placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label rbr-label">PASSWORD</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control rbr-input-group"
                                        placeholder="Min. 8 karakter" required>
                                    <span class="input-group-text rbr-input-icon" onclick="toggleVisibility('password', 'iconPass')">
                                        <i id="iconPass" class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-4">
                                <label class="form-label rbr-label">KONFIRMASI PASSWORD</label>
                                <div class="input-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control rbr-input-group"
                                        placeholder="Ulangi password" required>
                                    <span class="input-group-text rbr-input-icon" onclick="toggleVisibility('password_confirmation', 'iconConfirm')">
                                        <i id="iconConfirm" class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rbr-btn-login">
                                DAFTAR SEKARANG
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0 small text-muted">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold rbr-link">Masuk di sini</a>
                            </p>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="/" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

