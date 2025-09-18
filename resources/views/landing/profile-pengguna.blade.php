@extends("layout.landing")

@section("content")
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Form Data Diri User -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            Data Diri Pelanggan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Nama Lengkap:</strong></label>
                                <div class="form-control-plaintext border rounded px-3 py-2 bg-light">
                                    {{ Auth::check() && Auth::user() ? Auth::user()->name : 'Belum diisi' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Email:</strong></label>
                                <div class="form-control-plaintext border rounded px-3 py-2 bg-light">
                                    {{ Auth::check() && Auth::user() ? Auth::user()->email : 'Belum diisi' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>No. Telepon:</strong></label>
                                <div class="form-control-plaintext border rounded px-3 py-2 bg-light">
                                    {{ Auth::check() && Auth::user() ? Auth::user()->phone : 'Belum diisi' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><strong>Tanggal Bergabung:</strong></label>
                                <div class="form-control-plaintext border rounded px-3 py-2 bg-light">
                                    {{ Auth::check() && Auth::user() && Auth::user()->created_at ? Auth::user()->created_at->format('d M Y') : 'Tidak diketahui' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Button Actions -->
                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i>Edit Profil
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i>Ubah Password
                        </button>
                    </div>
                </div>

                <!-- Daftar Alamat -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="lni lni-map-marker"></i> Alamat Lengkap Pengguna</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus"></i> Tambah alamat
                        </button>
                    </div>
                    <div class="card-body">
                        @if($profiles->count() > 0)
                            <div class="row">
                                @foreach($profiles as $index => $profile)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card border shadow-sm h-100" id="card-{{ $profile->id }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h6 class="card-title text-primary mb-0">Alamat #{{ $index + 1 }}</h6>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="lni lni-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="showProfile({{ $profile->id }})">
                                                            <i class="lni lni-eye"></i> Lihat Detail
                                                        </a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="editProfile({{ $profile->id }})">
                                                            <i class="lni lni-pencil"></i> Edit
                                                        </a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteProfile({{ $profile->id }})">
                                                            <i class="lni lni-trash-can"></i> Hapus
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div class="address-details">
                                                <div class="mb-2">
                                                    <strong>No:</strong> {{ $index + 1 }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Nama:</strong> {{ $profile->name_penerima }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Alamat:</strong> 
                                                    <span class="text-muted">{{ Str::limit($profile->alamat, 80) }}</span>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Telp:</strong> {{ $profile->no_telp }}
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Provinsi:</strong> {{ $profile->provinsi_nama }}
                                                </div>
                                                <div class="mb-0">
                                                    <strong>Kota:</strong> {{ $profile->kota_nama }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-light">
                                             <div class="d-flex gap-2">
                                                 <button type="button" class="btn btn-sm btn-primary flex-fill" onclick="showProfile({{ $profile->id }})">
                                                     <i class="lni lni-eye"></i> Lihat
                                                 </button>
                                                 <button type="button" class="btn btn-sm btn-primary flex-fill" onclick="editProfile({{ $profile->id }})">
                                                     <i class="lni lni-pencil"></i> Edit
                                                 </button>
                                                 <button type="button" class="btn btn-sm btn-primary flex-fill" onclick="deleteProfile({{ $profile->id }})">
                                                     <i class="lni lni-trash-can"></i> Hapus
                                                 </button>
                                             </div>
                                         </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="alert alert-info">
                                    <i class="lni lni-information"></i> 
                                    Belum ada alamat tersimpan. Silakan tambah alamat baru.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_name_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="add_name_penerima" name="name_penerima" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="add_alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="add_no_telp" class="form-label">No. Telp</label>
                            <input type="text" class="form-control" id="add_no_telp" name="no_telp" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_provinsi" class="form-label">Provinsi</label>
                            <select class="form-select" id="add_provinsi" name="provinsi_id" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="add_kota" class="form-label">Kota</label>
                            <select class="form-select" id="add_kota" name="kota_id" required>
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control" id="edit_name_penerima" name="name_penerima" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit_alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_telp" class="form-label">No. Telp</label>
                            <input type="text" class="form-control" id="edit_no_telp" name="no_telp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_provinsi" class="form-label">Provinsi</label>
                            <select class="form-select" id="edit_provinsi" name="provinsi_id" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kota" class="form-label">Kota</label>
                            <select class="form-select" id="edit_kota" name="kota_id" required>
                                <option value="">Pilih Kota</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Show -->
    <div class="modal fade" id="showModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Penerima:</th>
                            <td id="show_name_penerima"></td>
                        </tr>
                        <tr>
                            <th>Alamat:</th>
                            <td id="show_alamat"></td>
                        </tr>
                        <tr>
                            <th>No. Telp:</th>
                            <td id="show_no_telp"></td>
                        </tr>
                        <tr>
                            <th>Provinsi:</th>
                            <td id="show_provinsi"></td>
                        </tr>
                        <tr>
                            <th>Kota:</th>
                            <td id="show_kota"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit me-2"></i>Edit Profil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editProfileForm" action="{{ route('landing.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="profile_name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="profile_name" name="name" 
                                   value="{{ Auth::check() && Auth::user() ? Auth::user()->name : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_username" class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" id="profile_username" name="username" 
                                   value="{{ Auth::check() && Auth::user() ? Auth::user()->username : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="profile_email" name="email" 
                                   value="{{ Auth::check() && Auth::user() ? Auth::user()->email : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_phone" class="form-label fw-bold">No. Telepon</label>
                            <input type="tel" class="form-control" id="profile_phone" name="phone" 
                                   value="{{ Auth::check() && Auth::user() ? Auth::user()->phone : '' }}" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="mb-3">
                            <label for="profile_alamat" class="form-label fw-bold">Alamat</label>
                            <textarea class="form-control" id="profile_alamat" name="alamat" rows="3">{{ Auth::check() && Auth::user() ? Auth::user()->alamat : '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Change Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="changePasswordForm" action="{{ route('landing.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Password Lama</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="6">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-1"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadProvinces();
            setupEventListeners();
        });

        function getCsrfToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            return token ? token.getAttribute('content') : '';
        }

        function loadProvinces() {
            fetch("{{ route('rajaongkir.provinsi') }}")
                .then(res => res.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        let provinceOptions = '';
                        data.forEach(prov => {
                            provinceOptions += `<option value="${prov.id}">${prov.nama}</option>`;
                        });

                        const addProvinsi = document.getElementById('add_provinsi');
                        const editProvinsi = document.getElementById('edit_provinsi');

                        if (addProvinsi) addProvinsi.innerHTML += provinceOptions;
                        if (editProvinsi) editProvinsi.innerHTML += provinceOptions;
                    }
                })
                .catch(error => {
                    console.error('Error loading provinces:', error);
                    Swal.fire('Error!', 'Gagal memuat data provinsi', 'error');
                });
        }

        // Load cities
        function loadCities(provinceId, targetSelectId, selectedCityId = null) {
            const targetSelect = document.getElementById(targetSelectId);

            if (!targetSelect || !provinceId) {
                if (targetSelect) {
                    targetSelect.innerHTML = '<option value="">Pilih Kota</option>';
                }
                return;
            }

            targetSelect.innerHTML = '<option value="">Loading...</option>';

            fetch("{{ url('rajaongkir/kota') }}/" + provinceId)
                .then(res => res.json())
                .then(data => {
                    let cityOptions = '<option value="">Pilih Kota</option>';
                    if (data.data && Array.isArray(data.data)) {
                        data.data.forEach(kota => {
                            const selected = selectedCityId == kota.id ? 'selected' : '';
                            cityOptions += `<option value="${kota.id}" ${selected}>${kota.name}</option>`;
                        });
                    }
                    targetSelect.innerHTML = cityOptions;
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    targetSelect.innerHTML = '<option value="">Error loading cities</option>';
                    Swal.fire('Error!', 'Gagal memuat data kota', 'error');
                });
        }

        function setupEventListeners() {
            const addProvinsi = document.getElementById('add_provinsi');
            const editProvinsi = document.getElementById('edit_provinsi');
            const addForm = document.getElementById('addForm');
            const editForm = document.getElementById('editForm');

            if (addProvinsi) {
                addProvinsi.addEventListener('change', function() {
                    const provinceId = this.value;
                    const provinceText = this.options[this.selectedIndex].text;

                    if (provinceId) {
                        loadCities(provinceId, 'add_kota');
                        this.setAttribute('data-provinsi-nama', provinceText);
                    } else {
                        document.getElementById('add_kota').innerHTML = '<option value="">Pilih Kota</option>';
                    }
                });
            }

            if (editProvinsi) {
                editProvinsi.addEventListener('change', function() {
                    const provinceId = this.value;
                    const provinceText = this.options[this.selectedIndex].text;

                    if (provinceId) {
                        loadCities(provinceId, 'edit_kota');
                        this.setAttribute('data-provinsi-nama', provinceText);
                    } else {
                        document.getElementById('edit_kota').innerHTML = '<option value="">Pilih Kota</option>';
                    }
                });
            }

            if (addForm) addForm.addEventListener('submit', handleAddForm);
            if (editForm) editForm.addEventListener('submit', handleEditForm);
            
            // Add event listener for edit profile form
            const editProfileForm = document.getElementById('editProfileForm');
            if (editProfileForm) editProfileForm.addEventListener('submit', handleEditProfileForm);
        }

        function handleAddForm(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name_penerima', document.getElementById('add_name_penerima').value);
            formData.append('alamat', document.getElementById('add_alamat').value);
            formData.append('no_telp', document.getElementById('add_no_telp').value);
            formData.append('provinsi_id', document.getElementById('add_provinsi').value);
            formData.append('provinsi_nama', document.getElementById('add_provinsi').options[document.getElementById('add_provinsi').selectedIndex].text);
            formData.append('kota_id', document.getElementById('add_kota').value);
            formData.append('kota_nama', document.getElementById('add_kota').options[document.getElementById('add_kota').selectedIndex].text);
            formData.append('_token', getCsrfToken());

            fetch('/landing/alamat', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
                    if (modal) modal.hide();
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data', 'error');
            });
        }

        function showProfile(id) {
            fetch(`/landing/alamat/${id}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const data = response.data;
                    document.getElementById('show_name_penerima').textContent = data.name_penerima;
                    document.getElementById('show_alamat').textContent = data.alamat;
                    document.getElementById('show_no_telp').textContent = data.no_telp;
                    document.getElementById('show_provinsi').textContent = data.provinsi_nama;
                    document.getElementById('show_kota').textContent = data.kota_nama;
                    new bootstrap.Modal(document.getElementById('showModal')).show();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data', 'error');
            });
        }

        // Edit Profile
        function editProfile(id) {
            fetch(`/landing/alamat/${id}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const data = response.data;
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_name_penerima').value = data.name_penerima;
                    document.getElementById('edit_alamat').value = data.alamat;
                    document.getElementById('edit_no_telp').value = data.no_telp;
                    document.getElementById('edit_provinsi').value = data.provinsi_id;

                    // Load cities for the selected province
                    loadCities(data.provinsi_id, 'edit_kota', data.kota_id);

                    new bootstrap.Modal(document.getElementById('editModal')).show();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data', 'error');
            });
        }

        function handleEditForm(e) {
            e.preventDefault();

            const id = document.getElementById('edit_id').value;
            const formData = new FormData();
            formData.append('name_penerima', document.getElementById('edit_name_penerima').value);
            formData.append('alamat', document.getElementById('edit_alamat').value);
            formData.append('no_telp', document.getElementById('edit_no_telp').value);
            formData.append('provinsi_id', document.getElementById('edit_provinsi').value);
            formData.append('provinsi_nama', document.getElementById('edit_provinsi').options[document.getElementById('edit_provinsi').selectedIndex].text);
            formData.append('kota_id', document.getElementById('edit_kota').value);
            formData.append('kota_nama', document.getElementById('edit_kota').options[document.getElementById('edit_kota').selectedIndex].text);
            formData.append('_method', 'PUT');
            formData.append('_token', getCsrfToken());

            fetch(`/landing/alamat/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    if (modal) modal.hide();
                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengupdate data', 'error');
            });
        }

        function deleteProfile(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('_method', 'DELETE');
                    formData.append('_token', getCsrfToken());

                    fetch(`/landing/alamat/${id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken()
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire('Terhapus!', response.message, 'success').then(() => {
                                const rowElement = document.getElementById(`row-${id}`);
                                if (rowElement) rowElement.remove();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                    });
                }
            });
        }

        function handleEditProfileForm(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name', document.getElementById('profile_name').value);
            formData.append('username', document.getElementById('profile_username').value);
            formData.append('email', document.getElementById('profile_email').value);
            formData.append('phone', document.getElementById('profile_phone').value);
            formData.append('alamat', document.getElementById('profile_alamat').value);
            formData.append('_token', getCsrfToken());
            formData.append('_method', 'PUT');

            fetch('{{ route("landing.profile.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
                    if (modal) modal.hide();
                    Swal.fire('Berhasil!', response.message || 'Profil berhasil diperbarui', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    let errorMessage = 'Gagal memperbarui profil';
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    } else if (response.message) {
                        errorMessage = response.message;
                    }
                    Swal.fire('Error!', errorMessage, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui profil', 'error');
            });
        }

        function handleChangePasswordForm(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            // Check if new password and confirmation match
            const newPassword = formData.get('new_password');
            const confirmPassword = formData.get('new_password_confirmation');
            
            if (newPassword !== confirmPassword) {
                Swal.fire('Error!', 'Password baru dan konfirmasi password tidak sama', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengubah...';
            submitBtn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                    if (modal) modal.hide();
                    Swal.fire('Berhasil!', response.message || 'Password berhasil diubah', 'success');
                    form.reset();
                } else {
                    let errorMessage = 'Gagal mengubah password';
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    } else if (response.message) {
                        errorMessage = response.message;
                    }
                    Swal.fire('Error!', errorMessage, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengubah password', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Reset forms when modals are closed
        document.getElementById('addModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('addForm').reset();
            document.getElementById('add_kota').innerHTML = '<option value="">Pilih Kota</option>';
        });

        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('editForm').reset();
            document.getElementById('edit_kota').innerHTML = '<option value="">Pilih Kota</option>';
        });

        document.getElementById('editProfileModal').addEventListener('hidden.bs.modal', function() {
            // Reset form to original values
            document.getElementById('profile_name').value = '{{ Auth::check() && Auth::user() ? Auth::user()->name : "" }}';
            document.getElementById('profile_username').value = '{{ Auth::check() && Auth::user() ? Auth::user()->username : "" }}';
            document.getElementById('profile_email').value = '{{ Auth::check() && Auth::user() ? Auth::user()->email : "" }}';
            document.getElementById('profile_alamat').value = '{{ Auth::check() && Auth::user() ? Auth::user()->alamat : "" }}';
        });

        // Event listener for change password form
        document.getElementById('changePasswordForm').addEventListener('submit', handleChangePasswordForm);

        // Reset change password form when modal is closed
        document.getElementById('changePasswordModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('changePasswordForm').reset();
        });
    </script>
@endsection

@section('styles')
<style>
/* Container Background Blue */
.container {
    background-color: #007bff !important;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

/* Change Password Modal Styling */
#changePasswordModal .modal-content {
    border: 2px solid #007bff;
    border-radius: 10px;
    overflow: hidden;
}

#changePasswordModal .modal-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    border-bottom: none;
}

#changePasswordModal .modal-body {
    background-color: #f8f9ff;
    padding: 30px;
}

#changePasswordModal .form-control {
    border: 2px solid #e3f2fd;
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s ease;
}

#changePasswordModal .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

#changePasswordModal .btn-outline-secondary {
    border-color: #007bff;
    color: #007bff;
}

#changePasswordModal .btn-outline-secondary:hover {
    background-color: #007bff;
    border-color: #007bff;
}

/* User Profile Styles */
.form-control-plaintext {
    background-color: #f8f9fa !important;
    border: 1px solid #dee2e6 !important;
    color: #495057;
    font-weight: 500;
}

.card-header.bg-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.card-header h5 i {
    margin-right: 8px;
}

/* Address Details Styles */
.address-details {
    font-size: 0.9rem;
    line-height: 1.6;
}

.address-details strong {
    color: #495057;
    min-width: 80px;
    display: inline-block;
}

/* Card Animations */
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #dee2e6;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}

.card-footer {
    border-top: 1px solid #e9ecef;
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0,0,0,.125);
}

/* Button Styles */
.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    transform: translateY(-1px);
}

.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .address-details {
        font-size: 0.85rem;
    }
    
    .address-details strong {
        min-width: 70px;
    }
    
    .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .form-control-plaintext {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
}

/* Label Styling */
.form-label strong {
    color: #495057;
    font-size: 0.9rem;
}



.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #1e7e34 0%, #155724 100%);
    transform: translateY(-1px);
}
</style>


@endsection
