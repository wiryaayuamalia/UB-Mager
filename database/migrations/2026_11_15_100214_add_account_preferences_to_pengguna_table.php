
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->json('preferensi_notifikasi')->nullable();
            $table->json('preferensi_privasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn([
                'preferensi_notifikasi',
                'preferensi_privasi',
            ]);
        });
    }
};
