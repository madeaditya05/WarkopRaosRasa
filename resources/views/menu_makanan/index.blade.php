@extends('layoutsbootstrapadmin')

@section('konten')
<!-- Main wrapper -->
<div class="body-wrapper">
    <!-- Header Start -->
    <header class="app-header">
        <nav class="navbar navbar-light d-flex justify-content-between align-items-center px-3">
            <div class="d-flex align-items-center">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <ul class="navbar-nav flex-row align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown">
                            <img src="{{asset('images/profile/user-1.jpg')}}" alt="Profile" width="35" height="35" class="rounded-circle">
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
                    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
</form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Header End -->

        
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Menu Makanan</h5>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Master Data Menu Makanan</h6>
                        <a href="{{ url('/menu_makanan/create') }}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus"></i> Tambah Menu
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Foto</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menu_makanan as $menu)
                                    <tr>
                                        <td>{{ $menu->nama_menu }}</td>
                                        <td>
                                            @if ($menu->foto)
                                                <img src="{{ asset('storage/' . $menu->foto) }}" width="100" alt="Foto Menu">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $menu->deskripsi }}</td>
                                        <td>{{ $menu->stok }}</td>
                                        <td>Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
                                        <td>{{ $menu->kategori }}</td>
                                        <td>
                                            <a href="{{ route('menu_makanan.edit', $menu->id) }}" class="btn btn-success btn-sm">Edit</a>
                                            <a href="#" onclick="deleteConfirm(this); return false;" data-id="{{ $menu->id }}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah anda yakin?</h5>
                </div>
                <div class="modal-body" id="xid"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a id="btn-delete" class="btn btn-danger" href="#">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteConfirm(e) {
            var id = e.getAttribute('data-id');
            var url = "{{url('menu_makanan/destroy/')}}" + "/" + id;
            document.getElementById("btn-delete").setAttribute("href", url);
            document.getElementById("xid").innerHTML = `Data dengan ID <b>${id}</b> akan dihapus`;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>

    
</div>
@endsection