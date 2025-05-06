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
        Schema::create('t_sertifikasi_mahasiswa', function (Blueprint $table) {
            $table->id('sertifikasi_mahasiswa_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('nama_sertifikasi');
            $table->string('penyelenggara');
            $table->date('tanggal');
            $table->string('file_sertifikat');
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sertifikasi_mahasiswa');
    }
};
