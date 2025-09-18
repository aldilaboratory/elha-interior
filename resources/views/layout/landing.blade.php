<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>DAWAN PETSHOP</title>
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

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <!-- End Topbar -->
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <!-- Start Header Logo -->
                        <a class="navbar-brand w-50 d-flex align-items-center" href="{{ route('shop') }}">
                            <span class="fw-bold text-primary" style="font-size: 1.5rem;">Dawan Pet Shop</span>
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <form action="{{ route('landing.products') }}" method="GET">
                            <div class="main-menu-search">
                                <!-- navbar search start -->
                                <div class="navbar-search search-style-5">
                                    <div class="search-input">
                                        <input type="text" placeholder="Search" name="search">
                                    </div>
                                    <div class="search-btn">
                                        <button type="submit"><i class="lni lni-search-alt"></i></button>
                                    </div>
                                    <!-- navbar search Ends -->
                                </div>
                            </div>
                        </form>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>Contact Us:
                                    <span>(+62) 851-6144-2346</span>
                                </h3>
                            </div>

                            <div class="navbar-cart">
                                <div class="cart-items">
                                    <a href="{{ url('/landing/alamat') }}" class="main-btn">
                                        <i class="lni lni-user"></i>
                                    </a>
                                </div>
                            </div>

                            @php
                            use App\Models\Keranjang;

                            $cartCount = 0;
                            if (Auth::check()) {
                            $cartCount = Keranjang::where('user_id', Auth::id())->sum('jumlah');
                            }
                            @endphp

                            <div class="navbar-cart">
                                <div class="cart-items">
                                    <a href="{{ route('landing.cart') }}" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items">{{ $cartCount }}</span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                            @php
                            use App\Models\Kategori;
                            $kategoris = Kategori::all();
                            @endphp
                            <ul class="sub-category">
                                @foreach($kategoris as $kategori)
                                <li>
                                    <a href="{{ route('shop', ['category' => $kategori->id]) }}">
                                        {{ $kategori->nama }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
    <ul id="nav" class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="{{ route('shop') }}"
               class="{{ request()->routeIs('shop') ? 'active' : '' }}"
               aria-label="Toggle navigation">
               Home
            </a>
        </li>

        @auth
        <li class="nav-item">
            <a href="{{ route('landing.pesanan') }}"
               class="{{ request()->routeIs('landing.pesanan') ? 'active' : '' }}">
               Pesanan Saya
            </a>
        </li>
        @endauth

        <li class="nav-item">
            <a href="{{ route('landing.products') }}"
               class="{{ request()->routeIs('landing.products') ? 'active' : '' }}">
               All Product
            </a>
        </li>

        @guest
        <li class="nav-item">
            <a href="{{ route('landing.login') }}"
               class="{{ request()->routeIs('landing.login') ? 'active' : '' }}">
               Sign In
            </a>
        </li>
        @else
        <li class="nav-item">
            <a href="{{ route('landing.logout') }}"
               class="{{ request()->routeIs('landing.logout') ? 'active' : '' }}">
               Logout
            </a>
        </li>
        @endguest
    </ul>
</div>
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-end">
                        <div class="user">
                            @auth
                            <span class="user-profile-link" style="pointer-events: none; cursor: default; text-decoration: none;">
                                <i class="lni lni-user"></i>
                                Hello, {{ Auth::user()->name }}
                            </span>
                            @else
                            <a href="{{ route('landing.login') }}" class="user-profile-link">
                                <i class="lni lni-user"></i>
                                Hello, Guest
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
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
