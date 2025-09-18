@extends('layout.main')
@section('css')
<style>

</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Produk</h1>
    <ul>
        <li>
            <a href="#">Home</a>
        </li>
        <li>Edit Produk</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('produk.update', $produk->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Upload Gambar -->
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar Produk</label>
                    <div class="text-center">
                        <div class="image-upload-container position-relative d-inline-block">
                            <img id="preview-image"
                                src="{{ $produk->image ? asset('upload/produk/' . $produk->image) : asset('assets/images/placeholder.jpg') }}"
                                alt="Preview Gambar"
                                class="img-thumbnail border-2 border-dashed border-primary"
                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer; transition: all 0.3s ease;">
                            <div class="image-overlay position-absolute top-50 start-50 translate-middle">
                                <i class="fas fa-camera text-primary" style="font-size: 2rem; opacity: 0.7;"></i>
                            </div>
                            <input type="file" name="image" id="image" class="d-none" accept="image/*">
                        </div>
                        <p class="text-muted mt-2 mb-0">
                            <small><i class="fas fa-info-circle me-1"></i>Klik gambar untuk upload foto produk baru</small>
                        </p>
                    </div>
                    @error('image')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Form Fields -->
            <div class="row g-4">
                <!-- Nama Produk -->
                <div class="col-lg-6">
                    <label for="nama" class="form-label fw-semibold">
                        <i class="fas fa-tag me-2 text-primary"></i>Nama Produk
                    </label>
                    <input class="form-control form-control-lg"
                        type="text"
                        name="nama"
                        id="nama"
                        placeholder="Masukkan nama produk"
                        value="{{ old('nama', $produk->nama) }}">
                    @error('nama')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="col-lg-6">
                    <label for="harga" class="form-label fw-semibold">
                        <i class="fas fa-dollar-sign me-2 text-success"></i>Harga
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text">Rp</span>
                        <input class="form-control"
                            type="number"
                            name="harga"
                            id="harga"
                            placeholder="0"
                            min="0"
                            value="{{ old('harga', $produk->harga) }}">
                    </div>
                    @error('harga')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="col-6 mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select form-select-lg select2" name="kategori_id" id="kategori_id" style="width: 100%;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($dataKategori as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-lg-6">
                    <label for="berat" class="form-label fw-semibold">
                        Berat
                    </label>
                    <div class="input-group input-group-lg">

                        <input class="form-control"
                            type="number"
                            name="berat"
                            id="berat"
                            placeholder="0"
                            min="0"
                            value="{{ old('berat',$produk->berat) }}">
                        <span class="input-group-text">g</span>
                    </div>
                    @error('berat')
                    <div class="text-danger mt-1">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}</small>
                    </div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold">
                        <i class="fas fa-align-left me-2 text-secondary"></i>Deskripsi Produk
                    </label>
                    <textarea class="form-control"
                        name="deskripsi"
                        id="deskripsi"
                        rows="4"
                        placeholder="Masukkan deskripsi produk...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
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
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-lg px-4 mr-2">
                            Kembali
                        </a>
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


    // Prevent negative input for harga and berat
    function preventNegativeInput(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        // Prevent typing minus sign, plus, and e/E
        input.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter
            if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            
            // Prevent: minus, plus, e, E
            if (e.key === '-' || e.key === '+' || e.key === 'e' || e.key === 'E') {
                e.preventDefault();
                return false;
            }
        });
        
        // Prevent paste of negative values
        input.addEventListener('paste', function(e) {
            setTimeout(function() {
                let value = parseFloat(input.value);
                if (isNaN(value) || value < 0) {
                    input.value = 0;
                }
            }, 10);
        });
        
        // Check value on input and set to 0 if negative
        input.addEventListener('input', function(e) {
            let value = parseFloat(e.target.value);
            if (isNaN(value) || value < 0) {
                e.target.value = 0;
            }
        });
        
        // Check value on blur (when user leaves the field)
        input.addEventListener('blur', function(e) {
            let value = parseFloat(e.target.value);
            if (isNaN(value) || value < 0) {
                e.target.value = 0;
            }
        });
    }
    
    // Apply to harga and berat fields when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        preventNegativeInput('harga');
        preventNegativeInput('berat');
    });
</script>
@endsection