@extends('layout.secondarylanding')
@section('css')

@endsection

@section('content')
<!-- Start Hero Area -->
<section class="hero-area">
    <div class="container">
        <!-- Full Width Banner Promosi -->
        <div class="row mb-4">
            <div class="col-12">
                @if($bannerPromosi->isNotEmpty())
                @php
                    $banner = $bannerPromosi->first();
                    $imageUrl = url('upload/bannerpromosi/' . $banner->image);
                @endphp
                
                <!-- Main Banner with Background Image -->
                <div class="main-banner-promosi"
                    style="background-image: url('{{ $imageUrl }}'); 
                           background-size: cover; 
                           background-position: center; 
                           background-repeat: no-repeat;
                           min-height: 400px;
                           border-radius: 10px;
                           position: relative;
                           display: flex;
                           align-items: center;
                           box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <div class="content p-5">
                        <h2 class="display-4 fw-bold mb-3" style="color: orange;">{{ $banner->nama }}</h2>
                        <p class="lead text-dark mb-4 w-50">{{ $banner->deskripsi }}</p>
                    </div>
                </div>
                
                <!-- Fallback: Card with Image if background doesn't work -->
                <div class="card mt-3 d-none" id="fallback-banner">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="{{ $imageUrl }}" class="img-fluid rounded-start h-100" alt="{{ $banner->nama }}" style="object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body d-flex flex-column justify-content-center h-100">
                                <h2 class="card-title display-5 fw-bold">{{ $banner->nama }}</h2>
                                <p class="card-text lead">{{ $banner->deskripsi }}</p>
                                <a href="{{ route('landing.products') }}" class="btn btn-primary btn-lg">Lihat Produk</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info text-center">
                    <h4>Selamat Datang di Elha Interior</h4>
                    <p>Temukan koleksi furniture dan dekorasi terbaik untuk rumah Anda.</p>
                    <a href="{{ route('landing.products') }}" class="btn btn-primary">Lihat Semua Produk</a>
                </div>
                @endif
            </div>
        </div>
        
        <script>
        // Check if background image loaded, if not show fallback
        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.querySelector('.main-banner-promosi');
            const fallback = document.getElementById('fallback-banner');
            
            if (banner && fallback) {
                const img = new Image();
                img.onload = function() {
                    // Image loaded successfully, keep main banner
                    console.log('Banner image loaded successfully');
                };
                img.onerror = function() {
                    // Image failed to load, show fallback
                    banner.style.display = 'none';
                    fallback.classList.remove('d-none');
                    console.log('Banner image failed to load, showing fallback');
                };
                
                // Extract URL from background-image style
                const bgImage = window.getComputedStyle(banner).backgroundImage;
                const urlMatch = bgImage.match(/url\(["']?([^"']*)["']?\)/);
                if (urlMatch && urlMatch[1]) {
                    img.src = urlMatch[1];
                }
            }
        });
        </script>
        
        <!-- Other Banners Below -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <!-- Produk Baru Banner -->
                <div class="hero-small-banner"
                    style="background-image: url({{asset('upload/produkbarupromosi/'.$produkBaruPromosi->image)}});
                           min-height: 250px;
                           background-position: center;
                           object-fit: cover;">
                    <div class="content">
                        <h2 class="mb-2" style="color: orange;">
                            {{$produkBaruPromosi->nama}}
                        </h2>
                        <p class="text-dark">{{$produkBaruPromosi->deskripsi}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-3">
                <!-- Info Promosi Banner -->
                <div class="hero-small-banner" 
                    style="background-image: url({{asset('upload/infopromosi/'.$infoPromosi->image)}});
                           min-height: 250px;
                           background-position: center;
                           object-fit: cover;">
                    <div class="content">
                        <h2 class="mb-2" style="color: orange;">{{$infoPromosi->nama}}</h2>
                        <p class="text-dark">{{$infoPromosi->deskripsi}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Area -->

<!-- End Hero Area -->
<!-- End Hero Area -->
<!-- Start Trending Product Area -->
<section class="trending-product section" style="margin-top: 12px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($data as $key =>$value)
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Product -->
                <div class="single-product">
                    <div class="product-image" style="position: relative;">
                        <a href="{{url('/landing/shop/detail/'. $value->id)}}">
                            <img src="{{asset('upload/produk/'.$value->image)}}" alt="#" style="cursor: pointer;">
                        </a>
                        <!-- Stock Info di pojok kanan atas -->
                        <div class="stock-badge" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            @if($value->stok > 0)
                                <span class="badge bg-success">Stok: {{ $value->stok }}</span>
                            @else
                                <span class="badge bg-danger">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="category">{{$value->kategori_nama}}</span>
                        <h4 class="title">
                            <a href="{{url('/landing/shop/detail/'. $value->id)}}">{{$value->nama}}</a>
                        </h4>
                        <div class="price" style="color: orange; font-weight: bold;">
                            <span style="color: #333; font-weight: bold;">Rp{{ number_format($value->harga, 0, ',', '.')}}</span>
                        </div>
                        <!-- Tombol Add to Cart -->
                        <div class="text-center mt-3">
                            @if($value->stok > 0)
                                <form action="{{ route('landing.cart.add') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $value->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn btn-primary" 
                                            style="width: 100%; background-color: orange; border: none; padding: 8px 16px; border-radius: 5px; color: white;">
                                        <i class="lni lni-cart"></i> Add to Cart
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary" disabled style="width: 100%; padding: 8px 16px; border-radius: 5px;">
                                    <i class="lni lni-ban"></i> Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Single Product -->
            </div>
            @endforeach
</section>
<!-- End Trending Product Area -->
@endsection

@section('js')
<script>
    // Add to cart functionality now handled by form submission
</script>
@endsection
