@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Kab Kota</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Tambah Kab Kota</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kab_kota.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="provinsi_id" class="form-label">Provinsi Id</label>
                            <input class="form-control" type="number" name="provinsi_id" id="provinsi_id"
                                value="{{ old('provinsi_id') }}">
                            @error('provinsi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control" type="text" name="nama" id="nama"
                                value="{{ old('nama') }}">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('kab_kota.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script></script>
@endsection
