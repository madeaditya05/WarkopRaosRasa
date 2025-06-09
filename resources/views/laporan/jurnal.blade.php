@extends('layoutsbootstrapadmin')

@section('konten')
<style>
    /* Typography dan layout untuk kesan formal */
    body, .body-wrapper {
        font-family: 'Times New Roman', serif;
        background-color: #f8f9fa;
        color: #222;
    }
    .report-container {
        max-width: 900px;
        margin: 40px auto;
        background: white;
        padding: 40px 50px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-radius: 8px;
        border: 1px solid #ccc;
    }
    .report-header {
        text-align: center;
        margin-bottom: 40px;
        border-bottom: 2px solid #003366;
        padding-bottom: 15px;
    }
    .report-header img.logo {
        height: 60px;
        margin-bottom: 15px;
    }
    .report-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #003366;
        letter-spacing: 1.5px;
        margin-bottom: 6px;
    }
    .report-header h4 {
        font-weight: 400;
        font-style: italic;
        color: #555;
        margin-top: 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        margin-bottom: 50px;
    }
    th, td {
        border: 1px solid #777;
        padding: 10px 15px;
        text-align: center;
    }
    th {
        background-color: #003366;
        color: white;
        font-weight: 600;
        letter-spacing: 0.05em;
    }
    tbody tr:nth-child(even) {
        background-color: #f1f5fb;
    }
    tbody tr:hover {
        background-color: #dde6f4;
    }
    td.text-left {
        text-align: left;
    }
    td.text-right {
        text-align: right;
        font-family: 'Courier New', monospace;
    }
    .footer-section {
        display: flex;
        justify-content: space-between;
        margin-top: 60px;
        font-size: 14px;
        color: #444;
    }
    .footer-section .signature {
        width: 180px;
        border-top: 1px solid #444;
        text-align: center;
        padding-top: 8px;
        font-weight: 600;
        letter-spacing: 0.08em;
        color: #003366;
    }
    .footer-section .date {
        font-style: italic;
        color: #666;
    }
</style>

<div class="body-wrapper">
    <div class="report-container">
        <div class="report-header">
            <img src="{{ asset('images/logos/warkop.png') }}" alt="Logo Pemerintah" class="logo" />
            <h1>Laporan Jurnal Penjualan Offline</h1>
            <h4>Periode: {{ \Carbon\Carbon::parse($transaksis->first()?->tanggal_pesan)->format('d M Y') ?? '-' }}
                &nbsp;–&nbsp;
                {{ \Carbon\Carbon::parse($transaksis->last()?->tanggal_pesan)->format('d M Y') ?? '-' }}
            </h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:110px;">Tanggal</th>
                    <th style="width:140px;">No. Faktur</th>
                    <th>Keterangan</th>
                    <th style="width:90px;">Ref</th>
                    <th style="width:140px;">Debit (Rp)</th>
                    <th style="width:140px;">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $trx)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal_pesan)->format('d M Y') }}</td>
                        <td>{{ $trx->no_faktur }}</td>
                        <td class="text-left">Kas</td>
                        <td>101</td>
                        <td class="text-right">{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-left">Penjualan</td>
                        <td>401</td>
                        <td></td>
                        <td class="text-right">{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="font-style: italic; color: #888;">
                            Tidak ada data transaksi untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-section">
            <div class="date">
                Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
            </div>
            
        </div>
    </div>
</div>
@endsection