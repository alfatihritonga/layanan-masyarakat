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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            
            // Relasi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('disaster_type_id')->constrained('disaster_types')->onDelete('restrict');
            
            // Informasi Kejadian
            $table->text('description');
            $table->text('location_address');
            $table->dateTime('incident_date');
            
            // Tingkat Urgensi & Status
            $table->enum('urgency_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'verified', 'in_progress', 'resolved', 'rejected'])->default('pending');
            
            // Data Tambahan
            $table->integer('victim_count')->nullable();
            $table->text('damage_description')->nullable();
            $table->string('contact_phone', 20);
            
            // Admin Area
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Tracking
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('urgency_level');
            $table->index('disaster_type_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
