@extends('layoutbootstrap')

@section('konten')

<div class="body-wrapper">
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tambah Bahan Baku</h5>

                <!-- Menampilkan Error Validasi -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Akhir Error Validasi -->

                <form action="{{ route('bahanbaku.store') }}" method="POST" class="p-4 rounded shadow-lg bg-white">
    @csrf

    <h3 class="mb-4 text-center text-primary"><i class="bi bi-box"></i> Tambah Bahan Baku</h3>


    <fieldset disabled>
                        <div class="mb-3"><label for="kodebahanlabel">Kode Bahan</label>
                        <input class="form-control form-control-solid" id="kode_bahan_tampil" name="kode_bahan_tampil" type="text" value="{{$kode_bahan}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_bahan" name="kode_bahan" value="{{$kode_bahan}}">

    <div class="mb-3">
        <label for="nama_bahan" class="form-label fw-bold"><i class="bi bi-tag"></i> Nama Bahan</label>
        <input type="text" class="form-control border-primary shadow-sm" id="nama_bahan" name="nama_bahan"
            value="{{ old('nama_bahan') }}" placeholder="Masukkan nama bahan" required>
    </div>

    <div class="mb-3">
        <label for="jumlah" class="form-label fw-bold"><i class="bi bi-tag"></i> Jumlah</label>
        <input type="text" class="form-control border-primary shadow-sm" id="jumlah" name="jumlah"
            value="{{ old('jumlah') }}" placeholder="Masukkan jumlah" required>
    </div>

    <div class="mb-3">
        <label for="satuan" class="form-label fw-bold"><i class="bi bi-rulers"></i> Satuan</label>
        <select class="form-select border-primary shadow-sm" id="satuan" name="satuan" required>
            <option value="">-- Pilih Satuan --</option>
            <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
            <option value="Lusin" {{ old('satuan') == 'Lusin' ? 'selected' : '' }}>Lusin</option>
            <option value="Kodi" {{ old('satuan') == 'Kodi' ? 'selected' : '' }}>Kodi</option>
            <option value="Gross" {{ old('satuan') == 'Gross' ? 'selected' : '' }}>Gross</option>
            <option value="Rim" {{ old('satuan') == 'Rim' ? 'selected' : '' }}>Rim</option>
            <option value="Kg" {{ old('satuan') == 'Rim' ? 'selected' : '' }}>Kg</option>
            <option value="Dus atau paket" {{ old('satuan') == 'Dus atau paket' ? 'selected' : '' }}>Dus atau paket</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="harga_per_satuan" class="form-label fw-bold"><i class="bi bi-currency-dollar"></i> Harga Per Satuan</label>
        <input type="number" class="form-control border-primary shadow-sm" id="harga_per_satuan" name="harga_per_satuan"
            value="{{ old('harga_per_satuan') }}" placeholder="Masukkan harga" required>
    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('bahanbaku.index') }}" class="btn btn-dark">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
