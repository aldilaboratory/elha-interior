@extends('layout.main')

@section('title', 'Detail Transaksi')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Detail Transaksi</h3>
            <div class="flex gap10">
                <a href="{{ route('laporan-penjualan.pdf', $transaksi->id) }}" class="btn btn-primary">
                    <i class="icon-download"></i> Download PDF
                </a>
                <a href="{{ route('laporan-penjualan.index') }}" class="btn btn-secondary">
                    <i class="icon-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="wg-box">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Transaksi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Order ID:</strong></td>
                            <td>{{ $transaksi->order_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Customer:</strong></td>
                            <td>{{ $transaksi->user ? $transaksi->user->name : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email Customer:</strong></td>
                            <td>{{ $transaksi->user ? $transaksi->user->email : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge badge-{{ $transaksi->status == 'completed' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'info') }}">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Pengiriman</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama Penerima:</strong></td>
                            <td>{{ $transaksi->nama_penerima ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No HP:</strong></td>
                            <td>{{ $transaksi->no_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat:</strong></td>
                            <td>{{ $transaksi->alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Provinsi:</strong></td>
                            <td>{{ $transaksi->nama_provinsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kota:</strong></td>
                            <td>{{ $transaksi->nama_kota ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kurir:</strong></td>
                            <td>{{ $transaksi->kurir ?? '-' }} - {{ $transaksi->paket ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Metode Pembayaran:</strong></td>
                            <td>{{ $transaksi->payment_method ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ongkir:</strong></td>
                            <td>Rp {{ number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="wg-box">
            <h5>Detail Produk</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->transaksiDetail as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($detail->gambar_produk)
                                        <img src="{{ asset('upload/produk/' . $detail->gambar_produk) }}" 
                                             alt="{{ $detail->nama_produk }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    @endif
                                    <div>
                                        <strong>{{ $detail->nama_produk }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Subtotal Produk:</th>
                            <th>Rp {{ number_format($transaksi->transaksiDetail->sum('subtotal'), 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Ongkir:</th>
                            <th>Rp {{ number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">Total:</th>
                            <th>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
@endsection