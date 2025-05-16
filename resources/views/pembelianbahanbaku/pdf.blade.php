<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Pembelian</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <h3>Detail Transaksi Pembelian</h3>
    <p><strong>Supplier:</strong> {{ $transaksi->supplier->nama_supplier }}</p>
    <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>

    <table>
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
</body>
</html>
