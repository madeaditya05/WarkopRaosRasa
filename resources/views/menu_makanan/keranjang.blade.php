@extends('layoutsbootstrapcustomer')

@section('konten')
@section('konten')
<!-- Main wrapper -->
<div class="body-wrapper">
    <!-- Header Start -->
    <header class="app-header">
        <nav class="navbar navbar-light d-flex justify-content-between align-items-center px-3">
            <div class="d-flex align-items-center">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown">
                            <img src="{{asset('images/profile/user-1.jpg')}}" alt="Profile" width="35" height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-user fs-6"></i>
                                    <p class="mb-0 fs-3">My Profile</p>
                                </a>
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-mail fs-6"></i>
                                    <p class="mb-0 fs-3">My Account</p>
                                </a>
                                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-list-check fs-6"></i>
                                    <p class="mb-0 fs-3">My Task</p>
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Header End -->


<div class="container mt-4">
    <h3 class="fw-semibold mb-4">Menu Makanan</h3>

    <div class="row">
        @foreach ($menu_makanan as $menu)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ asset('storage/' . $menu->foto) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                    <p class="card-text">{{ $menu->deskripsi }}</p>
                    <p class="text-muted mb-1">Stok: {{ $menu->stok }}</p>
                    <p class="text-dark fw-semibold mb-3">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>

                    @if ($menu->stok > 0)
                        <button class="btn btn-success w-100" disabled>Tersedia</button>
                    @else
                        <button class="btn btn-danger w-100" disabled>Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
