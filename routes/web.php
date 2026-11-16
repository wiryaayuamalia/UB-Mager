<?php

use App\Http\Controllers\{AuthController, ProfilController, PengaturanController, KatalogController, KeranjangController, CheckoutController,
    PaymentController, OrderProcessingController, PesananController, PengajuanPenjualController};
use App\Http\Controllers\Admin\{PengajuanController, KatalogController as AdminKatalogController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotifikasiController;

Route::get('/', fn() => redirect()->route('katalog.index'));

// ---- Publik ----
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{katalog}', [KatalogController::class, 'show'])->whereNumber('katalog')->name('katalog.show');

// ---- Auth ----
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::get('/otp', [AuthController::class, 'showOtp'])->name('otp.form');
Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/kirim-ulang', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---- Pengguna / Pembeli ----
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');

        // Pengaturan Akun
    Route::get('/pengaturan-akun', [PengaturanController::class, 'index'])
        ->name('pengaturan.index');

    Route::post('/pengaturan-akun/notifikasi', [PengaturanController::class, 'updateNotifikasi'])
        ->name('pengaturan.notifikasi');

    Route::post('/pengaturan-akun/privasi', [PengaturanController::class, 'updatePrivasi'])
        ->name('pengaturan.privasi');

    Route::post('/pengaturan-akun/password', [PengaturanController::class, 'updatePassword'])
        ->name('pengaturan.password');
    
        // NOTIFIKASI
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])
        ->name('notifikasi.index');

    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'baca'])
        ->whereNumber('id')
        ->name('notifikasi.baca');

    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'bacaSemua'])
        ->name('notifikasi.baca-semua');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{katalog}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::get('/checkout/{katalog}', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout/{katalog}', [CheckoutController::class, 'proses'])->name('checkout.proses');

    Route::get('/bayar/{pesanan}', [PaymentController::class, 'form'])->name('bayar.form');
    Route::post('/bayar/{pesanan}', [PaymentController::class, 'upload'])->name('bayar.upload');
    Route::post('/pesanan/{pesanan}/terima', [PaymentController::class, 'konfirmasiTerima'])->name('pesanan.terima');
    Route::get('/pesanan-saya', [PesananController::class, 'saya'])->name('pesanan.saya');

    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])
        ->name('chat.index');

    Route::get('/chat/{katalog}', [\App\Http\Controllers\ChatController::class, 'show'])
        ->name('chat.show');

    Route::post('/chat/{katalog}', [\App\Http\Controllers\ChatController::class, 'send'])
        ->name('chat.send');

    Route::get('/jadi-penjual', [PengajuanPenjualController::class, 'form'])->name('pengajuan.form');
    Route::post('/jadi-penjual', [PengajuanPenjualController::class, 'store'])->name('pengajuan.store');
});

// ---- Penjual ----
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PesananController::class, 'dashboardPenjual'])->name('dashboard');
    Route::get('/katalog/baru', [KatalogController::class, 'create'])->name('katalog.create');
    Route::get('/katalog/export', [KatalogController::class, 'export'])->name('katalog.export');
    Route::post('/titik-cod', [PesananController::class, 'updateTitikCod'])->name('titik-cod.update');
    Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');
    Route::get('/katalog/{katalog}/edit', [KatalogController::class, 'edit'])->name('katalog.edit');
    Route::put('/katalog/{katalog}', [KatalogController::class, 'update'])->name('katalog.update');
    Route::delete('/katalog/{katalog}', [KatalogController::class, 'destroy'])->name('katalog.destroy');
    Route::get('/pratinjau', [KatalogController::class, 'preview'])->name('preview');

    Route::get('/pesanan', [OrderProcessingController::class, 'masuk'])->name('pesanan');
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'inbox'])->name('chat');
    Route::post('/pesanan/{pesanan}/setuju', [OrderProcessingController::class, 'setuju'])->name('pesanan.setuju');
    Route::post('/pesanan/{pesanan}/tolak', [OrderProcessingController::class, 'tolak'])->name('pesanan.tolak');
    Route::post('/pesanan/{pesanan}/pengiriman', [OrderProcessingController::class, 'statusPengiriman'])->name('pesanan.pengiriman');
});

// ---- Admin ----
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/{pengajuan}/dokumen', [PengajuanController::class, 'dokumen'])->name('pengajuan.dokumen');
    Route::post('/pengajuan/{pengajuan}/setujui', [PengajuanController::class, 'setujui'])->name('pengajuan.setujui');
    Route::post('/pengajuan/{pengajuan}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');

    Route::get('/katalog', [AdminKatalogController::class, 'index'])->name('katalog.index');
    Route::post('/katalog/{katalog}/periksa', [AdminKatalogController::class, 'periksa'])->name('katalog.periksa');
    Route::post('/kategori', [AdminKatalogController::class, 'tambahKategori'])->name('kategori.store');
    Route::delete('/kategori/{kategori}', [AdminKatalogController::class, 'hapusKategori'])->name('kategori.destroy');
    Route::put('/rentang-harga/{rentang}', [AdminKatalogController::class, 'rentangHarga'])->name('rentang.update');
});
