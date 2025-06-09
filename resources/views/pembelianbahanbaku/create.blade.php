@extends('layoutsbootstrapadmin')

@section('konten')
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
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Template untuk baris baru --}}
    <template id="item-row-template">
        <tr>
            <td>
                <select name="__NAME__" class="form-select" required>
                    <option value="">-- Pilih Bahan Baku --</option>
                    @foreach ($bahanBakus as $bahan)
                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="__JUMLAH__" class="form-control jumlah" min="1" required></td>
            <td><input type="number" name="__HARGA__" class="form-control harga_satuan" min="0" required></td>
            <td><input type="number" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
        </tr>
    </template>

    {{-- Script ditempatkan di luar card --}}
    <script>
    let itemIndex = 1;

    document.addEventListener('DOMContentLoaded', function () {
        setupEventHandlers();

        document.getElementById('add-item').addEventListener('click', function () {
            const template = document.getElementById('item-row-template').innerHTML;
            const container = document.getElementById('items-container');
            const newRow = document.createElement('tbody');
            newRow.innerHTML = template
                .replace(/__NAME__/g, `items[${itemIndex}][bahan_baku_id]`)
                .replace(/__JUMLAH__/g, `items[${itemIndex}][jumlah]`)
                .replace(/__HARGA__/g, `items[${itemIndex}][harga_satuan]`);
            container.appendChild(newRow.firstElementChild);
            itemIndex++;
            setupEventHandlers();
        });

        updateTotalSubtotal(); // inisialisasi pertama
    });

    function setupEventHandlers() {
        document.querySelectorAll('.jumlah, .harga_satuan').forEach(function (input) {
            input.removeEventListener('input', updateSubtotal);
            input.addEventListener('input', updateSubtotal);
        });

        document.querySelectorAll('.btn-remove').forEach(function (button) {
            button.removeEventListener('click', removeRow);
            button.addEventListener('click', removeRow);
        });
    }

    function updateSubtotal() {
        const row = this.closest('tr');
        const jumlah = parseFloat(row.querySelector('.jumlah').value) || 0;
        const harga = parseFloat(row.querySelector('.harga_satuan').value) || 0;
        const subtotal = jumlah * harga;
        row.querySelector('.subtotal').value = subtotal;
        updateTotalSubtotal();
    }

    function updateTotalSubtotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(function (input) {
            total += parseFloat(input.value) || 0;
        });

        document.getElementById('total_subtotal_display').value = 'Rp' + total.toLocaleString('id-ID');
        document.getElementById('total_subtotal').value = total;
    }

    function removeRow() {
        this.closest('tr').remove();
        updateTotalSubtotal();
    }
</script>

</div>
@endsection
