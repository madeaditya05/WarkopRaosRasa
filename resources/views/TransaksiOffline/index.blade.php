@extends('layoutsbootstrapadmin')

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
    <!--  Header End -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title fw-semibold mb-4">Transaksi Offline</h5>

                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Data Transaksi Offline</h6>
                                <div>
                                    <a href="{{ route('TransaksiOffline.exportPdf') }}" class="btn btn-danger btn-icon-split btn-sm me-2">
                                        <span class="icon text-white-50">
                                            <i class="ti ti-file-download"></i>
                                        </span>
                                        <span class="text">Export PDF</span>
                                    </a>
                                    <a href="{{ route('TransaksiOffline.create') }}" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="ti ti-plus"></i>
                                        </span>
                                        <span class="text">Tambah Transaksi</span>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No Faktur</th>
                                                <th>Pembeli</th>
                                                <th>Tanggal</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transaksi as $transaksi)
                                                <tr>
                                                    <td>{{ $transaksi->no_faktur }}</td>
                                                    <td>{{ $transaksi->pelanggan->nama }}</td>
                                                    <td>{{ $transaksi->tanggal_pesan }}</td>
                                                    <td>Rp {{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
                                                    <td>
                                                        <a href="{{ route('TransaksiOffline.edit', $transaksi->id) }}" class="btn btn-success btn-icon-split btn-sm">
                                                            Edit
                                                        </a>
                                                        <a href="#" onclick="deleteConfirm(this); return false;" data-id="{{ $transaksi->id }}" class="btn btn-danger btn-icon-split btn-sm">
                                                            Hapus
                                                        </a>
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
        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                </div>
                <div class="modal-body" id="xid"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>

                    <!-- Gunakan form untuk method DELETE -->
                    <form id="deleteForm" action="" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>

                </div>
            </div>
        </div>
    </div> 

    <script>
        function deleteConfirm(el) {
            let id = el.getAttribute('data-id');
            let url = "{{ route('TransaksiOffline.destroy', ':id') }}";
            url = url.replace(':id', id);

            // Set action form delete
            document.getElementById('deleteForm').action = url;

            // Set pesan modal
            document.getElementById('xid').innerHTML = `Data dengan ID <b>${id}</b> akan dihapus`;

            // Tampilkan modal
            let myModal = new bootstrap.Modal(document.getElementById('deleteModal'), { keyboard: false });
            myModal.show();
        }
    </script>

@endsection
