# BOBO Klinik & Pet Shop (Laravel)

Versi **Laravel 12** dari website homepage dan sistem basis data administrasi klinik hewan, dibuat berdasarkan nota administrasi asli sebuah klinik hewan di Kota Wisata, Cibubur.

> **Catatan:** Proyek ini dibuat untuk portofolio. Semua data di dalamnya (pemilik, hewan, dokter, nota) adalah **data fiktif**.

## Fitur

- **Homepage**: profil klinik, layanan, hewan yang dilayani, kontak dan lokasi
- **Login**: autentikasi bawaan Laravel (sesi dan CSRF)
- **Dashboard**: nota dan pendapatan bulan ini, total pemilik dan hewan, pendapatan per layanan, nota terakhir
- **CRUD**: Nota (rincian dinamis, total otomatis), Pemilik, Hewan, Layanan, Dokter
- **Cetak**: nota siap cetak dengan terbilang otomatis, dan laporan nota per periode

## Teknologi

Laravel 12, PHP 8.2+, MySQL/MariaDB (XAMPP), Blade, Eloquent ORM, migrasi dan seeder.

## Cara Menjalankan (XAMPP)

Prasyarat: PHP 8.2 atau lebih baru dan [Composer](https://getcomposer.org/).

1. Jalankan **MySQL** di XAMPP, lalu buat database kosong `bobo_klinik` lewat phpMyAdmin.
2. Di folder proyek, jalankan:
   ```bash
   composer install
   copy .env.example .env      # Linux/Mac: cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
   ```
3. Buka `http://127.0.0.1:8000`, klik **Basis Data**, lalu login.

### Akun Demo

| Username | Password |
|---|---|
| `admin` | `admin123` |

Pengaturan database ada di `.env` (bawaan XAMPP: user `root`, tanpa password).

## Struktur Basis Data

`users`, `pemilik`, `hewan`, `dokter`, `layanan`, `nota`, `nota_detail`.
Relasi: `pemilik` → `hewan` → `nota` → `nota_detail` → `layanan`, dan `nota` → `dokter`.

## Struktur Utama

```
app/Http/Controllers/   Auth, Dashboard, Crud, Nota, Cetak
app/Models/             User, Pemilik, Hewan, Dokter, Layanan, Nota, NotaDetail
app/Support/Format.php  format rupiah, tanggal, terbilang
database/migrations/    skema tabel
database/seeders/       akun admin, layanan, data contoh
resources/views/        home, login, dashboard, crud, nota, cetak
routes/web.php
```

## Keamanan

Eloquent/query builder (anti SQL injection), output Blade ter-escape (anti XSS), token CSRF di semua form, password di-hash (bcrypt). Aplikasi ini ditujukan untuk demo lokal; ganti password akun demo sebelum dipakai di server sungguhan.
