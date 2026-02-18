<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Run the migrations.
         */
        Schema::table('izin_inputlaporankegiatans', function (Blueprint $table) {
            $table->foreign('kirimbalasanlaporankegiatan_id', 'kirimbalasanlaporankegiatan_id')
                ->references('id')
                ->on('izin_kirimbalasanlaporankegiatans')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_inputlaporankegiatans', function (Blueprint $table) {
            try {
                $table->dropForeign('kirimbalasanlaporankegiatan_id');
            } catch (\Exception $e) {
                // 
            }
        });
    }
};
