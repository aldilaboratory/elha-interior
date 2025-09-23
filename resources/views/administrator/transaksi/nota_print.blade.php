<!DOCTYPE html>
<html>
<head>
    <title>Nota Pesanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
        }
        .text-center {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="{{ asset('assets_landing/images/logo/logo-dark.png') }}" alt="Logo" style="width: 150px; margin-top: 25px">
    <h2 class="text-center">Nota Pesanan</h2>
    <hr>
    <div>
        <strong>Kode Transaksi:</strong> {{ $order->order_id }}<br>
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}<br>
        <strong>Customer:</strong> {{ $order->customer_name }}<br>
        <strong>Penerima:</strong> {{ $order->nama_penerima }}<br>
        <strong>Alamat:</strong> {{ $order->alamat }}<br>
        <strong>No. HP:</strong> {{ $order->no_hp }}<br>
    </div>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th class="text-right">Harga Satuan</th>
            <th class="text-right">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orderItems as $item)
            <tr>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ $item->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        <div class="text-right">
            <strong>Ongkos Kirim:</strong> Rp {{ number_format($order->ongkir, 0, ',', '.') }}
        </div>
        <div class="text-right">
            <strong>Total Pembayaran:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}
        </div>
        <div class="text-right">
            <strong>Status:</strong> {{ ucfirst($order->status) }}
        </div>
        @if($order->resi)
        <div class="text-right">
            <strong>No. Resi:</strong> {{ $order->resi }}
        </div>
        @endif
    </div>
</div>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>