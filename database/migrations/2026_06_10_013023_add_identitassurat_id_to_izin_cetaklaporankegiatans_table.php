<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('izin_cetaklaporankegiatans', function (Blueprint $table) {
    $table->foreignId('identitassurat_id')
          ->nullable()
          ->after('inputlaporankegiatan_id')
          ->constrained('izin_identitassurats')
          ->nullOnDelete();
});
}

public function down()
{
    Schema::table('izin_cetaklaporankegiatans', function ($table) {
        $table->dropForeign(['identitassurat_id']);
        $table->dropColumn('identitassurat_id');
    });
}
};
