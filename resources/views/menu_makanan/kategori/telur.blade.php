@extends('layoutsbootstrapcustomer')

@section('konten')
<!-- Main wrapper -->
<div class="body-wrapper">
    <div class="preloader-wrapper">
        <div class="preloader"></div>
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
                                <form action="{{ route('keranjang.store') }}" method="POST" id="form_{{ $menu->id }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $menu->id }}">

                                    <!-- Form for Quantity Adjustment -->
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustQuantity('decrement', '{{ $menu->id }}')">-</button>
                                        <input type="number" name="jumlah" id="quantity_{{ $menu->id }}" value="1" class="form-control" style="width: 50px;" min="1" readonly>
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustQuantity('increment', '{{ $menu->id }}')">+</button>
                                    </div>

                                     <button type="submit" class="btn w-100 mt-2" style="background-color: rgb(95, 58, 31); color: white;">Tambah ke Keranjang</button>
                                </form>
                            @else
                                <button class="btn btn-danger w-100" disabled>Tidak Tersedia</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JavaScript for Quantity Adjustment -->
        <script>
            function adjustQuantity(action, menuId) {
                let quantityInput = document.getElementById('quantity_' + menuId);
                let currentQuantity = parseInt(quantityInput.value);

                if (action === 'increment') {
                    quantityInput.value = currentQuantity + 1;
                } else if (action === 'decrement' && currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                }
            }
        </script>
    </div>
</div>
@endsection
