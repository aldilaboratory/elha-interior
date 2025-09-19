@extends('layout.landing')
@section('css')

@endsection

@section('content')
    <div class="container my-5">
        <h3>Checkout</h3>
        <div class="row mt-4">
            <div class="col-md-7">
                <form action="{{ route('landing.checkout.process') }}" method="POST">
                    @csrf

                    {{-- Hidden inputs untuk data cart --}}
                    @foreach($cartItems as $index => $item)
                        <input type="hidden" name="cart_data[{{ $index }}][produk_id]" value="{{ $item->produk_id }}">
                        <input type="hidden" name="cart_data[{{ $index }}][produk_nama]" value="{{ $item->produk_nama }}">
                        <input type="hidden" name="cart_data[{{ $index }}][produk_harga]" value="{{ $item->produk_harga }}">
                        <input type="hidden" name="cart_data[{{ $index }}][produk_image]" value="{{ $item->produk_image ?? '' }}">
                        <input type="hidden" name="cart_data[{{ $index }}][jumlah]" value="{{ $item->jumlah }}">
                    @endforeach

                    {{-- Pilih alamat dari profil atau input manual --}}
                    <div class="mb-3">
                        <label class="form-label">Pilih Alamat Pengiriman</label>
                        <select id="profile_select" class="form-control">
                            <option value="">-- Input Manual --</option>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}"
                                        data-nama="{{ $profile->name_penerima }}"
                                        data-alamat="{{ $profile->alamat }}"
                                        data-no-telp="{{ $profile->no_telp }}"
                                        data-provinsi-id="{{ $profile->provinsi_id }}"
                                        data-provinsi-nama="{{ $profile->provinsi_nama }}"
                                        data-kota-id="{{ $profile->kota_id }}"
                                        data-kota-nama="{{ $profile->kota_nama }}">
                                    {{ $profile->name_penerima }} - {{ $profile->alamat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Data penerima --}}
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                   value="{{ old('nama', Auth::user()->name) }}" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control"
                                   value="{{ old('no_hp', Auth::user()->phone) }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', Auth::user()->alamat) }}</textarea>
                        </div>

                        {{-- Pilihan pengiriman --}}
                        <div class="col-6 mb-3">
                            <label class="form-label">Provinsi</label>
                            <select name="provinsi_id" id="provinsi" class="form-control" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <input type="hidden" name="provinsi_nama" id="provinsi_nama">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Kota / Kabupaten</label>
                            <select name="kota_id" id="kota" class="form-control" required>
                                <option value="">Pilih Kota</option>
                            </select>
                            <input type="hidden" name="kota_nama" id="kota_nama">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Kurir</label>
                            <select name="kurir" id="kurir" class="form-control" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS Indonesia</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Paket</label>
                            <select name="paket" id="paket" class="form-control" required>
                                <option value="">Pilih Paket</option>
                            </select>
                            <input type="hidden" name="paket_harga" id="paket_harga">
                            <input type="hidden" name="paket_estimasi" id="paket_estimasi">
                        </div>
                    </div>

                    {{-- Ongkir & total --}}
                    <input type="hidden" name="ongkir" id="ongkir_input">
                    <input type="hidden" name="total" id="total_input">

                    {{-- Metode pembayaran --}}
                    <div class="mb-3">
                        <input type="hidden" name="payment_method" value="bank_transfer">
                    </div>

                    
                
            </div>

            {{-- Ringkasan belanja --}}
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h5>Ringkasan Belanja</h5>
                        <ul class="list-group list-group-flush mt-3">
                            @foreach($cartItems as $item)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $item->produk_nama }}</strong><br>
                                            <small class="text-muted">Unit Price: Rp {{ number_format($item->produk_harga) }}</small><br>
                                            <small class="text-muted">Qty: {{ $item->jumlah }}</small>
                                        </div>
                                        <div class="text-end">
                                            <strong>Rp {{ number_format($item->produk_harga * $item->jumlah) }}</strong>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                Ongkos Kirim
                                <span id="ongkirDisplay">Rp 0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between fw-bold">
                                Total
                                <span id="totalDisplay">Rp {{ number_format($total) }}</span>
                            </li>
                        </ul>
                        <button type="submit" class="btn btn-primary w-100 mt-3" id="submit-btn">Lanjut ke Pembayaran</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalAwal = parseInt("{{ $total }}");
            console.log(totalAwal);
            loadProvinsi();

            // Validasi form sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                let totalInput = document.getElementById('total_input').value;
                let ongkirInput = document.getElementById('ongkir_input').value;
                
                if (!totalInput || parseFloat(totalInput) < 0.01) {
                    e.preventDefault();
                    alert('Silakan pilih paket pengiriman terlebih dahulu untuk melanjutkan pembayaran.');
                    return false;
                }
                
                if (!ongkirInput) {
                    e.preventDefault();
                    alert('Silakan pilih paket pengiriman terlebih dahulu.');
                    return false;
                }
            });

            // Event listener untuk pilih profil
            document.getElementById('profile_select').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value !== '') {
                    // Isi form dengan data profil yang dipilih
                    document.getElementById('nama').value = selectedOption.dataset.nama;
                    document.getElementById('alamat').value = selectedOption.dataset.alamat;
                    document.getElementById('no_hp').value = selectedOption.dataset.noTelp;

                    // Set provinsi
                    const provinsiId = selectedOption.dataset.provinsiId;
                    const provinsiNama = selectedOption.dataset.provinsiNama;
                    document.getElementById('provinsi').value = provinsiId;
                    document.getElementById('provinsi_nama').value = provinsiNama;

                    // Load kota untuk provinsi yang dipilih
                    loadKotaForProfile(provinsiId, selectedOption.dataset.kotaId, selectedOption.dataset.kotaNama);
                } else {
                    // Reset form jika pilih input manual
                    document.getElementById('nama').value = "{{ Auth::user()->name }}";
                    document.getElementById('alamat').value = "{{ Auth::user()->alamat }}";
                    document.getElementById('no_hp').value = "{{ Auth::user()->phone }}";
                    document.getElementById('provinsi').value = '';
                    document.getElementById('kota').innerHTML = '<option value="">Pilih Kota</option>';
                    resetKurirPaket();
                }
            });

            function loadProvinsi() {
                fetch("{{ route('rajaongkir.provinsi') }}")
                    .then(res => res.json())
                    .then(data => {
                        let provinsiSelect = document.getElementById('provinsi');
                        data.forEach(prov => {
                            provinsiSelect.innerHTML += `<option value="${prov.id}">${prov.nama}</option>`;
                        });
                    });
            }

            function loadKotaForProfile(provinsiId, selectedKotaId, selectedKotaNama) {
                fetch("{{ url('rajaongkir/kota') }}/" + provinsiId)
                    .then(res => res.json())
                    .then(data => {
                        let kotaSelect = document.getElementById('kota');
                        kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
                        data.data.forEach(kota => {
                            const selected = kota.id == selectedKotaId ? 'selected' : '';
                            kotaSelect.innerHTML += `<option value="${kota.id}" ${selected}>${kota.name}</option>`;
                        });

                        // Set hidden input untuk kota nama
                        document.getElementById('kota_nama').value = selectedKotaNama;

                        // Reset kurir dan paket setelah kota berubah
                        resetKurirPaket();
                    });
            }

            document.getElementById('provinsi').addEventListener('change', function() {
                let provinsiText = this.options[this.selectedIndex].text;
                document.getElementById('provinsi_nama').value = provinsiText;

                fetch("{{ url('rajaongkir/kota') }}/" + this.value)
                    .then(res => res.json())
                    .then(data => {
                        let kotaSelect = document.getElementById('kota');
                        kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
                        data.data.forEach(kota => {
                            kotaSelect.innerHTML += `<option value="${kota.id}">${kota.name}</option>`;
                        });

                        // Reset kurir dan paket setelah provinsi berubah
                        resetKurirPaket();
                    });
            });

            document.getElementById('kota').addEventListener('change', function() {
                let kotaText = this.options[this.selectedIndex].text;
                document.getElementById('kota_nama').value = kotaText;

                // Reset kurir dan paket setelah kota berubah
                resetKurirPaket();
                loadPaket();
            });

            document.getElementById('kurir').addEventListener('change', function() {
                // Reset paket setelah kurir berubah
                document.getElementById('paket').innerHTML = '<option value="">Pilih Paket</option>';
                resetOngkir();
                loadPaket();
            });

            function loadPaket() {
                let kota = document.getElementById('kota').value;
                let kurir = document.getElementById('kurir').value;
                if (kota && kurir) {
                    fetch("{{ url('rajaongkir/ongkir') }}/" + kota + "/" + kurir)
                        .then(res => res.json())
                        .then(data => {
                            let paketSelect = document.getElementById('paket');
                            paketSelect.innerHTML = '<option value="">Pilih Paket</option>';
                            data.data.forEach(p => {
                                paketSelect.innerHTML += `<option value="${p.service}" data-cost="${p.cost}" data-etd="${p.etd}">${p.service} - Rp ${p.cost} (${p.etd})</option>`;
                            });
                        });
                }
            }

            document.getElementById('paket').addEventListener('change', function() {
                let cost = parseInt(this.selectedOptions[0].dataset.cost || 0);
                let etd = this.selectedOptions[0].dataset.etd || '';
                document.getElementById('ongkirDisplay').innerText = 'Rp ' + cost.toLocaleString();

                let total = totalAwal + cost;
                document.getElementById('totalDisplay').innerText = 'Rp ' + total.toLocaleString();

                // Isi hidden input
                document.getElementById('ongkir_input').value = cost;
                document.getElementById('total_input').value = total;
                document.getElementById('paket_harga').value = cost;
                document.getElementById('paket_estimasi').value = etd;
            });

            function resetKurirPaket() {
                document.getElementById('kurir').value = '';
                document.getElementById('paket').innerHTML = '<option value="">Pilih Paket</option>';
                resetOngkir();
            }

            function resetOngkir() {
                document.getElementById('ongkirDisplay').innerText = 'Rp 0';
                document.getElementById('totalDisplay').innerText = 'Rp ' + totalAwal.toLocaleString();
                document.getElementById('ongkir_input').value = '';
                document.getElementById('total_input').value = totalAwal;
                document.getElementById('paket_harga').value = '';
                document.getElementById('paket_estimasi').value = '';
            }
        });
    </script>
@endsection
