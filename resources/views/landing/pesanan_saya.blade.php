@extends('layout.landing')

@section('css')

@endsection

@section('content')
    <div class="container my-5">
        <h3>Pesanan Saya</h3>

        @if($orders->isEmpty())
            <div class="alert alert-info mt-4">Belum ada pesanan.</div>
        @else
            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th width="35%">Produk</th>
                        <th width="12%">Ongkir</th>
                        <th width="12%">Total Pembayaran</th>
                        <th width="12%">Status Pesanan</th>
                        <th width="12%">Resi</th>
                        <th width="17%">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <div class="mb-2">
                                    <strong>Kode Transaksi:</strong> {{ $order->order_id }}
                                </div>
                                @foreach($order->orderItems as $item)
                                    <div class="d-flex align-items-center mb-2 @if(!$loop->last) border-bottom pb-2 @endif">
                                        <img src="{{ asset('upload/produk/'.$item->image) }}"
                                             alt="{{ $item->nama_produk }}"
                                             class="rounded me-3"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $item->nama_produk }}</h6>
                                            <small class="text-muted">
                                                {{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </small>
                                            <div class="text-muted small">
                                                Subtotal: Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td class="align-middle">
                                <strong>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</strong>
                            </td>
                            <td class="align-middle">
                                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                            </td>
                            <td class="align-middle">
                                <span class="badge fs-6
                                    @if($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'dikirim') bg-info
                                    @elseif($order->status == 'selesai') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="align-middle">
                                @if($order->resi)
                                    <span class="badge bg-info">{{ $order->resi }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle text-end">
                                @if($order->status != 'selesai')
                                    <form action="{{ route('pesanan.terima', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin sudah menerima pesanan ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="transaksi_id" value="{{ $order->id }}">
                                        <button type="submit" class="btn w-100 mb-1 btn-success me-2">
                                            <i class="fas fa-check me-1"></i>Terima Pesanan
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success fw-bold">
                                        <i class="fas fa-check-circle me-1"></i>Pesanan Diterima
                                    </span>
                                @endif
                                <a href="{{ route('pesanan.print', $order->id) }}" target="_blank" class="btn text-light d-inline-block w-100 mt-1 btn-info mt-2 mt-md-0">
                                    <i class="fas fa-print me-1"></i>Cetak Nota
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('js')

@endsection
