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
                    <h5 class="card-title fw-semibold mb-4">Edit Bahan Baku</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bahanbaku.update', $bahanbaku->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="kode_bahan" class="form-label">Kode Bahan</label>
        <input type="text" class="form-control" id="kode_bahan" name="kode_bahan" 
            value="{{ old('kode_bahan', $bahanbaku->kode_bahan) }}" readonly required>
    </div>

    <div class="mb-3">
        <label for="nama_bahan" class="form-label">Nama Bahan</label>
        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" 
            value="{{ old('nama_bahan', $bahanbaku->nama_bahan) }}" required>
    </div>

    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="text" class="form-control" id="jumlah" name="jumlah" 
            value="{{ old('jumlah', $bahanbaku->jumlah) }}" required>
    </div>

    <div class="mb-3">
    <label for="satuan" class="form-label">Satuan</label>
    <select class="form-control" id="satuan" name="satuan" required>
        <option value="Pcs" {{ old('satuan', $bahanbaku->satuan) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
        <option value="Lusin" {{ old('satuan', $bahanbaku->satuan) == 'Lusin' ? 'selected' : '' }}>Lusin</option>
        <option value="Kodi" {{ old('satuan', $bahanbaku->satuan) == 'Kodi' ? 'selected' : '' }}>Kodi</option>
        <option value="Gross" {{ old('satuan', $bahanbaku->satuan) == 'Gross' ? 'selected' : '' }}>Gross</option>
        <option value="Rim" {{ old('satuan', $bahanbaku->satuan) == 'Rim' ? 'selected' : '' }}>Rim</option>
        <option value="Kg" {{ old('satuan', $bahanbaku->satuan) == 'Kg' ? 'selected' : '' }}>Kg</option>
        <option value="Dus atau paket" {{ old('satuan', $bahanbaku->satuan) == 'Dus atau paket' ? 'selected' : '' }}>Dus atau paket</option>
    </select>
</div>

            <div class="mb-3">
                <label for="harga_per_satuan" class="form-label">Harga per Satuan</label>
                <input type="number" class="form-control" id="harga_per_satuan" name="harga_per_satuan" 
                    value="{{ old('harga_per_satuan', $bahanbaku->harga_per_satuan) }}" step="0.01" required>
            </div>
            <div class="mb-3">
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $bahanbaku->keterangan) }}</textarea>
                <br>
                <!-- Tombol Simpan -->
                <input class="col-sm-1 btn btn-success btn-sm" type="submit" value="Ubah">
            
                <a href="{{ route('bahanbaku.index') }}" >

                <!-- Tombol Batal -->
                <a class="col-sm-1 btn btn-dark btn-sm" href="{{ url('/bahanbaku') }}" role="button">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection