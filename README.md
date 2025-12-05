## Artwork GallerySI — Kelompok 7 (TuhanMembersamai)

![Laravel](https://img.shields.io/badge/Laravel-10+-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

Proyek ini adalah aplikasi galeri karya (artwork sharing) berbasis Laravel. Pengguna dapat mengunggah karya, memberi komentar dan like, mengelola kategori, serta admin memiliki panel untuk manajemen post, kategori, dan activity log. Storage gambar diintegrasikan dengan Supabase Storage (public URLs) dan ada fallback ke storage lokal.

## Daftar Isi
- [Artwork GallerySI — Kelompok 7 (TuhanMembersamai)](#artwork-gallerysi--kelompok-7-tuhanmembersamai)
- [Daftar Isi](#daftar-isi)
- [Tentang](#tentang)
- [Fitur (Ringkasan)](#fitur-ringkasan)
- [Fitur Berdasarkan Role](#fitur-berdasarkan-role)
  - [Fitur User](#fitur-user)
  - [Fitur Admin](#fitur-admin)
- [Tech Stack](#tech-stack)
- [Instalasi \& Persiapan](#instalasi--persiapan)
- [Konfigurasi Supabase](#konfigurasi-supabase)
- [Struktur Database](#struktur-database)
- [Relasi Database (Ringkas)](#relasi-database-ringkas)
- [Workflow (User \& Admin)](#workflow-user--admin)
  - [Upload Artwork (User)](#upload-artwork-user)
  - [Hapus Artwork (User)](#hapus-artwork-user)
  - [Moderasi / Manajemen (Admin)](#moderasi--manajemen-admin)
- [Troubleshooting Cepat](#troubleshooting-cepat)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)
- [Stack \& dependensi](#stack--dependensi)
- [Persiapan \& Instalasi](#persiapan--instalasi)
- [Konfigurasi Supabase \& Troubleshooting](#konfigurasi-supabase--troubleshooting)
- [Struktur Singkat (file/folder penting)](#struktur-singkat-filefolder-penting)
- [Cara Kerja Upload (ringkas)](#cara-kerja-upload-ringkas)
- [Tips Debug cepat](#tips-debug-cepat)
- [Contribution](#contribution)
- [Lisensi](#lisensi-1)

## Tentang
Proyek ini adalah aplikasi galeri karya (artwork sharing) berbasis Laravel. Pengguna dapat mengunggah karya, memberi komentar dan like, mengelola kategori, serta admin memiliki panel untuk manajemen post, kategori, dan activity log. Storage gambar diintegrasikan dengan Supabase Storage (public URLs) dan ada fallback ke storage lokal.

## Fitur (Ringkasan)
- Upload artwork (gambar) dan simpan URL dari Supabase
- Lihat galeri (profil & eksplorasi publik)
- Komentar dan Like pada artwork
- Kategori dan pengelompokan artwork
- Profil pengguna dengan foto
- Halaman admin: kelola posts, categories, activity logs
- Pencatatan activity log (upload, delete, update)

## Fitur Berdasarkan Role

### Fitur User
- Daftar / Login / Logout
- Kelola profil (edit data, foto profil)
- Unggah artwork (upload gambar + deskripsi + pilih kategori)
- Lihat koleksi karya pribadi (profil)
- Melihat galeri publik / exploration
- Memberi komentar pada artwork
- Memberi like pada artwork
- Hapus karya sendiri

### Fitur Admin
- Login admin dengan role khusus
- Melihat semua artwork dan metadata
- Menghapus atau mengelola artwork (jika diperlukan)
- Kelola kategori (CRUD kategori)
- Melihat Activity Log (riwayat aksi pengguna)
- Mengelola post atau konten lain pada panel admin

## Tech Stack
- Backend: Laravel (PHP)
- Frontend: Blade + Bootstrap + custom CSS/JS
- Database: PostgreSQL (Supabase) atau yang dikonfigurasi di `.env`
- Storage: Supabase Storage (bucket `artworks`) dan fallback local disk
- HTTP client: Laravel HTTP Client / Guzzle

## Instalasi & Persiapan
1. Clone repo

```powershell
git clone https://github.com/aidilsaputrakirsan-classroom/final-project-cloud-computing-b-cc-kelompok-7-tuhanmembersamai.git
cd final-project-cloud-computing-b-cc-kelompok-7-tuhanmembersamai
```

2. Install dependencies

```powershell
composer install
npm install
```

3. Setup environment

```powershell
copy .env.example .env
php artisan key:generate
```

4. Migrate & seed

```powershell
php artisan migrate --seed
```

5. (Optional) buat symlink jika pakai storage lokal

```powershell
php artisan storage:link
```

## Konfigurasi Supabase
Tambahkan variabel ini di `.env`:

```env
SUPABASE_URL=https://<your-project>.supabase.co
SUPABASE_SERVICE_ROLE_KEY=<service-role-key>
SUPABASE_BUCKET=artworks
```

PENTING: `SUPABASE_URL` harus lengkap (termasuk `https://`)—jika kosong upload akan mencoba memanggil path `/storage/v1/...` tanpa host, menghasilkan "cURL error 6: Could not resolve host: storage".

## Struktur Database
Berikut tabel utama yang dipakai di aplikasi ini (ringkasan):

- `users` — pengguna (id, name, email, password, image, role, ...)
- `artworks` — karya (id, user_id, image, description, category_id, created_at)
- `categories` — kategori artwork (id, name)
- `comments` — komentar (id, artwork_id, user_id, content, created_at)
- `likes` — like (id, artwork_id, user_id)
- `posts` — (opsional, jika ada fitur post/admin)
- `activity_logs` — catatan aktivitas (id, user_id, action, metadata, created_at)

## Relasi Database (Ringkas)
- `User` hasMany `Artwork` (users.id -> artworks.user_id)
- `Artwork` belongsTo `User` (artworks.user_id -> users.id)
- `Artwork` belongsTo `Category` (artworks.category_id -> categories.id)
- `Artwork` hasMany `Comment` (comments.artwork_id -> artworks.id)
- `Artwork` hasMany `Like` (likes.artwork_id -> artworks.id)
- `User` hasMany `Comment` and `Like` (comments.user_id, likes.user_id)
- `ActivityLog` belongsTo `User` (activity_logs.user_id -> users.id)

Contoh diagram relasi (ER-style, ASCII):

```
users (1)  ─── (n) artworks
users (1)  ─── (n) comments
users (1)  ─── (n) likes
users (1)  ─── (n) activity_logs

categories (1)  ─── (n) artworks

artworks (1)  ─── (n) comments
artworks (1)  ─── (n) likes

# Ringkasan relasi utama:
# - Satu user dapat memiliki banyak artwork, komentar, like, dan activity log
# - Satu artwork dimiliki oleh satu user dan dapat memiliki banyak komentar & like
# - Satu kategori dapat memiliki banyak artwork
```

## Workflow (User & Admin)

### Upload Artwork (User)
1. User pilih menu Unggah → isi deskripsi + pilih file gambar + kategori.
2. Frontend submit form ke `ArtworkController::store()`.
3. Controller memanggil `SupabaseStorageService::upload()`:
	 - Service membaca file, membangun URL upload: `{$SUPABASE_URL}/storage/v1/object/{bucket}/{path}`
	 - Mengirim POST dengan body file ke Supabase Storage.
4. Supabase merespon → service mengembalikan public URL: `{$SUPABASE_URL}/storage/v1/object/public/{bucket}/{path}`.
5. Controller menyimpan record `artworks` dengan `image` berisi URL publik.
6. User dapat melihat karya di profil dan gallery publik.

### Hapus Artwork (User)
1. User klik Hapus pada karya sendiri.
2. Controller menghapus record DB; (opsional) operasi delete ke Supabase Storage belum diimplementasikan di versi ini.

### Moderasi / Manajemen (Admin)
1. Admin membuka panel admin → bisa melihat semua artworks.
2. Admin dapat menghapus/mengelola kategori dan melihat activity logs.

## Troubleshooting Cepat
- Error "cURL error 6: Could not resolve host: storage" → cek `SUPABASE_URL` di `.env`, jalankan:

```powershell
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

- Jika gambar tidak tampil dan URL disimpan penuh (https://...), pastikan view tidak memanggil `asset('storage/' . $image)` pada URL penuh — gunakan pola: jika `image` dimulai dengan `http`/`https` pakai langsung, jika tidak pakai `asset('storage/...')`.

## Kontribusi
- Fork, buat branch fitur, commit, push, PR. Ikuti standar PSR-12.

## Lisensi
- MIT

---

Perubahan ini menambahkan TOC, memisahkan fitur User/Admin, menambahkan struktur DB, relasi, dan workflow upload/hapus/manajemen.

## Stack & dependensi
- Backend: Laravel (PHP)
- Storage: Supabase Storage (S3-compatible endpoint)
- DB: PostgreSQL (via Supabase) atau konfigurasi lain sesuai `.env`
- Frontend: Bootstrap + custom CSS/JS

## Persiapan & Instalasi

1. Clone repository

```powershell
git clone https://github.com/aidilsaputrakirsan-classroom/final-project-cloud-computing-b-cc-kelompok-7-tuhanmembersamai.git
cd final-project-cloud-computing-b-cc-kelompok-7-tuhanmembersamai
```

2. Install dependencies

```powershell
composer install
npm install
```

3. Salin environment dan generate APP_KEY

```powershell
copy .env.example .env
php artisan key:generate
```

4. Konfigurasi `.env` (poin penting untuk Supabase)

Contoh variabel Supabase yang harus ada:

```env
DB_URL=postgresql://<user>:<pass>@<host>:5432/postgres
SUPABASE_URL=https://<your-project>.supabase.co
SUPABASE_SERVICE_ROLE_KEY=<service-role-key>
SUPABASE_BUCKET=artworks
FILESYSTEM_DISK=local
```

Catatan: `SUPABASE_URL` harus lengkap (termasuk `https://<project>.supabase.co`). Jika kosong atau salah, upload akan gagal dengan error seperti "cURL error 6: Could not resolve host: storage".

5. Buat symbolic link storage (jika pakai storage lokal)

```powershell
php artisan storage:link
```

6. Jalankan migrasi dan seeder

```powershell
php artisan migrate --seed
```

7. Jalankan dev server

```powershell
php artisan serve
npm run dev
```

## Konfigurasi Supabase & Troubleshooting
- Pastikan `SUPABASE_URL` di `.env` diisi dengan host Supabase (mis. `https://ejxrzekncqjgkpclools.supabase.co`).
- Jika muncul error saat upload: "cURL error 6: Could not resolve host: storage" → artinya aplikasi mengirim request ke path `/storage/v1/...` tanpa host. Periksa `SUPABASE_URL`, jalankan `php artisan config:clear` dan `php artisan cache:clear` lalu coba lagi.
- Di development kami menonaktifkan verifikasi SSL sementara (`verify => false`) untuk memudahkan debug. Jangan gunakan ini di production; gunakan CA certificate yang valid.

## Struktur Singkat (file/folder penting)
- `app/Services/SupabaseStorageService.php` — service untuk upload ke Supabase
- `app/Http/Controllers/User/ArtworkController.php` — controller upload dan list karya pengguna
- `app/Models/Artwork.php`, `Category.php`, `Comment.php`, `Like.php`, `ActivityLog.php` — model data utama
- `resources/views/pages` — tampilan: profile, exploration, detail, admin pages
- `config/filesystems.php` — konfigurasi disk Supabase (endpoint pada `disks.supabase.endpoint`)

## Cara Kerja Upload (ringkas)
- UI mengirim file ke `ArtworkController::store()`
- Controller memanggil `SupabaseStorageService::upload()` yang membangun URL upload `{$SUPABASE_URL}/storage/v1/object/{bucket}/{path}` dan mengirim POST dengan body file
- Setelah sukses, Service mengembalikan public URL `{$SUPABASE_URL}/storage/v1/object/public/{bucket}/{path}` yang disimpan ke database dan ditampilkan di view

## Tips Debug cepat
- Pastikan `.env` berisi `SUPABASE_URL` dan `SUPABASE_SERVICE_ROLE_KEY`.
- Hapus cache konfigurasi bila mengganti `.env` di server:

```powershell
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

- Periksa `storage/logs/laravel.log` untuk baris log yang memuat `Supabase upload URL:` (sudah ditambahkan di service) — itu akan menunjukkan URL yang dipakai untuk upload.

## Contribution
- Fork → branch → commit → PR. Ikuti PSR-12.

## Lisensi
- MIT

---
