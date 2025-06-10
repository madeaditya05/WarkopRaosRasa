@extends('layoutsbootstrapcustomer')

@section('konten')
<body>

<!-- Preloader (Jika Anda ingin memuat animasi loading) -->
<div class="preloader-wrapper">
  <div class="preloader"></div>
</div>

<!-- Bagian Berita -->
<section id="latest-blog" class="py-5">
    <div class="container py-4">
        <h2 class="text-center fw-bold mb-4">📰 Berita Seputar Warung Indomie & Kopi</h2>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse ($berita as $item)
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="image-holder zoom-effect">
                        <a href="{{ $item['url'] }}" target="_blank">
                            <img src="{{ $item['urlToImage'] ?? 'https://via.placeholder.com/600x400?text=No+Image' }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item['title'] }}</h5>
                        <p class="card-text">{{ \Str::limit($item['description'], 100) }}</p> <!-- Batasi deskripsi -->
                        <a href="{{ $item['url'] }}" target="_blank" class="btn btn-warning btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">Tidak ada berita ditemukan.</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
