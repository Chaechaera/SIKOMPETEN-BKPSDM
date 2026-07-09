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
        Schema::table('izin_kirimbalasanusulankegiatans', function (Blueprint $table) {
            $table->string('filepdfgenerate_path')->nullable()->after('tanggalcetak_balasanusulankegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_kirimbalasanusulankegiatans', function (Blueprint $table) {
            $table->dropColumn('filepdfgenerate_path');
        });
    }
};
