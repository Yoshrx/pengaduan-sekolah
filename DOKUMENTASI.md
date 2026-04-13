# DOKUMENTASI APLIKASI PENGADUAN SARANA SEKOLAH
**UKK RPL - Tahun Pelajaran 2025/2026**

---

## A. DESKRIPSI PROGRAM

Aplikasi Pengaduan Sarana Sekolah adalah sistem berbasis web yang dibangun menggunakan **Laravel (PHP Framework)** dengan database **MySQL**. Aplikasi ini memungkinkan siswa menyampaikan aspirasi/pengaduan terkait sarana dan prasarana sekolah secara digital, serta memudahkan admin mengelola dan merespons setiap pengaduan.

**Teknologi yang digunakan:**
- Backend  : PHP 8.x + Laravel 11
- Frontend : Blade Templating + CSS kustom
- Database : MySQL
- Tools    : Composer, Artisan CLI

---

## B. ERD (Entity Relationship Diagram)

```
+------------+        +-------------+       +-----------+
|   users    |        | pengaduans  |       | kategoris |
+------------+        +-------------+       +-----------+
| id (PK)    |1      N| id (PK)     |N     1| id (PK)   |
| name       |--------| user_id(FK) |-------| nama_kat  |
| username   |        | kategori_id |       | created_at|
| nis        |        | judul       |       | updated_at|
| kelas      |        | isi_pengad. |       +-----------+
| email      |        | lokasi      |
| password   |        | foto        |
| role       |        | status      |
| created_at |        | feedback    |
| updated_at |        | created_at  |
+------------+        | updated_at  |
                      +-------------+

Relasi:
- users (1) --> (N) pengaduans   : satu siswa bisa memiliki banyak pengaduan
- kategoris (1) --> (N) pengaduans : satu kategori mencakup banyak pengaduan
```

---

## C. STRUKTUR DATA

### Tabel: users
| Kolom    | Tipe               | Keterangan                  |
|----------|--------------------|-----------------------------|
| id       | BIGINT (PK)        | Auto increment               |
| name     | VARCHAR(255)       | Nama lengkap                |
| username | VARCHAR(255) UNIQUE | Username login             |
| nis      | VARCHAR(20)        | Nomor Induk Siswa           |
| kelas    | VARCHAR(20)        | Kelas siswa (XII RPL 1, dst)|
| email    | VARCHAR(255) UNIQUE | Email login                |
| password | VARCHAR(255)       | Bcrypt hash                 |
| role     | ENUM(admin,siswa)  | Peran pengguna              |

### Tabel: kategoris
| Kolom         | Tipe        | Keterangan              |
|---------------|-------------|-------------------------|
| id            | BIGINT (PK) | Auto increment           |
| nama_kategori | VARCHAR(50) | Nama kategori sarana    |

### Tabel: pengaduans
| Kolom          | Tipe                         | Keterangan              |
|----------------|------------------------------|-------------------------|
| id             | BIGINT (PK)                  | Auto increment           |
| user_id        | BIGINT (FK → users.id)       | Pemilik pengaduan       |
| kategori_id    | BIGINT (FK → kategoris.id)   | Kategori sarana         |
| judul          | VARCHAR(255)                 | Judul singkat           |
| isi_pengaduan  | TEXT                         | Detail pengaduan        |
| lokasi         | VARCHAR(100)                 | Lokasi sarana           |
| foto           | VARCHAR(255) nullable        | Path foto bukti         |
| status         | ENUM(Menunggu,Proses,Selesai)| Status penyelesaian     |
| feedback       | TEXT nullable                | Umpan balik dari admin  |

---

## D. DOKUMENTASI FUNGSI / PROSEDUR

### Model: Pengaduan.php
```php
// Scope untuk filter status - digunakan di controller query
scopeByStatus($query, string $status): Builder

// Scope filter per kategori
scopeByKategori($query, int $kategoriId): Builder

// Scope filter per bulan & tahun
scopeByBulan($query, int $bulan, int $tahun): Builder

// Accessor: badge CSS sesuai status
getBadgeStatusAttribute(): string
// Return: 'badge-warning' | 'badge-info' | 'badge-success'

// Accessor: format tanggal bahasa Indonesia
getTanggalFormatAttribute(): string
// Contoh return: "15 Februari 2026"

// Statistik status (static) - digunakan di dashboard admin
getStatistikStatus(): array
// Return: ['total'=>5, 'menunggu'=>2, 'proses'=>2, 'selesai'=>1]
```

### Model: Kategori.php
```php
// Statistik jumlah pengaduan per kategori (static)
getStatistikPerKategori(): array
// Return: ['Kebersihan'=>3, 'Toilet'=>1, ...]
// Menggunakan withCount() untuk efisiensi query
```

### Controller: PengaduanController.php
```php
// Menampilkan histori pengaduan siswa (dengan eager loading)
index(): View

// Menampilkan form pengaduan + daftar kategori
create(): View

// Menyimpan pengaduan baru (validasi + upload foto + simpan DB)
store(Request $request): RedirectResponse

// Menampilkan detail 1 pengaduan + feedback admin
show(int $id): View
```

### Controller: AdminPengaduanController.php
```php
// Daftar pengaduan dengan filter lengkap (status,kategori,siswa,tanggal,bulan,judul)
index(Request $request): View

// Detail pengaduan untuk admin
show(int $id): View

// Update status dan tambah feedback (validasi enum status)
updateStatus(Request $request, int $id): RedirectResponse
```

### Controller: AdminDashboardController.php
```php
// Dashboard: statistik total, per-status, per-kategori, 5 terbaru
index(): View
// Menggunakan: Pengaduan::getStatistikStatus() dan Kategori::getStatistikPerKategori()
```

---

## E. ALUR PROGRAM

### Alur Siswa:
```
Login → Dashboard Siswa
         ├── Buat Pengaduan Baru → Isi Form → Submit → Tersimpan (status: Menunggu)
         └── Riwayat Aspirasi → Pilih Pengaduan → Detail + Progres + Feedback Admin
```

### Alur Admin:
```
Login → Dashboard Admin (statistik)
         └── Data Pengaduan → Filter/Cari → Pilih Pengaduan → Detail
                                                                └── Ubah Status + Isi Feedback → Simpan
```

---

## F. DEBUGGING

### Bug #1: Nomor urut tabel tidak akurat
- **Masalah**: `$index + 1` tidak akurat saat ada pagination
- **Perbaikan**: Ganti dengan `$pengaduans->firstItem() + $loop->index`

### Bug #2: Status di form admin tidak pre-selected
- **Masalah**: Dropdown status tidak menampilkan nilai saat ini
- **Perbaikan**: Tambah `{{ $pengaduan->status==$s ? 'selected' : '' }}` pada option

### Bug #3: N+1 Query Problem
- **Masalah**: Tiap baris tabel memanggil query user dan kategori secara terpisah
- **Perbaikan**: Gunakan eager loading `Pengaduan::with(['user','kategori'])->...`

### Bug #4: Foto tidak bisa diakses
- **Masalah**: Path foto tidak ter-symlink ke public
- **Perbaikan**: Jalankan `php artisan storage:link`

### Bug #5: Route tidak ditemukan setelah update
- **Masalah**: Cache route lama masih tersimpan
- **Perbaikan**: Jalankan `php artisan route:clear`

---

## G. CARA INSTALASI

```bash
# 1. Clone / extract proyek
cd pengaduan-sekolah

# 2. Install dependensi
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Konfigurasi database di .env
DB_DATABASE=pengaduan_sekolah
DB_USERNAME=root
DB_PASSWORD=

# 5. Generate key aplikasi
php artisan key:generate

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Buat symlink storage
php artisan storage:link

# 8. Jalankan server development
php artisan serve
```

**Akun Default:**
| Role  | Email                | Password  |
|-------|----------------------|-----------|
| Admin | admin@sekolah.test   | admin123  |
| Siswa | budi@sekolah.test    | siswa123  |
| Siswa | siti@sekolah.test    | siswa123  |

---

## H. LAPORAN EVALUASI SINGKAT

**Hasil Pengujian Fungsional:**

| Fitur                              | Status |
|------------------------------------|--------|
| Login admin & siswa                | ✅ OK   |
| Form pengaduan dengan kategori     | ✅ OK   |
| Upload foto bukti                  | ✅ OK   |
| List pengaduan siswa + pagination  | ✅ OK   |
| Detail pengaduan + progres         | ✅ OK   |
| Filter admin (status,kategori,dll) | ✅ OK   |
| Update status + umpan balik        | ✅ OK   |
| Siswa lihat feedback dari admin    | ✅ OK   |
| Dashboard statistik admin          | ✅ OK   |
| Statistik per kategori             | ✅ OK   |

**Kelebihan:**
- Menggunakan eager loading untuk efisiensi query
- Accessor dan scope pada model untuk kode yang bersih dan reusable
- Filter lengkap: per tanggal, per bulan, per siswa, per kategori, per status

**Keterbatasan / Pengembangan Selanjutnya:**
- Notifikasi email ke siswa saat status berubah
- Export laporan ke Excel/PDF
- Role guru/wali kelas untuk monitoring
