@extends('layout.main')
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Profile</h1>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>Profile</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h5 class="fw-normal mb-0">Data Profile</h5>
                </div>
                <div class="col-auto">
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                        <i class="fa fa-edit mr-2"></i> Edit
                    </a>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="name" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Name
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="name"
                                value="{{ $profile->name }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="username" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Username
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="username"
                                value="{{ $profile->username }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="email" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Email
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="email"
                                value="{{ $profile->email }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="password" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Password
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="password"
                                value="{{ $profile->password }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="group_id" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Group Id
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="group_id"
                                value="{{ $profile->group_id }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="provinsi_id" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Provinsi Id
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="provinsi_id"
                                value="{{ $profile->provinsi_id }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="kab_kot_id" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Kab Kot Id
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="kab_kot_id"
                                value="{{ $profile->kab_kot_id }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="kecamatan_id" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Kecamatan Id
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="kecamatan_id"
                                value="{{ $profile->kecamatan_id }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="desa_id" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Desa Id
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="desa_id"
                                value="{{ $profile->desa_id }}">
                        </div>
                    </div>
                </div>
                <div class="col-xl-auto">
                    <div class="row mx-0">
                        <label for="alamat" class="col-auto col-form-label">
                            <i class="fa fa-arrow-right mr-1"></i> Alamat
                        </label>
                        <div class="col">
                            <input type="text" readonly class="form-control-plaintext" id="alamat"
                                value="{{ $profile->alamat }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @if (session()->has('dataSaved') && session()->get('dataSaved') == true)
        <script>
            swal({
                type: 'success',
                title: 'Success',
                text: '{{ session()->get('message') }}',
            });
        </script>
    @endif
    @if (session()->has('dataSaved') && session()->get('dataSaved') == false)
        <script>
            swal({
                type: 'error',
                title: 'Error',
                text: '{{ session()->get('message') }}',
            });
        </script>
    @endif
@endsection
