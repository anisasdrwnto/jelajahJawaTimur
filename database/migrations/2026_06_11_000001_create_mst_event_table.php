<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mst_event', function (Blueprint $table) {
            $table->string('eve_id_event', 30)->primary();
            $table->string('eve_nama_event', 255);
            $table->text('eve_deskripsi');
            $table->string('eve_kategori', 50);
            $table->date('eve_tanggal');
            $table->string('eve_lokasi', 255);
            $table->string('eve_gambar', 100)->nullable();
            $table->integer('eve_kuota');
            $table->string('eve_createBy', 50)->default('System');
            $table->datetime('eve_createDate')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mst_event');
    }
};