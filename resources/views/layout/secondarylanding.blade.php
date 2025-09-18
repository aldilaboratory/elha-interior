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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-pap7dQ5t6K6iD/0L0vR7VtU5xZtEoj+M5hXxX5A9+ejE62zwWqYI8pZ6e0ZGzJk6aJkC1rY1h+7v6SxY5y3Y8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
            text-decoration: none;
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
                        <a class="navbar-brand w-100 d-flex align-items-center" href="{{ route('shop') }}">
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
    @yield('content')

    <footer class="footer">

        <!-- End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
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

        //======== Brand Slider
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
    </script>

    @yield('js')
</body>

</html>
