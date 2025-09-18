<header class="header navbar-area">
    <!-- Start Topbar -->
    <div class="topbar bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-unstyled d-flex align-items-center gap-3 mb-0">
                            <li style="color: black"><i class="lni lni-phone me-1" style="color: orange"></i> +62 893 664 678</li>
                            <span>|</span>
                            <li style="color: black"><i class="lni lni- me-1"></i>support@elhainterior.com</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                    <ul class="list-unstyled d-flex align-items-center justify-content-end gap-3 mb-0">
                        <li><a href="https://maps.app.goo.gl/T6VH6xM3qneNVyR27" style="color: black"><i class="lni lni-map" style="color: orange;"></i> Lokasi toko</a></li>
                        <span>|</span>
                        <li><i class="ti-user"></i> <a href="{{ route('profile.edit') }}" style="color: black"><i class="lni lni-user" style="color: orange"></i> Akun saya</a></li>
                        <span>|</span>
                        @if (Auth::check())
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none" style="color: black">
                                <i class="ti-power-off" style="color:red"></i> Keluar
                            </button>
                            </form>
                        </li>
                        @else
                        {{-- <li><i class="ti-power-off"></i> <a href="{{ route('login') }}" style="color: black">Login</a></li> --}}
                        <li><i class="ti-power-off"></i> <a href="{{ url('/landing/alamat') }}" style="color: black">Login</a></li>
                        @endif
                    </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <!-- Start Header Middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-3 col-7">
                    <!-- Start Header Logo -->
                    <a class="navbar-brand w-50 d-flex align-items-center" href="{{ route('shop') }}">
                        {{-- <img src="{{ asset('assets/images/logo-elha.svg') }}" alt="ELHA INTERIOR" style="height: 40px; margin-right: 10px;"> --}}
                        <img src="{{ asset('assets_landing/images/logo/logo.png') }}" alt="logo">
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

                        {{-- <div class="navbar-cart">
                            <div class="cart-items">
                                <a href="{{ url('/landing/alamat') }}" class="main-btn">
                                    <i class="lni lni-user"></i>
                                </a>
                            </div>
                        </div> --}}

                        @php
                        $cartCount = 0;
                        if (Auth::check()) {
                        $cartCount = \App\Models\Keranjang::where('user_id', Auth::id())->sum('jumlah');
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
                        <span class="cat-button"><i class="lni lni-menu"></i>KATEGORI</span>
                        @php
                        $kategoris = \App\Models\Kategori::all();
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
                                    Beranda
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
                                    Semua Produk
                                    </a>
                                </li>

                                {{-- @guest
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
                                @endguest --}}
                            </ul>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="top-end">
                    {{-- <div class="user">
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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Bottom -->
</header>