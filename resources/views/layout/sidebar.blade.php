<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('dashboard') }}">
                    <i class="nav-icon cil-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('transaksi.index') }}">
                    <i class="nav-icon fa fa-wallet"></i>
                    <span class="nav-text">Transaksi</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('bannerpromosi.*') || request()->routeIs('footerpromosi.*') || request()->routeIs('produkbaru.*') || request()->routeIs('infopromosi.*') ? 'active' : '' }}" data-item="promosi">
                <a class="nav-item-hold" href="javascript:;">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="nav-text">Promosi</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('laporan-penjualan.*') || request()->routeIs('laporan-stok.*') ? 'active' : '' }}" data-item="laporan">
                <a class="nav-item-hold" href="javascript:;">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('produk.*') || request()->routeIs('kategori.*') ? 'active' : '' }}" data-item="master">
                <a class="nav-item-hold" href="javascript:;">
                    <i class="nav-icon fa fa-book"></i>
                    <span class="nav-text">Master</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->routeIs('user.*') || request()->routeIs('group.*') ? 'active' : '' }}" data-item="setting">
                <a class="nav-item-hold" href="javascript:;">
                    <i class="nav-icon fa fa-wrench"></i>
                    <span class="nav-text">Setting</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="childNav" data-parent="promosi">
            <li class="nav-item">
                <a class="{{ request()->routeIs('bannerpromosi.*') ? 'active' : '' }}" href="{{ route('bannerpromosi.index') }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Banner Promosi</span>
                </a>
                <a class="{{ request()->routeIs('footerpromosi.*') ? 'active' : '' }}" href="{{ route('footerpromosi.index') }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Footer Promosi</span>
                </a>
                <a class="{{ request()->routeIs('produkbaru.*') ? 'active' : '' }}" href="{{ route('produkbaru.edit',1) }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Produk Promosi</span>
                </a>
                <a class="{{ request()->routeIs('infopromosi.*') ? 'active' : '' }}" href="{{ route('infopromosi.edit',1) }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Info Promosi</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="laporan">
            <li class="nav-item">
                <a class="{{ request()->routeIs('laporan-penjualan.*') ? 'active' : '' }}" href="{{ route('laporan-penjualan.index') }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <span class="item-name">Laporan Penjualan</span>
                </a>
                <a class="{{ request()->routeIs('laporan-stok.*') ? 'active' : '' }}" href="{{ route('laporan-stok.index') }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Laporan Stok Barang</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="master">
            <li class="nav-item">
                <a class="{{ request()->routeIs('produk.*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Produk</span>
                </a>
                <a class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <span class="item-name">Kategori Produk</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="setting">
            <li class="nav-item">
                <a class="{{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="nav-icon fa fa-user"></i>
                    <span class="item-name">User</span>
                </a>
                <a class="{{ request()->routeIs('group.*') ? 'active' : '' }}" href="{{ route('group.index') }}">
                    <i class="nav-icon fa fa-users"></i>
                    <span class="item-name">Group</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-overlay"></div>
</div>
