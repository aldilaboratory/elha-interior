@extends('layout.secondarylanding')
@section('css')

@endsection

@section('content')
<!-- Start Hero Area -->
<section class="hero-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 custom-padding-right">
                <div class="slider-head">
                    <!-- Start Hero Slider -->
                    <div class="hero-slider">
                        @foreach($bannerPromosi as $slider)
                        <div class="single-slider"
                            style="background-image: url({{ asset('upload/bannerpromosi/' . $slider->image) }});">
                            <div class="content text-light">
                                <h2 class="text-light">{{ $slider->nama }}</h2>
                                <p>{{ $slider->deskripsi }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- End Single Slider -->
                    <!-- End Hero Slider -->
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                        <!-- Start Small Banner -->
                        <div class="hero-small-banner"
                            style="background-image: url({{asset('upload/produkbarupromosi/'.$produkBaruPromosi->image)}});">
                            <div class="content text-light">
                                <h2 class="text-light">
                                    {{$produkBaruPromosi->nama}}
                                </h2>
                                <p class="text-light">{{$produkBaruPromosi->deskripsi}}</p>
                            </div>
                        </div>
                        <!-- End Small Banner -->
                    </div>
                    <div class="col-lg-12 col-md-6 col-12">
                        <!-- Start Small Banner -->
                        <div class="hero-small-banner style2">
                            <div class="content">
                                <h2 class="text-light">{{$infoPromosi->nama}}</h2>
                                <p class="text-light">{{$infoPromosi->deskripsi}}</p>
                            </div>
                        </div>
                        <!-- Start Small Banner -->
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
                    <div class="product-image">
                        <img src="{{asset('upload/produk/'.$value->image)}}" alt="#">
                        <!-- <div class="button">
                            <a href="" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
                        </div> -->
                    </div>
                    <div class="product-info">
                        <span class="category">{{$value->kategori_nama}}</span>
                        <h4 class="title">
                            <a href="{{url('/landing/shop/detail/'. $value->id)}}">{{$value->nama}}</a>
                        </h4>
                        <div class="price">
                            <span>Rp{{ number_format($value->harga, 0, ',', '.')}}</span>
                        </div>
                        <div class="stock-info mt-2">
                            @if($value->stok > 0)
                                <span class="badge bg-success">Stok: {{ $value->stok }}</span>
                            @else
                                <span class="badge bg-danger">Stok Habis</span>
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

@endsection
