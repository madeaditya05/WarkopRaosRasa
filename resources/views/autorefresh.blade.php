<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="5"> {{-- Auto refresh tiap 5 detik --}}
    <meta charset="UTF-8">
    <title>Menunggu Pembayaran</title>
</head>
<body>
    <h2>Menunggu pembayaran...</h2>

    <p>Status saat ini: <strong>{{ $transaksi->status }}</strong></p>

    @if ($transaksi->status == 'success')
        <script>
            window.location.href = "{{ route('dashboard') }}"; // redirect jika berhasil
        </script>
    @endif
</body>
</html>
