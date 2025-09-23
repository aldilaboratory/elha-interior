@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb justify-content-between">
    <div class="d-md-flex">
        <h1 class="mr-2">Admin</h1>
        {{-- <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Admin</li>
        </ul> --}}
    </div>
    <div>
        <a href="{{ route('admin.create') }}" class="btn btn-primary">
            <i class="fa fa-plus mr-1"></i> Tambah Admin
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
                    <th scope="col">Name</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Group</th>
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
    <form id="form-destroy" action="{{ route('admin.destroy', 0) }}" method="post">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl('/admin/fetch'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            order: [[1, 'asc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                {
                    data: 'group_name',
                    name: 'group_name',
                    searchable: true,
                    orderable: true,
                    visible: true
                },
                { data: 'alamat', name: 'alamat' },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        if (data) {
                            var date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        }
                        return '';
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-warning edit-btn" data-id="${data}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">
                                <i class="fa fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ]
        });

        // Event handler untuk tombol Edit
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            window.location.href = baseUrl('/admin/' + id + '/edit');
        });

        // Event handler untuk tombol Delete
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus admin ini?')) {
                var form = $('#form-destroy');
                form.attr('action', baseUrl('/admin/' + id));
                form.submit();
            }
        });
    });
</script>
@endsection