@extends('layoutsbootstrapadmin')

@section('konten')
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Detail Transaksi</h5>
        <p><strong>Supplier:</strong> {{ $transaksi->supplier->nama_supplier }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Bahan Baku</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detail as $item)
                <tr>
                    <td>{{ $item->bahanBaku->nama_bahan }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('pembelian.export.pdf', $transaksi->id) }}" class="btn btn-danger">Download PDF</a>
        <a href="{{ route('pembelian.export.excel', $transaksi->id) }}" class="btn btn-success">Download Excel</a>
    </div>
</div>
@endsection
