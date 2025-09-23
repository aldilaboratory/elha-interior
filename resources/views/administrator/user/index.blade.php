@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb justify-content-between">
    <div class="d-md-flex">
        <h1 class="mr-2">User</h1>
        {{-- <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>User</li>
        </ul> --}}
    </div>
    {{-- <div>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i> Tambah
        </a>
    </div> --}}
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Alamat</th>
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
    <form id="form-destroy" action="{{ route('user.store') }}" method="post">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
@section('js')
<style>
    /* Custom styling for DataTable search bar */
    .dataTables_filter {
        margin-bottom: 20px;
    }
    
    .dataTables_filter label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0;
    }
    
    .dataTables_filter input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        width: 250px !important;
        margin-left: 10px !important;
    }
    
    .dataTables_filter input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }
    
    .dataTables_filter input::placeholder {
        color: #6c757d;
        font-style: italic;
    }
    
    /* Responsive search bar */
    @media (max-width: 768px) {
        .dataTables_filter input {
            width: 200px !important;
        }
    }
    
    @media (max-width: 576px) {
        .dataTables_filter {
            text-align: center;
        }
        .dataTables_filter input {
            width: 100% !important;
            margin-left: 0 !important;
            margin-top: 10px;
        }
    }
</style>

<script>
    $('table').DataTable({
        fixedHeader: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: baseUrl('/user/fetch'),
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
                data: 'name',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'phone',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'email',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'alamat',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'created_at',
                render: function(data) {
                    if (!data) return "";

                    const date = new Date(data);
                    return date.toLocaleString();
                }
            },
            {
                data: 'id',
                name: 'id',
                render: function(data, i, row) {
                    var div = document.createElement("div");
                    div.className = "row-action";

                    // Edit
                    var btn = document.createElement("button");
                    btn.className = "btn btn-warning btn-action mx-1 action-edit";
                    btn.innerHTML = '<i class="icon fa fa-edit"></i>';
                    div.append(btn);

                    // Delete
                    var btn = document.createElement("button");
                    btn.className = "btn btn-danger btn-action mx-1 action-hapus";
                    btn.innerHTML = '<i class="icon fa fa-trash-alt"></i>';
                    div.append(btn);

                    return div.outerHTML;
                },
                width: "150px",
                orderable: false,
            },
        ],
        createdRow: function(row, data) {
            $(".action-edit", row).click(function(e) {
                const url = baseUrl('/user/' + data.id + '/edit');
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
        },
        initComplete: function() {
            // Add placeholder text to search input
            $('.dataTables_filter input').attr('placeholder', 'Cari nama, username, email, group, atau alamat...');
        }
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