<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="2"> {{-- Refresh tiap 2 detik --}}
    <title>Status Pembayaran</title>
</head>
<body>
    <h2>Status Pembayaran</h2>
    <p>Order ID: {{ $transaksi->order_id }}</p>
    <p>Status Pembayaran: <strong>{{ strtoupper($transaksi->status) }}</strong></p>
    <p>Waktu sekarang: {{ \Carbon\Carbon::now('Asia/Jakarta') }}</p>

    @if ($transaksi->status === 'success')
        <p style="color: green;">Pembayaran berhasil!</p>
    @elseif ($transaksi->status === 'pending')
        <p style="color: orange;">Menunggu pembayaran...</p>
    @elseif ($transaksi->status === 'failed')
        <p style="color: red;">Pembayaran gagal atau kadaluarsa.</p>
    @endif
</body>
</html>
