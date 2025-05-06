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
                <h5 class="card-title fw-semibold mb-4">Tambah Menu Makanan</h5>

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

                <form action="{{ route('menu_makanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_menu" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ old('nama_menu') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Menu</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
                    </div>
                    <div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <select class="form-control" id="kategori" name="kategori" required style="width: 200px;">
        <option value="">-- Pilih Kategori --</option>
        <option value="Indomie">Indomie</option>
        <option value="Orak Arik">Orak Arik</option>
        <option value="Telur">Telur</option>
        <option value="Sarden">Sarden</option>
        <option value="Omlet">Omlet</option>
        <option value="Nasi/Mie">Nasi/Mie</option>
        <option value="Kornet">Kornet</option>
        <option value="Minuman Panas">Minuman Panas</option>
        <option value="Minuman Dingin">Minuman Dingin</option>
    </select>
</div>
                    </div>
                    <div>
                    <button type="submit" class="btn btn-success ms-4">Simpan</button>
                    <a href="{{ route('menu_makanan.index') }}" class="btn btn-dark">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
