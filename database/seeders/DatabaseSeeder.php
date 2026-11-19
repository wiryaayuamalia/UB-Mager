<?php

namespace Database\Seeders;

use App\Models\{Pengguna, Admin, Penjual, Kategori, RentangHarga};
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
        $rentangHarga = [
            ['label' => '< Rp50.000', 'harga_min' => 0, 'harga_maks' => 50000],
            ['label' => 'Rp50.000 - Rp150.000', 'harga_min' => 50000, 'harga_maks' => 150000],
            ['label' => '> Rp150.000', 'harga_min' => 150000, 'harga_maks' => 99999999],
        ];

        foreach ($rentangHarga as $data) {
            RentangHarga::firstOrCreate(['label' => $data['label']], $data);
        }

        $adminU = Pengguna::firstOrCreate(
            ['email' => 'admin@ubmager.test'],
            [
                'nama' => 'Admin',
                'password_hash' => Hash::make('password'),
                'role' => 'admin',
                'status_verifikasi' => 'terverifikasi',
            ]
        );

        Admin::firstOrCreate(
            ['id_pengguna' => $adminU->id_pengguna],
            ['level_akses' => 'super']
        );

        $penjualU = Pengguna::firstOrCreate(
            ['email' => 'penjual@ubmager.test'],
            [
                'nama' => 'Penjual',
                'password_hash' => Hash::make('password'),
                'role' => 'penjual',
                'status_verifikasi' => 'terverifikasi',
            ]
        );

        Penjual::firstOrCreate(
            ['id_pengguna' => $penjualU->id_pengguna],
            [
                'nama_toko' => 'Lapak Dimas',
                'lokasi_toko' => 'Dekat Gerbang Veteran UB',
                'latitude' => -7.9525,
                'longitude' => 112.6141,
                'rating_rata_rata' => 4.9,
            ]
        );

        Pengguna::firstOrCreate(
            ['email' => 'pembeli@ubmager.test'],
            [
                'nama' => 'Wirya Ayu',
                'password_hash' => Hash::make('password'),
                'status_verifikasi' => 'terverifikasi',
                'alamat' => 'Jl. Veteran No. 1, Malang',
            ]
        );

    }
}
