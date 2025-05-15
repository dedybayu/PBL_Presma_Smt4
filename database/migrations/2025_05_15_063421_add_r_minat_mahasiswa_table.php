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
        Schema::create('r_minat_mahasiswa', function (Blueprint $table) {
            $table->id('minat_mahasiswa_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('minat_keahlian_id');
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('minat_keahlian_id')->references('minat_keahlian_id')->on('m_minat_keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_minat_mahasiswa');
    }
};
