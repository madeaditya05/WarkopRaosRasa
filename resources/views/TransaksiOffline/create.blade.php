@extends('layoutsbootstrapadmin')

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
                <h5 class="card-title fw-semibold mb-4">Tambah Transaksi Offline</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('TransaksiOffline.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="no_faktur" class="form-label">No Faktur</label>
                        <input type="text" class="form-control" id="no_faktur" name="no_faktur" value="{{ $no_faktur }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pesan" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="{{ $tanggal->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Nama Pembeli</label>
                        <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                            <option value="">-- Pilih Pembeli --</option>
                            @foreach ($pelanggan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    <h5 class="mb-3">Detail Pesanan</h5>
                    <div id="detail-wrapper">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Menu</label>
                                <select name="menu_makanan_id[]" class="form-control" required>
                                    <option value="">-- Pilih Menu --</option>
                                    @foreach ($menu_makanan as $m)
                                        <option value="{{ $m->id }}" data-harga="{{ $m->harga }}">{{ $m->nama_menu }} (Stok: {{ $m->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Harga</label>
                                <input type="number" class="form-control harga" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control jumlah" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-danger w-100 remove-row">Hapus</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-row">Tambah Menu</button>

                    <hr>
                    <button type="submit" class="btn btn-success">Bayar</button>
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
