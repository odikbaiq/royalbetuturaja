@extends('layouts.admin')

@section('title', 'Tambah Galeri - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Tambah Galeri Baru</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Form Tambah Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Foto</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Gala Dinner">Gala Dinner</option>
                                <option value="Cooking Class">Cooking Class</option>
                                <option value="Tour Sejarah">Tour Sejarah</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar (Pilih beberapa file jika ingin mengunggah banyak)</label>
                            <input type="file" class="form-control" id="image" name="image[]" accept="image/*" multiple required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
