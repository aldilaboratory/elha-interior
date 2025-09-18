@extends('layout.main')

@section('title', 'Laporan Stok Barang')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Laporan Stok Barang</h3>
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
                    <div class="text-tiny">Laporan Stok Barang</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Filter Laporan</h5>
                    <form class="form-search" id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset class="name">
                                    <select id="kategori_id" name="kategori_id" class="form-control">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="name">
                                    <select id="stok_filter" name="stok_filter" class="form-control">
                                        <option value="">Semua Stok</option>
                                        <option value="empty">Stok Habis</option>
                                        <option value="low">Stok Rendah (≤10)</option>
                                    </select>
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
                <table id="laporan-stok-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
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

<!-- Modal Edit Stok -->
<div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Edit Stok Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStockForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_produk_id" name="produk_id">
                    
                    <div class="mb-3">
                        <label for="edit_nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="edit_nama_produk" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_stok_lama" class="form-label">Stok Saat Ini</label>
                        <input type="number" class="form-control" id="edit_stok_lama" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_stok_baru" class="form-label">Stok Baru <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_stok_baru" name="stok" min="0" required>
                        <div class="form-text">Masukkan jumlah stok yang baru</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
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
    var table = $('#laporan-stok-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl('/laporan-stok/fetch'),
            data: function(d) {
                d.kategori_id = $('#kategori_id').val();
                d.stok_filter = $('#stok_filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'gambar', name: 'gambar', searchable: false, orderable: false },
            { data: 'nama', name: 'nama', searchable: true, orderable: true },
            { data: 'kategori', name: 'kategori', searchable: true, orderable: true },
            { data: 'harga', name: 'harga', searchable: false, orderable: true },
            { data: 'stok', name: 'stok', searchable: false, orderable: true },
            { data: 'status_stok', name: 'status_stok', searchable: false, orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { width: "5%", targets: 0 },
            { width: "10%", targets: 1 },
            { width: "25%", targets: 2 },
            { width: "15%", targets: 3 },
            { width: "15%", targets: 4 },
            { width: "8%", targets: 5 },
            { width: "12%", targets: 6 },
            { width: "10%", targets: 7 }
        ],
        initComplete: function() {
            $('.dataTables_filter input').attr('placeholder', 'Cari nama produk atau kategori...');
        }
    });

    // Filter functionality
    $('#filter-btn').on('click', function() {
        table.ajax.reload();
    });

    $('#reset-btn').on('click', function() {
        $('#kategori_id').val('');
        $('#stok_filter').val('');
        table.ajax.reload();
    });

    // Handle form submission
    $('#editStockForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        produk_id: $('#edit_produk_id').val(),
        stok: $('#edit_stok_baru').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    $.ajax({
        url: '{{ route("laporan-stok.update-stock") }}',
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $('#editStockForm button[type="submit"]').prop('disabled', true).text('Menyimpan...');
        },
        success: function(response) {
            if (response.success) {
                $('#editStockModal').modal('hide');
                table.ajax.reload();
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        },
        error: function(xhr) {
            let errorMessage = 'Terjadi kesalahan saat memperbarui stok';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join('\n');
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: errorMessage
            });
        },
        complete: function() {
            $('#editStockForm button[type="submit"]').prop('disabled', false).text('Simpan Perubahan');
        }
    });
    });
});

// Function to open edit stock modal
function editStock(produkId, namaProduk, stokSaatIni) {
    $('#edit_produk_id').val(produkId);
    $('#edit_nama_produk').val(namaProduk);
    $('#edit_stok_lama').val(stokSaatIni);
    $('#edit_stok_baru').val(stokSaatIni);
    $('#editStockModal').modal('show');
}
</script>
@endsection