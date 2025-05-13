@extends('layoutsbootstrapcustomer')

@section('konten')
@section('konten')
<!-- Main wrapper -->
<div class="body-wrapper">
    
<div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>

<div class="container mt-4">
    <h3 class="fw-semibold mb-4">Menu Categories Telur</h3>

    <div class="row">
        @foreach ($tampil_telur as $menu)
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</div>
@endsection