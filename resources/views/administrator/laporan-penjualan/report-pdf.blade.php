<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Dawan Petshop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }
        
        .period-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
            color: #555;
        }
        
        .summary-section {
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            width: 25%;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: white;
        }
        
        .summary-label {
            font-weight: bold;
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
        
        .status-summary {
            margin-top: 15px;
        }
        
        .status-item {
            display: inline-block;
            margin-right: 20px;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        
        .transactions-table th,
        .transactions-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        
        .transactions-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }
        
        .transactions-table td.text-center {
            text-align: center;
        }
        
        .transactions-table td.text-right {
            text-align: right;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAWAN PETSHOP</h1>
        <h2>Laporan Penjualan</h2>
    </div>

    <div class="period-info">
        <strong>Periode: 
            @if($startDate && $endDate)
                {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
            @else
                Semua Data
            @endif
        </strong>
        @if($status && $status !== 'all')
            <br><strong>Status: {{ ucfirst($status) }}</strong>
        @endif
    </div>

    <div class="summary-section">
        <div class="summary-title">Ringkasan Laporan</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Total Transaksi</div>
                    <div class="summary-value">{{ number_format($totalTransaksi) }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Total Pendapatan (Paid)</div>
                    <div class="summary-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Total Ongkir (Paid)</div>
                    <div class="summary-value">Rp {{ number_format($totalOngkir, 0, ',', '.') }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Rata-rata Transaksi (Paid)</div>
                    <div class="summary-value">
                        Rp {{ $totalPaidTransaksi > 0 ? number_format($totalPendapatan / $totalPaidTransaksi, 0, ',', '.') : '0' }}
                    </div>
                </div>
            </div>
        </div>
        
        @if($statusSummary->count() > 0)
        <div class="status-summary">
            <strong>Ringkasan Status:</strong><br>
            @foreach($statusSummary as $status => $data)
                <span class="status-item status-{{ $status }}">
                    {{ ucfirst($status) }}: {{ $data['count'] }} transaksi (Rp {{ number_format($data['total'], 0, ',', '.') }})
                </span>
            @endforeach
        </div>
        @endif
    </div>

    <div class="transactions-section">
        <div class="summary-title">Detail Transaksi</div>
        <table class="transactions-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Order ID</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 20%;">Customer</th>
                    <th style="width: 20%;">Alamat</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 10%;">Ongkir</th>
                    <th style="width: 10%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->order_id }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ Str::limit($item->alamat, 30) }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="text-right">Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: bold;">
                    <td colspan="6" class="text-right"><strong>TOTAL (Hanya Transaksi Paid):</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalOngkir, 0, ',', '.') }}</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <p>Laporan digenerate pada {{ $generatedAt->format('d/m/Y H:i:s') }}</p>
        <p>Dawan Petshop - Sistem Manajemen Penjualan</p>
        <p>Total {{ $totalTransaksi }} transaksi dalam periode ini</p>
    </div>
</body>
</html>