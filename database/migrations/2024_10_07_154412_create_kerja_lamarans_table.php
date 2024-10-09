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
        Schema::create('kerja_lamarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_lamaran');
            $table->string('perusahaan');
            $table->string('posisi');
            $table->year('tahun_masuk');
            $table->year('tahun_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja_lamarans');
    }
};