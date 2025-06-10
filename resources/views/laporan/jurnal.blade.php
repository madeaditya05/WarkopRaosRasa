@extends('layoutsbootstrapadmin')

@section('konten')
<style>
    body, .body-wrapper {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f6fa;
        color: #222;
    }
    .report-container {
        max-width: 1000px;
        margin: 40px auto;
        background: white;
        padding: 40px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        border: 1px solid #ddd;
    }
    .report-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #944222;
        padding-bottom: 15px;
    }
    .report-header img.logo {
        height: 70px;
        margin-bottom: 10px;
    }
    .report-header h1 {
        font-size: 26px;
        font-weight: bold;
        color: #944222;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }
    .report-header h4 {
        font-size: 16px;
        font-style: italic;
        color: #555;
    }

    form.filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
        margin-bottom: 30px;
    }
    form select, form button, form a {
        padding: 8px 12px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
    form button {
        background-color: #0d6efd;
        color: white;
        border: none;
    }
    form a {
        background-color: #fc5c65;
        color: white;
        text-decoration: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        margin-bottom: 40px;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px 14px;
        text-align: center;
        vertical-align: middle;
    }
    th {
        background-color: #944222;
        color: white;
        font-weight: 600;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    td.text-left {
        text-align: left;
    }
    td.text-right {
        text-align: right;
        font-family: 'Courier New', monospace;
    }
    td.keterangan-cell {
        text-align: left;
        max-width: 280px;
        word-wrap: break-word;
        white-space: normal;
        padding-left: 14px;
    }
    td.keterangan-cell.credit-keterangan {
        padding-left: 50px;
    }

    /* Perbaikan khusus untuk kolom tanggal supaya tidak wrap dan lebarnya cukup */
    th.tanggal-col {
        width: 160px;
        white-space: nowrap;
    }
    td.tanggal-cell {
        white-space: nowrap;
        padding-left: 12px;
        padding-right: 12px;
    }

    .footer-section {
        text-align: right;
        font-size: 13px;
        color: #666;
        border-top: 1px dashed #ccc;
        padding-top: 15px;
    }
</style>

<div class="body-wrapper">
    <div class="report-container">
        <div class="report-header">
            <img src="{{ asset('images/logos/warkop.png') }}" alt="Logo Warkop" class="logo" />
            <h1>Laporan Jurnal Umum</h1>
            <h4>
                Periode:
                @if(request('bulan') && request('tahun'))
                    {{ \Carbon\Carbon::createFromDate(request('tahun'), request('bulan'), 1)->translatedFormat('F Y') }}
                @else
                    Semua Periode
                @endif
            </h4>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('laporan.jurnal') }}" class="filter-form">
            <select name="bulan">
                <option value="">-- Bulan --</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun">
                <option value="">-- Tahun --</option>
                @for ($y = now()->year; $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <select name="tipe">
                <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua</option>
                <option value="penjualan" {{ request('tipe') == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                <option value="penggajian" {{ request('tipe') == 'penggajian' ? 'selected' : '' }}>Penggajian</option>
                <option value="pembelian" {{ request('tipe') == 'pembelian' ? 'selected' : '' }}>Pembelian</option>
            </select>

            <button type="submit">Tampilkan</button>

            <a href="{{ route('laporan.jurnal.pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun'), 'tipe' => request('tipe', 'semua')]) }}"
               target="_blank">
                Cetak PDF
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th class="tanggal-col">Tanggal</th>
                    <th style="width:140px;">No. Faktur</th>
                    <th style="width:300px;">Keterangan</th>
                    <th style="width:90px;">Ref</th>
                    <th style="width:140px;">Debit (Rp)</th>
                    <th style="width:140px;">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                    <tr>
                        <td class="tanggal-cell">{{ \Carbon\Carbon::parse($row['tanggal'])->translatedFormat('d M Y') }}</td>
<td>{{ $row['no_faktur'] }}</td>
<td class="keterangan-cell {{ $row['kredit'] > 0 ? 'credit-keterangan' : '' }}">{{ $row['keterangan'] }}</td>
<td>{{ $row['ref'] }}</td>
<td class="text-right">
    {{ $row['debit'] > 0 ? number_format($row['debit'], 0, ',', '.') : '' }}
</td>
<td class="text-right" style="padding-right: 18px;">
    {{ $row['kredit'] > 0 ? number_format($row['kredit'], 0, ',', '.') : '' }}
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="font-style: italic; color: #888;">
                            Tidak ada data jurnal untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-section">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d M Y, H:i') }}
        </div>
    </div>
</div>
@endsection
