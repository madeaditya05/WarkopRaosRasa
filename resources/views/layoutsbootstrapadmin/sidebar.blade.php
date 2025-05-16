<style>
  .sidebar-nav {
  margin-top: 20px; /* Bisa diubah sesuai kebutuhan */
  padding-top: 10px;
}
</style>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
	
	
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex justify-content-center mt-3">
          <a href="#" class="text-nowrap logo-img">
            <img src="{{asset('images/logos/warkop.png')}}" width="200" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="#" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Masterdata</span>
            </li>
            {{-- 
<li class="sidebar-item">
    <a class="sidebar-link" href="{{ url('perusahaan') }}" aria-expanded="false">
        <span>
            <i class="ti ti-layout"></i>
        </span>
        <span class="hide-menu">Perusahaan</span>
    </a>
</li>
--}}


            <!-- Tambahkan Menu Makanan -->
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('menu_makanan') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Menu Makanan</span>
        </a>
    </li>

    
    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('supplier') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Supplier</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('karyawan') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Karyawan</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('pelanggan') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Pelanggan</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('bahanbaku') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Bahan Baku</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('user') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">User</span>
        </a>
    </li>
                <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Transaksi</span>
            </li>
            
        <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('pembelian/create') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Pembelian Bahan Baku</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class="sidebar-link" href="{{ url('TransaksiOffline') }}" aria-expanded="false">
            <span><i class="ti ti-restaurant"></i></span>
            <span class="hide-menu">Transaksi Penjualan Ofline</span>
        </a>
    </li>
       
  

          </ul>

        

        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
      
      <!-- Main content -->
