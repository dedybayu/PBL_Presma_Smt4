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
        Schema::create('m_kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->string('kelas_kode')->unique();
            $table->string('kelas_nama');
            $table->unsignedBigInteger('prodi_id');
            $table->timestamps();

            $table->foreign('prodi_id')->references('prodi_id')->on('m_prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kelas');
    }
};
