<!DOCTYPE html>
<html>
<head>
    <title>Rekap Gaji Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Rekap Gaji Bulan {{ $daftarBulan[$bulan] }} {{ $tahun }}</h3>

    <table>
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Gaji Pokok</th>
                <th>Tunjangan</th>
                <th>Total Gaji</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataGaji as $gaji)
            <tr>
                <td>{{ $gaji->karyawan->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($gaji->tanggal)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->tunjangan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                <td>{{ $gaji->status }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>Total Gaji Dibayarkan</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($totalGaji, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
