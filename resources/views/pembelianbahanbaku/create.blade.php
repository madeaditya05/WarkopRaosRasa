@extends('layoutsbootstrapadmin')

@section('konten')

<div class="container">
    <h2>Tambah Transaksi Pembelian Bahan Baku</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

<div class="body-wrapper">
    <div class="card mt-4">
         <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Transaksi Pembelian Bahan Baku</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Ada beberapa masalah pada input Anda.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                </div>

                <hr>
                <h5 class="mt-4">Detail Pembelian Bahan Baku</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="items-table">
                        <thead class="table-light">
                            <tr>
                                <th>Bahan Baku</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="items-container">
                            <tr>
                                <td>
                                    <select name="items[0][bahan_baku_id]" class="form-select" required>
                                        <option value="">-- Pilih Bahan Baku --</option>
                                        @foreach ($bahanBakus as $bahan)
                                            <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="items[0][jumlah]" class="form-control jumlah" min="1" required></td>
                                <td><input type="number" name="items[0][harga_satuan]" class="form-control harga_satuan" min="0" required></td>
                                <td><input type="number" class="form-control subtotal" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" id="add-item">Tambah Item</button>
                </div>

                <div class="text-end mb-3">
                <label for="total_subtotal" class="form-label fw-semibold">Total Subtotal:</label>
                <input type="text" id="total_subtotal_display" class="form-control d-inline w-auto text-end" readonly>
                <input type="hidden" id="total_subtotal" name="subtotal">
                </div>


                <div class="text-end">
                    <button type="submit" class="btn btn-primary"> Transaksi ....</button>
                </div>
            </form>
        </div>

    </div>
    @endif

    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
        @csrf

        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select name="supplier_id" id="supplier_id" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pembelian</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>

        <h4>Daftar Bahan Baku</h4>
        <table class="table table-bordered" id="table-items">
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th><button type="button" id="btnAddRow" class="btn btn-success btn-sm">Tambah Baris</button></th>
                </tr>
            </thead>
            <tbody id="tbody-items">
                <tr>
                    <td>
                        <input type="text" name="items[0][nama_bahan]" id="nama_bahan_0" class="form-control" onblur="onNamaBahanChange(0)" list="listBahan" required autocomplete="off">
                        <datalist id="listBahan">
                            @foreach ($bahanBakus as $bahan)
                                <option value="{{ $bahan->nama_bahan }}"></option>
                            @endforeach
                        </datalist>
                    </td>
                    <td><input type="text" name="items[0][satuan]" id="satuan_0" class="form-control" readonly></td>
                    <td><input type="number" name="items[0][jumlah]" id="jumlah_0" class="form-control" min="1" oninput="updateSubtotal(0)" required></td>
                    <td><input type="number" name="items[0][harga_satuan]" id="harga_satuan_0" class="form-control" readonly></td>
                    <td><input type="number" name="items[0][subtotal]" id="subtotal_0" class="form-control" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" name="subtotal" id="total" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
    </form>
</div>

<script>
    // Ini yang benar untuk memasukkan data PHP ke JS
    const bahanData = @json($bahanBakus);

    let rowIndex = 1;

    function onNamaBahanChange(index) {
        const inputNama = document.getElementById('nama_bahan_' + index);
        const nama = inputNama.value.trim().toLowerCase();
        const bahan = bahanData.find(b => b.nama_bahan.toLowerCase() === nama);

        if (bahan) {
            document.getElementById('satuan_' + index).value = bahan.satuan;
            document.getElementById('harga_satuan_' + index).value = bahan.harga_per_satuan;
        } else {
            document.getElementById('satuan_' + index).value = '';
            document.getElementById('harga_satuan_' + index).value = 0;
        }

        updateSubtotal(index);
        checkDuplicateNama(index);
    }

    function updateSubtotal(index) {
        const jumlah = parseFloat(document.getElementById('jumlah_' + index).value) || 0;
        const harga = parseFloat(document.getElementById('harga_satuan_' + index).value) || 0;
        const subtotalInput = document.getElementById('subtotal_' + index);
        const subtotal = jumlah * harga;
        subtotalInput.value = subtotal.toFixed(2);

        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name^="items"]').forEach(input => {
            if (input.name.includes('[subtotal]')) {
                total += parseFloat(input.value) || 0;
            }
        });
        document.getElementById('total').value = total.toFixed(2);
    }

    function checkDuplicateNama(currentIndex) {
        const currentNama = document.getElementById('nama_bahan_' + currentIndex).value.trim().toLowerCase();
        if (!currentNama) return;

        for(let i = 0; i < rowIndex; i++) {
            if (i !== currentIndex) {
                let otherNama = document.getElementById('nama_bahan_' + i);
                if (otherNama && otherNama.value.trim().toLowerCase() === currentNama) {
                    // Jika ada duplikat, jumlah baris yang lama ditambahkan, lalu hapus baris ini
                    const jumlahLama = parseFloat(document.getElementById('jumlah_' + i).value) || 0;
                    const jumlahBaru = parseFloat(document.getElementById('jumlah_' + currentIndex).value) || 0;

                    document.getElementById('jumlah_' + i).value = jumlahLama + jumlahBaru;
                    updateSubtotal(i);

                    // Hapus baris duplikat sekarang
                    removeRowByIndex(currentIndex);

                    break;
                }
            }
        }
    }

    function removeRowByIndex(index) {
        const row = document.getElementById('tbody-items').querySelectorAll('tr')[index];
        if(row) row.remove();
        updateTotal();
    }

    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateTotal();
    }

    document.getElementById('btnAddRow').addEventListener('click', function() {
        const tbody = document.getElementById('tbody-items');

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <input type="text" name="items[${rowIndex}][nama_bahan]" id="nama_bahan_${rowIndex}" class="form-control" onblur="onNamaBahanChange(${rowIndex})" list="listBahan" required autocomplete="off">
            </td>
            <td><input type="text" name="items[${rowIndex}][satuan]" id="satuan_${rowIndex}" class="form-control" readonly></td>
            <td><input type="number" name="items[${rowIndex}][jumlah]" id="jumlah_${rowIndex}" class="form-control" min="1" oninput="updateSubtotal(${rowIndex})" required></td>
            <td><input type="number" name="items[${rowIndex}][harga_satuan]" id="harga_satuan_${rowIndex}" class="form-control" readonly></td>
            <td><input type="number" name="items[${rowIndex}][subtotal]" id="subtotal_${rowIndex}" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Hapus</button></td>
        `;

        tbody.appendChild(tr);
        rowIndex++;
    });
</script>
@endsection