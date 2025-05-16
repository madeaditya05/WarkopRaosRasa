@extends('layouts.app')

@section('content')
<h1>Edit Transaksi Pembelian</h1>

<form method="POST" action="{{ route('transaksi-bahan-baku.update', $transaksi->id) }}">
  @csrf
  @method('PUT')

  <div>
    <label>Supplier</label>
    <select name="supplier_id" required>
      @foreach($suppliers as $supplier)
        <option value="{{ $supplier->id }}" {{ $transaksi->supplier_id == $supplier->id ? 'selected' : '' }}>
          {{ $supplier->nama }}
        </option>
      @endforeach
    </select>
  </div>

  <div>
    <label>Tanggal</label>
    <input type="date" name="tanggal" value="{{ $transaksi->tanggal }}" required>
  </div>

  <h3>Detail Bahan Baku</h3>
  <div id="details">
    @foreach($transaksi->details as $detail)
    <div class="row mb-2">
      <select name="bahan_baku_id[]" required>
        @foreach($bahanBakus as $bahan)
          <option value="{{ $bahan->id }}" {{ $bahan->id == $detail->bahan_baku_id ? 'selected' : '' }}>
            {{ $bahan->nama }}
          </option>
        @endforeach
      </select>

      <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" required>
      <input type="number" step="0.01" name="harga_satuan[]" value="{{ $detail->harga_satuan }}" required>
      <button type="button" onclick="removeRow(this)">🗑</button>
    </div>
    @endforeach
  </div>

  <button type="button" onclick="addRow()">+ Tambah Baris</button><br><br>
  <button type="submit">Update</button>
</form>

<script>
  function addRow() {
    const bahanList = `{!! addslashes(json_encode($bahanBakus)) !!}`;
    const bahanBakus = JSON.parse(bahanList);
    let options = '';
    bahanBakus.forEach(b => {
      options += `<option value="${b.id}">${b.nama}</option>`;
    });

    const row = `
      <div class="row mb-2">
        <select name="bahan_baku_id[]" required>${options}</select>
        <input type="number" name="jumlah[]" placeholder="Jumlah" required>
        <input type="number" step="0.01" name="harga_satuan[]" placeholder="Harga Satuan" required>
        <button type="button" onclick="removeRow(this)">🗑</button>
      </div>
    `;
    document.getElementById('details').insertAdjacentHTML('beforeend', row);
  }

  function removeRow(btn) {
    btn.parentElement.remove();
  }
</script>
@endsection
