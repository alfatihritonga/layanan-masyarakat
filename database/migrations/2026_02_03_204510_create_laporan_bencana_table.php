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
        Schema::create('laporan_bencana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_bencana', [
                'banjir', 
                'gempa_bumi', 
                'tanah_longsor', 
                'kebakaran', 
                'tsunami',
                'gunung_meletus',
                'angin_puting_beliung',
                'kekeringan',
                'lainnya'
            ]);
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'verified', 'resolved'])->default('pending');
            $table->date('tanggal_kejadian');
            $table->json('dampak')->nullable(); // {korban_jiwa, korban_luka, kerugian_material}
            $table->softDeletes();
            $table->timestamps();

            // Indexing untuk query cepat
            $table->index('user_id');
            $table->index('status');
            $table->index('tanggal_kejadian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bencana');
    }
};
