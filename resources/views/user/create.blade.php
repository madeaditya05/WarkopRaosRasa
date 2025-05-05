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
                <h5 class="card-title fw-semibold mb-4">Tambah User</h5>

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

                <form action="{{ route('user.store') }}" method="POST" class="p-4 rounded shadow-lg bg-white">
    @csrf

    <h3 class="mb-4 text-center text-primary"><i class="bi bi-box"></i> Tambah User</h3>


    <div class="mb-3">
        <label for="name" class="form-label fw-bold"><i class="bi bi-tag"></i> Nama</label>
        <input type="text" class="form-control border-primary shadow-sm" id="name" name="name"
            value="{{ old('name') }}" placeholder="Masukkan Nama" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-bold"><i class="bi bi-tag"></i> Email</label>
        <input type="text" class="form-control border-primary shadow-sm" id="email" name="email"
            value="{{ old('email') }}" placeholder="Masukkan Email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-bold"><i class="bi bi-tag"></i> Password</label>
        <input type="text" class="form-control border-primary shadow-sm" id="password" name="password"
            value="{{ old('password') }}" placeholder="Masukkan Password" required>
    </div>

    <div class="mb-3">
    <label for="user_group" class="form-label">User Group</label>
    <select class="form-control" id="user_group" name="user_group" required style="width: 200px;">
        <option value="">-- Pilih User Group --</option>
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
    </select>
</div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('user.index') }}" class="btn btn-dark">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
