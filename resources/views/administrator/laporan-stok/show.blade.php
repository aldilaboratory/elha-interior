@extends('layout.main')

@section('title', 'Detail Produk')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Detail Produk</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('laporan-stok.index') }}">
                        <div class="text-tiny">Laporan Stok Barang</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Detail Produk</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        @if($produk->image)
                            <img src="{{ asset('upload/produk/' . $produk->image) }}" 
                                 alt="{{ $produk->nama }}" 
                                 class="img-fluid rounded" 
                                 style="max-width: 100%; height: auto; max-height: 400px;">
                        @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" 
                                 alt="No Image" 
                                 class="img-fluid rounded" 
                                 style="max-width: 100%; height: auto; max-height: 400px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <h4>{{ $produk->nama }}</h4>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Kategori:</strong></td>
                            <td>{{ $produk->kategori ? $produk->kategori->nama : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga:</strong></td>
                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Stok:</strong></td>
                            <td>
                                <span class="badge badge-lg 
                                    @if($produk->stok <= 0) badge-danger
                                    @elseif($produk->stok <= 10) badge-warning
                                    @else badge-success
                                    @endif">
                                    {{ $produk->stok }} unit
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status Stok:</strong></td>
                            <td>
                                @if($produk->stok <= 0)
                                    <span class="badge badge-danger">Habis</span>
                                @elseif($produk->stok <= 10)
                                    <span class="badge badge-warning">Stok Rendah</span>
                                @else
                                    <span class="badge badge-success">Tersedia</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Berat:</strong></td>
                            <td>{{ $produk->berat ?? '-' }} gram</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($produk->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diupdate:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($produk->updated_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @if($produk->deskripsi)
        <div class="wg-box">
            <h5>Deskripsi Produk</h5>
            <div class="mt-3">
                {!! nl2br(e($produk->deskripsi)) !!}
            </div>
        </div>
        @endif

        @if($produk->stok <= 10)
        <div class="wg-box">
            <div class="alert alert-{{ $produk->stok <= 0 ? 'danger' : 'warning' }}">
                <h6>
                    <i class="icon-alert-triangle"></i>
                    @if($produk->stok <= 0)
                        Peringatan: Stok Habis!
                    @else
                        Peringatan: Stok Rendah!
                    @endif
                </h6>
                <p class="mb-0">
                    @if($produk->stok <= 0)
                        Produk ini sudah habis dan perlu segera direstok.
                    @else
                        Stok produk ini tinggal {{ $produk->stok }} unit. Pertimbangkan untuk menambah stok.
                    @endif
                </p>
            </div>
        </div>
        @endif

        <div class="wg-box">
            <a href="{{ route('laporan-stok.index') }}" class="btn btn-secondary">
                <i class="icon-arrow-left"></i> Kembali ke Laporan
            </a>
            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-primary">
                <i class="icon-edit"></i> Edit Produk
            </a>
        </div>
    </div>
</div>
@endsection