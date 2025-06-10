<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Besar</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h4 { margin-top: 30px; }
    </style>
</head>
<body>
    <h2>Laporan Buku Besar</h2>
    @foreach ($bukuBesar as $akun => $entri)
        <h4>Akun: {{ $akun }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Ref</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php $saldo = 0; @endphp
                @foreach ($entri as $row)
                    @php
                        $saldo += in_array($akun, ['Penjualan', 'Utang', 'Modal'])
                            ? $row['kredit'] - $row['debit']
                            : $row['debit'] - $row['kredit'];
                    @endphp
                    <tr>
                        <td>{{ $row['tanggal'] }}</td>
                        <td>{{ $row['keterangan'] }}</td>
                        <td>{{ $row['ref'] }}</td>
                        <td>{{ number_format($row['debit'], 2, ',', '.') }}</td>
                        <td>{{ number_format($row['kredit'], 2, ',', '.') }}</td>
                        <td>{{ number_format($saldo, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
