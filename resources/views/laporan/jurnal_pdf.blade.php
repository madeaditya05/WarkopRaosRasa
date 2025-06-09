<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Umum</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 14px; color: #000; }
        h1, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        td.text-left { text-align: left; }
        td.text-right { text-align: right; }
        .indent { padding-left: 30px; } /* Menjorok ke kanan */
    </style>
</head>
<body>
    <h1>Laporan Jurnal Umum</h1>
    <h4>
        Periode:
        @if($bulan && $tahun)
            {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
        @else
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        @endif
    </h4>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Faktur</th>
                <th>Keterangan</th>
                <th>Ref</th>
                <th>Debit (Rp)</th>
                <th>Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            {{-- PENJUALAN --}}
            @foreach ($transaksis as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal_pesan)->format('d-m-Y') }}</td>
                    <td>{{ $trx->no_faktur }}</td>
                    <td class="text-left">Kas</td> <!-- Debit -->
                    <td>101</td>
                    <td class="text-right">{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-left indent">Penjualan</td> <!-- Kredit -->
                    <td>401</td>
                    <td></td>
                    <td class="text-right">{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- PENGGAJIAN --}}
            @foreach ($penggajians as $gj)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($gj->tanggal)->format('d-m-Y') }}</td>
                    <td>GJ-{{ $gj->id }}</td>
                    <td class="text-left">Beban Gaji</td> <!-- Debit -->
                    <td>501</td>
                    <td class="text-right">{{ number_format($gj->total_gaji, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-left indent">Kas</td> <!-- Kredit -->
                    <td>101</td>
                    <td></td>
                    <td class="text-right">{{ number_format($gj->total_gaji, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- PEMBELIAN BAHAN BAKU --}}
            @foreach ($pembelians as $pb)
                @php
                    $subtotal = $pb->details->sum('subtotal');
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pb->tanggal)->format('d-m-Y') }}</td>
                    <td>PB-{{ $pb->id }}</td>
                    <td class="text-left">Persediaan Bahan Baku</td> <!-- Debit -->
                    <td>103</td>
                    <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-left indent">Kas</td> <!-- Kredit -->
                    <td>101</td>
                    <td></td>
                    <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 30px; text-align: right;">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}
    </p>
</body>
</html>
