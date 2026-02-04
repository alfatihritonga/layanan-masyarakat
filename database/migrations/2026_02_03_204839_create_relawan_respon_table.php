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
        Schema::create('relawan_respon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relawan_id')->constrained('relawan')->onDelete('cascade');
            $table->foreignId('respon_laporan_id')->constrained('respon_laporan')->onDelete('cascade');
            $table->string('peran')->nullable(); // koordinator, medis, evakuasi, dll
            $table->timestamps();

            $table->unique(['relawan_id', 'respon_laporan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawan_respon');
    }
};
