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



    <!-- Start Header Area -->
    @include('partials.header')
    <!-- End Header Area -->
    @yield('content')

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

    @yield('js')
</body>

</html>
