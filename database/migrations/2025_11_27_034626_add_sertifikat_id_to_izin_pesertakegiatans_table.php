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
            if (!Schema::hasColumn('izin_pesertakegiatans', 'sertifikat_id')) {
                $table->unsignedBigInteger('sertifikat_id')->nullable()->after('subunitkerja_id_peserta');
                $table->foreign('sertifikat_id')->references('id')->on('izin_sertifikats')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_pesertakegiatans', function (Blueprint $table) {
            if (Schema::hasColumn('izin_pesertakegiatans', 'sertifikat_id')) {
                $table->dropColumn('sertifikat_id');
            }
        });
    }
};
