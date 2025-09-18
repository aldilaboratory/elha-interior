# DawanPetshop - Database Documentation

## Overview
Dokumentasi ini menjelaskan struktur database untuk aplikasi DawanPetshop, sebuah sistem e-commerce untuk toko hewan peliharaan yang dibangun menggunakan Laravel Framework.

## Database Schema Summary
Database terdiri dari **12 tabel utama** yang dibagi menjadi beberapa kategori fungsional:

### 1. Core Business Tables
- **user** - Data pengguna sistem
- **group** - Grup/role pengguna
- **produk** - Data produk yang dijual
- **kategori** - Kategori produk

### 2. Shopping & Transaction Management
- **keranjang** - Keranjang belanja pengguna
- **transaksi** - Data transaksi/pesanan
- **transaksi_detail** - Detail item dalam transaksi

### 3. Geographic Data
- **provinsi** - Data provinsi Indonesia
- **kab_kota** - Data kabupaten/kota
- **desa** - Data desa/kelurahan

### 4. Additional Tables
- **profil_lengkap_penggunas** - Profil lengkap pengguna
- **status** - Status transaksi
- **metode** - Metode pembayaran

---

## Detailed Table Descriptions

### 1. USER Table
**Purpose**: Menyimpan data pengguna yang terdaftar dalam sistem

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(255) | NOT NULL | Nama lengkap pengguna |
| username | VARCHAR(255) | UNIQUE, NOT NULL | Username untuk login |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email pengguna |
| phone | VARCHAR(255) | NULLABLE | Nomor telepon |
| password | VARCHAR(255) | NOT NULL | Password terenkripsi |
| group_id | INT | NOT NULL, FK | Referensi ke tabel group |
| provinsi_id | INT | NULLABLE, FK | Referensi ke tabel provinsi |
| kab_kot_id | INT | NULLABLE, FK | Referensi ke tabel kab_kota |
| kecamatan_id | INT | NULLABLE, FK | Referensi ke tabel kecamatan |
| desa_id | INT | NULLABLE, FK | Referensi ke tabel desa |
| alamat | TEXT | NULLABLE | Alamat lengkap pengguna |
| email_verified_at | TIMESTAMP | NULLABLE | Waktu verifikasi email |
| remember_token | VARCHAR(100) | NULLABLE | Token untuk remember me |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `group` (Many-to-One)
- Has many `keranjang` (One-to-Many)
- Has many `transaksi` (One-to-Many)
- Has many `profil_lengkap_penggunas` (One-to-Many)

### 2. GROUP Table
**Purpose**: Menyimpan data grup/role pengguna (Admin, Customer, dll)

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama grup (Admin, Customer) |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Has many `user` (One-to-Many)

### 3. PRODUK Table
**Purpose**: Menyimpan data produk yang dijual di toko

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama produk |
| deskripsi | TEXT | NOT NULL | Deskripsi produk |
| image | VARCHAR(255) | NOT NULL | Path gambar produk |
| harga | INT | NOT NULL | Harga produk (dalam rupiah) |
| berat | INT | NOT NULL | Berat produk (dalam gram) |
| kategori_id | INT | NOT NULL, FK | Referensi ke tabel kategori |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `kategori` (Many-to-One)
- Has many `keranjang` (One-to-Many)
- Has many `transaksi_detail` (One-to-Many)

### 4. KATEGORI Table
**Purpose**: Menyimpan kategori produk

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama kategori |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Has many `produk` (One-to-Many)

### 5. KERANJANG Table
**Purpose**: Menyimpan item dalam keranjang belanja pengguna

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | INT | NOT NULL, FK | Referensi ke tabel user |
| produk_id | INT | NOT NULL, FK | Referensi ke tabel produk |
| jumlah | INT | NOT NULL | Jumlah item dalam keranjang |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `user` (Many-to-One)
- Belongs to `produk` (Many-to-One)

### 6. TRANSAKSI Table
**Purpose**: Menyimpan data transaksi/pesanan

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | INT | NOT NULL, FK | Referensi ke tabel user |
| order_id | VARCHAR(255) | UNIQUE, NOT NULL | ID pesanan unik |
| nama_penerima | VARCHAR(255) | NOT NULL | Nama penerima paket |
| alamat | TEXT | NOT NULL | Alamat pengiriman |
| no_hp | VARCHAR(255) | NOT NULL | Nomor HP penerima |
| provinsi_id | BIGINT UNSIGNED | NOT NULL | ID provinsi pengiriman |
| provinsi_nama | VARCHAR(255) | NOT NULL | Nama provinsi |
| kota_id | BIGINT UNSIGNED | NOT NULL | ID kota pengiriman |
| kota_nama | VARCHAR(255) | NOT NULL | Nama kota |
| kurir | VARCHAR(255) | NOT NULL | Nama kurir (JNE, TIKI, dll) |
| paket | VARCHAR(255) | NOT NULL | Jenis paket pengiriman |
| paket_harga | INT | DEFAULT 0 | Harga paket |
| paket_estimasi | VARCHAR(255) | NULLABLE | Estimasi waktu pengiriman |
| ongkir | INT | DEFAULT 0 | Ongkos kirim |
| total | INT | DEFAULT 0 | Total pembayaran |
| status | VARCHAR(255) | DEFAULT 'pending' | Status transaksi |
| payment_method | VARCHAR(255) | NOT NULL | Metode pembayaran |
| snap_token | VARCHAR(255) | NULLABLE | Token Midtrans |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `user` (Many-to-One)
- Has many `transaksi_detail` (One-to-Many)

### 7. TRANSAKSI_DETAIL Table
**Purpose**: Menyimpan detail item dalam setiap transaksi

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| transaksi_id | BIGINT UNSIGNED | NOT NULL, FK | Referensi ke tabel transaksi |
| produk_id | BIGINT UNSIGNED | NOT NULL, FK | Referensi ke tabel produk |
| nama_produk | VARCHAR(255) | NOT NULL | Nama produk saat transaksi |
| gambar_produk | VARCHAR(255) | NOT NULL | Gambar produk saat transaksi |
| harga | INT | NOT NULL | Harga produk saat transaksi |
| jumlah | INT | NOT NULL | Jumlah item dibeli |
| subtotal | INT | NOT NULL | Subtotal (harga × jumlah) |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `transaksi` (Many-to-One)
- Belongs to `produk` (Many-to-One)

### 8. PROVINSI Table
**Purpose**: Menyimpan data provinsi di Indonesia

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama provinsi |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Has many `kab_kota` (One-to-Many)

### 9. KAB_KOTA Table
**Purpose**: Menyimpan data kabupaten/kota

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| provinsi_id | INT | NOT NULL, FK | Referensi ke tabel provinsi |
| nama | VARCHAR(255) | NOT NULL | Nama kabupaten/kota |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `provinsi` (Many-to-One)

### 10. DESA Table
**Purpose**: Menyimpan data desa/kelurahan

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| kecamatan_id | INT | NOT NULL, FK | Referensi ke tabel kecamatan |
| nama | VARCHAR(255) | NOT NULL | Nama desa/kelurahan |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

### 11. PROFIL_LENGKAP_PENGGUNAS Table
**Purpose**: Menyimpan profil lengkap pengguna untuk pengiriman

| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | BIGINT UNSIGNED | NULLABLE, FK | Referensi ke tabel user |
| name_penerima | VARCHAR(255) | NOT NULL | Nama penerima |
| alamat | TEXT | NOT NULL | Alamat lengkap |
| no_telp | VARCHAR(255) | NOT NULL | Nomor telepon |
| provinsi_id | BIGINT UNSIGNED | NOT NULL | ID provinsi |
| provinsi_nama | VARCHAR(255) | NOT NULL | Nama provinsi |
| kota_id | BIGINT UNSIGNED | NOT NULL | ID kota |
| kota_nama | VARCHAR(255) | NOT NULL | Nama kota |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

**Relationships**:
- Belongs to `user` (Many-to-One)

### 12. STATUS & METODE Tables
**Purpose**: Lookup tables untuk status transaksi dan metode pembayaran

#### STATUS Table
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama status |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

#### METODE Table
| Field | Type | Constraints | Description |
|-------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(255) | NOT NULL | Nama metode pembayaran |
| created_at | TIMESTAMP | NOT NULL | Waktu pembuatan record |
| updated_at | TIMESTAMP | NOT NULL | Waktu update terakhir |

---

## Business Logic & Data Flow

### 1. User Registration & Authentication
- Pengguna mendaftar dengan data di tabel `user`
- Setiap user memiliki `group_id` yang menentukan role (Admin/Customer)
- Email verification menggunakan field `email_verified_at`

### 2. Product Management
- Produk dikategorikan menggunakan tabel `kategori`
- Setiap produk memiliki informasi harga, berat (untuk ongkir), dan gambar
- Admin dapat mengelola produk melalui dashboard

### 3. Shopping Cart Flow
- User menambahkan produk ke `keranjang`
- Keranjang menyimpan `user_id`, `produk_id`, dan `jumlah`
- User dapat mengubah jumlah atau menghapus item dari keranjang

### 4. Transaction Process
- Saat checkout, data keranjang dipindah ke `transaksi` dan `transaksi_detail`
- Sistem menghitung ongkir berdasarkan berat produk dan alamat tujuan
- Integrasi dengan payment gateway (Midtrans) menggunakan `snap_token`
- Status transaksi diupdate sesuai progress pembayaran dan pengiriman

### 5. Geographic Data Integration
- Sistem menggunakan data `provinsi` dan `kab_kota` untuk:
  - Alamat pengguna
  - Alamat pengiriman
  - Perhitungan ongkos kirim
- Data geografis membantu integrasi dengan API kurir (JNE, TIKI, dll)

### 6. User Profile Management
- Tabel `profil_lengkap_penggunas` menyimpan multiple alamat pengiriman
- User dapat memilih alamat yang berbeda untuk setiap transaksi
- Data profil digunakan untuk mempercepat proses checkout

---

## Database Indexes & Performance

### Recommended Indexes
```sql
-- User table
CREATE INDEX idx_user_email ON user(email);
CREATE INDEX idx_user_username ON user(username);
CREATE INDEX idx_user_group_id ON user(group_id);

-- Produk table
CREATE INDEX idx_produk_kategori_id ON produk(kategori_id);
CREATE INDEX idx_produk_nama ON produk(nama);

-- Transaksi table
CREATE INDEX idx_transaksi_user_id ON transaksi(user_id);
CREATE INDEX idx_transaksi_order_id ON transaksi(order_id);
CREATE INDEX idx_transaksi_status ON transaksi(status);

-- Keranjang table
CREATE INDEX idx_keranjang_user_id ON keranjang(user_id);
CREATE INDEX idx_keranjang_produk_id ON keranjang(produk_id);

-- Geographic tables
CREATE INDEX idx_kab_kota_provinsi_id ON kab_kota(provinsi_id);
CREATE INDEX idx_desa_kecamatan_id ON desa(kecamatan_id);
```

---

## Security Considerations

### 1. Data Protection
- Password disimpan dalam bentuk hash menggunakan Laravel's Hash facade
- Sensitive data seperti `snap_token` hanya disimpan sementara
- Email verification untuk mencegah spam registration

### 2. Foreign Key Constraints
- Semua foreign key memiliki constraint untuk menjaga referential integrity
- Cascade delete/update sesuai business logic

### 3. Input Validation
- Semua input divalidasi menggunakan Laravel Form Request
- XSS protection melalui Laravel's built-in security features

---

## Migration Files Location
Semua migration files tersimpan di: `database/migrations/`

Key migration files:
- `create_user_table.php` - User management
- `2025_08_10_0828321_create_produk_table.php` - Product management
- `create_transaksi_table.php` - Transaction system
- `create_keranjang_table.php` - Shopping cart
- Dan lainnya...

---

## Generated Files
Dokumentasi ini dibuat bersamaan dengan:
1. **ERD-DawanPetshop.svg** - Entity Relationship Diagram
2. **Database-Schema-Diagram.svg** - Detailed schema diagram dengan data types

Kedua file tersebut tersimpan di folder `database-diagrams/` untuk referensi visual struktur database.

---

*Dokumentasi ini dibuat pada: {{ date('Y-m-d H:i:s') }}*
*Laravel Version: 10.x*
*Database: MySQL/MariaDB*