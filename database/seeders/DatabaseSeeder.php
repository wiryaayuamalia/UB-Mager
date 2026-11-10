<?php

namespace Database\Seeders;

use App\Models\{Pengguna, Admin, Penjual, Kategori, RentangHarga, Katalog};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Buku', 'Kemeja & Batik', 'Peralatan Masak', 'Laptop & Aksesori', 'Tablet & Aksesoris',
                  'Alat Tulis', 'Meja & Kursi Belajar', 'Headset & Speaker', 'Alat Lab', 'Lemari & Rak',
                  'Kasur & Bantal', 'Alat Olahraga'] as $n) {
            Kategori::firstOrCreate(['nama_kategori' => $n]);
        }
        RentangHarga::insert([
            ['label' => '< Rp50.000', 'harga_min' => 0, 'harga_maks' => 50000],
            ['label' => 'Rp50.000 - Rp150.000', 'harga_min' => 50000, 'harga_maks' => 150000],
            ['label' => '> Rp150.000', 'harga_min' => 150000, 'harga_maks' => 99999999],
        ]);

        $adminU = Pengguna::create(['nama' => 'Reya Admin', 'email' => 'admin@ubmager.test', 'password_hash' => Hash::make('password'),
            'role' => 'admin', 'status_verifikasi' => 'terverifikasi']);
        Admin::create(['id_pengguna' => $adminU->id_pengguna, 'level_akses' => 'super']);

        $penjualU = Pengguna::create(['nama' => 'Dimas N.', 'email' => 'penjual@ubmager.test', 'password_hash' => Hash::make('password'),
            'role' => 'penjual', 'status_verifikasi' => 'terverifikasi']);
        $penjual = Penjual::create(['id_pengguna' => $penjualU->id_pengguna, 'nama_toko' => 'Lapak Dimas',
            'lokasi_toko' => 'Dekat Gerbang Veteran UB', 'latitude' => -7.9525, 'longitude' => 112.6141, 'rating_rata_rata' => 4.9]);

        Pengguna::create(['nama' => 'Wirya Ayu', 'email' => 'pembeli@ubmager.test', 'password_hash' => Hash::make('password'),
            'status_verifikasi' => 'terverifikasi', 'alamat' => 'Jl. Veteran No. 1, Malang']);

        $sample = [
            ['Buku Pengantar Ilmu Hukum Edisi Terbaru', 1, 45000, 'Seperti Baru', 'Dekat Gerbang Veteran UB'],
            ['Jaket Varsity Thrift Vintage - Size L', 2, 120000, 'Mulus 90%', 'Jl. Soekarno-Hatta (Suhat)'],
            ['Rice Cooker Mini Miyako 0.6L Anak Kos', 3, 95000, 'Seperti Baru', 'Sigura-gura'],
            ['Kalkulator Scientific Casio fx-991EX', 6, 160000, 'Mulus 90%', 'Fakultas Teknik UB'],
            ['Meja Lipat Belajar Lesehan Kayu', 7, 35000, 'Pemakaian Wajar', 'Dinoyo'],
            ['Helm Bogo Retro Coklat Mulus', 12, 85000, 'Mulus 90%', 'Sigura-gura'],
            ['Modul & Diktat Praktikum Pemrograman Java', 1, 25000, 'Seperti Baru', 'Gedung FILKOM UB'],
            ['Lampu Meja Belajar LED USB Rechargeable', 7, 40000, 'Mulus 90%', 'Dinoyo'],
        ];
        foreach ($sample as [$nama, $kat, $harga, $kondisi, $lokasi]) {
            Katalog::create([
                'id_penjual' => $penjual->id_penjual, 'id_kategori' => $kat, 'nama_barang' => $nama,
                'deskripsi' => 'Barang preloved kondisi terawat, bisa COD di area kampus.',
                'harga' => $harga, 'kondisi' => $kondisi, 'lokasi' => $lokasi, 'stok' => 1,
                'status_katalog' => 'aktif', 'status_kelengkapan' => 'lengkap',
            ]);
        }
    }
}
