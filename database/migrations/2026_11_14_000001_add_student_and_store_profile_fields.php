<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            if (!Schema::hasColumn('pengguna', 'nim')) $table->string('nim', 30)->nullable()->after('no_hp');
            if (!Schema::hasColumn('pengguna', 'fakultas')) $table->string('fakultas', 120)->nullable()->after('nim');
            if (!Schema::hasColumn('pengguna', 'program_studi')) $table->string('program_studi', 120)->nullable()->after('fakultas');
            if (!Schema::hasColumn('pengguna', 'angkatan')) $table->string('angkatan', 4)->nullable()->after('program_studi');
            if (!Schema::hasColumn('pengguna', 'titik_cod_favorit')) $table->string('titik_cod_favorit', 150)->nullable()->after('alamat');
        });
        Schema::table('penjual', function (Blueprint $table) {
            if (!Schema::hasColumn('penjual', 'kategori_spesialisasi')) $table->string('kategori_spesialisasi', 100)->nullable();
            if (!Schema::hasColumn('penjual', 'titik_cod_favorit')) $table->string('titik_cod_favorit', 150)->nullable();
        });
        Schema::table('pengajuan_penjual', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuan_penjual', 'kategori_spesialisasi')) $table->string('kategori_spesialisasi', 100)->nullable();
            if (!Schema::hasColumn('pengajuan_penjual', 'komitmen_disetujui')) $table->boolean('komitmen_disetujui')->default(false);
        });
        Schema::table('katalog', function (Blueprint $table) {
            if (!Schema::hasColumn('katalog', 'bisa_nego')) $table->boolean('bisa_nego')->default(false);
        });
    }

    public function down(): void
    {
        foreach (['pengguna' => ['nim','fakultas','program_studi','angkatan','titik_cod_favorit'], 'penjual' => ['kategori_spesialisasi','titik_cod_favorit'], 'pengajuan_penjual' => ['kategori_spesialisasi','komitmen_disetujui'], 'katalog' => ['bisa_nego']] as $table => $columns) {
            Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                foreach ($columns as $column) if (Schema::hasColumn($table, $column)) $blueprint->dropColumn($column);
            });
        }
    }
};
