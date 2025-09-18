<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>ELHA INTERIOR</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets_landing/images/logo/logo.png')}}" />


    <!-- ========================= CSS here ========================= -->
    <link href="{{ asset('assets_landing/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/css/LineIcons.3.0.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/elha-custom.css') }}" rel="stylesheet">

    @yield('css')

    <style>
        .float{
            position:fixed;
            width:60px;
            height:60px;
            bottom:100px;
            right:30px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
        }

        .my-float{
            margin-top:16px;
        }

        /* Logo text responsive styling */
        .navbar-brand span {
            white-space: nowrap;
        }

        .user-profile-link {
            color: inherit;
            text-decoration: none !important;
            pointer-events: none !important;
            cursor: default !important;
            user-select: none !important;
            transition: color 0.3s ease;
        }
        
        .user-profile-link:hover {
            color: #0167F3;
            text-decoration: none;
        }
        
        .user-profile-link i {
            margin-right: 5px;
        }

        @media (max-width: 991px) {
            .navbar-brand span {
                font-size: 1.3rem !important;
            }
        }

        @media (max-width: 767px) {
            .navbar-brand span {
                font-size: 1.1rem !important;
            }
        }

        @media (max-width: 575px) {
            .navbar-brand span {
                font-size: 1rem !important;
            }
        }
    </style>
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->



    <!-- Start Header Area -->
    <header class="header shop">
        <!-- Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12">
                        <!-- Top Left -->
                        <div class="top-left">
                            <ul class="list-main">
                                <li><i class="ti-headphone-alt"></i> +62 893 664 678</li>
                                <li><i class="ti-email"></i> support@elhainterior.com</li>
                            </ul>
                        </div>
                        <!--/ End Top Left -->
                    </div>
                    <div class="col-lg-8 col-md-12 col-12">
                        <!-- Top Right -->
                        <div class="right-content">
                            <ul class="list-main">
                                <li><a href="https://maps.app.goo.gl/T6VH6xM3qneNVyR27"><i class="ti-location-pin"></i> Lokasi toko</a></li>
                                <li><i class="ti-user"></i> <a href="{{ route('profile.edit') }}"> Akun saya</a></li>
                                @if (Auth::check())
                                    {{-- User sudah login, maka tampil tombol logout --}}
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="text-danger d-inline">
                                        @csrf
                                            <button type="submit" class="dropdown-item">
                                            <i class="ti-power-off text-danger"></i>{{ __('Keluar') }}
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    {{-- User belum login, maka tampil tombol login --}}
                                    <li><i class="ti-power-off"></i><a href="{{ route('login') }}"> Login</a></li>
                                @endif
                            </ul>
                        </div>
                        <!-- End Top Right -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <div class="middle-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-12">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{ route('landing.index') }}"><img src="{{ asset('assets/images/logo-elha.svg') }}" alt="logo"></a>
                        </div>
                        <!--/ End Logo -->
                        <!-- Search Form -->
                        <div class="search-top">
                            <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                            <!-- Search Form -->
                            <div class="search-top">
                                <form class="search-form">
                                    <input type="text" placeholder="Search here..." name="search">
                                    <button value="search" type="submit"><i class="ti-search"></i></button>
                                </form>
                            </div>
                            <!--/ End Search Form -->
                        </div>
                        <!--/ End Search Form -->
                        <div class="mobile-nav"></div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-12">
                        <div class="search-bar-top">
                            <div class="search-bar">
                                <form action="{{ route('landing.products') }}" method="GET">
                                    <input name="search" placeholder="Cari produk di sini..." type="search">
                                    <button class="btnn"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="right-bar">
                            <!-- Search Form -->
                            <div class="sinlge-bar">
                                <a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div>
                            @php
                            use App\Models\Keranjang;
                            $cartCount = 0;
                            if (Auth::check()) {
                                $cartCount = Keranjang::where('user_id', Auth::id())->sum('jumlah');
                            }
                            @endphp
                            <div class="sinlge-bar shopping">
                                <a href="{{ route('landing.cart') }}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{ $cartCount }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Inner -->
        <div class="header-inner">
            <div class="container">
                <div class="cat-nav-head">
                    <div class="row">
                        <div class="col-lg-3">
                            @if (Route::is('landing.index'))
                            <div class="all-category">
                                <h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>KATEGORI</h3>
                                @php
                                $kategoris = \App\Models\Kategori::all();
                                @endphp
                                <ul class="main-category">
                                    <li><a href="{{ route('shop') }}">Ruang Seputar Thailand</a></li>
                                    <li><a href="{{ route('shop') }}">Peralatan Dapur</a></li>
                                    <li><a href="{{ route('shop') }}">Perlengkapan Kamar Mandi</a></li>
                                    @foreach($kategoris as $kategori)
                                    <li>
                                        <a href="{{ route('shop', ['category' => $kategori->id]) }}">
                                            {{ $kategori->nama }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-9 col-12">
                            <div class="menu-area">
                                <!-- Main Menu -->
                                <nav class="navbar navbar-expand-lg">
                                    <div class="navbar-collapse">
                                        <div class="nav-inner">
                                            <ul class="nav main-menu menu navbar-nav">
                                                <li class="active"><a href="{{ route('landing.index') }}">Beranda</a></li>
                                                @auth
                                                <li><a href="{{ route('landing.pesanan') }}">Pesanan Saya</a></li>
                                                @endauth
                                                <li><a href="{{ route('landing.products') }}">Produk</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                                <!--/ End Main Menu -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Header Inner -->
    </header>
    <!-- End Header Area -->

    @php

    $alamat = \App\Models\ProfilLengkapPengguna::query()->where('user_id', \Illuminate\Support\Facades\Auth::id())->count();

    @endphp


    @if($alamat < 1)
    <div class="w-75 mt-5 mx-auto mx-5 alert alert-info text-center">
        Anda Belum Membuat Satupun Alamat Pengiriman Pergi Dan Klik Untuk Menambahkanya. <span><a href="{{ route('alamat.index') }}">Disini!!!</a></span>
    </div>
    @endif

    @yield('content')

    <section class="banner section">
        <div class="container">
            <div class="row">
                @php
                use App\Models\FooterPromosi;
                $footerBanners = FooterPromosi::all();
                @endphp

                @foreach($footerBanners as $key => $banner)
                <div class="col-lg-6 col-md-6 col-12 {{ $key == 1 ? 'custom-responsive-margin' : '' }}">
                    <div class="single-banner"
                        style="background-image:url('{{ asset('upload/footerpromosi/'.$banner->image) }}');">
                        <div class="content">
                            <h2 class='text-light'>{{ $banner->nama }}</h2>
                            <p class='text-light'>{!! $banner->deskripsi !!}</p>
                            <div class="button">
                                <a href="{{url('/landing/shop/detail/'. $banner->produk_id)}}" class="btn">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->

    <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img src="{{asset('assets_landing/images/logo/white-logo.svg')}}" alt="#">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="footer-newsletter">
                                <h4 class="title">
                                    Subscribe to our Newsletter
                                    <span>Get all the latest information, Sales and Offers.</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="newsletter-form">
                                        <input name="EMAIL" placeholder="Email address here..." type="email">
                                        <div class="button">
                                            <button class="btn">Subscribe<span class="dir-part"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->
        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>Get In Touch With Us</h3>
                                <p class="phone">Phone: +1 (900) 33 169 7720</p>
                                <ul>
                                    <li><span>Monday-Friday: </span> 9.00 am - 8.00 pm</li>
                                    <li><span>Saturday: </span> 10.00 am - 6.00 pm</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:support@shopgrids.com">support@shopgrids.com</a>
                                </p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer our-app">
                                <h3>Our Mobile App</h3>
                                <ul class="app-btn">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-apple"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">App Store</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-play-store"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">Google Play</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Information</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="javascript:void(0)">Contact Us</a></li>
                                    <li><a href="javascript:void(0)">Downloads</a></li>
                                    <li><a href="javascript:void(0)">Sitemap</a></li>
                                    <li><a href="javascript:void(0)">FAQs Page</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Shop Departments</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Computers & Accessories</a></li>
                                    <li><a href="javascript:void(0)">Smartphones & Tablets</a></li>
                                    <li><a href="javascript:void(0)">TV, Video & Audio</a></li>
                                    <li><a href="javascript:void(0)">Cameras, Photo & Video</a></li>
                                    <li><a href="javascript:void(0)">Headphones</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>We Accept:</span>
                                <img src="{{asset('assets_landing/images/footer/credit-cards-footer.png')}}" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>Designed and Developed by<a href="https://graygrids.com/" rel="nofollow"
                                        target="_blank">GrayGrids</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li>
                                    <span>Follow Us On:</span>
                                </li>
                                <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>


    <!-- ========================= scroll-top ========================= -->
    <div class="d-flex gap-3">
        <a href="https://wa.me/6285161442346" target="_blank" class="float">
            <i class="lni lni-whatsapp my-float"></i>
        </a>

        <a href="#" class="scroll-top">
            <i class="lni lni-chevron-up"></i>
        </a>
    </div>



    <!-- ========================= JS here ========================= -->
    <script src="{{asset('assets_landing/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets_landing/js/tiny-slider.js')}}"></script>
    <script src="{{asset('assets_landing/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets_landing/js/main.js')}}"></script>
    <script>
        //========= Hero Slider
        if (document.querySelector('.hero-slider')) {
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });
        }

        //======== Brand Slider
        if (document.querySelector('.brands-logo-carousel')) {
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        }
    </script>

    <script>
        // Completely disable user profile link
        document.addEventListener('DOMContentLoaded', function() {
            const userLinks = document.querySelectorAll('.user-profile-link');
            
            userLinks.forEach(function(link) {
                // Remove href if exists
                if (link.hasAttribute('href')) {
                    link.removeAttribute('href');
                }
                
                // Block all possible events
                const events = ['click', 'mousedown', 'mouseup', 'keydown', 'keyup', 'keypress', 'touchstart', 'touchend', 'focus', 'blur', 'contextmenu'];
                
                events.forEach(function(eventType) {
                    link.addEventListener(eventType, function(e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        e.stopPropagation();
                        return false;
                    }, true);
                });
                
                // Set all event handlers to return false
                link.onclick = function() { return false; };
                link.onmousedown = function() { return false; };
                link.onmouseup = function() { return false; };
                link.onkeydown = function() { return false; };
                link.onkeyup = function() { return false; };
                link.onkeypress = function() { return false; };
                link.ontouchstart = function() { return false; };
                link.ontouchend = function() { return false; };
                link.onfocus = function() { return false; };
                link.onblur = function() { return false; };
                link.oncontextmenu = function() { return false; };
            });
        });
    </script>

    @yield('js')
</body>

</html>
