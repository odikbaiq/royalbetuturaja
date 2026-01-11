<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Restaurant, Gala Dinner, Cooking Class">
    <meta name="description" content="Royal Betutu Raja - Admin Dashboard">

    <title>@yield('title', 'Admin Dashboard - Royal Betutu Raja')</title>

    <link rel="icon" href="{{ asset('img/royalbetuturaja.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/sidebar-rbr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout-admin-rbr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

    @include('partials.sidebar')

    <button class="rbr-hamburger d-lg-none" id="rbr-toggle-btn" data-rbr-toggle aria-label="Toggle Navigation">
        <i class="fas fa-bars"></i>
    </button>

    <main class="rbr-admin-main" id="main-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/sidebar-rbr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    @stack('scripts')

    <script>
        // Inisialisasi notifikasi jika ada session
        @if(session('success'))
            showRbrAlert('success', 'Berhasil!', "{{ session('success') }}");
        @endif

        @if(session('error'))
            showRbrAlert('error', 'Error!', "{{ session('error') }}");
        @endif
    </script>
</body>
</html>
