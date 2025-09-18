@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">User</h1>
    <ul>
        <li>
            <a href="#">Home</a>
        </li>
        <li>Tambah User</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ old('name') }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input class="form-control" type="text" name="username" id="username"
                            value="{{ old('username') }}">
                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="text" name="email" id="email"
                            value="{{ old('email') }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="text" name="password" id="password"
                            value="{{ old('password') }}">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="group_id" class="form-label">Group</label>
                        <select class="form-control" name="group_id" id="group_id">
                            <option value="">-- Pilih Group --</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('group_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="button-navigate mt-3">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
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