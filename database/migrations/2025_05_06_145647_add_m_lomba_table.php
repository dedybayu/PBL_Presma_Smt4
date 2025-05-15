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
        Schema::create('m_lomba', function (Blueprint $table) {
            $table->id('lomba_id');
            $table->string('lomba_kode')->unique();
            $table->string('lomba_nama');
            $table->unsignedBigInteger('tingkat_lomba_id');
            $table->unsignedBigInteger('kategori_lomba_id');
            $table->string('penyelenggara');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('status_verifikasi')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('tingkat_lomba_id')->references('tingkat_lomba_id')->on('m_tingkat_lomba');
            $table->foreign('kategori_lomba_id')->references('kategori_lomba_id')->on('m_kategori_lomba');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_lomba');
    }
};
