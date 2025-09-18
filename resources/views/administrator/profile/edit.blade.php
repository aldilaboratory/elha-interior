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
            <li>Edit Profile</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" name="name" id="name"
                                value="{{ old('name') ? old('name') : $profile->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input class="form-control" type="text" name="username" id="username"
                                value="{{ old('username') ? old('username') : $profile->username }}">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" name="email" id="email"
                                value="{{ old('email') ? old('email') : $profile->email }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="text" name="password" id="password"
                                value="{{ old('password') ? old('password') : $profile->password }}">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="group_id" class="form-label">Group Id</label>
                            <input class="form-control" type="number" name="group_id" id="group_id"
                                value="{{ old('group_id') ? old('group_id') : $profile->group_id }}">
                            @error('group_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="provinsi_id" class="form-label">Provinsi Id</label>
                            <input class="form-control" type="number" name="provinsi_id" id="provinsi_id"
                                value="{{ old('provinsi_id') ? old('provinsi_id') : $profile->provinsi_id }}">
                            @error('provinsi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="kab_kot_id" class="form-label">Kab Kot Id</label>
                            <input class="form-control" type="number" name="kab_kot_id" id="kab_kot_id"
                                value="{{ old('kab_kot_id') ? old('kab_kot_id') : $profile->kab_kot_id }}">
                            @error('kab_kot_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">Kecamatan Id</label>
                            <input class="form-control" type="number" name="kecamatan_id" id="kecamatan_id"
                                value="{{ old('kecamatan_id') ? old('kecamatan_id') : $profile->kecamatan_id }}">
                            @error('kecamatan_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="desa_id" class="form-label">Desa Id</label>
                            <input class="form-control" type="number" name="desa_id" id="desa_id"
                                value="{{ old('desa_id') ? old('desa_id') : $profile->desa_id }}">
                            @error('desa_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-auto">
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat') ? old('alamat') : $profile->alamat }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="button-navigate mt-3">
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">
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
