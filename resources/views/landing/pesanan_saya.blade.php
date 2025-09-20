@extends('layout.landing')

@section('css')
<style>
    .order-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .status-badge {
        font-size: 0.85rem;
        border-radius: 25px;
        padding: 8px 16px;
        font-weight: 500;
    }
    
    .btn-modern {
        border-radius: 25px;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,123,255,0.3);
    }
    
    .product-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
    }
    
    /* Product Card Styles */
    .product-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .add-to-cart-form {
        transition: all 0.3s ease;
    }

    .add-to-cart-form:hover {
        transform: scale(1.02);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
    
    .page-header {
        background: #f3f3f3;
        color: #333;
        padding: 60px 0;
        margin-bottom: 40px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .order-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
    }
    
    @media (max-width: 768px) {
        .order-card .row {
            text-align: center;
        }
        
        .btn-modern {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-shopping-bag me-3"></i>Pesanan Saya
                    </h1>
                    <p class="lead">Kelola dan pantau status pesanan kamu dengan mudah</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card order-card">
                        <div class="card-body empty-state">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">Belum Ada Pesanan</h4>
                            <p class="text-muted mb-4">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                            <a href="{{ route('landing.index') }}" class="btn btn-primary btn-modern btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Orders List -->
            <div class="row">
                @foreach($orders as $order)
                <div class="col-12 mb-4">
                    <div class="card order-card">
                        <!-- Order Header -->
                        <div class="card-header bg-white py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0 fw-bold text-dark">
                                        <i class="fas fa-receipt me-2"></i>Order #{{ $order->order_id }}
                                    </h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</small>
                                </div>
                                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                    <span class="badge status-badge
                                        @if($order->status == 'pending') bg-warning text-dark
                                        @elseif($order->status == 'paid') bg-primary text-white
                                        @elseif($order->status == 'dikirim') bg-info text-white
                                        @elseif($order->status == 'selesai') bg-success text-white
                                        @else bg-secondary text-white
                                        @endif">
                                        @if($order->status == 'pending')
                                            <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                        @elseif($order->status == 'paid')
                                            <i class="fas fa-credit-card me-1"></i>Paid - Menunggu Konfirmasi
                                        @elseif($order->status == 'dikirim')
                                            <i class="fas fa-truck me-1"></i>Sedang Dikirim
                                        @elseif($order->status == 'selesai')
                                            <i class="fas fa-check-double me-1"></i>Selesai
                                        @else
                                            <i class="fas fa-info-circle me-1"></i>{{ ucfirst($order->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Order Items -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-box me-2"></i>Produk Pesanan
                                    </h6>
                                    @foreach($order->orderItems as $item)
                                    <div class="product-item">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('upload/produk/'.$item->image) }}"
                                                 alt="{{ $item->nama_produk }}"
                                                 class="rounded me-3"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $item->nama_produk }}</h6>
                                                <p class="mb-1 text-muted">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                <p class="mb-0 fw-bold text-danger">
                                                    Subtotal: Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Details -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        @if($order->resi)
                                        <div class="col-sm-6 mb-3">
                                            <h6 class="fw-bold">
                                                <i class="fas fa-shipping-fast me-2"></i>Nomor Resi
                                            </h6>
                                            <span class="badge bg-info fs-6">{{ $order->resi }}</span>
                                        </div>
                                        @endif
                                        {{-- <div class="col-sm-6 mb-3">
                                            <h6 class="fw-bold">
                                                <i class="fas fa-calendar me-2"></i>Tanggal Pesanan
                                            </h6>
                                            <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <h6 class="fw-bold mb-3">
                                            <i class="fas fa-calculator me-2"></i>Ringkasan Pembayaran
                                        </h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Ongkir:</span>
                                            <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                                        </div>
                                        <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total:</span>
                                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    {{-- <div class="d-flex flex-wrap gap-2 text-end"> --}}
                                    <div class="text-end">
                                        @if($order->status != 'pending' && $order->status != 'paid')
                                            @if($order->status != 'selesai')
                                                <form action="{{ route('pesanan.terima', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin sudah menerima pesanan ini?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="transaksi_id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-success btn-modern">
                                                        <i class="fas fa-check me-2"></i>Terima Pesanan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-success fw-bold">
                                                    <i class="fas fa-check-circle me-1"></i>Pesanan Diterima
                                                </span>
                                            @endif
                                            
                                            <a href="{{ route('pesanan.print', $order->id) }}" target="_blank" class="btn btn-outline-primary btn-modern">
                                                <i class="fas fa-print me-2"></i>Cetak Nota
                                            </a>
                                        @endif
                                        
                                        @if($order->status == 'pending' || $order->status == 'paid')
                                            <button class="btn btn-outline-danger btn-modern" onclick="cancelOrder({{ $order->id }})">
                                                <i class="fas fa-times me-2"></i>Batalkan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
             </div>
         @endif

         <!-- Recommended Products Section -->
         @if($recommendedProducts->isNotEmpty())
         <div class="row mt-5">
             <div class="col-12">
                 <div class="text-center mb-4">
                     <h2 class="fw-bold" style="color: orange">
                         <i class="fas fa-star me-2"></i>Produk Rekomendasi
                     </h2>
                     <p class="text-muted">Produk dengan kategori yang sama dengan pesanan Anda</p>
                 </div>
                 
                 <div class="row">
                     @foreach($recommendedProducts as $product)
                     <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                         <div class="card product-card h-100">
                             <div class="position-relative overflow-hidden">
                                 <img src="{{ asset('upload/produk/' . $product->image) }}" 
                                      alt="{{ $product->nama }}" 
                                      class="card-img-top product-image"
                                      style="height: 200px; object-fit: cover;">
                                 <div class="product-overlay">
                                     <a href="{{ route('shop.detail', $product->id) }}" class="btn btn-primary btn-modern">
                                         <i class="fas fa-eye me-2"></i>Lihat Detail
                                     </a>
                                 </div>
                             </div>
                             <div class="card-body d-flex flex-column">
                                 <span class="badge bg-secondary mb-2 align-self-start">{{ $product->kategori_nama }}</span>
                                 <h6 class="card-title fw-bold">{{ $product->nama }}</h6>
                                 <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->deskripsi, 80) }}</p>
                                 <div class="mt-auto">
                                     <div class="d-flex justify-content-between align-items-center mb-2">
                                         <span class="h5 fw-bold text-dark mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                         <small class="text-muted">Stok: {{ $product->stok }}</small>
                                     </div>
                                     <form action="{{ route('landing.cart.add') }}" method="POST" class="add-to-cart-form">
                                         @csrf
                                         <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                         <input type="hidden" name="jumlah" value="1">
                                         <button type="submit" class="btn w-100 my-2" style="background-color: orange; color: white;">
                                             <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                         </button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                     @endforeach
                 </div>
             </div>
         </div>
         @endif
    </div>
@endsection

@section('js')
<script>
    function cancelOrder(orderId) {
        if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
            // Implementasi pembatalan pesanan
            fetch(`/landing/pesanan/${orderId}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal membatalkan pesanan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    }
    
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Handle add to cart forms
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menambahkan...';
            button.disabled = true;
            
            // Submit form via fetch
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    button.innerHTML = '<i class="fas fa-check me-2"></i>Berhasil!';
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');
                    
                    // Show success message
                    showToast('Produk berhasil ditambahkan ke keranjang!', 'success');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-primary');
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Gagal menambahkan produk ke keranjang', 'error');
                
                // Reset button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 3000);
    }
</script>
@endsection
