@extends('layouts.auth')

@section('title', 'Administrator Access - Royal Betutu Raja')

@section('content')
<div class="rbr-auth-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7 col-lg-4">

                <div class="text-center mb-4 rbr-auth-header">
                    <h2 class="fw-bold text-dark mb-1">ADMINISTRATOR <span class="admin-badge">ACCESS</span></h2>
                    <p class="text-muted small">Otentikasi khusus pengelola sistem Royal Betutu Raja</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4 rbr-auth-card">
                    <div class="card-body p-4 p-sm-5">
                        @if(session('message'))
                            <div class="alert alert-info border-0 small py-2 text-center">
                                <i class="bi bi-info-circle me-2"></i>{{ session('message') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger border-0 small py-2">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-triangle me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label rbr-label">Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control rbr-input"
                                    placeholder="nama@gmail.com" value="{{ old('email') }}"
                                    required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label rbr-label">Password</label>
                                <div class="input-group shadow-sm rounded">
                                    <input type="password" id="password" name="password"
                                        class="form-control rbr-input-group border-end-0"
                                        placeholder="Masukkan password" required>
                                    <span class="input-group-text rbr-input-icon bg-white border-start-0"
                                          style="cursor: pointer;"
                                          id="togglePassword">
                                        <i id="toggleIcon" class="bi bi-eye-slash text-muted"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rbr-btn-login text-uppercase">
                                Verifikasi & Masuk
                            </button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="/" class="text-muted small text-decoration-none transition-all">
                        <i class="bi bi-shield-lock me-1"></i> Mode Keamanan Aktif
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
