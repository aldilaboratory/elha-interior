<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="childNav" data-parent="promosi">
            <li class="nav-item">
                <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon cil-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('bannerpromosi.*') ? 'active' : '' }}" href="{{ route('bannerpromosi.index') }}">
                    <i class="nav-icon fas fa-image"></i>
                    <span class="item-name">Banner Promosi</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="{{ request()->routeIs('footerpromosi.*') ? 'active' : '' }}" href="{{ route('footerpromosi.index') }}">
                    <i class="nav-icon fas fa-images"></i>
                    <span class="item-name">Footer Promosi</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="{{ request()->routeIs('produkbaru.*') ? 'active' : '' }}" href="{{ route('produkbaru.edit',1) }}">
                    <i class="nav-icon fas fa-star"></i>
                    <span class="item-name">Produk Promosi 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('infopromosi.*') ? 'active' : '' }}" href="{{ route('infopromosi.edit',1) }}">
                    <i class="nav-icon fas fa-info-circle"></i>
                    <span class="item-name">Produk Promosi 2</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="laporan">
            <li class="nav-item">
                <a class="{{ request()->routeIs('laporan-penjualan.*') ? 'active' : '' }}" href="{{ route('laporan-penjualan.index') }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <span class="item-name">Laporan Penjualan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('laporan-stok.*') ? 'active' : '' }}" href="{{ route('laporan-stok.index') }}">
                    <i class="nav-icon fas fa-warehouse"></i>
                    <span class="item-name">Laporan Stok Barang</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="transaksi">
            <li class="nav-item">
                <a class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <span class="item-name">Transaksi</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="master">
            <li class="nav-item">
                <a class="{{ request()->routeIs('produk.*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                    <i class="nav-icon fas fa-box"></i>
                    <span class="item-name">Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                    <i class="nav-icon fas fa-tags"></i>
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
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('group.*') ? 'active' : '' }}" href="{{ route('group.index') }}">
                    <i class="nav-icon fa fa-users"></i>
                    <span class="item-name">Group</span>
                </a>
            </li>
        </ul>
    </div>
    </div>
</div>
