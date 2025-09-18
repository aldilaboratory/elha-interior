@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Produk Baru Promosi</h1>
    <ul>
        <li>
            <a href="#">Home</a>
        </li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('infopromosi.update', $infoPromosi->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Form Fields -->
            <div class="row g-4">
                <!-- Nama Produk -->
                <div class="col-lg-12">
                    <label for="nama" class="form-label fw-semibold">
                        <i class="fas fa-tag me-2 text-primary"></i>Nama
                    </label>
                    <input class="form-control form-control-lg"
                        type="text"
                        name="nama"
                        id="nama"
                        placeholder="Masukkan nama "
                        value="{{ old('nama', $infoPromosi->nama) }}">
                    @error('nama')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold">
                        <i class="fas fa-align-left me-2 text-secondary"></i>Deskripsi
                    </label>
                    <textarea class="form-control"
                        name="deskripsi"
                        id="deskripsi"
                        rows="4"
                        placeholder="Masukkan deskripsi...">{{ old('deskripsi', $infoPromosi->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Image upload functionality
    document.getElementById('preview-image').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File yang dipilih harus berupa gambar!');
                return;
            }

            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file tidak boleh lebih dari 5MB!');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('preview-image');
                previewImage.src = e.target.result;

                // Add animation effect
                previewImage.style.opacity = '0';
                setTimeout(() => {
                    previewImage.style.opacity = '1';
                }, 100);
            }
            reader.readAsDataURL(file);
        }
    });


    // Auto-format price input
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value) {
            // Add thousand separators (optional)
            value = parseInt(value).toLocaleString('id-ID');
            // Remove formatting for form submission
            e.target.dataset.rawValue = e.target.value.replace(/\D/g, '');
        }
    });
</script>
@endsection