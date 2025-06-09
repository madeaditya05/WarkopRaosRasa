@extends('layoutsbootstrapadmin')

@section('konten')
<div class="body-wrapper">
  <!-- Header -->
  <header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
      </ul>
      <div class="navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center">
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown">
              <img src="{{asset('images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end">
              <div class="message-body">
                <a class="dropdown-item d-flex gap-2" href="#"><i class="ti ti-user"></i>My Profile</a>
                <a class="dropdown-item d-flex gap-2" href="#"><i class="ti ti-mail"></i>My Account</a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                  <button type="submit" class="btn btn-outline-primary mx-3 mt-2 w-100">Logout</button>
                </form>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Content -->
  <div class="container-fluid py-4">
    <h2 class="mb-4">Dasbor</h2>

    <!-- Filter Periode -->
    <form method="GET" class="mb-4">
      <div class="row g-2 align-items-center">
        <div class="col-auto">
          <label for="periode" class="form-label fw-bold mb-0">Filter Periode:</label>
        </div>
        <div class="col-auto">
          <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
            <option value="minggu" {{ $periode == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="bulan" {{ $periode == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
            <option value="tahun" {{ $periode == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
          </select>
        </div>
      </div>
    </form>

    <!-- Stat Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card text-white bg-primary shadow rounded-3">
          <div class="card-body">
            <h6 class="card-title">Jumlah Pembeli</h6>
            <h3 class="card-text">{{ $jumlahPembeli }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-info shadow rounded-3">
          <div class="card-body">
            <h6 class="card-title">Jumlah Transaksi</h6>
            <h3 class="card-text">{{ $jumlahTransaksi }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success shadow rounded-3">
          <div class="card-body">
            <h6 class="card-title">Total Penjualan</h6>
            <h3 class="card-text">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning shadow rounded-3">
          <div class="card-body">
            <h6 class="card-title">Total Keuntungan</h6>
            <h3 class="card-text">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow">
      <div class="card-body">
        <h5>Penjualan Offline per {{ ucfirst($periode) }}</h5>
        <canvas id="chartPenjualanOffline"></canvas>
      </div>
    </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h5>Penjualan Online per {{ ucfirst($periode) }}</h5>
            <canvas id="chartPenjualanOnline"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mt-2">
    <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h5>Total Penjualan (Top 5 Menu)</h5>
        <canvas id="chartMenuTerlaris"></canvas>
      </div>
    </div>
  </div>


      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h5>Pembelian Bahan Baku</h5>
            <canvas id="chartPembelian"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h5>Stok Bahan Baku</h5>
            <canvas id="chartStokBahan"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const makeChart = (id, type, labels, data, label, bgColor) => {
    new Chart(document.getElementById(id).getContext('2d'), {
      type: type,
      data: {
        labels: labels,
        datasets: [{
          label: label,
          data: data,
          backgroundColor: bgColor,
          borderRadius: 10,
          borderSkipped: false
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: type === 'pie'
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  };

  makeChart("chartPenjualanOnline", "line", {!! json_encode($labelsPenjualanOnline) !!}, {!! json_encode($dataPenjualanOnline) !!}, "Penjualan", "rgba(54, 162, 235, 0.6)");
  makeChart("chartPenjualanOffline", "line", {!! json_encode($labelsPenjualanOffline) !!}, {!! json_encode($dataPenjualanOffline) !!}, "Penjualan", "rgba(54, 162, 235, 0.6)");
  makeChart("chartPembelian", "bar", {!! json_encode($labelsPembelian) !!}, {!! json_encode($dataPembelian) !!}, "Pembelian Bahan Baku", "rgba(255, 99, 132, 0.6)");
  makeChart("chartMenuTerlaris", "bar", {!! json_encode($labelsMenu) !!}, {!! json_encode($dataMenu) !!}, "Menu Terlaris", "rgba(75, 192, 192, 0.6)");
  makeChart("chartStokBahan", "pie", {!! json_encode($labelsBahan) !!}, {!! json_encode($dataBahan) !!}, "Stok Bahan Baku", [
    "rgba(255, 206, 86, 0.6)",
    "rgba(153, 102, 255, 0.6)",
    "rgba(255, 159, 64, 0.6)",
    "rgba(54, 162, 235, 0.6)"
  ]);
</script>
@endsection
