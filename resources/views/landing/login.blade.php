<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DawanPetshop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="vh-100 d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center">
                <a href="{{ route('shop') }}"><img src="{{ asset('assets_landing/images/logo/logo-dark.png') }}" alt="logo" class="w-25 mb-3"></a>
            </div>
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center">Login</h4>
                    <form action="{{ route('landing.authenticate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required placeholder="Masukkan password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: orange; color: white;">Login</button>
                    </form>
                    <p class="mt-3 text-center">
                        Belum punya akun? <a href="{{ route('landing.registrasi') }}">Daftar</a>
                    </p>
                </div>
            </div>
            @error('auth_failed')
            <div class="alert alert-danger mt-3" role="alert">
                Email atau password anda salah
                <button class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@if(session('sweetalert'))
<script>
    Swal.fire({
        title: '{{ session('sweetalert.title') }}',
        text: '{{ session('sweetalert.text') }}',
        icon: '{{ session('sweetalert.icon') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff6600',
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: true,
        allowOutsideClick: false
    });
</script>
@endif

</body>
</html>
