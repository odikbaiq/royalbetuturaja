@extends('layouts.customer')

@section('title', 'Kalender Jadwal Reservasi - Royal Betutu Raja')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Kalender Jadwal Reservasi</h1>
            <p class="mb-4">Lihat jadwal reservasi yang sudah dikonfirmasi. Tanggal yang berwarna menunjukkan tanggal yang sudah penuh.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        events: [
            @foreach($reservations as $reservation)
            {
                title: '{{ $reservation->service_type }} - {{ $reservation->guests }} orang',
                start: '{{ $reservation->date }}',
                backgroundColor: '#28a745',
                borderColor: '#28a745'
            },
            @endforeach
        ],
        eventClick: function(info) {
            alert('Reservasi: ' + info.event.title + '\nTanggal: ' + info.event.start.toLocaleDateString('id-ID'));
        }
    });
    calendar.render();
});
</script>
@endsection
