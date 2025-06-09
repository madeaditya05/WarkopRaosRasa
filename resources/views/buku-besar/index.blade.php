@extends('layoutsbootstrapadmin')

@section('konten')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Laporan Buku Besar</h5>

                <form method="GET" action="{{ route('buku-besar') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="akun" class="form-select">
                            <option value="">-- Semua Akun --</option>
                            @foreach ($akunKasDanPenjualan as $akun)
                                <option value="{{ $akun }}" {{ request('akun') == $akun ? 'selected' : '' }}>
                                    {{ $akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('buku-besar.export', request()->only(['tanggal', 'akun'])) }}" class="btn btn-success w-100">Export PDF</a>
                    </div>
                </form>

                @if (!empty($bukuBesar))
                    @foreach ($bukuBesar as $akun => $entri)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="m-0 text-primary">Akun: {{ $akun }}</h6>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Ref</th>
                                            <th class="text-end">Debit</th>
                                            <th class="text-end">Kredit</th>
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $saldo = 0; $totalDebit = 0; $totalKredit = 0; @endphp
                                        @foreach ($entri as $row)
                                            @php
                                                $totalDebit += $row['debit'];
                                                $totalKredit += $row['kredit'];
                                                $saldo += in_array($akun, ['Penjualan', 'Utang', 'Modal'])
                                                    ? $row['kredit'] - $row['debit']
                                                    : $row['debit'] - $row['kredit'];
                                            @endphp
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($row['tanggal'])->format('d-m-Y') }}</td>
                                                <td>{{ $row['keterangan'] }}</td>
                                                <td>{{ $row['ref'] }}</td>
                                                <td class="text-end">{{ number_format($row['debit'], 2, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($row['kredit'], 2, ',', '.') }}</td>
                                                <td class="text-end">
                                                    {{ $saldo < 0 ? '(' . number_format(abs($saldo), 2, ',', '.') . ')' : number_format($saldo, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="fw-bold bg-light">
                                            <td colspan="3" class="text-end">Total</td>
                                            <td class="text-end">{{ number_format($totalDebit, 2, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($totalKredit, 2, ',', '.') }}</td>
                                            <td class="text-end">
                                                {{ $saldo < 0 ? '(' . number_format(abs($saldo), 2, ',', '.') . ')' : number_format($saldo, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">Tidak ada data buku besar tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
