@extends('layout.secondarylanding')

@section('css')
    <style>
        .sidebar {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .sidebar h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .sidebar .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list li a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-list li a:hover {
            color: #007bff;
        }

        .category-count {
            background: #f8f9fa;
            color: #666;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .price-range {
            margin: 20px 0;
        }

        .price-range input[type="range"] {
            width: 100%;
            margin: 10px 0;
        }

        .price-display {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .filter-group {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .filter-group:last-child {
            border-bottom: none;
        }

        .brand-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 8px;
        }

        .checkbox-item label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin-bottom: 0;
        }

        .view-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .view-toggle .btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: #fff;
            color: #666;
        }

        .view-toggle .btn.active {
            background: orange;
            color: #fff;
            border-color: #007bff;
        }

        .sort-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .items-count {
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 991px) {
            .sidebar {
                margin-bottom: 30px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area" style="padding: 60px 0;">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar">
                        <!-- Search Product -->
                        <div class="filter-group">
                            <h5>Search Product</h5>
                            <form action="{{ url()->current() }}" method="GET" id="searchForm">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('min_price'))
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if(request('max_price'))
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search here..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="lni lni-search-alt"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- All Categories -->
                        <div class="filter-group">
                            <h5>Semua Kategori</h5>
                            <ul class="category-list">
                                <li><a href="{{ url()->current() }}">Semua Produk <span class="category-count">{{ $totalProducts }}</span></a></li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ url()->current() }}?category={{ $category->id }}"
                                           class="{{ request('category') == $category->id ? 'text-primary fw-bold' : '' }}">
                                            {{ $category->nama }}
                                            <span class="category-count">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Price Range -->
                        <div class="filter-group">
                            <h5>Rentang Harga</h5>
                            <form action="{{ url()->current() }}" method="GET" id="priceFilterForm">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <div class="price-range">
                                    <div class="price-display">
                                        <span>Rp <span id="minPrice">{{ number_format(request('min_price', 0)) }}</span></span>
                                        <span>Rp <span id="maxPrice">{{ number_format(request('max_price', $maxPrice)) }}</span></span>
                                    </div>
                                    <input type="range" id="minPriceRange" name="min_price" min="0" max="{{ $maxPrice }}" value="{{ request('min_price', 0) }}" step="50000">
                                    <input type="range" id="maxPriceRange" name="max_price" min="0" max="{{ $maxPrice }}" value="{{ request('max_price', $maxPrice) }}" step="50000">
                                </div>

                                <!-- Price Input Fields -->
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" name="min_price_input" placeholder="Min" value="{{ request('min_price', 0) }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" name="max_price_input" placeholder="Max" value="{{ request('max_price', $maxPrice) }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Filter</button>
                            </form>
                        </div>


                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 col-md-12">
                    <!-- Sort and View Options -->
                    <div class="sort-filter">
                        <div class="items-count">
                            Showing {{ $data->count() }} of {{ $data->total() }} items
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="view-toggle">
                                <button class="btn active" id="gridView">
                                    <i class="lni lni-grid-alt"></i>
                                </button>
                                <button class="btn" id="listView">
                                    <i class="lni lni-list"></i>
                                </button>
                            </div>
                            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('min_price'))
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if(request('max_price'))
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif
                                <label class="me-2" style="font-size: 14px;">Urutkan:</label>
                                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 150px;">
                                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Termurah ke Termahal</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Termahal ke Termurah</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A ke Z</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Z ke A</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row" id="productsContainer">
                        @forelse ($data as $key => $value)
                            <div class="col-lg-3 col-md-6 col-12 mb-4">
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-image" style="position: relative; max-height: 185px;">
                                        <a href="{{ url('/landing/shop/detail/' . $value->id) }}">
                                            <img src="{{ asset('upload/produk/' . $value->image) }}" alt="{{ $value->nama }}" style="width: 100%; object-fit: cover; cursor: pointer;">
                                        </a>
                                        @if($value->is_sale ?? false)
                                            <span class="sale-tag">Sale</span>
                                        @endif
                                        <!-- Stock Info di pojok kanan atas -->
                                        <div class="stock-badge" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                            @if($value->stok > 0)
                                                <span class="badge bg-success">Stok: {{ $value->stok }}</span>
                                            @else
                                                <span class="badge bg-danger">Stok Habis</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <span class="category">{{ $value->kategori_nama ?? 'Uncategorized' }}</span>
                                        <h4 class="title">
                                            <a href="{{ url('/landing/shop/detail/' . $value->id) }}">{{ $value->nama }}</a>
                                        </h4>
                                        <div class="price">
                                            <span style="color: black; font-weight: bold;">Rp{{ number_format($value->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <!-- Tombol Add to Cart -->
                                        <div class="text-center mt-3">
                                            @if($value->stok > 0)
                                                @auth
                                                    <form action="{{ route('landing.cart.add') }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="produk_id" value="{{ $value->id }}">
                                                        <input type="hidden" name="jumlah" value="1">
                                                        <button type="submit" class="btn btn-primary" 
                                                                style="width: 100%; background-color: orange; border: none; padding: 8px 16px; border-radius: 5px; color: white;">
                                                            <i class="lni lni-cart"></i> Add to Cart
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('landing.login') }}" class="btn btn-primary" 
                                                       style="width: 100%; background-color: orange; border: none; padding: 8px 16px; border-radius: 5px; color: white; text-decoration: none; display: inline-block;">
                                                        <i class="lni lni-lock"></i> Login untuk Add to Cart
                                                    </a>
                                                @endauth
                                            @else
                                                <button class="btn btn-secondary" disabled style="width: 100%; padding: 8px 16px; border-radius: 5px;">
                                                    <i class="lni lni-ban"></i> Stok Habis
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <h5>Tidak ada profuk ditemukan</h5>
                                    <p>Coba ubah kriteria pencarianmu</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($data->hasPages())
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center mt-4">
                                {{ $data->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->
@endsection

@section('js')
    <script>
        // Price Range Sliders
        document.addEventListener('DOMContentLoaded', function() {
            const minPriceRange = document.getElementById('minPriceRange');
            const maxPriceRange = document.getElementById('maxPriceRange');
            const minPriceDisplay = document.getElementById('minPrice');
            const maxPriceDisplay = document.getElementById('maxPrice');

            function updatePriceDisplay() {
                minPriceDisplay.textContent = parseInt(minPriceRange.value).toLocaleString();
                maxPriceDisplay.textContent = parseInt(maxPriceRange.value).toLocaleString();
            }

            minPriceRange.addEventListener('input', updatePriceDisplay);
            maxPriceRange.addEventListener('input', updatePriceDisplay);

            // View Toggle
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const productsContainer = document.getElementById('productsContainer');

            gridView.addEventListener('click', function() {
                gridView.classList.add('active');
                listView.classList.remove('active');
                productsContainer.className = 'row';
                document.querySelectorAll('.product-item').forEach(item => {
                    item.className = 'col-lg-4 col-md-6 col-12 mb-4 product-item';
                });
            });

            listView.addEventListener('click', function() {
                listView.classList.add('active');
                gridView.classList.remove('active');
                productsContainer.className = 'row';
                document.querySelectorAll('.product-item').forEach(item => {
                    item.className = 'col-12 mb-4 product-item';
                });
            });

            // Add to cart functionality now handled by form submission
        });
    </script>
@endsection
