<?php

use App\Http\Controllers\{AuthController, ProfilController, KatalogController, KeranjangController, CheckoutController,
    PaymentController, OrderProcessingController, PesananController, PengajuanPenjualController};
use App\Http\Controllers\Admin\{PengajuanController, KatalogController as AdminKatalogController};
use Illuminate\Support\Facades\Route;

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

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{katalog}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::get('/checkout/{katalog}', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout/{katalog}', [CheckoutController::class, 'proses'])->name('checkout.proses');

    Route::get('/bayar/{pesanan}', [PaymentController::class, 'form'])->name('bayar.form');
    Route::post('/bayar/{pesanan}', [PaymentController::class, 'upload'])->name('bayar.upload');
    Route::post('/pesanan/{pesanan}/terima', [PaymentController::class, 'konfirmasiTerima'])->name('pesanan.terima');
    Route::get('/pesanan-saya', [PesananController::class, 'saya'])->name('pesanan.saya');

    Route::get('/jadi-penjual', [PengajuanPenjualController::class, 'form'])->name('pengajuan.form');
    Route::post('/jadi-penjual', [PengajuanPenjualController::class, 'store'])->name('pengajuan.store');
});

// ---- Penjual ----
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PesananController::class, 'dashboardPenjual'])->name('dashboard');
    Route::get('/katalog/baru', [KatalogController::class, 'create'])->name('katalog.create');
    Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');
    Route::delete('/katalog/{katalog}', [KatalogController::class, 'destroy'])->name('katalog.destroy');

    Route::get('/pesanan', [OrderProcessingController::class, 'masuk'])->name('pesanan');
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
});
