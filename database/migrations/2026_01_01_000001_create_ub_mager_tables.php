<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $t) {
            $t->id('id_pengguna');
            $t->string('nama', 100);
            $t->string('email', 100)->nullable()->unique();
            $t->string('no_hp', 15)->nullable()->unique();
            $t->string('password_hash');
            $t->string('foto')->nullable();
            $t->text('alamat')->nullable();
            $t->enum('role', ['pengguna', 'penjual', 'admin'])->default('pengguna');
            $t->enum('status_verifikasi', ['belum', 'terverifikasi'])->default('belum');
            $t->enum('status_akun', ['aktif', 'nonaktif', 'suspend'])->default('aktif');
            $t->dateTime('created_at')->useCurrent();
        });

        Schema::create('penjual', function (Blueprint $t) {
            $t->id('id_penjual');
            $t->foreignId('id_pengguna')->unique()->constrained('pengguna', 'id_pengguna');
            $t->string('nama_toko', 100);
            $t->string('lokasi_toko');
            $t->decimal('latitude', 10, 8);
            $t->decimal('longitude', 11, 8);
            $t->decimal('saldo', 12, 2)->default(0);
            $t->decimal('rating_rata_rata', 2, 1)->default(0);
            $t->enum('status_toko', ['aktif', 'nonaktif'])->default('aktif');
        });

        Schema::create('admin', function (Blueprint $t) {
            $t->id('id_admin');
            $t->foreignId('id_pengguna')->unique()->constrained('pengguna', 'id_pengguna');
            $t->string('level_akses', 30);
        });

        Schema::create('otp', function (Blueprint $t) {
            $t->id('id_otp');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->string('kode_otp', 6);
            $t->dateTime('waktu_kirim');
            $t->dateTime('waktu_kadaluarsa');
            $t->tinyInteger('jumlah_percobaan')->default(0);
            $t->enum('status', ['aktif', 'terpakai', 'kadaluarsa'])->default('aktif');
        });

        Schema::create('pengajuan_penjual', function (Blueprint $t) {
            $t->id('id_pengajuan');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_admin')->nullable()->constrained('admin', 'id_admin');
            $t->string('nama_toko', 100);
            $t->enum('jenis_dokumen', ['KTP', 'KTM']);
            $t->string('dokumen_identitas');
            $t->string('lokasi_toko');
            $t->decimal('latitude', 10, 8);
            $t->decimal('longitude', 11, 8);
            $t->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $t->text('alasan_penolakan')->nullable();
            $t->dateTime('tanggal_pengajuan');
        });

        Schema::create('kategori', function (Blueprint $t) {
            $t->id('id_kategori');
            $t->string('nama_kategori', 50)->unique();
        });

        Schema::create('rentang_harga', function (Blueprint $t) {
            $t->id('id_rentang');
            $t->string('label', 50);
            $t->decimal('harga_min', 12, 2);
            $t->decimal('harga_maks', 12, 2);
        });

        Schema::create('katalog', function (Blueprint $t) {
            $t->id('id_katalog');
            $t->foreignId('id_penjual')->constrained('penjual', 'id_penjual');
            $t->foreignId('id_kategori')->constrained('kategori', 'id_kategori');
            $t->string('nama_barang', 150);
            $t->text('deskripsi');
            $t->decimal('harga', 12, 2);
            $t->string('kondisi', 50);
            $t->string('lokasi', 100);
            $t->integer('stok')->default(1);
            $t->enum('status_katalog', ['menunggu pemeriksaan', 'aktif', 'nonaktif'])->default('menunggu pemeriksaan');
            $t->enum('status_kelengkapan', ['lengkap', 'tidak lengkap'])->default('tidak lengkap');
            $t->dateTime('created_at')->useCurrent();
        });

        Schema::create('foto_katalog', function (Blueprint $t) {
            $t->id('id_foto');
            $t->foreignId('id_katalog')->constrained('katalog', 'id_katalog')->cascadeOnDelete();
            $t->string('path_foto');
            $t->tinyInteger('urutan')->default(1);
        });

        Schema::create('keranjang', function (Blueprint $t) {
            $t->id('id_keranjang');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_katalog')->constrained('katalog', 'id_katalog');
            $t->dateTime('tanggal_ditambahkan');
            $t->unique(['id_pengguna', 'id_katalog']);
        });

        Schema::create('notifikasi', function (Blueprint $t) {
            $t->id('id_notifikasi');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->string('judul', 100);
            $t->text('isi');
            $t->string('jenis', 30);
            $t->dateTime('waktu');
            $t->boolean('sudah_dibaca')->default(false);
        });

        Schema::create('pesanan', function (Blueprint $t) {
            $t->id('id_pesanan');
            $t->foreignId('id_pembeli')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_penjual')->constrained('penjual', 'id_penjual');
            $t->foreignId('id_katalog')->constrained('katalog', 'id_katalog');
            $t->string('alamat_pengiriman');
            $t->enum('metode_pengiriman', ['kurir instan', 'cod']);
            $t->enum('metode_pembayaran', ['transfer', 'e-wallet', 'tunai cod']);
            $t->decimal('harga_barang', 12, 2);
            $t->decimal('ongkir', 12, 2)->default(0);
            $t->decimal('total_bayar', 12, 2);
            $t->enum('status_pesanan', ['menunggu pembayaran', 'dikonfirmasi', 'disiapkan', 'dikirim', 'selesai', 'ditolak', 'dibatalkan'])->default('menunggu pembayaran');
            $t->text('alasan_penolakan')->nullable();
            $t->dateTime('batas_bayar')->nullable();
            $t->dateTime('tanggal_pesanan');
        });

        Schema::create('pembayaran', function (Blueprint $t) {
            $t->id('id_pembayaran');
            $t->foreignId('id_pesanan')->unique()->constrained('pesanan', 'id_pesanan');
            $t->string('metode', 30);
            $t->decimal('jumlah', 12, 2);
            $t->enum('status_pembayaran', ['menunggu', 'terverifikasi', 'escrow', 'dicairkan', 'refund', 'dibatalkan'])->default('menunggu');
            $t->string('bukti_pembayaran')->nullable();
            $t->dateTime('waktu_bayar')->nullable();
            $t->dateTime('waktu_pencairan')->nullable();
        });

        Schema::create('pengiriman', function (Blueprint $t) {
            $t->id('id_pengiriman');
            $t->foreignId('id_pesanan')->unique()->constrained('pesanan', 'id_pesanan');
            $t->string('mitra_kurir', 30);
            $t->string('alamat_jemput');
            $t->string('alamat_antar');
            $t->enum('status_pengiriman', ['menunggu pickup', 'dikirim', 'diterima'])->default('menunggu pickup');
            $t->dateTime('waktu_pickup')->nullable();
            $t->dateTime('waktu_diterima')->nullable();
        });

        Schema::create('ulasan', function (Blueprint $t) {
            $t->id('id_ulasan');
            $t->foreignId('id_pesanan')->unique()->constrained('pesanan', 'id_pesanan');
            $t->tinyInteger('rating');
            $t->text('komentar')->nullable();
            $t->dateTime('tanggal_ulasan');
        });

        Schema::create('komplain', function (Blueprint $t) {
            $t->id('id_komplain');
            $t->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan');
            $t->foreignId('id_admin')->nullable()->constrained('admin', 'id_admin');
            $t->text('deskripsi');
            $t->string('bukti_foto');
            $t->enum('status_komplain', ['diajukan', 'diproses', 'selesai'])->default('diajukan');
            $t->enum('keputusan', ['hold', 'refund', 'dicairkan ke penjual'])->nullable();
            $t->dateTime('tanggal_komplain');
        });

        Schema::create('pesan', function (Blueprint $t) {
            $t->id('id_pesan');
            $t->foreignId('id_katalog')->constrained('katalog', 'id_katalog');
            $t->foreignId('id_pengirim')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_penerima')->constrained('pengguna', 'id_pengguna');
            $t->text('isi_pesan');
            $t->dateTime('waktu_kirim');
            $t->boolean('sudah_dibaca')->default(false);
        });

        // CHECK constraint (MySQL 8+ / MariaDB 10.2+)
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            DB::statement('ALTER TABLE otp ADD CONSTRAINT chk_otp_percobaan CHECK (jumlah_percobaan <= 3)');
            DB::statement('ALTER TABLE ulasan ADD CONSTRAINT chk_ulasan_rating CHECK (rating BETWEEN 1 AND 5)');
            DB::statement('ALTER TABLE katalog ADD CONSTRAINT chk_katalog_harga CHECK (harga > 0)');
            DB::statement('ALTER TABLE pesanan ADD CONSTRAINT chk_pesanan_total CHECK (total_bayar = harga_barang + ongkir)');
            DB::statement('ALTER TABLE rentang_harga ADD CONSTRAINT chk_harga_maks CHECK (harga_maks >= harga_min)');
        }
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        foreach (['pesan','komplain','ulasan','pengiriman','pembayaran','pesanan','notifikasi','keranjang','foto_katalog','katalog','rentang_harga','kategori','pengajuan_penjual','otp','admin','penjual','pengguna'] as $t) {
            Schema::dropIfExists($t);
        }
        Schema::enableForeignKeyConstraints();
    }
};
