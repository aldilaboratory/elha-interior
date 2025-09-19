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
    @include('partials.header')
    <!-- End Header Area -->

    @php

    $alamat = \App\Models\ProfilLengkapPengguna::query()->where('user_id', \Illuminate\Support\Facades\Auth::id())->count();

    @endphp


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
                            <h2 style="color: orange">{{ $banner->nama }}</h2>
                            <p style="color: #333">{!! $banner->deskripsi !!}</p>
                            <div class="button">
                                <a href="{{url('/landing/shop/detail/'. $banner->produk_id)}}" class="btn" style="background-color: orange">
                                    Beli Sekarang
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
    {{-- <section class="shipping-info">
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
    </section> --}}
    <!-- End Shipping Info -->

    <!-- Start Footer Area -->
    @include('partials.footer')
    <!-- End Footer Area -->


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
