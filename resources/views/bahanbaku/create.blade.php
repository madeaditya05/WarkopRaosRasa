@extends('layoutsbootstrapadmin')

@section('konten')
<div class="container mt-4">
    <div class="card shadow-sm rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Bahan Baku</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('bahanbaku.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <label for="kode_bahan" class="col-sm-3 col-form-label">Kode Bahan</label>
                    <div class="col-sm-9">
                        <input type="text" name="kode_bahan" id="kode_bahan" class="form-control" value="{{ $kode_bahan }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama_bahan" class="col-sm-3 col-form-label">Nama Bahan</label>
                    <div class="col-sm-9">
                        <select name="nama_bahan" id="nama_bahan" class="form-select" required>
                            <option value="">-- Pilih Bahan --</option>
                            <option value="telur">Telur</option>
                            <option value="beras">Beras</option>
                            <option value="rempah">Rempah</option>
                            <option value="mie">Mie</option>
                            <option value="teh sariwangi">Teh Sariwangi</option>
                            <option value="es">Es</option>
                            <option value="krupuk">Krupuk</option>
                            <option value="gula">Gula</option>
                            <option value="saos">Saos</option>
                            <option value="kecap">Kecap</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-9">
                        <input type="number" name="jumlah" id="jumlah" class="form-control" min="0" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                    <div class="col-sm-9">
                        <input type="text" name="satuan" id="satuan" class="form-control" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="harga_per_satuan" class="col-sm-3 col-form-label">Harga per Satuan</label>
                    <div class="col-sm-9">
                        <input type="number" name="harga_per_satuan" id="harga_per_satuan" class="form-control" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="subtotal" class="col-sm-3 col-form-label">Subtotal</label>
                    <div class="col-sm-9">
                        <input type="text" id="subtotal" class="form-control" readonly>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan</button>
                    <a href="{{ route('bahanbaku.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const bahanData = {
        "telur": { satuan: "Kg", harga: 28000 },
        "beras": { satuan: "Kg", harga: 18655 },
        "rempah": { satuan: "Kg", harga: 32000 },
        "mie": { satuan: "Dus", harga: 14000 },
        "teh sariwangi": { satuan: "Kotak", harga: 9800 },
        "es": { satuan: "Kg", harga: 5000 },
        "krupuk": { satuan: "Kg", harga: 16000 },
        "gula": { satuan: "Kg", harga: 15200 },
        "saos": { satuan: "Botol", harga: 11500 },
        "kecap": { satuan: "Botol", harga: 12500 }
    };

    const namaBahan = document.getElementById('nama_bahan');
    const satuan = document.getElementById('satuan');
    const harga = document.getElementById('harga_per_satuan');
    const jumlah = document.getElementById('jumlah');
    const subtotal = document.getElementById('subtotal');

    namaBahan.addEventListener('change', () => {
        const selected = namaBahan.value;
        if (bahanData[selected]) {
            satuan.value = bahanData[selected].satuan;
            harga.value = bahanData[selected].harga;
            hitungSubtotal();
        } else {
            satuan.value = '';
            harga.value = '';
            subtotal.value = '';
        }
    });

    jumlah.addEventListener('input', hitungSubtotal);
    harga.addEventListener('input', hitungSubtotal);

    function hitungSubtotal() {
        const jml = parseFloat(jumlah.value) || 0;
        const hrg = parseFloat(harga.value) || 0;
        const sub = jml * hrg;
        subtotal.value = sub.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
    }
</script>
@endsection
