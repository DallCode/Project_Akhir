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
        Schema::create('pendidikan_lamarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_lamaran');
            $table->string('institusi');
            $table->string('jurusan');
            $table->year('tahun_masuk');
            $table->year('tahun_lulus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan_lamarans');
    }
};
