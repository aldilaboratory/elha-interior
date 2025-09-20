@extends('layout.main')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb justify-content-between">
    <div class="d-md-flex">
        <h1 class="mr-2">Transaksi</h1>
        {{-- <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Transaksi</li>
        </ul> --}}
    </div>
    {{-- <div>
        <button type="button" class="btn btn-danger" id="btn-delete-pending">
            <i class="fa fa-trash mr-1"></i> Hapus Transaksi Pending
        </button>
    </div> --}}
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Transaksi</th>
                <th scope="col">Pelanggan</th>
                <th scope="col">Gambar Produk</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Qty</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Total Transaksi</th>
                <th scope="col">Status</th>
                <th scope="col">Resi</th>
                <th scope="col">Estimasi</th>
                <th scope="col">Created At</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<div class="d-none">
    <form id="form-destroy" action="{{ route('transaksi.store') }}" method="post">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
@section('js')
<script>
    $('table').DataTable({
        fixedHeader: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        searchable: true,
        ajax: {
            url: baseUrl('/transaksi/fetch'),
            headers: {
                'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
            },
            dataSrc: "data",
            type: "POST"
        },
        order: [
            [1, 'asc']
        ],
        columns: [{
                data: 'DT_RowIndex',
                sClass: 'text-center',
                width: '50px',
                searchable: false,
                orderable: false,
            },
            {
                data: 'transaksi_id',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'nama_penerima',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'gambar_produk',
                searchable: false,
                orderable: false,
                visible: true,
            },
            {
                data: 'nama_produk',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'qty',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data, type, row) {
                    return data + ' pcs';
                }
            },
            {
                data: 'harga',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                    }
                    return data;
                }
            },
            {
                data: 'subtotal',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                    }
                    return data;
                }
            },
            {
                data: 'total',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return 'Rp ' + parseInt(data).toLocaleString('id-ID');
                    }
                    return data; // biarkan nilai asli untuk sorting
                }
            }, {
                data: 'status',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data, type, row) {
                    let options = `
                <option value="pending" ${data === 'pending' ? 'selected' : ''}>Pending</option>
                <option value="dikonfirmasi" ${data === 'dikonfirmasi' ? 'selected' : ''}>Dikonfirmasi</option>
                <option value="dikemas" ${data === 'dikemas' ? 'selected' : ''}>Dikemas</option>
                <option value="dikirim" ${data === 'dikirim' ? 'selected' : ''}>Dikirim</option>
                <option value="selesai" ${data === 'selesai' ? 'selected' : ''}>Selesai</option>
                <option value="ditolak" ${data === 'ditolak' ? 'selected' : ''}>Ditolak</option>
            `;
                    return `
                <select class="form-select form-select-sm status-select" data-id="${row.transaksi_id}">
                    ${options}
                </select>
            `;
                }
            }, {
                data: 'resi',
                searchable: false,
                orderable: true,
                visible: true,
                render: function(data) {
                    if (data) {
                        return `<span class="badge bg-info text-white">${data}</span>`;
                    } else {
                        return '<span class="text-muted">-</span>';
                    }
                }
            }, {
                data: 'estimasi',
                searchable: false,
                orderable: true,
                visible: true,
            }, {
                data: 'created_at',
                render: function(data) {
                    if (!data) return "";

                    const date = new Date(data);
                    return date.toLocaleString();
                }
            },
            {
                data: null,
                className: 'text-center',
                searchable: false,
                orderable: false,
                render: function(data, type, row) {
                    let url = printRoute.replace(':id', row.id);
                    return `
            <a href="${url}" target="_blank" class="btn btn-info btn-sm">
                <i class="fas fa-print"></i> Cetak Nota
            </a>
        `;
                }
            }
        ],

        createdRow: function(row, data) {
            $(".action-edit", row).click(function(e) {
                const url = baseUrl('/transaksi/' + data.id + '/edit');
                window.location.replace(url);
            });

            $(".action-hapus", row).click(function(e) {
                e.preventDefault();
                swal({
                    type: "warning",
                    title: "Warning",
                    text: "Anda yakin akan menghapus data ini ??",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                }).then(() => {
                    const url = $('#form-destroy').attr('action');
                    $('#form-destroy').attr('action', url + '/' + data.id)
                        .trigger('submit');
                }, (dismiss) => {});
            });
            // Detail
            $(".action-detail", row).click(function(e) {
                e.preventDefault();

                // Request data detail transaksi
                $.get(baseUrl('/transaksi/' + data.id + '/detail'), function(res) {
                    let html = '';
                    res.forEach(function(item) {
                        html += `
                    <tr>
                        <td>${item.nama_barang}</td>
                        <td>${item.jumlah}</td>
                        <td>${item.harga}</td>
                    </tr>
                `;
                    });

                    $("#modal-detail tbody").html(html);
                    $("#modal-detail").modal('show');
                });
            });
        },
    });


    // Handler untuk tombol hapus transaksi pending
    $('#btn-delete-pending').on('click', function() {
        swal({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus semua transaksi pending? Tindakan ini tidak dapat dibatalkan.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('transaksi.delete-pending') }}",
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            swal({
                                type: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then(() => {
                                // Refresh tabel setelah hapus
                                $('table').DataTable().ajax.reload();
                            });
                        } else {
                            swal({
                                type: 'info',
                                title: 'Info',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Terjadi kesalahan saat menghapus transaksi pending';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: errorMessage,
                        });
                    }
                });
            }
        });
    });

    // Event handler untuk select option status (di luar DataTable)
    $(document).on('change', '.status-select', function() {
        let transaksiId = $(this).data('id');
        let newStatus = $(this).val();
        
        $.ajax({
            url: baseUrl('/update-status'),
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: transaksiId,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    swal({
                        type: 'success',
                        title: 'Berhasil!',
                        text: 'Status pesanan berhasil diperbarui',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('table').DataTable().ajax.reload();
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'Gagal memperbarui status pesanan',
                    });
                }
            },
            error: function(xhr) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui status',
                });
            }
        });
    });
</script>
@if (session()->has('dataSaved') && session()->get('dataSaved') == true)
<script>
    swal({
        type: 'success',
        title: 'Success',
        text: '{{ session()->get('
        message ') }}',
    });
</script>
@endif
@if (session()->has('dataSaved') && session()->get('dataSaved') == false)
<script>
    swal({
        type: 'error',
        title: 'Error',
        text: '{{ session()->get('
        message ') }}',
    });
</script>
@endif
@endsection
