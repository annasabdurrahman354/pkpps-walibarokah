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

        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nama_panggilan');
            $table->string('jenis_kelamin');
            $table->string('kewarganegaraan');
            $table->json('unit');

            $table->string('nik', 16)->unique()->nullable();
            $table->string('nip')->unique()->nullable();
            $table->string('nfc')->unique()->nullable();

            $table->unsignedSmallInteger('tempat_lahir_id')->nullable();
            $table->foreign('tempat_lahir_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_lahir')->nullable();

            $table->string('nomor_telepon', 16)->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('tanggal_mulai_tugas')->nullable();
            $table->string('status');

            $table->string('alamat')->nullable();
            $table->unsignedTinyInteger('provinsi_id')->nullable();
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('kota_id')->nullable();
            $table->foreign('kota_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->nullOnDelete()->cascadeOnUpdate();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kode_pos', 5)->nullable();

            $table->string('asal_kelompok')->nullable();
            $table->string('asal_desa')->nullable();
            $table->string('asal_daerah')->nullable();
            $table->string('asal_pondok')->nullable();

            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('golongan_darah')->nullable();

            $table->string('status_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nomor_telepon_ayah', 16)->nullable();

            $table->string('status_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nomor_telepon_ibu', 16)->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUlid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
