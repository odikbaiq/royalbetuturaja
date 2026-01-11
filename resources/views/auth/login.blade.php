@extends('layouts.auth')

@section('title', 'Login - Royal Betutu Raja')

@section('content')
<div class="rbr-auth-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-4">

                <div class="text-center mb-4 rbr-auth-header">
                    <h2 class="fw-bold text-dark mb-1">Selamat Datang</h2>
                    <p class="text-muted small">Silakan masuk untuk mengelola reservasi Anda</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 rbr-auth-card">
                    <div class="card-body p-4 p-sm-5">

                        {{-- Flash Message & Validation --}}
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

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label rbr-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control rbr-input"
                                    placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label rbr-label">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control rbr-input-group"
                                        placeholder="Masukkan password" required>
                                    <span class="input-group-text rbr-input-icon" onclick="togglePassword()">
                                        <i id="toggleIcon" class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Button Login --}}
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rbr-btn-login">
                                MASUK SEKARANG
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0 small text-muted">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold rbr-link">Daftar di sini</a>
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
