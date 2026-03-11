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
        Schema::create('usaha', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));

            // Data Pelaku Usaha
            $table->string('nama_pemilik');
            $table->string('nama_usaha');
            $table->text('deskripsi_kegiatan')->nullable();

            // KBLI 2025
            $table->string('kbli_kategori_kode')->nullable();
            $table->string('kbli_kategori_nama')->nullable();
            $table->string('kbli_golongan_pokok_kode')->nullable();
            $table->string('kbli_golongan_pokok_nama')->nullable();
            $table->string('kbli_golongan_kode')->nullable();
            $table->string('kbli_golongan_nama')->nullable();
            $table->string('kbli_subgolongan_kode')->nullable();
            $table->string('kbli_subgolongan_nama')->nullable();
            $table->string('kbli_kelompok_kode')->nullable();
            $table->string('kbli_kelompok_nama')->nullable();

            // Lokasi
            $table->string('provinsi_kode')->nullable();
            $table->string('provinsi_nama')->nullable();
            $table->string('kabkot_kode')->nullable();
            $table->string('kabkot_nama')->nullable();
            $table->string('kecamatan_kode')->nullable();
            $table->string('kecamatan_nama')->nullable();
            $table->string('desa_kode')->nullable();
            $table->string('desa_nama')->nullable();
            $table->string('sls_kode')->nullable();
            $table->string('sls_nama')->nullable();
            $table->string('sub_sls')->nullable();

            // Geotagging
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            // Platform Digital (JSON array)
            $table->jsonb('platform_digital')->default('[]');

            // Klasifikasi
            $table->string('kelas_usaha')->nullable();
            $table->string('cakupan_pasar')->nullable();

            // Metadata
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index('kabkot_kode');
            $table->index('kecamatan_kode');
            $table->index('kbli_kategori_kode');
            $table->index('kelas_usaha');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usaha');
    }
};
