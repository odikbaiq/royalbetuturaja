<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Royal Betutu Raja')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="icon" href="{{ asset('img/royalbetuturaja.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/sidebar-rbr.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-cs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/testimonial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/riviews.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('partials.sidebar')

    <div class="rbr-main-content">
        <header class="rbr-mobile-nav rounded-3 mb-4 d-lg-none">
            <button class="btn btn-dark shadow-sm" id="rbr-toggle-btn" data-rbr-toggle>
                <i class="fas fa-bars"></i>
            </button>
            <span class="fw-bold text-dark">Royal Betutu Raja</span>
            <div style="width: 40px;"></div>
        </header>

        <div class="container-fluid py-2">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/customer/riviews.js') }}"></script>

    <script src="{{ asset('js/sidebar-rbr.js') }}"></script>
    @stack('scripts')
</body>
</html>
