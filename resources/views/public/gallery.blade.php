@extends('layouts.app')

@section('content')
<div class="royal-gallery">
    <div class="container-fluid bg-royal-gradient page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-3 mb-3 animated slideInDown royal-title-gold">Galeri</h1>
            <p class="fs-5 text-white">Dokumentasi Momen Eksklusif di Royal Betutu Raja</p>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5" style="max-width: 600px;">
                <h1 class="display-5 mb-3 text-royal-maroon">Koleksi Momen</h1>
                <p>Pilih kategori untuk melihat keindahan tradisi, kelezatan kuliner, dan keseruan belajar budaya bersama kami.</p>
            </div>

            <div class="row g-2 mb-5 justify-content-center">
                <div class="col-12 text-center">
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <button class="btn btn-outline-dark rounded-pill py-2 px-4 active filter-btn" data-filter="all">Semua Momen</button>
                        <button class="btn btn-outline-dark rounded-pill py-2 px-4 filter-btn" data-filter="toursejarah">Tour Sejarah</button>
                        <button class="btn btn-outline-dark rounded-pill py-2 px-4 filter-btn" data-filter="galadinner">Gala Dinner</button>
                        <button class="btn btn-outline-dark rounded-pill py-2 px-4 filter-btn" data-filter="cookingclass">Cooking Class</button>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="gallery-wrapper">
                @forelse($galleries as $gallery)
                    <div class="col-lg-4 col-md-6 gallery-item {{ strtolower(str_replace(' ', '', $gallery->category)) }}">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="position-relative">
                                <img class="img-fluid gallery-img w-100" src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}">
                                <span class="badge badge-category position-absolute top-0 end-0 m-2">{{ $gallery->category }}</span>
                            </div>
                            <div class="p-4 text-center">
                                <h5 class="lh-base mb-2 text-royal-maroon">{{ $gallery->title }}</h5>
                                <p class="mb-4">{{ $gallery->description }}</p>
                                <small class="text-muted">
                                    <i class="fa fa-calendar me-2"></i>{{ $gallery->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="py-5">Belum ada galeri tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
