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
        Schema::create('respon_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')->constrained('laporan_bencana')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('komentar');
            $table->enum('status_respon', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->json('tindakan')->nullable(); // Array tindakan yang diambil
            $table->timestamps();

            $table->index(['laporan_id', 'status_respon']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respon_laporan');
    }
};
