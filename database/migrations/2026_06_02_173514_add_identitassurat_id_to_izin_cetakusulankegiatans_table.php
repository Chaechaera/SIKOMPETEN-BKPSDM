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
        Schema::table('izin_cetakusulankegiatans', function (Blueprint $table) {
            $table->foreignId('identitassurat_id')
                ->nullable()
                ->after('inputusulankegiatan_id')
                ->constrained('izin_identitassurats')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('izin_cetakusulankegiatans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('identitassurat_id');
        });
    }
};
