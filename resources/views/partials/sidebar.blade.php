@php
    $user = auth()->user();
    if (!$user) {
        return;
    }
    $role = $user->role;
    $is_admin = ($role === 'admin');
@endphp

<aside class="rbr-sidebar shadow-lg" id="rbrSidebar">
    <div class="rbr-sidebar-header d-flex align-items-center">
        <div class="rbr-brand-logo me-2">
            <i class="fas fa-crown text-warning fs-4"></i>
        </div>
        <div class="rbr-brand-wrapper">
            <h6 class="rbr-brand-text m-0">{{ $is_admin ? 'ADMIN PANEL' : 'CUSTOMER AREA' }}</h6>
            <small class="rbr-brand-subtext text-uppercase">Royal Betutu Raja</small>
        </div>
    </div>

    <div class="rbr-sidebar-content">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="{{ route($role.'.dashboard') }}" class="rbr-nav-link {{ request()->routeIs($role.'.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
            </li>

            @if($is_admin)
                <li class="rbr-nav-section">Manajemen Konten</li>
                <li class="nav-item">
                    <a href="{{ route('admin.menu.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i> <span>Menu Makanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.gallery.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i> <span>Galeri Foto</span>
                    </a>
                </li>

                <li class="rbr-nav-section">Manajemen Reservasi</li>
                <li class="nav-item">
                    <a href="{{ route('admin.reservation.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.reservation.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> <span>Data Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span>Data Customer</span>
                    </a>
                </li>

                <li class="rbr-nav-section">Pesan & Interaksi</li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope-open-text"></i> <span>Pesan Masuk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reviews.index') }}" class="rbr-nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="fas fa-star"></i> <span>Moderasi Ulasan</span>
                    </a>
                </li>

                <li class="rbr-nav-section">Laporan & Keuangan</li>
                <li class="nav-item">
                    <a href="{{ route('admin.financial-report') }}" class="rbr-nav-link">
                        <i class="fas fa-chart-line"></i> <span>Laporan Keuangan</span>
                    </a>
                </li>
            @else
                <li class="rbr-nav-section">Reservasi Saya</li>
                <li class="nav-item">
                    <a href="{{ route('customer.reservation.create') }}" class="rbr-nav-link {{ request()->routeIs('customer.reservation.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> <span>Buat Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.reservation.index') }}" class="rbr-nav-link {{ request()->routeIs('customer.reservation.index') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> <span>Riwayat Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.payment.index') }}" class="rbr-nav-link {{ request()->routeIs('customer.payment.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i> <span>Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.profile.index') }}" class="rbr-nav-link {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i> <span>Profil Saya</span>
                    </a>
                </li>
            @endif

            <li class="rbr-nav-section">Sistem</li>
            <li class="nav-item">
                <a href="{{ route('public.home') }}" class="rbr-nav-link">
                    <i class="fas fa-home"></i> <span>Ke Website Utama</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rbr-btn-logout">
                        <i class="fas fa-sign-out-alt"></i> <span>Keluar Aplikasi</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
