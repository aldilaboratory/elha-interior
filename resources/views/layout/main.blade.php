<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DAWAN PETSHOP</title>

    <link rel="shortcut icon" href="{{ asset('/favicon.svg') }}" type="image/x-icon">

    <!-- Vendors styles-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('assets/icons/coreui/css/free.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/icons/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/plugins/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/plugins/sweetalert2.min.css') }}" rel="stylesheet" />

    <!-- Main styles for this application-->
    <link href="{{ asset('assets/css/themes/lite-purple.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sidebar-custom.css') }}" rel="stylesheet">

    {{-- CSS --}}
    @yield('css')
</head>

<body>
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">

            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="m-auto"></div>
            <div class="header-part-right">
                <!-- Full screen toggle -->
                <!--<i class="cil-fullscreen header-icon d-none d-sm-inline-block" data-fullscreen></i>-->

                <!-- Notificaiton -->
                <!--<div class="dropdown">-->
                <!--    <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown"-->
                <!--        aria-haspopup="true" aria-expanded="false">-->
                <!--        <span class="badge badge-primary">3</span>-->
                <!--        <i class="cil-bell text-muted header-icon"></i>-->
                <!--    </div>-->

                    <!-- Notification dropdown -->
                <!--    <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none"-->
                <!--        aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">-->
                <!--        <div class="dropdown-item d-flex">-->
                <!--            <div class="notification-icon">-->
                <!--                <i class="cil-comment-bubble text-primary mr-1"></i>-->
                <!--            </div>-->
                <!--            <div class="notification-details flex-grow-1">-->
                <!--                <p class="m-0 d-flex align-items-center">-->
                <!--                    <span>New message</span>-->
                <!--                    <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>-->
                <!--                    <span class="flex-grow-1"></span>-->
                <!--                    <span class="text-small text-muted ml-auto">10 sec ago</span>-->
                <!--                </p>-->
                <!--                <p class="text-small text-muted m-0">James: Hey! are you busy?</p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="dropdown-item d-flex">-->
                <!--            <div class="notification-icon">-->
                <!--                <i class="cil-comment-bubble text-success mr-1"></i>-->
                <!--            </div>-->
                <!--            <div class="notification-details flex-grow-1">-->
                <!--                <p class="m-0 d-flex align-items-center">-->
                <!--                    <span>New order received</span>-->
                <!--                    <span class="badge badge-pill badge-success ml-1 mr-1">new</span>-->
                <!--                    <span class="flex-grow-1"></span>-->
                <!--                    <span class="text-small text-muted ml-auto">2 hours ago</span>-->
                <!--                </p>-->
                <!--                <p class="text-small text-muted m-0">1 Headphone, 3 iPhone x</p>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" id="userDropdown" alt=""
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="cil-user mr-1"></i> Setting Akun
                            </div>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item" style="border: none; background: none; text-align: left; width: 100%; cursor: pointer;">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebars --}}
        @include('layout.sidebar')

        {{-- Main Layout --}}
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content">
                {{-- View Render --}}
                @yield('content')
            </div>
            <!-- fotter end -->
        </div>
    </div>

    <!-- Gull and necessary plugins-->
    <script src="{{ asset('assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/js/scripts/cookies.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-custom.js') }}"></script>

    <script>
        const baseUrl = (path, prefix = "/admin") => "{{ url('/') }}" + prefix + path;
        const printRoute = "{{ route('pesanan.print', ':id') }}";
        const assetUrl = (path) => "{{ asset('/') }}" + path;
        
        // Setup CSRF token for Ajax requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    {{-- JS --}}
    @yield('js')
</body>

</html>
