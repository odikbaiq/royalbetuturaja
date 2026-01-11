@extends('layouts.admin')

@section('title', 'Kelola Galeri - Admin')


@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Kelola Galeri</h3>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Daftar Galeri</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary mb-3">Tambah Galeri</a>

                    <!-- Filter Buttons -->
                    <div class="mb-3">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary {{ !$category ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.gallery.index', ['category' => 'Gala Dinner']) }}" class="btn btn-outline-warning {{ $category == 'Gala Dinner' ? 'active' : '' }}">Gala Dinner</a>
                        <a href="{{ route('admin.gallery.index', ['category' => 'Cooking Class']) }}" class="btn btn-outline-success {{ $category == 'Cooking Class' ? 'active' : '' }}">Cooking Class</a>
                        <a href="{{ route('admin.gallery.index', ['category' => 'Tour Sejarah']) }}" class="btn btn-outline-info {{ $category == 'Tour Sejarah' ? 'active' : '' }}">Tour Sejarah</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleries ?? [] as $gallery)
                                <tr>
                                    <td>{{ $loop->iteration + ($galleries->currentPage() - 1) * $galleries->perPage() }}</td>
                                    <td>
                                        @if($gallery->image)
                                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $gallery->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $gallery->category == 'Gala Dinner' ? 'warning' : ($gallery->category == 'Cooking Class' ? 'success' : 'info') }}">
                                            {{ $gallery->category }}
                                        </span>
                                    </td>
                                    <td>{{ strlen($gallery->description ?? '') > 50 ? substr($gallery->description, 0, 50) . '...' : $gallery->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus galeri ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data galeri</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $galleries->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
