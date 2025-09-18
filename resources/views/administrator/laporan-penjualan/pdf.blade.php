<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - {{ $transaksi->order_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 5px 10px 5px 0;
            font-weight: bold;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
            vertical-align: top;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-processing {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .products-table th,
        .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .products-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        
        .products-table td.text-center {
            text-align: center;
        }
        
        .products-table td.text-right {
            text-align: right;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 3px;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            margin: 5px 0;
            font-size: 13px;
        }
        
        .total-final {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .two-column {
            display: table;
            width: 100%;
        }
        
        .column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .column:last-child {
            padding-right: 0;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAWAN PETSHOP</h1>
        <h2>Detail Transaksi</h2>
    </div>

    <div class="two-column">
        <div class="column">
            <div class="info-section">
                <div class="info-title">Informasi Transaksi</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Kode Transaksi:</div>
                        <div class="info-value">{{ $transaksi->order_id }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tanggal:</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Customer:</div>
                        <div class="info-value">{{ $transaksi->user->name ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status:</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $transaksi->status }}">
                                {{ ucfirst($transaksi->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="info-section">
                <div class="info-title">Informasi Pengiriman</div>
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Nama Penerima:</div>
                        <div class="info-value">{{ $transaksi->nama_penerima }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">No. HP:</div>
                        <div class="info-value">{{ $transaksi->no_hp }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Alamat:</div>
                        <div class="info-value">{{ $transaksi->alamat }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kurir:</div>
                        <div class="info-value">{{ $transaksi->kurir }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Metode Pembayaran:</div>
                        <div class="info-value">{{ $transaksi->metode_pembayaran }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-title">Detail Produk</div>
        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th style="width: 100px;">Harga</th>
                    <th style="width: 60px;">Jumlah</th>
                    <th style="width: 100px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->transaksiDetail as $detail)
                <tr>
                    <td class="text-center">
                        @if($detail->gambar_produk)
                            <img src="{{ public_path('upload/produk/' . $detail->gambar_produk) }}" 
                                 alt="{{ $detail->nama_produk }}" 
                                 class="product-image">
                        @else
                            <div style="width: 50px; height: 50px; background-color: #f8f9fa; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #666;">
                                No Image
                            </div>
                        @endif
                    </td>
                    <td>{{ $detail->nama_produk }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <strong>Subtotal: Rp {{ number_format($transaksi->transaksiDetail->sum(function($detail) { return $detail->harga * $detail->jumlah; }), 0, ',', '.') }}</strong>
            </div>
            <div class="total-row">
                <strong>Ongkir: Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }}</strong>
            </div>
            <div class="total-final">
                <strong>Total: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        <p>Dawan Petshop - Sistem Manajemen Transaksi</p>
    </div>
</body>
</html>