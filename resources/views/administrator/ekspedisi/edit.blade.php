@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Ekspedisi</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Edit Ekspedisi</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('ekspedisi.update', $ekspedisi->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="kode" class="form-label">Kode</label>
                            <input class="form-control" type="text" name="kode" id="kode"
                                value="{{ old('kode') ? old('kode') : $ekspedisi->kode }}">
                            @error('kode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input class="form-control" type="text" name="nama" id="nama"
                                value="{{ old('nama') ? old('nama') : $ekspedisi->nama }}">
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="text" name="image" id="image"
                                value="{{ old('image') ? old('image') : $ekspedisi->image }}">
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('ekspedisi.index') }}" class="btn btn-secondary">
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
