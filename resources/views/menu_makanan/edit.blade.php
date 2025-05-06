@extends('layoutbootstrap')

@section('konten')

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
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
                  <img src="{{asset('images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="{{url('logout')}}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Data Perusahaan</h5>

                <!-- Display Error jika ada error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Akhir Display Error -->

                 <!-- Awal Dari Input Form -->
                 <form action="{{ route('menu_makanan.update', $menuMakanan->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <fieldset>
                        <div class="mb-3"><label for="kodenamamenulabel">Nama Menu</label>
                        <input class="form-control form-control-solid" id="nama_menu_tampil" name="nama_menu_tampil" type="text" placeholder="Contoh: PR-001" value="{{$menuMakanan->nama_menu}}"></div>
                    </fieldset>
                    <input type="hidden" id="nama_menu" name="nama_menu" value="{{$menuMakanan->nama_menu}}">

                    <div class="mb-3">
                        <label for="foto" class="form-label">Ganti Foto Menu</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" value="{{$menuMakanan->foto}}">
                    </div>

                    <div class="mb-3"><label for="deskripsilabel">Deskripsi</label>
                    <input class="form-control form-control-solid" id="deskripsi" name="deskripsi" type="text" placeholder="Contoh: Toko Mukena Sejuk Menenangkan" value="{{$menuMakanan->deskripsi}}">
                    </div>
                    
        
                    <div class="mb-0"><label for="hargalabel">Harga</label>
                        <textarea class="form-control form-control-solid" id="harga" name="harga" rows="3" placeholder="Cth: Jl Pelajar Pejuan 45">{{$menuMakanan->harga}}</textarea>
                    </div>

                    <div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <select class="form-control form-control-solid" id="kategori" name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="Indomie" {{ $menuMakanan->kategori == 'Indomie' ? 'selected' : '' }}>Indomie</option>
        <option value="Orak Arik" {{ $menuMakanan->kategori == 'Orak Arik' ? 'selected' : '' }}>Orak Arik</option>
        <option value="Telur" {{ $menuMakanan->kategori == 'Telur' ? 'selected' : '' }}>Telur</option>
        <option value="Sarden" {{ $menuMakanan->kategori == 'Sarden' ? 'selected' : '' }}>Sarden</option>
        <option value="Omlet" {{ $menuMakanan->kategori == 'Omlet' ? 'selected' : '' }}>Omlet</option>
        <option value="Nasi/Mie" {{ $menuMakanan->kategori == 'Nasi/Mie' ? 'selected' : '' }}>Nasi/Mie</option>
        <option value="Kornet" {{ $menuMakanan->kategori == 'Kornet' ? 'selected' : '' }}>Kornet</option>
        <option value="Minuman Panas" {{ $menuMakanan->kategori == 'Minuman Panas' ? 'selected' : '' }}>Minuman Panas</option>
        <option value="Minuman Dingin" {{ $menuMakanan->kategori == 'Minuman Dingin' ? 'selected' : '' }}>Minuman Dingin</option>
    </select>
</div>

                    </div>
                    <br>
                    <div>
                    <!-- untuk tombol simpan -->
                    
                    <input class="col-sm-1 btn btn-success btn-sm ms-4" type="submit" value="Ubah">

                    <!-- untuk tombol batal simpan -->
                    <a class="col-sm-1 btn btn-dark  btn-sm" href="{{ url('/menu_makanan') }}" role="button">Batal</a>
</div>
                </form>
                <!-- Akhir Dari Input Form -->
            
          </div>
        </div>
      </div>
		
		
		
        
@endsection


