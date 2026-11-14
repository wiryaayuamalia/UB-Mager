# Catatan penyesuaian UI & backend UB Mager

Project dasar: `ub-mager.zip`  
Referensi visual: `Archive 2.zip`

## Penyesuaian utama

- Sistem layout global diperbarui dengan identitas visual UB Mager (maroon, cream, dan gold), navigasi responsif, tipografi, komponen kartu, tabel, status, dan notifikasi.
- Halaman katalog utama disusun ulang mengikuti hero, pencarian/filter terpadu, kategori cepat, tab barang, dan kartu produk.
- Registrasi ditambah persetujuan syarat transaksi; profil mahasiswa mendukung NIM, fakultas, program studi, angkatan, WhatsApp, domisili, titik COD favorit, dan foto profil.
- Form pengajuan penjual memuat spesialisasi toko, dokumen KTM/KTP, koordinat, dan komitmen penjual.
- Admin mendapat controller verifikasi pengajuan (termasuk penyimpanan keputusan dan pembuatan akun penjual), moderasi katalog, kategori, serta rentang harga.
- Dashboard penjual diperluas dengan inventaris, edit katalog, arsip, ekspor CSV, titik COD favorit, pratinjau lapak, pesanan masuk, dan inbox chat.
- Katalog mendukung maksimal enam foto, nego, dan antrean review setelah perubahan.
- Chat pembeli–penjual memakai tabel `pesan` yang sudah tersedia.
- Alur pesanan diperketat dengan pemeriksaan status dan kepemilikan transaksi.
- Konfigurasi autentikasi diarahkan ke model `Pengguna`; `.env` lokal tidak disertakan agar kredensial lokal tidak ikut terdistribusi.

## Validasi yang dijalankan

- `php -l` untuk source PHP aplikasi, route, dan migration.
- Kompilasi seluruh template Blade menggunakan BladeCompiler.
- Pemeriksaan seluruh nama route yang dipakai oleh Blade terhadap route terdaftar.

Tes integrasi database dan PHPUnit belum dapat dijalankan di lingkungan penyuntingan ini karena ekstensi PHP `pdo_sqlite`/`pdo_mysql`, `dom`, `mbstring`, dan `xmlwriter` tidak tersedia. Jalankan migrasi dan tes pada lingkungan PHP lokal yang memiliki ekstensi tersebut.
