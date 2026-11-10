# UB Mager – Kode Laravel (overlay)

Folder ini BUKAN project Laravel utuh, tapi file-file yang ditimpa/ditambahkan ke project Laravel 11/12 yang baru dibuat.

## Langkah
1. composer create-project laravel/laravel ub-mager
2. Salin isi folder ini ke dalam folder ub-mager (timpa bootstrap/app.php, routes/console.php, database/seeders/DatabaseSeeder.php)
3. Edit .env:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ub_mager
   DB_USERNAME=root
   DB_PASSWORD=
   AUTH_MODEL=App\Models\Pengguna
   MAIL_MAILER=log
4. Buat database `ub_mager` di MySQL (phpMyAdmin / HeidiSQL)
5. php artisan migrate --seed
6. php artisan storage:link
7. php artisan serve        -> http://127.0.0.1:8000
8. (opsional) php artisan schedule:work   -> auto-batal pesanan >10 menit

## Akun demo (password: password)
admin@ubmager.test, penjual@ubmager.test, pembeli@ubmager.test
