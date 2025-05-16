@extends('layoutsbootstrapadmin')

@section('konten')
<div class="container">
    <h2>Detail Transaksi #{{ $transaksi->id }}</h2>

    <div class="mb-3">
        <strong>Supplier:</strong> {{ $transaksi->supplier->nama_supplier }}<br>
        <strong>Tanggal:</strong> {{ $transaksi->tanggal }}<br>
        <strong>Status:</strong> {{ $transaksi->status }}
    </div>

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
            @php $total = 0; @endphp
            @foreach($transaksi->details as $detail)
            <tr>
                <td>{{ $detail->bahanBaku->nama }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @php $total += $detail->subtotal; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th>Rp{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
