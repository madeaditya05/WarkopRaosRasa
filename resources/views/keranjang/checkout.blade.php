    @extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-semibold mb-4">Checkout</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h5>Order ID: {{ $orderId }}</h5>

    <h4>Detail Keranjang</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keranjang as $id => $item)
                <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>

    <a href="{{ route('keranjang.checkout') }}" class="btn btn-primary">Lanjutkan ke Pembayaran</a>
</div>
@endsection
