@extends('layouts.admin')

@section('title', 'Detail Menu - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Detail Menu</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Informasi Menu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px; border-radius: 5px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $menu->name }}</h4>
                            <p class="text-muted">{{ $menu->description }}</p>
                            <p><strong>Kategori:</strong> {{ $menu->category }}</p>
                            <p><strong>Harga:</strong> Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge {{ $menu->is_available ? 'bg-success' : 'bg-danger' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </p>
                            <p><strong>Menu Terbaik:</strong> {{ $menu->is_best ? 'Ya' : 'Tidak' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
