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
                <h5 class="card-title fw-semibold mb-4">Tambah Karyawan</h5>

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

                <form action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <textarea class="form-control" id="email" name="email" rows="3" placeholder="aran@gmail.com" required>{{ old('email') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="number" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('karyawan.index') }}" class="btn btn-dark">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
