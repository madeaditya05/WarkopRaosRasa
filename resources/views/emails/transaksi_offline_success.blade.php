<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaksi Offline Berhasil</title>
</head>
<body>
    <h2>Halo, {{ $transaksi->pelanggan->nama }}</h2>
    <p>Transaksi Anda dengan No. Faktur <strong>{{ $transaksi->no_faktur }}</strong> pada tanggal <strong>{{ $transaksi->tanggal_pesan }}</strong> telah berhasil.</p>

    <p><strong>Total Harga:</strong> Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

    <h4>Detail Pesanan:</h4>
    <ul>
        @foreach ($transaksi->details as $detail)
            <li>{{ $detail->menuMakanan->nama }} x {{ $detail->jumlah }} - Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</li>
        @endforeach
    </ul>

    <p>Terima kasih telah bertransaksi!</p>
</body>
</html>
