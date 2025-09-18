@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Keranjang</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Edit Keranjang</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('keranjang.update', $keranjang->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">

                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('keranjang.index') }}" class="btn btn-secondary">
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
