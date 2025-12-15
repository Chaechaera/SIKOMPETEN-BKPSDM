<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('izin_pesertakegiatans', function (Blueprint $table) {
            if (!Schema::hasColumn('izin_pesertakegiatans', 'nomorsertifikatpeserta_kegiatan')) {
                $table->string('nomorsertifikatpeserta_kegiatan')->nullable()->after('subunitkerja_id_peserta');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_pesertakegiatans', function (Blueprint $table) {
            if (Schema::hasColumn('izin_pesertakegiatans', 'nomorsertifikatpeserta_kegiatan')) {
                $table->dropColumn('nomorsertifikatpeserta_kegiatan');
            }
        });
    }
};
