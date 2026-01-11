@extends('layouts.admin')

@section('title', 'Kelola Menu - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h3 class="text-dark">Kelola Menu</h3>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white">Daftar Menu</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary mb-3">Tambah Menu</a>

                    <!-- Filter Buttons -->
                    <div class="mb-3">
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary {{ !$category ? 'active' : '' }}">Semua</a>
                        <a href="{{ route('admin.menu.index', ['category' => 'Makanan']) }}" class="btn btn-outline-primary {{ $category == 'Makanan' ? 'active' : '' }}">Makanan</a>
                        <a href="{{ route('admin.menu.index', ['category' => 'Minuman']) }}" class="btn btn-outline-info {{ $category == 'Minuman' ? 'active' : '' }}">Minuman</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menus ?? [] as $menu)
                                <tr>
                                    <td>{{ $loop->iteration + ($menus->currentPage() - 1) * $menus->perPage() }}</td>
                                    <td>
                                        @if($menu->image)
                                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $menu->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $menu->category == 'Makanan' ? 'primary' : 'info' }}">
                                            {{ $menu->category }}
                                        </span>
                                    </td>
                                    <td>{{ strlen($menu->description) > 50 ? substr($menu->description, 0, 50) . '...' : $menu->description }}</td>
                                    <td>Rp. {{ number_format($menu->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $menu->is_available ? 'bg-success' : 'bg-danger' }}">
                                            {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus menu ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data menu</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $menus->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK'
    });
@endif
</script>
@endsection
