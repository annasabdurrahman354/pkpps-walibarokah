<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('siswa', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nama');
            $table->string('nama_panggilan');
            $table->string('jenis_kelamin');
            $table->string('kewarganegaraan')->nullable();

            $table->string('nik', 16)->unique()->nullable();
            $table->string('nis')->unique()->nullable();
            $table->string('nism', 18)->unique()->nullable();
            $table->string('nisn', 10)->unique()->nullable();
            $table->string('nfc')->unique()->nullable();

            $table->unsignedSmallInteger('tempat_lahir_id')->nullable();
            $table->foreign('tempat_lahir_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->date('tanggal_lahir')->nullable();

            $table->string('nomor_telepon', 16)->nullable();
            $table->string('email')->unique()->nullable();

            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jenjang_sekolah');
            $table->string('kelas_sekolah');
            $table->string('rombel_kelas_sekolah');
            $table->string('kelas_pondok');
            $table->date('tanggal_masuk')->nullable();

            $table->string('kategori_administrasi');
            $table->string('sumber_pembiayaan')->nullable();
            $table->string('status_siswa');

            $table->string('status_mukim')->nullable();
            $table->string('status_tinggal')->nullable();
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

            $table->string('golongan_darah')->nullable();
            $table->json('riwayat_penyakit')->nullable();
            $table->string('kebutuhan_khusus')->nullable();
            $table->string('kebutuhan_diabilitas')->nullable();
            $table->string('cita_cita')->nullable();
            $table->string('hobi')->nullable();

            $table->string('nomor_kk', 16)->nullable();
            $table->string('nama_kepala_keluarga')->nullable();
            $table->unsignedTinyInteger('jumlah_saudara')->nullable();
            $table->unsignedTinyInteger('anak_nomor')->nullable();
            $table->string('nomor_kip')->nullable();
            $table->unsignedInteger('tahun_penerimaan_kip')->nullable();

            $table->string('status_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('kewarganegaraan_ayah')->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->unsignedSmallInteger('tempat_lahir_ayah_id')->nullable();
            $table->foreign('tempat_lahir_ayah_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('nomor_telepon_ayah', 16)->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah')->nullable();

            $table->boolean('ayah_tinggal_luar_negeri')->nullable();
            $table->string('alamat_ayah')->nullable();
            $table->unsignedTinyInteger('provinsi_ayah_id')->nullable();
            $table->foreign('provinsi_ayah_id')->references('id')->on('provinsi')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('kota_id')->nullable();
            $table->foreign('kota_ayah_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kecamatan_ayah_id')->nullable();
            $table->foreign('kecamatan_ayah_id')->references('id')->on('kecamatan')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kelurahan_ayah_id')->nullable();
            $table->foreign('kelurahan_ayah_id')->references('id')->on('kelurahan')->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('rt_ayah')->nullable();
            $table->tinyInteger('rw_ayah')->nullable();
            $table->string('kode_pos_ayah', 5)->nullable();
            $table->string('kepemilikan_rumah_ayah')->nullable();

            $table->string('status_ibu')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('kewarganegaraan_ibu')->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->boolean('kk_sama_dengan_ayah')->nullable();
            $table->unsignedSmallInteger('tempat_lahir_ibu_id')->nullable();
            $table->foreign('tempat_lahir_ibu_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('nomor_telepon_ibu', 16)->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu')->nullable();

            $table->boolean('alamat_ibu_sama_dengan_ayah')->nullable();
            $table->boolean('ibu_tinggal_luar_negeri')->nullable();
            $table->string('alamat_ibu')->nullable();
            $table->unsignedTinyInteger('provinsi_ibu_id')->nullable();
            $table->foreign('provinsi_ibu_id')->references('id')->on('provinsi')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('kota_ibu_id')->nullable();
            $table->foreign('kota_ibu_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kecamatan_ibu_id')->nullable();
            $table->foreign('kecamatan_ibu_id')->references('id')->on('kecamatan')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kelurahan_ibu_id')->nullable();
            $table->foreign('kelurahan_ibu_id')->references('id')->on('kelurahan')->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('rt_ibu')->nullable();
            $table->tinyInteger('rw_ibu')->nullable();
            $table->string('kode_pos_ibu', 5)->nullable();
            $table->string('kepemilikan_rumah_ibu')->nullable();

            $table->string('hubungan_wali')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('jenis_kelamin_wali')->nullable();
            $table->string('kewarganegaraan_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->unsignedSmallInteger('tempat_lahir_wali_id')->nullable();
            $table->foreign('tempat_lahir_wali_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('nomor_telepon_wali', 16)->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('pendidikan_terakhir_wali')->nullable();

            $table->boolean('wali_tinggal_luar_negeri')->nullable();
            $table->string('alamat_wali')->nullable();
            $table->unsignedTinyInteger('provinsi_wali_id')->nullable();
            $table->foreign('provinsi_wali_id')->references('id')->on('provinsi')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('kota_wali_id')->nullable();
            $table->foreign('kota_wali_id')->references('id')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kecamatan_wali_id')->nullable();
            $table->foreign('kecamatan_wali_id')->references('id')->on('kecamatan')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('kelurahan_wali_id')->nullable();
            $table->foreign('kelurahan_wali_id')->references('id')->on('kelurahan')->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('rt_wali')->nullable();
            $table->tinyInteger('rw_wali')->nullable();
            $table->string('kode_pos_wali', 5)->nullable();
            $table->string('kepemilikan_rumah_wali')->nullable();

            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('users');

        Schema::enableForeignKeyConstraints();
    }
};
