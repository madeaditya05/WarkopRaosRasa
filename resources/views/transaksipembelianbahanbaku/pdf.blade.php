<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Transaksi Pembelian</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Daftar Transaksi Pembelian Bahan Baku</h2>
    <table>
        <thead>
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
</body>
</html>