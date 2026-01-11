@extends('layouts.admin')

@section('title', 'Edit Galeri - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Edit Galeri</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Form Edit Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Foto</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Gala Dinner" {{ $gallery->category == 'Gala Dinner' ? 'selected' : '' }}>Gala Dinner</option>
                                <option value="Cooking Class" {{ $gallery->category == 'Cooking Class' ? 'selected' : '' }}>Cooking Class</option>
                                <option value="Tour Sejarah" {{ $gallery->category == 'Tour Sejarah' ? 'selected' : '' }}>Tour Sejarah</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @if($gallery->image)
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="100" class="mt-2">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $gallery->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
