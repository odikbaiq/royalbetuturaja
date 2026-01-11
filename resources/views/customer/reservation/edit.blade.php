@extends('layouts.customer')

@section('title', 'Edit Reservasi - Royal Betutu Raja')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Edit Reservasi</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded p-5">
                    @if(session('message'))
                        <div class="alert alert-info">{{ session('message') }}</div>
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
                    <form method="POST" action="{{ route('customer.reservation.update', $reservation->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reservation_date">Tanggal Reservasi</label>
                                <input type="date" class="form-control" id="reservation_date" name="reservation_date" required min="{{ date('Y-m-d') }}" value="{{ old('reservation_date', $reservation->date) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reservation_time">Waktu Reservasi</label>
                                <select class="form-control" id="reservation_time" name="reservation_time" required>
                                    <option value="">Pilih Waktu</option>
                                    <option value="11:00" {{ old('reservation_time', $reservation->time) == '11:00' ? 'selected' : '' }}>11:00</option>
                                    <option value="12:00" {{ old('reservation_time', $reservation->time) == '12:00' ? 'selected' : '' }}>12:00</option>
                                    <option value="13:00" {{ old('reservation_time', $reservation->time) == '13:00' ? 'selected' : '' }}>13:00</option>
                                    <option value="14:00" {{ old('reservation_time', $reservation->time) == '14:00' ? 'selected' : '' }}>14:00</option>
                                    <option value="15:00" {{ old('reservation_time', $reservation->time) == '15:00' ? 'selected' : '' }}>15:00</option>
                                    <option value="16:00" {{ old('reservation_time', $reservation->time) == '16:00' ? 'selected' : '' }}>16:00</option>
                                    <option value="17:00" {{ old('reservation_time', $reservation->time) == '17:00' ? 'selected' : '' }}>17:00</option>
                                    <option value="18:00" {{ old('reservation_time', $reservation->time) == '18:00' ? 'selected' : '' }}>18:00</option>
                                    <option value="19:00" {{ old('reservation_time', $reservation->time) == '19:00' ? 'selected' : '' }}>19:00</option>
                                    <option value="20:00" {{ old('reservation_time', $reservation->time) == '20:00' ? 'selected' : '' }}>20:00</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="number_of_people">Jumlah Orang</label>
                                <input type="number" class="form-control" id="number_of_people" name="number_of_people" required min="1" max="20" value="{{ old('number_of_people', $reservation->guests) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="service_type">Tipe Layanan</label>
                                <select class="form-control" id="service_type" name="service_type" required>
                                    <option value="">Pilih Layanan</option>
                                    <option value="Gala Dinner" {{ old('service_type', $reservation->service_type) == 'Gala Dinner' ? 'selected' : '' }}>Gala Dinner</option>
                                    <option value="Cooking Class" {{ old('service_type', $reservation->service_type) == 'Cooking Class' ? 'selected' : '' }}>Cooking Class</option>
                                    <option value="Tour Sejarah" {{ old('service_type', $reservation->service_type) == 'Tour Sejarah' ? 'selected' : '' }}>Tour Sejarah</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="special_requests">Permintaan Khusus</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Permintaan khusus (opsional)">{{ old('special_requests', $reservation->notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Reservasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
