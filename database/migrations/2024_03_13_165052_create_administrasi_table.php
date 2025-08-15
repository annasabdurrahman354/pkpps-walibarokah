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
        Schema::disableForeignKeyConstraints();

        Schema::create('administrasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_administrasi_id')->nullable()->references('id')->on('jenis_administrasi')->cascadeOnUpdate()->nullOnDelete();
            $table->string('tahun_ajaran');
            $table->string('periode');
            $table->json('sasaran');
            $table->json('nominal_tagihan');
            $table->date('batas_awal_pembayaran');
            $table->date('batas_akhir_pembayaran');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasi');
    }
};
