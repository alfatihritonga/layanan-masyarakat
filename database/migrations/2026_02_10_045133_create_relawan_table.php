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
        Schema::create('relawan', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 100);
            $table->string('no_hp', 20);
            $table->string('email')->unique();
            $table->text('alamat');

            $table->string('kecamatan', 100);
            $table->string('kabupaten_kota', 100);

            $table->enum('status_ketersediaan', [
                'available',
                'on_duty',
                'unavailable'
            ])->default('available');

            $table->json('skill')->nullable();
            $table->year('tahun_bergabung');

            $table->softDeletes();
            $table->timestamps();

            $table->index('status_ketersediaan');
            $table->index('kabupaten_kota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawan');
    }
};
