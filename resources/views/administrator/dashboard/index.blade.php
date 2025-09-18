@extends('layout.main')
@section('css')
    <style>
        .stats-card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Dashboard</h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li>Dashboard</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white mr-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Transaksi (Paid)</h6>
                            <h4 class="mb-0">{{ App\Models\Transaksi::where('status', 'paid')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white mr-3">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Produk</h6>
                            <h4 class="mb-0">{{ App\Models\Produk::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white mr-3">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Item di Keranjang</h6>
                            <h4 class="mb-0">{{ App\Models\Keranjang::count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white mr-3">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Pendapatan</h6>
                            <h4 class="mb-0">Rp {{ number_format(App\Models\Transaksi::where('status', 'paid')->sum('total'), 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Nama Penerima</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(App\Models\Transaksi::where('status', 'paid')->latest()->limit(5)->get() as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->order_id }}</td>
                                    <td>{{ $transaksi->nama_penerima }}</td>
                                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    <td>
                                    <span class="badge badge-{{ $transaksi->status == 'paid' ? 'success' : 'warning' }}">
                                        {{ $transaksi->status }}
                                    </span>
                                    </td>
                                    <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
