@extends('layouts.customer')

@section('title', 'Profil Royal - Royal Betutu Raja')

@section('content')
{{-- Type Hinting untuk VS Code (Menghilangkan Garis Kuning) --}}
@php
    /** @var \App\Models\User $user */
    $user = auth()->user();
@endphp

<div class="container-fluid py-5 mt-5">
    <div class="container">

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                    <div>
                        <strong class="d-block">Berhasil!</strong>
                        {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Notifikasi Error (Hanya jika error bukan dari field spesifik) --}}
        @if($errors->any() && !session('active_tab'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                    <div>
                        <strong class="d-block">Mohon Maaf!</strong>
                        <ul class="mb-0 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            {{-- Card Profil Kiri --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 border-top border-4 border-primary h-100">
                    <div class="card-body">
                        <div class="position-relative d-inline-block mb-4">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/profiles/' . $user->profile_picture) }}" class="avatar-circle mx-auto shadow-sm" id="profile-avatar">
                            @else
                                <div class="avatar-circle mx-auto bg-dark text-gold display-4 fw-bold shadow-sm" id="profile-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        <div class="py-2 px-3 bg-light rounded-pill d-inline-block">
                            <small class="fw-bold text-primary"><i class="bi bi-crown-fill me-1"></i>Member {{ ucfirst($user->role) }}</small>
                        </div>

                        <div class="mt-5 text-start p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                <small class="text-muted">Bergabung sejak:</small>
                            </div>
                            <p class="fw-bold mb-0 ps-4">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Form Kanan --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 p-md-5">
                        <ul class="nav nav-pills nav-justified mb-5 p-1 custom-tab-container" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link {{ session('active_tab') == 'password' ? '' : 'active' }} fw-bold py-3" id="edit-tab" data-bs-toggle="pill" data-bs-target="#pills-edit" type="button">
                                    <i class="bi bi-person-circle me-2"></i>Informasi Profil
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link {{ session('active_tab') == 'password' ? 'active' : '' }} fw-bold py-3" id="pass-tab" data-bs-toggle="pill" data-bs-target="#pills-pass" type="button">
                                    <i class="bi bi-shield-lock-fill me-2"></i>Keamanan Akun
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            {{-- Edit Informasi --}}
                            <div class="tab-pane fade {{ session('active_tab') == 'password' ? '' : 'show active' }}" id="pills-edit">
                                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-uppercase tracking-wider text-muted">Nama Lengkap</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text border-0 bg-light"><i class="bi bi-person text-primary"></i></span>
                                            <input type="text" class="form-control border-0 bg-light fs-6 @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        @error('name') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label fw-bold small text-uppercase tracking-wider text-muted">Email Aktif</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text border-0 bg-light"><i class="bi bi-envelope text-primary"></i></span>
                                            <input type="email" class="form-control border-0 bg-light fs-6 @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label fw-bold small text-uppercase tracking-wider text-muted">Ganti Foto Profil</label>
                                        <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*" id="profile_picture_input">
                                        <small class="text-muted">Format: JPEG, PNG, JPG. Maksimal 2MB.</small>
                                        @error('profile_picture') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm py-3 fw-bold mt-2">
                                        Perbarui Profil
                                    </button>
                                </form>
                            </div>

                            {{-- Keamanan Akun --}}
                            <div class="tab-pane fade {{ session('active_tab') == 'password' ? 'show active' : '' }}" id="pills-pass">
                                <form method="POST" action="{{ route('customer.profile.changePassword') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase text-muted">Password Saat Ini</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                            <span class="input-group-text border-0 bg-white"><i class="bi bi-key-fill text-muted"></i></span>
                                            <input type="password" class="form-control border-0 @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                            <button class="btn btn-white border-0 px-3" type="button" onclick="togglePass('current_password')">
                                                <i class="bi bi-eye-slash" id="current_password_icon"></i>
                                            </button>
                                        </div>
                                        @error('current_password') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase text-muted">Password Baru</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                            <span class="input-group-text border-0 bg-white"><i class="bi bi-lock-fill text-muted"></i></span>
                                            <input type="password" class="form-control border-0 @error('password') is-invalid @enderror" id="password" name="password" required>
                                            <button class="btn btn-white border-0 px-3" type="button" onclick="togglePass('password')">
                                                <i class="bi bi-eye-slash" id="password_icon"></i>
                                            </button>
                                        </div>
                                        @error('password') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-uppercase text-muted">Konfirmasi Password Baru</label>
                                        <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                            <span class="input-group-text border-0 bg-white"><i class="bi bi-shield-check text-muted"></i></span>
                                            <input type="password" class="form-control border-0" id="password_confirmation" name="password_confirmation" required>
                                            <button class="btn btn-white border-0 px-3" type="button" onclick="togglePass('password_confirmation')">
                                                <i class="bi bi-eye-slash" id="password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold mt-2">
                                        Update Keamanan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
