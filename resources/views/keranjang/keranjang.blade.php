@extends('layoutsbootstrapcustomer.app')

@section('content')
    <h1>Keranjang Belanja</h1>

    @if(session()->has('keranjang') && count(session('keranjang')) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('keranjang') as $id => $item)
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keranjang.hapus', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td><strong>{{ number_format(array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], session('keranjang'))), 0, ',', '.') }}</strong></td>
                    <td><a href="{{ route('keranjang.checkout') }}" class="btn btn-primary">Checkout</a></td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Keranjang Anda kosong.</p>
    @endif
@endsection
