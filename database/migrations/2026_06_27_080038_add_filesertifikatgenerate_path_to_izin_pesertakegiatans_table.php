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
            $table->string('filesertifikatgenerate_path')->nullable()->after('nomorsertifikatpeserta_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_pesertakegiatans', function (Blueprint $table) {
            $table->dropColumn('filesertifikatgenerate_path');
        });
    }
};
