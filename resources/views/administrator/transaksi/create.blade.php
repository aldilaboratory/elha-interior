@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Transaksi</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Tambah Transaksi</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="user_id" class="form-label">User Id</label>
                            <input class="form-control" type="number" name="user_id" id="user_id"
                                value="{{ old('user_id') }}">
                            @error('user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input class="form-control" type="number" name="total_harga" id="total_harga"
                                value="{{ old('total_harga') }}">
                            @error('total_harga')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="metode_id" class="form-label">Metode Id</label>
                            <input class="form-control" type="number" name="metode_id" id="metode_id"
                                value="{{ old('metode_id') }}">
                            @error('metode_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="ekspedisi_id" class="form-label">Ekspedisi Id</label>
                            <input class="form-control" type="number" name="ekspedisi_id" id="ekspedisi_id"
                                value="{{ old('ekspedisi_id') }}">
                            @error('ekspedisi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
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
