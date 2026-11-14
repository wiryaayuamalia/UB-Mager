# UB Mager

Marketplace preloved mahasiswa untuk area Malang–Batu. Aplikasi menggunakan Laravel 12, Blade, Tailwind CSS CDN, dan database relasional.

## Menjalankan dengan MySQL (XAMPP)

Persyaratan: PHP 8.2+, Composer, XAMPP/MySQL, serta ekstensi PHP `pdo_mysql`, `fileinfo`, `mbstring`, `dom`, `xml`, `ctype`, `tokenizer`, dan `openssl`.

1. Jalankan Apache dan MySQL dari XAMPP.
2. Buka `http://localhost/phpmyadmin`.
3. Buat database baru bernama `ub_mager` dengan collation `utf8mb4_unicode_ci`.
4. Buka terminal pada folder project `ub-mager`.
5. Jalankan perintah berikut:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan config:clear
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Pada Windows CMD, gunakan `copy .env.example .env` sebagai pengganti perintah `cp`.

Konfigurasi MySQL default pada `.env.example`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ub_mager
DB_USERNAME=root
DB_PASSWORD=
```

Jika MySQL memakai password atau port berbeda, sesuaikan nilai tersebut di file `.env`. Buka aplikasi di `http://127.0.0.1:8000`.

## Akun demo

Semua akun demo memakai password `password`:
- Admin: `admin@ubmager.test`
- Penjual: `penjual@ubmager.test`
- Pembeli: `pembeli@ubmager.test`

## Fitur yang tersedia

- Registrasi email/nomor HP, OTP, login, logout, dan profil mahasiswa.
- Katalog publik, pencarian, kategori, filter lokasi/harga, detail barang, dan keranjang.
- Checkout COD/kurir, unggah bukti pembayaran, daftar pesanan, dan konfirmasi barang diterima.
- Pengajuan penjual dengan dokumen identitas dan koordinat; admin dapat menyetujui/menolak.
- Dashboard penjual, CRUD katalog, moderasi status, pratinjau lapak, pesanan masuk, dan chat.
- Panel admin untuk verifikasi penjual, moderasi katalog, kategori, dan rentang harga.

## Catatan integrasi

- Mode email bawaan menggunakan `MAIL_MAILER=log`; kode OTP email ditulis ke `storage/logs/laravel.log`. Integrasi SMS/WhatsApp gateway belum dikonfigurasi.
- Alur unggah bukti pembayaran merupakan simulasi prototipe escrow. Hubungkan payment gateway dan proses verifikasi pembayaran sungguhan sebelum aplikasi dipakai untuk transaksi uang nyata.
- Peta koordinat menyimpan latitude/longitude dan menyediakan tautan Google Maps; belum ada integrasi geocoding atau peta interaktif.
