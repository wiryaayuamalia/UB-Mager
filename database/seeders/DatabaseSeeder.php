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

    }
}
