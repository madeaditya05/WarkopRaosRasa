@extends('layoutsbootstrapadmin')

@section('konten')
<div class="body-wrapper">
    <div class="container-fluid">
        <h4 class="fw-semibold mb-4">Rekap Gaji Karyawan per Bulan</h4>

        <form method="GET" action="{{ route('gaji.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="bulan" class="form-select" required>
                    @foreach($daftarBulan as $key => $nama)
                        <option value="{{ $key }}" {{ $key == $bulan ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}" required>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="{{ route('gaji.create') }}" class="btn btn-success">+ Tambah Gaji</a>
                <a href="{{ route('gaji.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
                   class="btn btn-danger" target="_blank">Export PDF</a>
            </div>
        </form>

        @if($dataGaji->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Bulan</th>
                        <th>Tahun</th>
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
                            <td>{{ $gaji->karyawan->jabatan }}</td>
                            <td>{{ $daftarBulan[date('n', strtotime($gaji->tanggal))] }}</td>
                            <td>{{ date('Y', strtotime($gaji->tanggal)) }}</td>
                            <td>Rp{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($gaji->tunjangan, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success">{{ $gaji->status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="alert alert-info mt-3">
            Total Pengeluaran Gaji Bulan {{ $daftarBulan[$bulan] }} {{ $tahun }}: 
            <strong>Rp{{ number_format($totalGaji, 0, ',', '.') }}</strong>
        </div>
        @else
            <div class="alert alert-warning">Tidak ada data gaji untuk bulan dan tahun tersebut.</div>
        @endif
    </div>
</div>
@endsection
