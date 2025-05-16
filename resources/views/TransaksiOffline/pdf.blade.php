<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi Offline</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Data Transaksi Offline</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Pembeli</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $i => $trx)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $trx->no_faktur }}</td>
                    <td>{{ $trx->pelanggan->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal_pesan)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($trx->total_harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>