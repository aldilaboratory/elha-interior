@extends('layout.main')

@section('title', 'Laporan Penjualan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="main-content-inner" style="padding-top: 0;">
    <div class="main-content-wrap" style="padding-top: 0;">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27" style="margin-top: -20px;">
            <h3>Laporan Penjualan</h3>
            <div class="flex gap10">
                <button type="button" id="print-pdf-btn" class="btn btn-success">
                    <i class="icon-printer"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Filter Laporan</h5>
                    <form class="form-search" id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset class="name">
                                    <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Tanggal Mulai">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="name">
                                    <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Tanggal Akhir">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <button type="button" id="filter-btn" class="btn btn-primary">Filter</button>
                                <button type="button" id="reset-btn" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                <table id="laporan-penjualan-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .dataTables_filter {
        margin-bottom: 20px;
    }
    
    .dataTables_filter label {
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }
    
    .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px 12px;
        width: 300px;
        transition: border-color 0.3s ease;
    }
    
    .dataTables_filter input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }
    
    @media (max-width: 768px) {
        .dataTables_filter input {
            width: 100%;
        }
    }
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#laporan-penjualan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl('/laporan-penjualan/fetch'),
            type: 'POST',
            data: function(d) {
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'kode', name: 'kode', searchable: true, orderable: true },
            { data: 'tanggal', name: 'tanggal', searchable: false, orderable: true },
            { data: 'customer', name: 'customer', searchable: true, orderable: true },
            { data: 'status', name: 'status', searchable: true, orderable: false },
            { data: 'total', name: 'total', searchable: false, orderable: true },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "15%", targets: 1 },
            { width: "15%", targets: 2 },
            { width: "20%", targets: 3 },
            { width: "10%", targets: 4 },
            { width: "15%", targets: 5 },
            { width: "20%", targets: 6 }
        ],
        initComplete: function() {
            $('.dataTables_filter input').attr('placeholder', 'Cari kode transaksi, customer, atau status...');
        }
    });

    // Filter functionality
    $('#filter-btn').on('click', function() {
        table.ajax.reload();
    });

    $('#reset-btn').on('click', function() {
        $('#start_date').val('');
        $('#end_date').val('');
        table.ajax.reload();
    });

    // Print PDF functionality
    $('#print-pdf-btn').on('click', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        // Build URL with current filter parameters
        var url = baseUrl('/laporan-penjualan/generate-pdf');
        var params = [];
        
        if (startDate) {
            params.push('start_date=' + encodeURIComponent(startDate));
        }
        if (endDate) {
            params.push('end_date=' + encodeURIComponent(endDate));
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        // Open PDF in new window
        window.open(url, '_blank');
    });
});
</script>
@endsection