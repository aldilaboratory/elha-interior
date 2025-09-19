@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb justify-content-between">
    <div class="d-md-flex">
        <h1 class="mr-2">Banner Promosi</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Banner Promosi</li>
        </ul>
    </div>
    <div>
        <a href="{{ route('bannerpromosi.create') }}" class="btn btn-success">
            <i class="fa fa-plus mr-1"></i> Tambah
        </a>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Deskripsi</th>
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
    <form id="form-destroy" action="{{ route('bannerpromosi.store') }}" method="post">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        console.log('Initializing DataTable...');
        console.log('Fetch URL:', "{{ route('bannerpromosi.fetch') }}");
        
        $('table').DataTable({
            fixedHeader: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('bannerpromosi.fetch') }}",
                headers: {
                    'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
                },
                dataSrc: "data",
                type: "POST",
                error: function(xhr, error, thrown) {
                    console.error('DataTables AJAX Error:', error);
                    console.error('Response:', xhr.responseText);
                    console.error('Status:', xhr.status);
                }
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
                data: 'image',
                searchable: false,
                orderable: false,
                visible: true,
                render: function(data, type, row) {
                    if (data) {
                        return `<img src="{{ asset('/upload/bannerpromosi') }}/${data}" alt="${row.nama}" style="width:160px; height:auto;">`;
                    } else {
                        return '<span class="text-muted">Tidak ada gambar</span>';
                    }
                }
            }, {
                data: 'nama',
                searchable: true,
                orderable: true,
                visible: true,
            },
            {
                data: 'deskripsi',
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
                const url = baseUrl('/bannerpromosi/' + data.id + '/edit');
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
    });
    
    }); // End document.ready
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