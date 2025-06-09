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

        </nav>
    </header>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Transaksi Offline</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                        <input type="text" class="form-control" id="no_faktur" name="no_faktur" value="{{ $transaksi->no_faktur }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="{{ \Carbon\Carbon::parse($transaksi->tanggal_pesan)->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Nama Pembeli</label>
                        <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                            <option value="">-- Pilih Pembeli --</option>
                            @foreach ($pelanggan as $p)
                                <option value="{{ $p->id }}" {{ $p->id == $transaksi->pelanggan_id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    <h5 class="mb-3">Detail Pesanan</h5>
                    <div id="detail-wrapper">
                        @foreach ($transaksi->detail as $detail)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Menu</label>
                                    <select name="menu_makanan_id[]" class="form-control" required>
                                        <option value="">-- Pilih Menu --</option>
                                        @foreach ($menu_makanan as $m)
                                            <option value="{{ $m->id }}" data-harga="{{ $m->harga }}" {{ $detail->menu_makanan_id == $m->id ? 'selected' : '' }}>
                                                {{ $m->nama_menu }} (Stok: {{ $m->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Harga</label>
                                    <input type="number" class="form-control harga" value="{{ $detail->harga }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control jumlah" value="{{ $detail->jumlah }}" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger w-100 remove-row">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary" id="add-row">Tambah Menu</button>

                    <hr>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('TransaksiOffline.index') }}" class="btn btn-dark">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateHarga(select) {
            const harga = select.options[select.selectedIndex].dataset.harga;
            select.closest('.row').querySelector('.harga').value = harga || 0;
        }

        document.querySelectorAll('select[name="menu_makanan_id[]"]').forEach(select => {
            select.addEventListener('change', () => updateHarga(select));
            updateHarga(select); // trigger awal
        });

        document.getElementById('add-row').addEventListener('click', function () {
            const wrapper = document.getElementById('detail-wrapper');
            const newRow = wrapper.children[0].cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('select').selectedIndex = 0;

            wrapper.appendChild(newRow);

            newRow.querySelector('select').addEventListener('change', () => updateHarga(newRow.querySelector('select')));
            newRow.querySelector('.remove-row').addEventListener('click', () => newRow.remove());
        });

        document.querySelectorAll('.remove-row').forEach(btn => {
            btn.addEventListener('click', function () {
                if (document.querySelectorAll('#detail-wrapper .row').length > 1) {
                    btn.closest('.row').remove();
                }
            });
        });
    });
</script>
@endsection
