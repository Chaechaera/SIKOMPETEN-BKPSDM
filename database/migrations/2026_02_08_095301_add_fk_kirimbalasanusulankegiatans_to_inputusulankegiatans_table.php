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
        Schema::table('izin_inputusulankegiatans', function (Blueprint $table) {
            $table->foreign('kirimbalasanusulankegiatan_id')
                ->references('id')
                ->on('izin_kirimbalasanusulankegiatans')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_inputusulankegiatans', function (Blueprint $table) {
            $table->dropForeign([
                'kirimbalasanusulankegiatan_id'
            ]);
        });
    }
};
