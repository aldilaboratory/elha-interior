@extends("layout.landing")

@section("content")
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Profile Pengguna</h4>
                        <div>
                            <button type="button" class="btn btn-warning me-2" id="editProfileBtn">
                                <i class="lni lni-pencil"></i> Edit Profile
                            </button>
                            <div class="btn btn-secondary" style="display: inline-block; pointer-events: none; opacity: 0.7; cursor: default;">
                                <i class="lni lni-map-marker"></i> Kelola Alamat
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-avatar mb-3">
                                    <i class="lni lni-user" style="font-size: 80px; color: #0167F3;"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <!-- View Mode -->
                                <div class="profile-info" id="viewMode">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap:</label>
                                        <p class="form-control-plaintext">{{ $user->name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Username:</label>
                                        <p class="form-control-plaintext">{{ $user->username }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email:</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                    @if($user->alamat)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alamat:</label>
                                        <p class="form-control-plaintext">{{ $user->alamat }}</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Edit Mode -->
                                <div class="profile-edit d-none" id="editMode">
                                    <form action="{{ route('landing.profile.update') }}" method="POST" id="profileForm">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Nama Lengkap:</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="username" class="form-label fw-bold">Username:</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                   id="username" name="username" value="{{ old('username', $user->username) }}" required>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label fw-bold">Email:</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label fw-bold">Alamat:</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                      id="alamat" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success me-2">
                                                <i class="lni lni-checkmark"></i> Simpan Perubahan
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="cancelEditBtn">
                                                <i class="lni lni-close"></i> Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        @if($profiles->count() > 0)
                        <hr>
                        <h5 class="mb-3">Alamat Pengiriman Tersimpan</h5>
                        <div class="row">
                            @foreach($profiles as $profile)
                            <div class="col-md-6 mb-3">
                                <div class="card border-secondary">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $profile->name_penerima }}</h6>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                <i class="lni lni-map-marker"></i> {{ $profile->alamat }}<br>
                                                <i class="lni lni-phone"></i> {{ $profile->no_telp }}<br>
                                                {{ $profile->kota_nama }}, {{ $profile->provinsi_nama }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <hr>
                        <div class="alert alert-info">
                            <i class="lni lni-information"></i> 
                            Belum ada alamat pengiriman tersimpan. 
                            <a href="{{ route('landing.profile-pengguna') }}" class="alert-link">Tambah alamat sekarang</a>
                        </div>
                        @endif
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('landing.index') }}" class="btn btn-primary">
                                <i class="lni lni-home"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .profile-avatar {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 50%;
        display: inline-block;
    }
    
    .profile-info .form-control-plaintext {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 4px;
        margin-bottom: 0;
    }
    
    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border: none;
    }
    
    .card-header {
        background: linear-gradient(135deg, #0167F3 0%, #081828 100%);
        color: white;
    }
    

</style>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editProfileBtn');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    
    // Toggle to edit mode
    editBtn.addEventListener('click', function() {
        viewMode.classList.add('d-none');
        editMode.classList.remove('d-none');
        editBtn.style.display = 'none';
    });
    
    // Toggle back to view mode
    cancelBtn.addEventListener('click', function() {
        editMode.classList.add('d-none');
        viewMode.classList.remove('d-none');
        editBtn.style.display = 'inline-block';
        
        // Reset form to original values
        document.getElementById('profileForm').reset();
        
        // Clear any validation errors
        const invalidInputs = document.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        const feedbacks = document.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.style.display = 'none';
        });
    });
    
    // Show success message if redirected after update
    @if(session('success'))
        const successAlert = document.createElement('div');
        successAlert.className = 'alert alert-success alert-dismissible fade show';
        successAlert.innerHTML = `
            <i class="lni lni-checkmark-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.card-body').insertBefore(successAlert, document.querySelector('.row'));
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            successAlert.remove();
        }, 5000);
    @endif
    
    // Show error message if validation fails
    @if($errors->any())
        viewMode.classList.add('d-none');
        editMode.classList.remove('d-none');
        editBtn.style.display = 'none';
    @endif
    

});
</script>
@endsection