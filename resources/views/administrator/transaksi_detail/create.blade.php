@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Transaksi Detail</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Tambah Transaksi Detail</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('transaksi_detail.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="transaksi_id" class="form-label">Transaksi Id</label>
                            <input class="form-control" type="number" name="transaksi_id" id="transaksi_id"
                                value="{{ old('transaksi_id') }}">
                            @error('transaksi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="produk_id" class="form-label">Produk Id</label>
                            <input class="form-control" type="number" name="produk_id" id="produk_id"
                                value="{{ old('produk_id') }}">
                            @error('produk_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="harga" class="form-label">Harga</label>
                            <input class="form-control" type="number" name="harga" id="harga"
                                value="{{ old('harga') }}">
                            @error('harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('transaksi_detail.index') }}" class="btn btn-secondary">
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
