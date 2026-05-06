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
        Schema::table('izin_pelaksanaankegiatans', function (Blueprint $table) {
            $table->text('catatan_pelaksanaan')->nullable()->after('buktipelaksanaan_kegiatan');
            $table->text('hambatan_pelaksanaan')->nullable()->after('catatan_pelaksanaan');
            $table->text('solusi_hambatan_pelaksanaan')->nullable()->after('hambatan_pelaksanaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_pelaksanaankegiatans', function (Blueprint $table) {
            $table->dropColumn([
                'catatan_pelaksanaan',
                'hambatan_pelaksanaan',
                'solusi_hambatan_pelaksanaan',
            ]);
        });
    }
};
