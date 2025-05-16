@extends('layoutsbootstrapadmin')

@section('konten')
<div class="body-wrapper">
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Daftar Transaksi Pembelian</h5>

            <div class="d-flex justify-content-start gap-2 mb-3">
                <a href="{{ route('pembelian.create') }}" class="btn btn-primary">+ Tambah Pembelian</a>
                <a href="{{ route('transaksi.export.pdf') }}" class="btn btn-danger">Export PDF</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th>Subtotal</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->id }}</td>
                            <td>{{ $trx->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $trx->tanggal }}</td>
                            <td>Rp{{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection