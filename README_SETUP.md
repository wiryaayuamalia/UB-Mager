# UB Mager — Setup MySQL

Project ini menggunakan MySQL sebagai database default.

1. Jalankan Apache dan MySQL dari XAMPP.
2. Buat database `ub_mager` di phpMyAdmin dengan collation `utf8mb4_unicode_ci`.
3. Dari terminal pada folder project, jalankan:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan config:clear
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Pada Windows CMD, gunakan `copy .env.example .env`. Konfigurasi default: host `127.0.0.1`, port `3306`, database `ub_mager`, username `root`, password kosong. Sesuaikan file `.env` jika instalasi MySQL berbeda.

Akun demo: `admin@ubmager.test`, `penjual@ubmager.test`, `pembeli@ubmager.test` — password `password`.

OTP email masih menggunakan mode log development. SMS/WhatsApp gateway dan payment gateway belum terhubung ke provider eksternal.
