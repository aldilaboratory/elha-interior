@extends('layout.landing')
@section('css')

@endsection

@section('content')
<!-- Start Breadcrumbs -->
<!-- End Breadcrumbs -->

<!-- Start Item Details -->
<section class="item-details section">
    <div class="container">
        <div class="top-area">
            <div class="row align-items-center">
                <!-- Gambar Produk -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-images">
                        <main id="gallery">
                            <div class="main-img">
                                <img src="{{ asset('/upload/produk/'.$data->image) }}" id="current" alt="#">
                            </div>
                        </main>
                    </div>
                </div>

                <!-- Info Produk -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-info">
                        <h2 class="title">{{ $data->nama }}</h2>
                        <p class="category"><i class="lni lni-tag"></i> <a href="javascript:void(0)">{{ $data->kategori_nama }}</a></p>
                        <h3 class="price">Rp{{ number_format($data->harga, 0, ',', '.') }}</h3>
                        <div class="stock-info mb-3">
                            @if($data->stok > 0)
                                <span>Ketersediaan: <span class="text-success">{{ $data->stok }}</span></span>
                            @else
                                <span>Ketersediaan: <span class="text-danger">Stok habis</span></span>
                            @endif
                        </div>
                        <p class="info-text">{{ $data->deskripsi }}</p>

                        <!-- Form Add to Cart -->
                        @if($data->stok > 0)
                            @auth
                                <form action="{{ route('landing.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $data->id }}">

                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="form-group quantity">
                                                <label for="jumlah">Quantity</label>
                                                <input class="form-control" type="number" name="jumlah" value="1" min="1" max="{{ $data->stok }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bottom-content">
                                        <div class="row align-items-end">
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="button cart-button">
                                                    <button type="submit" class="btn" style="width: 100%; background-color: orange;"><i class="lni lni-cart"></i> Add to Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="form-group quantity">
                                            <label for="jumlah">Quantity</label>
                                            <input class="form-control" type="number" value="1" min="1" max="{{ $data->stok }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="bottom-content">
                                    <div class="row align-items-end">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="button cart-button">
                                                <a href="{{ route('landing.login') }}" class="btn" style="width: 100%; background-color: orange; text-decoration: none; color: white; display: inline-block; text-align: center;"><i class="lni lni-lock"></i> Login untuk Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        @else
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group quantity">
                                        <label for="jumlah">Quantity</label>
                                        <input class="form-control" type="number" value="0" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="bottom-content">
                                <div class="row align-items-end">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <div class="button cart-button">
                                            <button type="button" class="btn btn-secondary" style="width: 100%; background-color: orange;" disabled>Stok Habis</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Item Details -->

<!-- Review Modal -->
<div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Leave a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="review-name">Your Name</label>
                            <input class="form-control" type="text" id="review-name" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="review-email">Your Email</label>
                            <input class="form-control" type="email" id="review-email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="review-subject">Subject</label>
                            <input class="form-control" type="text" id="review-subject" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="review-rating">Rating</label>
                            <select class="form-control" id="review-rating">
                                <option>5 Stars</option>
                                <option>4 Stars</option>
                                <option>3 Stars</option>
                                <option>2 Stars</option>
                                <option>1 Star</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="review-message">Review</label>
                    <textarea class="form-control" id="review-message" rows="8" required></textarea>
                </div>
            </div>
            <div class="modal-footer button">
                <button type="button" class="btn">Submit Review</button>
            </div>
        </div>
    </div>
</div>
<!-- End Review Modal -->

</section>
<!-- End Trending Product Area -->
@endsection

@section('js')

@endsection