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
        Schema::create('t_sertifikasi_dosen', function (Blueprint $table) {
            $table->id('sertifikasi_dosen_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('nama_sertifikasi');
            $table->string('penyelenggara');
            $table->date('tanggal');
            $table->string('file_sertifikat');
            $table->timestamps();

            $table->foreign('dosen_id')->references('dosen_id')->on('m_dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sertifikasi_dosen');
    }
};
