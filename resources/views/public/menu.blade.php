@extends('layouts.app')

@section('content')
    <section>
        <!-- Page Header Start -->
        <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container text-center">
                <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Menu</h1>
                <p class="fs-5 text-white">Daftar Menu Royal Betutu Raja</p>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Menu Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s"
                    style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Daftar Menu</h1>
                    <p>Royal Betutu Raja memiliki beberapa pilihan makanan dan minuman</p>
                </div>
                @if ($menus->isEmpty())
                    <div class="text-center">
                        <p>Belum ada menu yang dibuat di admin.</p>
                    </div>
                @else
                    <div class="text-center mb-5">
                        <ul class="nav nav-pills d-inline-flex justify-content-center">
                            @foreach ($menus as $category => $items)
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-secondary border-2 @if ($loop->first) active @endif"
                                        data-bs-toggle="pill" href="#tab-{{ $loop->index }}">{{ $category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="tab-content">
                        @foreach ($menus as $category => $items)
                            <div id="tab-{{ $loop->index }}"
                                class="tab-pane fade p-0 @if ($loop->first) show active @endif">
                                <div class="row g-4">
                                    @forelse($items as $menu)
                                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                            <div class="product-item">
                                                <div class="position-relative bg-light overflow-hidden">
                                                    <img class="img-fluid w-100"
                                                        src="{{ asset('storage/' . $menu->image) }}"
                                                        alt="{{ $menu->name }}">
                                                    @if ($menu->is_best)
                                                        <div
                                                            class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                            Best</div>
                                                    @endif
                                                </div>
                                                <div class="text-center p-4">
                                                    <p class="d-block h5 mb-2">{{ $menu->name }}</p>
                                                    <p class="text-muted mb-2">{{ $menu->description }}</p>
                                                    <span
                                                        class="text-black me-1">Rp.{{ number_format($menu->price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>Belum ada menu {{ $category }} tersedia.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
