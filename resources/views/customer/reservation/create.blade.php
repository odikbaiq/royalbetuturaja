@extends('layouts.customer')

@section('title', 'Reservasi Meja - Royal Betutu Raja')

@section('content')
<div class="container-fluid py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        {{-- Sisi Kiri: Visual --}}
                        <div class="col-lg-4 bg-dark text-white p-5 d-none d-lg-flex flex-column justify-content-center text-center">
                            <h2 class="fw-bold mb-4 text-gold">Royal Experience</h2>
                            <p class="lead small mb-4">Nikmati kunjungan wisata bernuansa kerajaan di Puri Ageng Sukawati</p>
                            <div class="text-start border-top border-secondary pt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-clock-history fs-4 me-3 text-gold"></i>
                                    <small>Konfirmasi Instan</small>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-shield-check fs-4 me-3 text-gold"></i>
                                    <small>Pembayaran Aman</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt fs-4 me-3 text-gold"></i>
                                    <small>Lokasi Eksklusif</small>
                                </div>
                            </div>
                        </div>

                        {{-- Sisi Kanan: Form --}}
                        <div class="col-lg-8 p-4 p-md-5 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="fw-bold mb-0">Atur Jadwal Anda</h3>
                                <span class="badge bg-light text-dark border p-2 fw-normal">Langkah 1 dari 2</span>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm mb-4">
                                    <ul class="mb-0 small">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('customer.reservation.store') }}" id="resForm">
                                @csrf
                                <div class="row g-4">
                                    {{-- Tanggal --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted"><i class="bi bi-calendar-event me-2"></i>TANGGAL</label>
                                        <input type="date" class="form-control form-control-lg border-light bg-light shadow-none"
                                               id="reservation_date" name="date" required min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                                    </div>

                                    {{-- Waktu --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted"><i class="bi bi-clock me-2"></i>WAKTU</label>
                                        <select class="form-select form-control-lg border-light bg-light shadow-none" name="time" required>
                                            <option value="" selected disabled>Pilih Waktu</option>
                                            @foreach(['11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00'] as $time)
                                                <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }} WITA</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jumlah Tamu --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted"><i class="bi bi-people me-2"></i>JUMLAH TAMU</label>
                                        <input type="number" class="form-control form-control-lg border-light bg-light shadow-none"
                                               id="guests" name="guests" placeholder="Min. 1" required min="1" max="20" value="{{ old('guests') }}">
                                    </div>

                                    {{-- Tipe Layanan --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted"><i class="bi bi-stars me-2"></i>TIPE LAYANAN</label>
                                        <select class="form-select form-control-lg border-light bg-light shadow-none" id="service_type" name="service_type" required>
                                            <option value="" selected disabled>Pilih Layanan</option>
                                            <option value="Gala Dinner" data-price="500000" {{ old('service_type') == 'Gala Dinner' ? 'selected' : '' }}>Gala Dinner (Rp 500k/pax)</option>
                                            <option value="Cooking Class" data-price="350000" {{ old('service_type') == 'Cooking Class' ? 'selected' : '' }}>Cooking Class (Rp 350k/pax)</option>
                                            <option value="Tour Sejarah" data-price="100000" {{ old('service_type') == 'Tour Sejarah' ? 'selected' : '' }}>Tour Sejarah (Rp 100k/pax)</option>
                                        </select>
                                    </div>

                                    {{-- Permintaan Khusus --}}
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted"><i class="bi bi-chat-dots me-2"></i>PERMINTAAN KHUSUS</label>
                                        <textarea class="form-control border-light bg-light shadow-none" name="special_requests" rows="3" placeholder="Alergi makanan, dekorasi ulang tahun, dll...">{{ old('special_requests') }}</textarea>
                                    </div>

                                    {{-- Estimasi Harga --}}
                                    <div class="col-12 mt-4">
                                        <div class="p-3 rounded-3 bg-soft-gold border d-flex justify-content-between align-items-center">
                                            <span class="text-muted small">Estimasi Total:</span>
                                            <h4 class="mb-0 fw-bold text-primary" id="estimated_price">Rp 0</h4>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm">
                                            Kirim Reservasi <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dark { background-color: #1a1a1a !important; }
    .text-gold { color: #D4AF37; }
    .bg-soft-gold { background-color: #fffdf5; border-color: #f1e4b8 !important; }
    .btn-primary { background-color: #8B0000; border: none; }
    .btn-primary:hover { background-color: #660000; transform: translateY(-2px); transition: 0.3s; color: white; }
    .form-control-lg, .form-select-lg { font-size: 0.95rem; border-radius: 12px; }
    .form-control:focus { background-color: #fff !important; border-color: #8B0000 !important; box-shadow: none !important; }
</style>

<script>
    const guestsInput = document.getElementById('guests');
    const serviceSelect = document.getElementById('service_type');
    const displayPrice = document.getElementById('estimated_price');

    function calculatePrice() {
        const guests = guestsInput.value || 0;
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const pricePerPax = selectedOption ? selectedOption.getAttribute('data-price') : 0;
        const total = guests * (pricePerPax || 0);
        displayPrice.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    guestsInput.addEventListener('input', calculatePrice);
    serviceSelect.addEventListener('change', calculatePrice);
</script>
@endsection
