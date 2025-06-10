<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Warkop Raos Rasa</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" type="image/png" href="{{asset('images/logos/ikon.png')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('css/vendor.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('style.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Tambahkan ini di bagian <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>


     <!-- Tambahan Sweet Alert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- Tambahan untuk Midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>
    </head>

    <body>
    <header class="fixed-top wow fadeIn shadow-sm" data-wow-delay="0.1s" style="background-color: white;">
      <div class="container-fluid">
        <div class="row py-3 border-bottom">
          
          <div class="col-sm-4 col-lg-3 text-center text-sm-start">
            <div class="main-logo">
              <a href="{{ route('dashboard') }}">
                <img src="images/logos/logo.png" alt="logo" class="img-fluid">
              </a>
            </div>
          </div>
          
          <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block" style="margin-left: 0px;">
            <div class="search-bar row bg-light p-2 my-2 rounded-4">
              <div class="col-md-4 d-none d-md-block">
                <select class="form-select border-0 bg-transparent">
                  <option>All Categories</option>
                  <option>Groceries</option>
                  <option>Drinks</option>
                  <option>Chocolates</option>
                </select>
              </div>
              <div class="col-11 col-md-7">
                <form id="search-form" class="text-center" action="{{ route('showSearch') }}" method="GET">
                  <input type="text" name="q" class="form-control border-0 bg-transparent" placeholder="Search for more than 20 products" />
                </form>
              </div>
              <div class="col-1 d-flex align-items-center justify-content-center">
                <button type="submit" form="search-form" class="btn p-0 border-0 bg-transparent">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          
          <div class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">


            <ul class="d-flex justify-content-end list-unstyled m-0">
            <li class="dropdown">
            <a href="#" class="rounded-circle bg-light p-2 mx-1 d-inline-block" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
              <img src="{{ asset('images/profile/user-1.jpg') }}" alt="Profile" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
            </a>
            


              <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <li><button class="dropdown-item" type="button">My Profile</button></li>
                <li><button class="dropdown-item" type="button">My Account</button></li>
                <li><button class="dropdown-item" type="button">My Task</button></li>
                <li><hr class="dropdown-divider"></li>
                <li><form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form></li>
              </ul>
            </li>

              <li>
              <a href="#" class="rounded-circle bg-light p-2 mx-1" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                <img src="{{ asset('images/profile/heart.png') }}" alt="Favorite" class="rounded-circle" style="width: 80%; height: 80%; object-fit: cover;">
              </a>

              </li>
              <li class="d-lg-none">
                <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#cart"></use></svg>
                </a>
              </li>
              <li class="d-lg-none">
                <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                  <svg width="24" height="24" viewBox="0 0 24 24"><use xlink:href="#search"></use></svg>
                </a>
              </li>
            </ul>

            <div class="cart text-end d-none d-lg-block dropdown">
    <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
        <span class="fs-6 text-muted dropdown-toggle" style="color: rgb(95, 58, 31)">Your Cart</span>

        @php
            $keranjang = session('keranjang', []);
            $totalBelanja = 0;
            foreach ($keranjang as $item) {
                $totalBelanja += $item['harga'] * $item['jumlah'];
            }
        @endphp

        <span class="cart-total fs-5 fw-bold" style="color: rgb(95, 58, 31)">
            Rp {{ number_format($totalBelanja, 0, ',', '.') }}
        </span>
    </button>
</div>

          </div>

        </div>
      </div>
</header>

<!-- Setelah header, pastikan konten utama diberi margin-top -->
    <main style="margin-top: 120px;">
      <div class="container-fluid">
        <div class="row py-3">
          <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
            <nav class="main-menu d-flex navbar navbar-expand-lg">

              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

                <div class="offcanvas-header justify-content-center">
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
              
                  <select class="filter-categories border-0 mb-0 me-5" style="color: rgb(95, 58, 31)">
                    <option>Shop by Departments</option>
                    <option>Groceries</option>
                    <option>Drinks</option>
                    <option>Chocolates</option>
                  </select>
              
                  <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                    <li class="nav-item active">
                      <a href="berita" class="nav-link" style="color: rgb(95, 58, 31)">Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="#men" class="nav-link" style="color: rgb(95, 58, 31)">Men</a>
                    </li>
                    <li class="nav-item">
                      <a href="#kids" class="nav-link" style="color: rgb(95, 58, 31)">Kids</a>
                    </li>
                    <li class="nav-item">
                      <a href="#accessories" class="nav-link" style="color: rgb(95, 58, 31)">Accessories</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" role="button" id="pages" data-bs-toggle="dropdown" aria-expanded="false" style="color: rgb(95, 58, 31)">Pages</a>
                      <ul class="dropdown-menu" aria-labelledby="pages">
                        <li><a href="index.html" class="dropdown-item">About Us </a></li>
                        <li><a href="index.html" class="dropdown-item">Shop </a></li>
                        <li><a href="index.html" class="dropdown-item">Single Product </a></li>
                        <li><a href="index.html" class="dropdown-item">Cart </a></li>
                        <li><a href="index.html" class="dropdown-item">Checkout </a></li>
                        <li><a href="index.html" class="dropdown-item">Blog </a></li>
                        <li><a href="index.html" class="dropdown-item">Single Post </a></li>
                        <li><a href="index.html" class="dropdown-item">Styles </a></li>
                        <li><a href="index.html" class="dropdown-item">Contact </a></li>
                        <li><a href="index.html" class="dropdown-item">Thank You </a></li>
                        <li><a href="index.html" class="dropdown-item">My Account </a></li>
                        <li><a href="index.html" class="dropdown-item">404 Error </a></li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a href="#brand" class="nav-link" style="color: rgb(95, 58, 31)">Brand</a>
                    </li>
                    <li class="nav-item">
                      <a href="#sale" class="nav-link" style="color: rgb(95, 58, 31)">Sale</a>
                    </li>
                    <li class="nav-item">
                      <a href="#blog" class="nav-link" style="color: rgb(95, 58, 31)">Blog</a>
                    </li>
                  </ul>
                
                </div>

              </div>
          </div>
        </div>
      </div>

      <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>
    
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span style="color: rgb(95, 58, 31)">Your cart</span>
                <span class="badge bg-primary rounded-pill" style="color: rgb(95, 58, 31)">
                    {{ count(session('keranjang', [])) }}
                </span>
            </h4>
            <ul class="list-group mb-3">
    @php
        $total = 0;
    @endphp
    @foreach(session('keranjang', []) as $id => $item)
        @php
            $total += $item['harga'] * $item['jumlah'];
        @endphp
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <h6 class="my-0">{{ $item['nama'] }}</h6>
                  <small class="text-muted">Rp{{ number_format($item['harga'], 0, ',', '.') }}</small>

                <div class="d-flex align-items-center mt-1">
                    <form action="{{ route('keranjang.update', $id) }}" method="POST" class="d-flex">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="btn btn-sm btn-outline-secondary me-1">-</button>
                    </form>

                    <span>{{ $item['jumlah'] }}</span>

                    <form action="{{ route('keranjang.update', $id) }}" method="POST" class="ms-1 d-flex">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="increase">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                    </form>

                    <form action="{{ route('keranjang.destroy', $id) }}" method="POST" class="ms-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                    </form>
                </div>
            </div>
            <span class="text-body-secondary">{{ 'Rp ' . number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
        </li>
    @endforeach

    <li class="list-group-item d-flex justify-content-between">
        <span>Total</span>
        <strong>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</strong>
    </li>
</ul>

            <a href="{{ route('keranjang.checkout') }}" class="w-100 btn btn-primary btn-lg" style="color: rgb(255, 196, 63); background-color: rgb(95, 58, 31);">Continue to checkout</a>
        </div>
    </div>
</div>

    
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch" aria-labelledby="Search">
      <div class="offcanvas-header justify-content-center">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Search</span>
          </h4>
          <form role="search" action="index.html" method="get" class="d-flex mt-3 gap-0">
            <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="What are you looking for?" aria-label="What are you looking for?">
            <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>