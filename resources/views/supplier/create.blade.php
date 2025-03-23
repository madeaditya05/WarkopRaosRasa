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
                <h5 class="card-title fw-semibold mb-4">Tambah Supplier</h5>

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

                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="{{ old('nama_supplier') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="number" class="form-control" id="kontak" name="kontak" value="{{ old('kontak') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Cth: Jl Pelajar Pejuang 45" required>{{ old('alamat') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-dark">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
