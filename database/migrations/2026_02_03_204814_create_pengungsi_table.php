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
        Schema::create('pengungsi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan_bencana')->onDelete('cascade');
            $table->integer('jumlah_orang')->default(0);
            $table->integer('jumlah_anak')->default(0);
            $table->integer('jumlah_lansia')->default(0);
            $table->string('lokasi_pengungsian');
            $table->json('kebutuhan_utama')->nullable(); // Array kebutuhan
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->index('laporan_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengungsi');
    }
};
