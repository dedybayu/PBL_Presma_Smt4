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
        Schema::create('t_prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('prestasi_nama');
            $table->unsignedBigInteger('lomba_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('file_sertifikat');
            $table->string('file_bukti_foto');
            $table->string('file_surat_tugas');
            $table->string('file_surat_undangan');
            $table->string('file_surat_proposal');
            $table->boolean('status_verifikasi');
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('dosen_id')->references('dosen_id')->on('m_dosen');
            $table->foreign('lomba_id')->references('lomba_id')->on('m_lomba');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_prestasi');
    }
};
