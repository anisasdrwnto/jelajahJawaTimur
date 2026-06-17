<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trx_pendaftaran', function (Blueprint $table) {
            $table->string('pdf_id_pendaftaran', 30)->primary();
            $table->string('pdf_id_users', 30)->nullable();
            $table->string('pdf_id_event', 30);
            $table->string('pdf_nama', 100);
            $table->string('pdf_email', 100);
            $table->string('pdf_no_hp', 20);
            $table->string('pdf_status', 20)->default('pending');
            $table->datetime('pdf_createDate')->useCurrent();

            $table->foreign('pdf_id_event')->references('eve_id_event')->on('mst_event')->onDelete('cascade');
            $table->foreign('pdf_id_users')->references('mus_id_users')->on('mst_users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trx_pendaftaran');
    }
};