@extends('layoutsbootstrapadmin')

@section('konten')
<div class="body-wrapper">
    <!-- Header Start -->
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    <a href="#" class="btn btn-primary">-</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ asset('images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Header End -->

    <div class="container-fluid">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Transaksi Offline</h5>

                <form action="{{ route('TransaksiOffline.update', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="no_faktur" class="form-label">No Faktur</label>
                        <input type="text" id="no_faktur" class="form-control" value="{{ $transaksi->no_faktur }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
                        <input type="date" name="tanggal_pesan" id="tanggal_pesan" class="form-control" value="{{ $transaksi->tanggal_pesan }}">
                        @error('tanggal_pesan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
                        <select name="pelanggan_id" id="pelanggan_id" class="form-select">
                            <option disabled selected>-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ $p->id == $transaksi->pelanggan_id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
    <label class="form-label">Total Harga</label>
    <input type="text" class="form-control" value="Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}" disabled>
</div>


                    <div class="mt-4">
                        <a href="{{ route('TransaksiOffline.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
