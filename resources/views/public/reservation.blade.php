@extends('layouts.app')

@section('content')
<div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Reservasi</h1>
        <p class="fs-5 text-white animated slideInDown">Pesan layanan Royal Betutu Raja</p>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-white rounded shadow p-5">
                    <h2 class="mb-4 text-center" style="color: #800000;">Form Reservasi</h2>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('public.reservation.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: #800000; font-weight: bold;">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color: #800000; font-weight: bold;">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="service_type" class="form-label" style="color: #800000; font-weight: bold;">Pilihan Layanan</label>
                                <select class="form-select" id="service_type" name="service_type" required>
                                    <option value="">Pilih Layanan</option>
                                    <option value="Tour Sejarah" {{ old('service_type') == 'Tour Sejarah' ? 'selected' : '' }}>Tour Sejarah - Rp 100.000/pax</option>
                                    <option value="Cooking Class" {{ old('service_type') == 'Cooking Class' ? 'selected' : '' }}>Cooking Class - Rp 350.000/pax</option>
                                    <option value="Gala Dinner" {{ old('service_type') == 'Gala Dinner' ? 'selected' : '' }}>Gala Dinner - Rp 500.000/pax</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="guests" class="form-label" style="color: #800000; font-weight: bold;">Jumlah Orang</label>
                                <input type="number" class="form-control" id="guests" name="guests" min="1" max="20" value="{{ old('guests', 1) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="date" class="form-label" style="color: #800000; font-weight: bold;">Tanggal</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="time" class="form-label" style="color: #800000; font-weight: bold;">Waktu</label>
                                <select class="form-select" id="time" name="time" required>
                                    <option value="">Pilih Waktu</option>
                                    <option value="10:00" {{ old('time') == '10:00' ? 'selected' : '' }}>10:00</option>
                                    <option value="12:00" {{ old('time') == '12:00' ? 'selected' : '' }}>12:00</option>
                                    <option value="14:00" {{ old('time') == '14:00' ? 'selected' : '' }}>14:00</option>
                                    <option value="16:00" {{ old('time') == '16:00' ? 'selected' : '' }}>16:00</option>
                                    <option value="18:00" {{ old('time') == '18:00' ? 'selected' : '' }}>18:00</option>
                                    <option value="20:00" {{ old('time') == '20:00' ? 'selected' : '' }}>20:00</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="special_requests" class="form-label" style="color: #800000; font-weight: bold;">Permintaan Khusus (Opsional)</label>
                                <textarea class="form-control" id="special_requests" name="special_requests" rows="3" maxlength="500">{{ old('special_requests') }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5 py-3" style="background-color: #800000; color: #D4AF37; border: none;">
                                <i class="fa fa-calendar-check me-2"></i>Kirim Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
